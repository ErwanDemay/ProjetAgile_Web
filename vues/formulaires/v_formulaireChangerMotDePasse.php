<br><br><br><br><br>
<p>v_formulaireChangerMotDePasse.php</p>

<form action ='index.php?controleur=utilisateurs&action=changerMotDePasse' method="POST">
    <label for="ancienMotDePasse">Mot de passe actuel</label>
    <input type="ancienMotDePasse" id="ancienMotDePasse" name="ancienMotDePasse" placeholder="Entrez votre mot de passe actuel">

    <label for="nouveauMotDePasse">Nouveau mot de passe</label>
    <input type="nouveauMotDePasse" id="nouveauMotDePasse" name="nouveauMotDePasse" placeholder="Entrez votre nouveau mot de passe"><!-- A mettre en type password quand fonctionnel -->

    <button type="submit">Mettre à jour le mot de passe</button>
    <p>Le nouveau mot de passe doit contenir au minimum :</p>
    <ul>
        <li>8 caractères</li>
        <li>1 lettre majuscule</li>
        <li>1 lettre minuscule</li>
        <li>1 chiffre</li>
        <li>1 caractère spécial</li>
    </ul>
</form>