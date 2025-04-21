<?php
require_once __DIR__ . "/../model/user.php";

$user = new user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'create':
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $gender = $_POST['gender'];
            $photo = file_get_contents($_FILES['photo']['tmp_name']);
            if ($user->create($name, $email, $password, $gender, $photo)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create user']);
            }
            break;
            case 'read':
                try {
                    $page = $_POST['page'] ?? 1;
                    $limit = $_POST['limit'] ?? 10;
                    $users = $user->read($page, $limit);
                    $totalUsers = $user->getTotalUsers();
                    $totalPages = ceil($totalUsers / $limit);
                    foreach ($users as &$user) {
                        $user['photo'] = base64_encode($user['photo']);
                    }
                    echo json_encode(['users' => $users, 'totalPages' => $totalPages]);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                break;
            
        case 'update':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $gender = $_POST['gender'];
            $photo = null;

            // Check if a new photo is uploaded
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $photo = file_get_contents($_FILES['photo']['tmp_name']);
            }

            if ($user->update($id, $name, $email, $gender, $photo)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update user']);
            }
            break;
        case 'delete':
            $id = $_POST['id'];
            if ($user->delete($id)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
            }
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
}
