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
    
    
}