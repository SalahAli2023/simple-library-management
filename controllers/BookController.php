<?php
require_once __DIR__.'/../models/Book.php';

class BookController {
    private $bookModel;
    
    public function __construct() {
        $this->bookModel = new Book();
    }
    
    public function index() {
        $books = $this->bookModel->getAllBook();
        require __DIR__.'/../views/books/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'isbn' => $_POST['isbn'],
                'total_copies' => $_POST['total_copies']
            ];
            
            $this->bookModel->create($data);
            header('Location: index.php?action=books');
            exit;
        }
        
        require_once __DIR__.'/../views/books/create.php';
    }
    
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'isbn' => $_POST['isbn'],
                'available_copies' => $_POST['available_copies'],
                'total_copies' => $_POST['total_copies']
            ];
            
            $this->bookModel->update($id, $data);
            header('Location: index.php?action=books');
            exit;
        }
        
        $book = $this->bookModel->findById($id);
        require __DIR__.'/../views/books/edit.php';
    }
    
    public function delete($id) {
        $this->bookModel->delete($id);
        header('Location: index.php?action=books');
        exit;
    }
    
    public function search() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchTerm = $_POST['search_term'];
            $books = $this->bookModel->searchBooks($searchTerm);
            require __DIR__.'/../views/books/search.php';
            exit;
        }
        
        require __DIR__.'/../views/books/search.php';
    }
    
    public function borrow($bookId, $userId) {
        $success = $this->bookModel->borrowBook($bookId, $userId);
        if ($success) {
            header('Location: index.php?action=books&message=borrow_success');
        } else {
            header('Location: index.php?action=books&message=borrow_failed');
        }
        exit;
    }
}