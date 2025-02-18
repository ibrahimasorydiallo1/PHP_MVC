<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use App\router;
use App\controllers\userController;

$router = new Router();

// Ajouter des routes;
$router->add('GET', '/user/index', function () use ($db) {
    $controller = new userController($db);
    $controller->show($id);
});

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
    $userController = new userController($db);
    $userController->addUser($name, $email);

} else {
    echo "404 - Page non trouvée";
}