<head>
<link rel="stylesheet" href="../../css/formulaireAjout.css">
</head>
<body>
    <div class="form-container">
        <h2>Ajouter une recette</h2>
        <!-- verifier le controleur -->
        <form action="index.php?controleur=recettes&action=recetteAdded" method="post" enctype="multipart/form-data">
            <div class="input-field">
                <input type="text" id="libelle" name="libelle" placeholder="Nom de la recette" required>
            </div>
            <div class="input-field">
                <input id="description" name="description" placeholder="Description de la recette" required></input>
            </div>
            <div class="input-field">
                <select id="idType" name="idType" required>
                    <option value="" disabled selected>Type de recette</option>
                    <option value="1">Entrée</option>
                    <option value="2">Plat</option>
                    <option value="3">Dessert</option>
                </select>
            </div>
            <div class="input-field">
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <div class="buttons">
                <a href="index.php?controleur=recettes&action=consultationRecettes" class="cancel-btn">Annuler</a>
                <button type="submit" class="create-btn">Créer</button>
            </div>
        </form>
    </div>
</body>
