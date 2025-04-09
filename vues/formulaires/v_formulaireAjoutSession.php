<head>
<link rel="stylesheet" href="../../css/formulaireAjout.css">
</head>
<body>
    <div class="form-container">
        <h2>Ajouter une session</h2>
        <form action="index.php?controleur=sessions&action=sessionAdded" method="POST" enctype="multipart/form-data">
            <div class="input-field">
                <input type="text" id="nomSession" name="nomSession" placeholder="Nom de la session" required>
            </div>
            <div class="input-field">
                <input type="date" id="dateSession" name="dateSession" required>
            </div>
            <div class="input-field">
                <input type="time" id="heureDebut" name="heureDebut" placeholder="Heure de début" required>
            </div>
            <div class="input-field">
                <input type="time" id="heureFin" name="heureFin" placeholder="Heure de fin" required>
            </div>
            <div class="input-field">
                <input type="number" id="prixSession" name="prixSession" placeholder="Prix de la session" required>
            </div>
            <div class="input-field">
                <input type="number" id="nbPlacesSession" name="nbPlacesSession" placeholder="Nombre de places" required>
            </div>
            <div class="buttons">
                <a href="index.php?controleur=sessions&action=consultationSessions" class="cancel-btn">Annuler</a>
                <button type="submit" class="create-btn">Créer</button>
            </div>
        </form>
    </div>
    </body>

