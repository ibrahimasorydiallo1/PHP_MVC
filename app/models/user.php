<?php

namespace App\models;
use PDO;

class user {
    private $db;
    
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    //Functions pour récupérer tous les utilisateurs
    function getAllUsers() {
        $stmt = $this->db->prepare('SELECT * FROM users');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //Fonction pour ajouter les utilisateurs
    function addUser($name, $email) {
        $stmt = $this->db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }
}

