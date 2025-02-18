<?php

namespace App\models;
use PDO;

class user {
    private $db;
    
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Récupérer tous les utilisateurs
    public function getAllUsers() {
        $stmt = $this->db->prepare('SELECT * FROM users');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Ajouter un utilisateur avec un mot de passe sécurisé
    public function addUser($name, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }

    // Récupérer les tâches d'un utilisateur spécifique
    public function getTasks($userId) {
        $stmt = $this->db->prepare('SELECT * FROM tasks WHERE user_id = :user_id');
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUserByEmail($email) {
    $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

// Récupérer une tâche par ID pour un utilisateur
public function getTaskById($taskId, $userId) {
    $stmt = $this->db->prepare('SELECT * FROM tasks WHERE id = :task_id AND user_id = :user_id');
    $stmt->bindParam(':task_id', $taskId);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

// Mettre à jour une tâche
public function updateTask($taskId, $userId, $title, $description, $status) {
    $stmt = $this->db->prepare('UPDATE tasks SET title = :title, description = :description, status = :status WHERE id = :task_id AND user_id = :user_id');
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':task_id', $taskId);
    $stmt->bindParam(':user_id', $userId);
    return $stmt->execute();
}

// Supprimer une tâche
public function deleteTask($taskId, $userId) {
    $stmt = $this->db->prepare('DELETE FROM tasks WHERE id = :task_id AND user_id = :user_id');
    $stmt->bindParam(':task_id', $taskId);
    $stmt->bindParam(':user_id', $userId);
    return $stmt->execute();
}
}
