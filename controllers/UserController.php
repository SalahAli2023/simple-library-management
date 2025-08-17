<?php
require_once '../models/User.php';

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function index() {
        $users = $this->userModel->getAll();
        require '../views/users/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone']
            ];
            
            $this->userModel->create($data);
            header('Location: index.php?action=users');
            exit;
        }
        
        require '../views/users/create.php';
    }
    
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone']
            ];
            
            $this->userModel->update($id, $data);
            header('Location: index.php?action=users');
            exit;
        }
        
        $user = $this->userModel->findById($id);
        require '../views/users/edit.php';
    }
    
    public function delete($id) {
        $this->userModel->delete($id);
        header('Location: index.php?action=users');
        exit;
    }
    
    public function search() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchTerm = $_POST['search_term'];
            $users = $this->userModel->searchUsers($searchTerm);
            require '../views/users/search.php';
            exit;
        }
        
        require '../views/users/search.php';
    }
}