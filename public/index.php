<?php
require_once __DIR__ .'/../models/Database.php';

// Error handling
// set_exception_handler(function($e) {
//     error_log($e->getMessage());
//     header('HTTP/1.1 500 Internal Server Error');
//     die('An error occurred');
// });

// Get action from URL
$action = $_GET['action'] ?? 'books';
$method = $_GET['method'] ?? 'index';

// Route to appropriate controller
switch ($action) {
    case 'books':
        require_once __DIR__ .'/../controllers/BookController.php';
        $controller = new BookController();
        
        if ($method === 'borrow') {
            $bookId = $_GET['book_id'] ?? null;
            $userId = $_GET['user_id'] ?? null;
            if ($bookId && $userId) {
                $controller->borrow($bookId, $userId);
            }
        } elseif (method_exists($controller, $method)) {
            $id = $_GET['id'] ?? null;
            if ($id) {
                $controller->$method($id);
            } else {
                $controller->$method();
            }
        }
        break;
        
    case 'users':
        require_once __DIR__ .'/../controllers/UserController.php';
        $controller = new UserController();
        
        if (method_exists($controller, $method)) {
            $id = $_GET['id'] ?? null;
            if ($id) {
                $controller->$method($id);
            } else {
                $controller->$method();
            }
        }
        break;
        
    default:
        header('HTTP/1.1 404 Not Found');
        die('Page not found');
}