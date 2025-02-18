<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use App\router;
// use App\Router;
use App\controllers\myAppController;

$router = new Router();

// Page d'accueil => connexion utilisateur
$router->add('GET', '/', function () {
    echo "Bienvenue sur la page d'accueil!";
});

// Afficher les tâches de l'utilisateur connecté
$router->add('GET', '/tasks', function () use ($db) {
    if (!isset($_SESSION['user_id'])) {
        echo "Veuillez vous connecter";
        return;
    }
    $controller = new myAppController($db);
    $controller->showTasks($_SESSION['user_id']);
});

// Modifier/Supprimer une tâche
$router->add('GET', '/tasks/edit/{id:\d+}', function ($id) use ($db) {
    $controller = new myAppController($db);
    $controller->editAndDeleteTask($id);
});

// Ajouter un utilisateur
$router->add('POST', '/user/add', function () use ($db) {
    if (!isset($_POST['name'], $_POST['email'], $_POST['password'])) {
        echo "Tous les champs sont requis.";
        return;
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Hashing dans le modèle

    $controller = new myAppController($db);
    $controller->addUser($name, $email, $password);
});

// Connexion utilisateur
$router->add('POST', '/user/login', function () use ($db) {
    if (!isset($_POST['email'], $_POST['password'])) {
        echo "Email et mot de passe requis.";
        return;
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $controller = new myAppController($db);
    $controller->loginUser($email, $password);
});

// Déconnexion utilisateur
$router->add('GET', '/user/logout', function () {
    session_destroy();
    header("Location: /");
    exit();
});

// Routage basique (fallback 404)
echo "404 - Page non trouvée";

