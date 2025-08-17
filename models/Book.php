<?php
require_once 'Traits/LoggingTrait.php';
require_once 'Traits/SearchableTrait.php';
require_once 'Notification/NotificationInterface.php';
require_once 'Notification/EmailNotification.php';

class Book {
    use LoggingTrait, SearchableTrait;
    
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Get all books FROM DB
    public function getAllBook() {
        $stmt = $this->db->query("SELECT * FROM books");
        return $stmt->fetchAll();
    }

    //Add new book
    public function create($data) {
        $query = "INSERT INTO books (title, author, isbn, available_copies, total_copies) 
                VALUES (:title, :author, :isbn, :available_copies, :total_copies)";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':title' => $data['title'],
            ':author' => $data['author'],
            ':isbn' => $data['isbn'],
            ':available_copies' => $data['total_copies'],
            ':total_copies' => $data['total_copies']
        ]);
        
        $this->logAction('Book created', "Title: {$data['title']}");
        
        return $this->db->lastInsertId();
    }

    //Update book details
    public function update($id, $data) {
        $query = "UPDATE books SET  title = :title, 
                                    author = :author, 
                                    isbn = :isbn, 
                                    available_copies = :available_copies,
                                    total_copies = :total_copies
                                    WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':author' => $data['author'],
            ':isbn' => $data['isbn'],
            ':available_copies' => $data['available_copies'],
            ':total_copies' => $data['total_copies']
        ]);
        
        $this->logAction('Book updated', "ID: $id");
        
        return $stmt->rowCount();
    }

    //Delete book from database
    public function delete($id) {
        $query = "DELETE FROM books WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        
        $this->logAction('Book deleted', "ID: $id");
        
        return $stmt->rowCount();
    }

    // Get book by ID
    public function findById($id) {
        $query = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetch();
    }
    
    // Search books by SearchableTrait
    public function searchBooks($searchTerm) {
        return $this->search('books', ['title', 'author'], $searchTerm);
    }

    //borrow Book
    public function borrowBook($bookId, $userId) {
        try {
            $this->db->beginTransaction();
            
            // Check book availability
            $book = $this->findById($bookId);
            if ($book['available_copies'] <= 0) {
                throw new Exception("No available copies");
            }
            
            // Update book available copies
            $updateBook = "UPDATE books SET available_copies = available_copies - 1 WHERE id = :id";
            $stmt = $this->db->prepare($updateBook);
            $stmt->execute([':id' => $bookId]);
            
            // Create borrowing record
            $borrowDate = date('Y-m-d H:i:s');
            $dueDate = date('Y-m-d H:i:s', strtotime('+14 days'));
            
            $insertBorrow = "INSERT INTO borrowings (book_id, user_id, borrow_date, due_date) 
                            VALUES (:book_id, :user_id, :borrow_date, :due_date)";
            $stmt = $this->db->prepare($insertBorrow);
            $stmt->execute([
                ':book_id' => $bookId,
                ':user_id' => $userId,
                ':borrow_date' => $borrowDate,
                ':due_date' => $dueDate
            ]);
            
            // Send notification
            $notification = new EmailNotification();
            $message = "You have borrowed '{$book['title']}'. Due date: $dueDate";
            $notification->send("salah@g.com", $message);
            
            $this->db->commit();
            $this->logAction('Book borrowed', "Book ID: $bookId, User ID: $userId");
            
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            $this->logAction('Borrow failed', $e->getMessage());
            return false;
        }
    }
    
    //Calculate Late Fee
    public function calculateLateFee($borrowingId) {
        $query = "SELECT due_date FROM borrowings WHERE id = :id AND return_date IS NULL";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $borrowingId]);
        $borrowing = $stmt->fetch();
        
        if (!$borrowing) {
            return 0;
        }
        
        $dueDate = new DateTime($borrowing['due_date']);
        $today = new DateTime();
        
        if ($today > $dueDate) {
            $daysLate = $today->diff($dueDate)->days;
            return $daysLate * 0.50; // $0.50 per day late
        }
        
        return 0;
    }
    
    
    
}