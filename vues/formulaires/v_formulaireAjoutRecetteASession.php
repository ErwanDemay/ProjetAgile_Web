<head>
    <link rel="stylesheet" href="../../css/formulaireAjout.css">
</head>
<body>
<div class="form-container">
    <!-- Affichage du titre pour l'ajout d'une recette à une session -->
    <h2>Ajouter une recette à la session <br>"<?php echo htmlspecialchars($session->getNomSession()); ?>"</h2>

    <!-- Formulaire pour ajouter une recette à la session -->
    <form method="POST" action="index.php?controleur=sessions&action=addRecetteASession">
    <div class="input-field">    
    <input type="hidden" name="session_id" value="<?php echo htmlspecialchars($session->getId()); ?>">
        <!-- Sélection de la recette à ajouter à la session -->
        <label for="recette_id">Sélectionner une recette :</label>
        <select name="recette_id" id="recette_id" required>
            <?php foreach ($recettesDisponibles as $recette) : ?>
                <option value="<?php echo $recette->getId(); ?>"><?php echo htmlspecialchars($recette->getLibelle()); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="buttons">
        <button type="submit" class="create-btn">Ajouter la recette</button>
    </div>
    </form>
        <a href="index.php?controleur=sessions">Retour aux sessions</a>
    </div>
</body>
