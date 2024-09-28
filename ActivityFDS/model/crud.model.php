<?php

interface Icrud{
    public function getAllUsers();
    public function getUserById();
    public function insertUser();
    public function updateUser();
    public function deleteUser();
}


class crud
{
    protected $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        try{
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute()){
                $data =  $stmt->fetchAll();
                if ($stmt->rowCount() > 0){
                    return $data;
                }else{
                    return 'Table does not exist!';
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getUserById($data) {
        $sql = "SELECT * FROM users WHERE id = ?";
        try{
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->id])){
                $data =  $stmt->fetchAll();
                if ($stmt->rowCount() > 0){
                    return $data;
                }else{
                    return 'User does not exist!';
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function insertUser($data) {
        $sql = 'INSERT INTO users(firstname, lastname, is_admin) VALUES(?, ?, ?)';
        try{
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->firstname, $data->lastname, $data->is_admin])){
                return 'Insterted Succesfully!';
            }else{
                return 'Insertion Failed!';
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function updateUser($data) {
        $sql = "UPDATE users SET is_admin = CASE WHEN is_admin = 0 THEN 1 WHEN is_admin = 1 THEN 0 END WHERE id = ?";
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->id])) {
                return "Updated Successfully";
            } else {
                return "Update Failed!";
            }
        } catch (PDOException $e) {
            return $e->getMessage();  
        }
    }

    public function deleteUser($data) {
        $sql = "DELETE FROM users WHERE id = ?";
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->id])) {
                return "User successfully deleted.";
            } else {
                return "Failed to delete user.";
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}

