<?php
require_once 'Traits/LoggingTrait.php';
require_once 'Traits/SearchableTrait.php';

class User {
    use LoggingTrait, SearchableTrait;
    
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Get all User from DB
    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }
    
    //Add new User
    public function create($data) {
        $query = "INSERT INTO users (name, email, phone) 
                        VALUES (:name, :email, :phone)";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':phone' => $data['phone']
        ]);
        
        $this->logAction('User created', "Name: {$data['name']}");
        
        return $this->db->lastInsertId();
    }
    
    //Update User details
    public function update($id, $data) {
        $query = "UPDATE users 
                    SET  name = :name, 
                        email = :email, 
                        phone = :phone
                        WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':phone' => $data['phone']
        ]);
        
        $this->logAction('User updated', "ID: $id");
        
        return $stmt->rowCount();
    }

    //Delete User from database
    public function delete($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        
        $this->logAction('User deleted', "ID: $id");
        
        return $stmt->rowCount();
    }
    
    // Get User by ID
    public function findById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetch();
    }
    
    // Search User by SearchableTrait
    public function searchUsers($searchTerm) {
        return $this->search('users', ['name', 'email'], $searchTerm);
    }
}