<head>
<link rel="stylesheet" href="../../css/formulaireAjout.css">
</head>
<body>
    <div class="form-container">
        <h2>Modifier une recette</h2>
        <form action="index.php?controleur=recettes&action=recetteModified" method="post" enctype="multipart/form-data">
            <!-- Champ caché pour l'ID de la recette -->
            <input type="hidden" name="id" value="<?php echo $laRecette->getId(); ?>">
            
            <div class="input-field">
                <input type="text" id="libelle" name="libelle" placeholder="Nom de la recette" value="<?php echo $laRecette->getLibelle(); ?>" required>
            </div>
            <div class="input-field">
                <textarea id="description" name="description" placeholder="Description de la recette" required><?php echo $laRecette->getDescription(); ?></textarea>
            </div>
            <div class="input-field">
                <select id="idType" name="idType" required>
                    <option value="" disabled>Type de recette</option>
                    <option value="1" <?php echo ($laRecette->getId_Type() == 1) ? 'selected' : ''; ?>>Entrée</option>
                    <option value="2" <?php echo ($laRecette->getId_Type() == 2) ? 'selected' : ''; ?>>Plat</option>
                    <option value="3" <?php echo ($laRecette->getId_Type() == 3) ? 'selected' : ''; ?>>Dessert</option>
                </select>
            </div>
            <div class="input-field">
                <label for="image">Image actuelle : <?php echo $laRecette->getUneImage(); ?></label>
                <input type="file" id="image" name="image" accept="image/*">
                <small>Laissez vide pour conserver l'image actuelle</small>
            </div>
            <div class="buttons">
                <a href="index.php?controleur=recettes&action=consultationRecettes" class="cancel-btn">Annuler</a>
                <button type="submit" class="create-btn">Modifier</button>
            </div>
        </form>
    </div>
</body> 