<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau avec style</title>
    <link rel="stylesheet" href="../css/sessions.css">
</head>
<body>
<h1>Prochaines sessions</h1>
<div class="button-container">
    <a href="../index.php?controleur=sessions&action=addSession" class="button-add">Ajouter une session</a>
</div>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom de la session</th>
                <th>Date de la session</th>
                <th>Heure de début</th>
                <th>Heure de fin</th>
                <th>Prix</th>
                <th>Nb de places</th>
                <th>Nb de places restantes</th>
                <th>Recettes associées</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Session 1</td>
                <td>2025-04-10</td>
                <td>08:00</td>
                <td>10:00</td>
                <td>50€</td>
                <td>30</td>
                <td>10</td>
                <td>
                    <ul>
                        <li>Recette 1: Soupe à la tomate</li>
                        <li>Recette 2: Poulet rôti</li>
                        <li>Recette 3: Tarte aux pommes</li>
                    </ul>
                </td>
                <td>
                    <a href="../index.php?controleur=sessions&action=updateSession&id=1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                        </svg>
                    </a>
                    <a href="../index.php?controleur=sessions&action=deleteSession&id=1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                        </svg>
                    </a>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Session 2</td>
                <td>2025-04-11</td>
                <td>09:00</td>
                <td>11:00</td>
                <td>45€</td>
                <td>25</td>
                <td>15</td>
                <td>
                    <ul>
                        <li>Recette 1: Salade César</li>
                        <li>Recette 2: Tacos de poisson</li>
                    </ul>
                </td>
                <td>
                    <a href="../index.php?controleur=sessions&action=updateSession&id=2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                        </svg>
                    </a>
                    <a href="../index.php?controleur=sessions&action=deleteSession&id=2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                        </svg>
                    </a>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Session 3</td>
                <td>2025-04-12</td>
                <td>10:00</td>
                <td>12:00</td>
                <td>60€</td>
                <td>40</td>
                <td>30</td>
                <td>
                    <ul>
                        <li>Recette 1: Soupe de légumes</li>
                        <li>Recette 2: Pizza Margherita</li>
                        <li>Recette 3: Crêpes sucrées</li>
                    </ul>
                </td>
                <td>
                    <a href="../index.php?controleur=sessions&action=updateSession&id=3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                        </svg>
                    </a>
                    <a href="../index.php?controleur=sessions&action=deleteSession&id=3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                        </svg>
                    </a>
                </td>
            </tr>
            <tr>
                <td>4</td>
                <td>Session 4</td>
                <td>2025-04-13</td>
                <td>13:00</td>
                <td>15:00</td>
                <td>55€</td>
                <td>35</td>
                <td>10</td>
                <td>
                    <ul>
                        <li>Recette 1: Ratatouille</li>
                        <li>Recette 2: Tarte au citron meringuée</li>
                    </ul>
                </td>
                <td>
                    <a href="../index.php?controleur=sessions&action=updateSession&id=4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                        </svg>
                    </a>
                    <a href="../index.php?controleur=sessions&action=deleteSession&id=4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                        </svg>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>
