<head>
<link rel="stylesheet" href="../../css/formulaireAjout.css">
</head>
<body>
    <div class="form-container">
        <h2>Ajouter une session</h2>
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="input-field">
                <input type="text" id="nomSession" name="nomSession" placeholder="Nom de la session" value="session->getNomSession()" required>
            </div>
            <div class="input-field">
                <input type="date" id="dateSession" name="dateSession" value="session->getDateSession()" required>
            </div>
            <div class="input-field">
                <input type="time" id="heureDebut" name="heureDebut" placeholder="Heure de début" value="session->getHeureDebut()" required>
            </div>
            <div class="input-field">
                <input type="time" id="heureFin" name="heureFin" placeholder="Heure de fin" value="session->getHeureFin()" required>
            </div>
            <div class="input-field">
                <input type="text" id="prixSession" name="prixSession" placeholder="Prix de la session" value="session->getPrix()" required>
            </div>
            <div class="input-field">
                <input type="text" id="nbPlacesSession" name="nbPlacesSession" placeholder="Nombre de places" value="session->getNbPlaces()" required>
            </div>
            <div class="buttons">
                <a href="../../index.php?controleur=sessions&action=consultationSessions" class="cancel-btn">Annuler</a>
                <a href="../../index.php?controleur=sessions&action=sessionAjoutee" class="create-btn">Créer</a>
            </div>
        </form>
    </div>
    </body>

