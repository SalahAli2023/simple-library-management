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

    
    
    
}