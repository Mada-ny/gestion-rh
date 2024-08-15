<h1>Bonjour {{ $emailData['employe']->prénom }} !</h1>

<p>Nous avons le plaisir de vous accueillir sur notre plateforme de gestion des congés et absences.</p>

<p>Voici vos identifiants de connexion :</p>
<ul>
    <li>Adresse e-mail : {{ $emailData['employe']->email }}</li>
    <li>Mot de passe temporaire : {{ $emailData['password'] }}</li>
</ul>

<p>Pour vous connecter, rendez-vous sur notre <a href="{{ $emailData['loginUrl'] }}">portail en ligne</a>.</p>

<p>Nous vous invitons à modifier votre mot de passe dès votre première connexion.</p>

<p>Nous vous souhaitons la bienvenue et une excellente intégration au sein de notre équipe !</p>

<p>Cordialement,<br>L'équipe RH</p>