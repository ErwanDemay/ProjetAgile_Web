<body>
    
    <div class="form-container">
        <h2>Ajouter une recette</h2>
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="input-field">
                <input type="text" id="title" name="title" placeholder="Type" required>
            </div>
            <div class="input-field">
                <input type="text" id="input2" name="input2" placeholder="Prénom" required>
            </div>
            <div class="input-field">
                <select id="type" name="type" required>
                    <option value="" disabled selected>Type de recette</option>
                    <option value="entrée">Entrée</option>
                    <option value="plat">Plat</option>
                    <option value="dessert">Dessert</option>
                </select>
            </div>
            <div class="input-field">
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <div class="buttons">
                <button type="button" class="cancel-btn">Annuler</button>
                <button type="submit" class="create-btn">Créer</button>
            </div>
        </form>
    </div>
    </body>

