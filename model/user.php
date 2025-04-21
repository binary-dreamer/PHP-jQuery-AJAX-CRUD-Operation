<?php

 require_once __DIR__."/../config/db.php";

class user {
    private $con;

    public function __construct() {
        $db= new db();
        $this->con = $db->connect();
    }

    public function create($name, $email, $password, $gender, $photo) {
        $query = "INSERT INTO user (name, email, password, gender, photo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($query);
        $null = NULL;
        $stmt->bind_param("ssssb", $name, $email, $password, $gender, $null);
        $stmt->send_long_data(4, $photo);
        if ($stmt->execute()) {
            error_log('Create Query Executed Successfully'); // Debugging statement
            return true;
        } else {
            error_log('Create Query Failed: ' . $stmt->error); // Debugging statement
            return false;
        }
    }

    public function read($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM user LIMIT ? OFFSET ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalUsers() {
        $query = "SELECT COUNT(*) as total FROM user";
        $result = $this->con->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function update($id, $name, $email, $gender, $photo) {
        if ($photo !== null) {
            // Update query with photo
            $query = "UPDATE user SET name = ?, email = ?, gender = ?, photo = ? WHERE id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("ssssi", $name, $email, $gender, $photo, $id);
        } else {
            // Update query without changing the photo
            $query = "UPDATE user SET name = ?, email = ?, gender = ? WHERE id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("sssi", $name, $email, $gender, $id);
        }

        if ($stmt->execute()) {
            error_log('Update Query Executed Successfully'); // Debugging statement
            return true;
        } else {
            error_log('Update Query Failed: ' . $stmt->error); // Debugging statement
            return false;
        }
    }

    public function delete($id) {
        $query = "DELETE FROM user WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}


?>
