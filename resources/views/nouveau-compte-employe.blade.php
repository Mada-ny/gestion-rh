<!DOCTYPE html>
<html>
<head>
    <title>Vos identifiants de connexion</title>
</head>
<body>
    <h1>Bienvenue {{ $employe->prenom }} {{ $employe->nom }} !</h1>
    <p>Votre compte a été créé sur notre plateforme de gestion des congés et absences.</p>
    <p>Voici vos identifiants de connexion :</p>
    <ul>
        <li>Nom d'utilisateur : {{ $nomUtilisateur }}</li>
        <li>Mot de passe temporaire : {{ $motDePasseTemporaire }}</li>
    </ul>
    <p>Veuillez vous connecter et changer votre mot de passe dès que possible.</p>
    <p>Cordialement,<br>L'équipe RH</p>
</body>
</html>
