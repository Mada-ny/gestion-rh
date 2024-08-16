<h1>Nouvelle demande d'absence</h1>

<p>Un employé a soumis une nouvelle demande d'absence :</p>

<ul>
    <li>Employé : {{ $demandeAbsence->employe->nom }} {{ $demandeAbsence->employe->prénom }}</li>
    <li>Date de début : {{ $demandeAbsence->date_debut->format('d/m/Y') }}</li>
    <li>Date de fin : {{ $demandeAbsence->date_fin->format('d/m/Y') }}</li>
    <li>Motif : {{ $demandeAbsence->motif }}</li>
</ul>

<p>Vous pouvez consulter et approuver cette demande sur la plateforme.</p>