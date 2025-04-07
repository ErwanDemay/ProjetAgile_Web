<head>
<link rel="stylesheet" href="../../css/formulaireAjout.css">
</head>
<body>
    <div class="form-container">
        <h2>Ajouter une recette</h2>
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="input-field">
                <input type="text" id="libelleRecette" name="libelleRecette" placeholder="Nom de la recette" value="recette->getLibelle()" required>
            </div>
            <div class="input-field">
                <input type="text" id="descriptionRecette" name="descriptionRecette" placeholder="Description de la recette" value="recette->getDescription()" required>
            </div>
            <div class="input-field">
                <select id="typeRecette" name="typeRecette" value="recette->getId_Type()" required>
                    <option value="" disabled selected>Type de recette</option>
                    <option value="entrée">Entrée</option>
                    <option value="plat">Plat</option>
                    <option value="dessert">Dessert</option>
                </select>
            </div>
            <div class="input-field">
                <input type="file" id="imageRecette" name="imageRecette" accept="image/*" value="recette->getUneImage()" required>
            </div>
            <div class="buttons">
            <a href="../../index.php?controleur=recettes&action=consultationRecettes" class="cancel-btn">Annuler</a>
            <a href="../../index.php?controleur=recettes&action=recetteAjoutee" class="create-btn">Créer</a>
            </div>
        </form>
    </div>
    </body>

