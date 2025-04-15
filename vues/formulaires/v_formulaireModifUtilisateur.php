<head>
<link rel="stylesheet" href="../../css/formulaireAjout.css">
</head>
<body>
    <div class="form-container">
        <h2>Modifier un utilisateur</h2>
        <form action="index.php?controleur=utilisateurs&action=updateUtilisateur" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value='<?php echo $unUtilisateur->getId(); ?>'/>
            <div class="input-field">
                <input type="text" id="mail" name="mail" value="<?php echo $unUtilisateur->getMail(); ?>" required>
            </div>
            <div class="input-field">
                <input type="text" id="motDePasse" name="motDePasse" placeholder="Mot de passe" required>
            </div>
            <div class="input-field">
                <input type="text" id="role" name="role" placeholder="Role" value="<?php echo $unUtilisateur->getRole(); ?>" required><!-- IL FAUT METTRE UNE LISTE DÉROULANTE ICI -->
            </div>
            <div class="buttons">
                <a href="index.php?controleur=utilisateurs&action=gestion" class="cancel-btn">Annuler</a>
                <button type="submit" class="create-btn">Modifier</button>
            </div>
        </form>
    </div>
    </body>
