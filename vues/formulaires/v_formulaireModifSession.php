<head>
<link rel="stylesheet" href="../../css/formulaireAjout.css">
</head>
<body>
    <div class="form-container">
        <h2>Modifier une session</h2>
        <form action="index.php?controleur=sessions&action=sessionUpdated" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value='<?php echo $laSession->getId(); ?>'/>
            <div class="input-field">
                <input type="text" id="nomSession" name="nomSession" placeholder="Nom de la session" value="<?php echo $laSession->getNomSession(); ?>" required>
            </div>
            <div class="input-field">
                <input type="date" id="dateSession" name="dateSession" value="<?php echo $laSession->getDateSession(); ?>" required>
            </div>
            <div class="input-field">
                <input type="time" id="heureDebut" name="heureDebut" placeholder="Heure de début" value="<?php echo $laSession->getHeureDebut(); ?>" required>
            </div>
            <div class="input-field">
                <input type="time" id="heureFin" name="heureFin" placeholder="Heure de fin" value="<?php echo $laSession->getHeureFin(); ?>" required>
            </div>
            <div class="input-field">
                <input type="text" id="prixSession" name="prixSession" placeholder="Prix de la session" value="<?php echo $laSession->getPrix(); ?>" required>
            </div>
            <div class="input-field">
                <input type="text" id="nbPlacesSession" name="nbPlacesSession" placeholder="Nombre de places" value="<?php echo $laSession->getNbPlaces(); ?>" required>
            </div>
            <div class="buttons">
                <a href="index.php?controleur=sessions&action=consultationSessions" class="cancel-btn">Annuler</a>
                <button type="submit" class="create-btn">Modifier</button>
            </div>
        </form>
    </div>
    </body>

