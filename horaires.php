<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Horaires d'Ouverture - Clients</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            text-align: left;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        // Fonction pour récupérer les horaires et les afficher
        async function fetchHoraires() {
            try {
                const response = await fetch('./pages/Back-end/horaires_api.php');
                if (!response.ok) throw new Error(`Erreur HTTP: ${response.status}`);
                const horaires = await response.json();
                const table = document.getElementById('horaires-table');
                table.innerHTML = '';

                horaires.forEach(horaire => {
                    const status = horaire.ferme == 1 ? "Fermé" : `${horaire.heure_ouverture} - ${horaire.heure_fermeture}`;
                    const row = `<tr>
                        <td>${horaire.jour}</td>
                        <td>${status}</td>
                    </tr>`;
                    table.innerHTML += row;
                });
            } catch (error) {
                console.error("Erreur lors de la récupération des horaires :", error);
            }
        }

        // Charger les horaires lorsque la page est chargée
        window.onload = fetchHoraires;
    </script>
</head>
<body>
    <h1 style="text-align: center;">Horaires d'Ouverture</h1>
    <table border="1" align="center">
        <thead>
            <tr>
                <th>Jour</th>
                <th>Horaires</th>
            </tr>
        </thead>
        <tbody id="horaires-table">
            <!-- Les horaires seront affichés ici -->
        </tbody>
    </table>
</body>
</html>
