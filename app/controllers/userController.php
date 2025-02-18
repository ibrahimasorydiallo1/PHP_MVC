<?php

// C'est mon fichier controller
namespace App\controllers;

use App\models\user;

class userController {
    private $userModel;
    
    public function __construct($db) {
        $this->userModel = new user($db);
    }

    // Récupère tous les utilisateurs
    public function index() {
        $users = $this->userModel->getAllUsers();

        // Charger la vue et lui transmettre les utilisateurs
        require_once __DIR__ .'/../views/users.php';
    }

    // Methode pour Insérer des nouveaux utilisateurs via le modèle
    public function addUser($name, $email) {
        $this->userModel->addUser($name, $email);

        // Redirection vers la liste des utilisateurs
        header("Location: /");
    }
}
