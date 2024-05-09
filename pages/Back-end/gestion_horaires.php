<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Horaires d'Ouverture</title>
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
            const table = document.getElementById('horaires-table');
            if (!table) {
                console.error("L'élément HTML `horaires-table` est introuvable.");
                return;
            }

            const response = await fetch('./horaires_api.php');
            if (!response.ok) throw new Error(`Erreur HTTP: ${response.status}`);

            const resultText = await response.text();
            let horaires;
            try {
                horaires = JSON.parse(resultText);
            } catch (error) {
                console.error("Erreur lors du parsing JSON :", error, resultText);
                return;
            }

            table.innerHTML = '';

            horaires.forEach(horaire => {
                const formId = `horaire-${horaire.horaires_id}`;
                const checked = horaire.ferme == 1 ? 'checked' : '';

                const row = `
                    <tr>
                        <td>${horaire.jour}</td>
                        <td><input type="time" name="heure_ouverture" value="${horaire.heure_ouverture}" /></td>
                        <td><input type="time" name="heure_fermeture" value="${horaire.heure_fermeture}" /></td>
                        <td><input type="checkbox" name="ferme" ${checked} /></td>
                        <td><input type="hidden" name="horaires_id" value="${horaire.horaires_id}" /></td>
                        <td><button type="button" onclick="submitForm('${formId}')">Mettre à jour</button></td>
                    </tr>`;

                // Entourer le formulaire autour de la ligne de tableau
                table.innerHTML += `<form id="${formId}">${row}</form>`;
            });
        } catch (error) {
            console.error("Erreur lors de la récupération des horaires :", error);
        }
    }

    // Fonction pour soumettre le formulaire
    async function submitForm(formId) {
        const form = document.getElementById(formId);
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = key === 'ferme' ? (form.elements['ferme'].checked ? 1 : 0) : value;
        });

        // Vérifiez que `horaires_id` est bien présent
        if (!data['horaires_id']) {
            console.error("Clé `horaires_id` manquante dans les données envoyées.");
            return;
        }

        // Loguez les données pour vérifier
        console.log("Données envoyées :", JSON.stringify(data));

        try {
            const response = await fetch('./horaires_api.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            });

            if (!response.ok) throw new Error(`Erreur HTTP: ${response.status}`);
            const resultText = await response.text();

            let result;
            try {
                result = JSON.parse(resultText);
            } catch (error) {
                console.error("Erreur lors du parsing JSON de la mise à jour :", error, resultText);
                return;
            }

            console.log("Résultat de la mise à jour :", result);
        } catch (error) {
            console.error("Erreur lors de la mise à jour :", error);
        }

        // Actualiser les horaires après la mise à jour
        fetchHoraires();
    }

    // Charger les horaires lorsque la page est chargée
    window.onload = fetchHoraires;
</script>


</head>
<body>
    <h1 style="text-align: center;">Gestion des Horaires d'Ouverture</h1>
    <table border="1" align="center">
        <thead>
            <tr>
                <th>Jour</th>
                <th>Heure d'Ouverture</th>
                <th>Heure de Fermeture</th>
                <th>Fermé</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="horaires-table">
            <!-- Les horaires seront affichés ici -->
        </tbody>
    </table>
</body>
</html>
