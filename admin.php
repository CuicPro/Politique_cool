<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>    
    <!-- Zone pour prévisualiser et éditer les cartes -->
    <div id="preview-cards" class="cards-container">
        <!-- Les cartes prévisualisées seront ajoutées ici dynamiquement -->
    </div>
    
    <form id="add-card-form">
        <div class="drop-zone" id="drop-zone">
        </div>
        <img id="preview-image" src="#" alt="Preview">


        <label for="name">Nom:</label><br>
        <input type="text" id="name" name="name"><br><br>
        <label for="skills">Compétences:</label><br>
        <div id="skills-container">
        <script>
                const skills = [
                    "Droit lgbtquia+",
                    "Droits des femmes",
                    "Nucléaire",
                    "Ecologie",
                    "Agricultures",
                    "Salaires",
                    "Emploie",
                    "Retraite",
                    "Education",
                    "Impôts",
                    "Immigration",
                    "Europe",
                    "Droit des animeaux",
                    "Pouvoir d'achat",
                    "Droit du Travail",
                    "Santé",
                ];

                const options = ["-","↑","↓"];

                skills.forEach(skill => {
                    document.write(`<label for="${skill}">${skill}:</label><br>`);
                    document.write(`<select id="${skill}" name="skills[]">`);
                    options.forEach(option => {
                        document.write(`<option value="${option}">${option}</option>`);
                    });
                    document.write(`</select><br><br>`);
                });
            </script>        
        </div>    
    <input type="submit" value="Ajouter Carte">









    </form>
    








    <script src="scripts.js"></script>
    <script>
        const dropZone = document.getElementById('drop-zone');
        const preview = document.getElementById('preview');
        const previewImage = document.getElementById('preview-image');

        // Empêcher le comportement par défaut du navigateur pour les glissements
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false)
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Gestion des événements de glissement
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false)
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false)
        });

        function highlight() {
            dropZone.classList.add('highlight');
        }

        function unhighlight() {
            dropZone.classList.remove('highlight');
        }

        // Gestion de l'événement de drop pour charger l'image
        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            let dt = e.dataTransfer;
            let files = dt.files;

            handleFiles(files);
        }

        // Gestion du clic pour sélectionner un fichier
        dropZone.addEventListener('click', () => {
            let input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = function(e) {
                handleFiles(e.target.files);
            };
            input.click();
        });

        // Fonction pour gérer les fichiers sélectionnés
        function handleFiles(files) {
            const file = files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Charger les cartes depuis index.html pour prévisualisation et édition
            fetch("api.php")
                .then(response => response.json())
                .then(cards => {
                    let previewCardsContainer = document.getElementById("preview-cards");
                    cards.forEach(card => {
                        let cardElement = document.createElement("div");
                        cardElement.className = "card";
                        cardElement.setAttribute("data-card-id", card.id); // Ajouter un attribut pour identifier la carte
                        cardElement.innerHTML = `
                            <img src="${card.image}" alt="${card.name}">
                            <h2>${card.name}</h2>
                            <p>${card.skills.join(", ")}</p>
                            <button class="edit-card-btn">Éditer</button>
                        `;
                        previewCardsContainer.appendChild(cardElement);
                    });
                })
                .catch(error => console.error("Error fetching cards:", error));
        });
    </script>
</body>
</html>
