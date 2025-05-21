<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
     <link rel="stylesheet" href="styles.css">
    <style>
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100vh;
            z-index: -1;
            background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0, 0, 0 ,0.7)) url("beige.jpg");
        }
    </style>

</head>
<body>
   <div id="particles-js"></div>
<div class="page-wrapper contact-page">


     <!-- Menu Burger -->
    <header>
        <nav class="navbar">
            <div class="logo">Contact</div>
            <div class="burger" id="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
                </div>
        <ul class="nav-links" id="nav-links">
            <li><a href="Acceuil.html">À propos</a></li>
            <li><a href="Projets.html">Projets</a></li>
            <li><a href="ParcoursPro.html">Parcours pro</a></li>
            <li><a href="jeu.html">Jeu</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</header>
<main>
<h1> Contactez moi</h1>

<?php
    $civilite = $prenom = $nom = $email = $raison = $message = "";
    $erreurs = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $civilite = htmlspecialchars($_POST['civilite'] ?? '');
        $prenom = htmlspecialchars($_POST['prenom'] ?? '');
        $nom = htmlspecialchars($_POST['nom'] ?? '');
        $email = htmlspecialchars($_POST['email'] ?? '');
        $raison = htmlspecialchars($_POST['reason'] ?? '');
        $message = htmlspecialchars($_POST['message'] ?? '');

        // Validation
        if (empty($civilite)) $erreurs['civilite'] = "Veuillez choisir une civilité.";
        if (empty($prenom)) $erreurs['prenom'] = "Le prénom est requis.";
        if (empty($nom)) $erreurs['nom'] = "Le nom est requis.";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreurs['email'] = "Email invalide.";
        if (strlen(trim($message)) < 5) $erreurs['message'] = "Le message doit contenir au moins 5 caractères.";
        if (empty($raison)) $erreurs['reason'] = "Veuillez choisir une raison.";

        if (empty($erreurs)) {
            echo "<p style='color:green;'>Message bien reçu !</p>";
            echo "<p><b>Civilité :</b> $civilite</p>";
            echo "<p><b>Nom :</b> $nom</p>";
            echo "<p><b>Prénom :</b> $prenom</p>";
            echo "<p><b>Email :</b> $email</p>";
            echo "<p><b>Raison :</b> $raison</p>";
            echo "<p><b>Message :</b><br>" . nl2br($message) . "</p>";

                        // Création du contenu à enregistrer
            $contenu = "Date: " . date('Y-m-d H:i:s') . "\n";
            $contenu .= "Civilité: $civilite\n";
            $contenu .= "Nom: $nom\n";
            $contenu .= "Prénom: $prenom\n";
            $contenu .= "Email: $email\n";
            $contenu .= "Raison: $raison\n";
            $contenu .= "Message: $message\n";
            $contenu .= "----------------------------------------\n";

            // Enregistrement
            $fichier = "content_form_data.txt";
            file_put_contents('content_form_data.txt', $contenu, FILE_APPEND | LOCK_EX);
        
    // Envoi sur mon adresse mail
    $to = 'nicolas.perret@le-campus-numerique.fr';
    $subject = "Nouveau message de contact";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

    $body = "Vous avez reçu un nouveau message :\n\n";
    $body .= "Civilité : $civilite\n";
    $body .= "Prénom : $prenom\n";
    $body .= "Nom : $nom\n";
    $body .= "Email : $email\n";
    $body .= "Raison : $raison\n";
    $body .= "Message :\n$message\n";

    if (mail($to, $subject, $body, $headers)) {
        echo "<p style='color:green;'>Votre message a aussi été envoyé par email.</p>";
    } else {
        echo "<p style='color:red;'>Erreur lors de l'envoi de l'email.</p>";
    }
}
}
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !empty($erreurs)) {
    ?>

        <form action="contact.php" method="POST">
            <div>
                <label for="civilite">Civilité</label>
                <select name="civilite" id="civilite">
                    <option value="">--Choisissez une option--</option>
                    <option value="Mr" <?= $civilite === 'Mr' ? 'selected' : '' ?>>Monsieur</option>
                    <option value="Mme" <?= $civilite === 'Mme' ? 'selected' : '' ?>>Madame</option>
                    <option value="other" <?= $civilite === 'Non-B' ? 'selected' : '' ?>>Autre</option>
                </select>
                <?php if (isset($erreurs['civilite'])) echo "<p style='color:red;'>{$erreurs['civilite']}</p>"; ?>
            </div>

            <div>
                <label for="nom">Nom</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($nom) ?>">
                <?php if (isset($erreurs['nom'])) echo "<p style='color:red;'>{$erreurs['nom']}</p>"; ?>
            </div>

            <div>
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" value="<?= htmlspecialchars($prenom) ?>">
                <?php if (isset($erreurs['prenom'])) echo "<p style='color:red;'>{$erreurs['prenom']}</p>"; ?>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
                <?php if (isset($erreurs['email'])) echo "<p style='color:red;'>{$erreurs['email']}</p>"; ?>
            </div>

            <fieldset>
                <legend>Raison du message :</legend>

                <div>
                    <input type="radio" id="bugs" name="reason" value="bugs" <?= $raison === 'bugs' ? 'checked' : '' ?> />
                    <label for="bugs">Report de bugs</label>
                </div>

                <div>
                    <input type="radio" id="improve" name="reason" value="improve" <?= $raison === 'improve' ? 'checked' : '' ?> />
                    <label for="improve">Amélioration à proposer</label>
                </div>

                <div>
                    <input type="radio" id="speak" name="reason" value="speak" <?= $raison === 'speak' ? 'checked' : '' ?> />
                    <label for="speak">Communiquer avec moi</label>
                </div>
                <?php if (isset($erreurs['reason'])) echo "<p style='color:red;'>{$erreurs['reason']}</p>"; ?>
            </fieldset>

            <div>
                <label for="message">Votre message</label>
                <textarea name="message" placeholder="Exprimez-vous"><?= htmlspecialchars($message) ?></textarea>
                <?php if (isset($erreurs['message'])) echo "<p style='color:red;'>{$erreurs['message']}</p>"; ?>
            </div>

            <button type="submit">Envoyer</button>
        </form>

    <?php } ?>
    
    <div class="contact-icons">
  <a href="mailto:nicolas.perret@le-campus-numerique.fr" title="Envoyer un mail">
    <img src="images/icons8-mail-50.png" alt="Email">
  </a>
  <a href="https://www.linkedin.com/in/nicolas-perret-215805358/" target="_blank" title="Mon LinkedIn">
    <img src="images/icons8-linkedin-94.png" alt="LinkedIn">
  </a>
  <a href="https://github.com/Nico01210" target="_blank" title="Mon GitHub">
    <img src="images/icons8-github-24.png" alt="GitHub">
  </a>
</div>
</main>

<footer class="footer">
    <div class="footer-container">
        <p>Copyright &copy; 2025 Nicolas PERRET. Tous droits réservés.</p>
        <ul class="footer-links">
            <li><a href="Acceuil.html">À propos</a></li>
            <li><a href="Projets.html">Projets</a></li>
            <li><a href="ParcoursPro.html">Parcours pro</a></li>
            <li><a href="jeu.html">Jeu</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
<script>
particlesJS.load('particles-js', 'particles.json', function() {
console.log('particles.js loaded');
});
</script>
<script src="script.js"></script>
<script src="particles.js"></script>
<script src="app.js"></script>


</div>
</body>
</html>