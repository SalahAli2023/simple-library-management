<?php
require_once __DIR__.'/../models/User.php';

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function index() {
        $users = $this->userModel->getAllUser();
        require __DIR__.'/../views/users/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
                'phone' => preg_replace('/[^0-9]/', '', $_POST['phone']),
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
            ];
            
            try{
                $this->userModel->create($data);

                if ($userModel) {
                    // Preparing a success message
                    $_SESSION['flash_message'] = [
                        'type' => 'success',
                        'text' => 'User is created successfully!'
                    ];
                }
                header('Location: index.php?action=users');
                exit;
            }
            
            catch (PDOException $e) {
                error_log('User creation failed: ' . $e->getMessage());
                $_SESSION['flash_message'] = [
                    'type' => 'danger',
                    'text' => 'User created is Failed : ' . $e->getMessage()
                ];
                
                //Refill the form
                $_SESSION['old_input'] = $_POST;
                
                // Redirecting to the previous page
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
                
            }
        }
        require  __DIR__.'/../views/users/create.php';
    }
    
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone']
            ];
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            try{
                $this->userModel->update($id, $data);
                if ($$user > 0 ) {
                    $_SESSION['flash_message'] = [
                        'type' => 'success',
                        'text' => 'User Details are updated successfully!'
                    ];
                }
                else {
                    $_SESSION['flash_message'] = [
                        'type' => 'warning',
                        'text' =>'User Details are not updated'
                    ];
                }

                header('Location: index.php?action=users');
                exit;

            }catch (PDOException $e) {
                error_log('User update failed: ' . $e->getMessage());
                
                $_SESSION['flash_message'] = [
                    'type' => 'danger',
                    'text' => 'User update failed' . $e->getMessage()
                ];
                
                $_SESSION['old_input'] = $_POST;
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }
        }
        
        $user = $this->userModel->findById($id);
        require __DIR__.'/../views/users/edit.php';
    }
    
    public function delete($id) {
        $this->userModel->delete($id);
        header('Location: index.php?action=users');
        exit;
    }
    
    public function search() {
        $query = $_GET['query'] ?? '';
        if ($_SERVER['REQUEST_METHOD'] === 'Post') 
            {
                $searchTerm = $_POST['query'];
                $users = $this->userModel->searchUsers($searchTerm);
                require __DIR__.'/../views/users/search.php';
                exit;
        }
        
        require __DIR__.'/../views/users/search.php';
    }
}