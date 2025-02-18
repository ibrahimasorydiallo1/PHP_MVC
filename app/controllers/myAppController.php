<?php

// C'est mon fichier controller
namespace App\controllers;

use App\models\user;

class myAppController {
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
    public function addUser($name, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->userModel->addUser($name, $email, $hashedPassword);
        header("Location: /");
    }

    public function showTasks($id) {
        if (!$id) {
            echo "Erreur : utilisateur non connecté.";
            return;
        }
        $tasks = $this->userModel->getTasks($id);
        require_once __DIR__ . '/../views/tasks.php';
    }

    public function loginUser($email, $password) {
    $user = $this->userModel->getUserByEmail($email);

    if ($user && password_verify($password, $user->password)) {
        session_start();
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;

        header("Location: /tasks");
        exit();
    } else {
        echo "Identifiants incorrects.";
    }
}

public function editAndDeleteTask($taskId) {
    if (!isset($_SESSION['user_id'])) {
        echo "Veuillez vous connecter.";
        return;
    }

    $userId = $_SESSION['user_id'];

    // Récupérer la tâche pour s'assurer qu'elle appartient à l'utilisateur
    $task = $this->userModel->getTaskById($taskId, $userId);
    if (!$task) {
        echo "Tâche non trouvée ou vous n'avez pas la permission.";
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete'])) {
            $this->userModel->deleteTask($taskId, $userId);
            header("Location: /tasks");
            exit();
        } elseif (isset($_POST['update'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $status = $_POST['status'];

            $this->userModel->updateTask($taskId, $userId, $title, $description, $status);
            header("Location: /tasks");
            exit();
        }
    }

    // Charger la vue pour afficher le formulaire
    require_once __DIR__ . '/../views/edit_task.php';
}


}
