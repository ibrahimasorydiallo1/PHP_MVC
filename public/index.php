<?php

require_once __DIR__ . '/../config/database.php';

use App\router;
use App\controllers\userController;

$router = new Router();

// Ajouter des routes;

// Afficher les tasks de l'utilisateur connecté

$router->add('GET', '/user/{id:\d+}', function ($id) use ($db) {
    $controller = new userController($db);
    $controller->show($id);
});

// La page d'accueil avec (/) => connexion du user
$router->add('GET', '/', function () {
    echo "Bienvenue sur la page d'accueil!";
});

// (/tasks) pour le user connecté 
// → List tasks + Formulaire de création

$router->add('GET', '/tasks', function () use ($db) {
    $controller = new userController($db);
    $controller->showTasks();
});

// • Page de gestion (/tasks/edit/{id}) → Modifier/Supprimer une tâche.

$router->add('GET', '/tasks/edit/{id:\d+}', function ($id) use ($db) {
    $controller = new userController($db);
    $controller->editAndDeleteTask($id);
});

// Ajouter un utilisateur
$router->add('POST', '/user/add', function () use ($db) {
    $controller = new userController($db);
    $controller->addUser();
});

// Routage basique
// Vérifie si on a un paramètre controller ou non dans l'url
if(isset($_GET['controller'])) {
    $controller = $_GET['controller'];
} else {
    $controller = 'user';
}

// Vérifie si on a un paramètre action(fonction) ou non dans l'url
if(isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'index';
}

if($controller == 'user' && $action == 'index') {
    // Créer une instance du controller
    $userController = new userController($db);
    // Appeler la fonction index du controller
    $userController->index();

} elseif($controller == 'user' && $action == 'add') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $userController = new userController($db);
    $userController->addUser($name, $email);

} else {
    echo "404 - Page non trouvée";
}