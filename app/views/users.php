            <!-- PAGE INSCRIPTION -->

<?php require_once 'templates/header.php'; ?>

<h1>Liste des utilisateurs</h1>

<ul>
    <?php if (!empty($users)) { ?>
        <?php foreach ($users as $user) { ?>
            <li>
                <?php echo $user['name']; ?> <?php echo $user['email']; ?> <?php echo $user['password']; ?>
            </li>
        <?php } ?>
    <?php } else { ?>
        <li>Aucun utilisateur trouvé.</li>
    <?php } ?>
</ul>

<h2>Ajouter un utilisateur</h2>
<form action="?controller=user&action=add" method="post">
    <label for="name">Nom:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required>
    <br>

    <input type="submit" value="S'inscrire">
</form>

<?php require_once 'templates/footer.php'; ?>