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
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="container">
        <div class="form-section">
        <form id="admin-form" method="POST" action="php/api.php" enctype="multipart/form-data">
    <h2>Créer une Carte</h2>
    <div class="drop-zone" id="drop-zone">
        <p>Faites glisser une image ici / cliquez pour sélectionner un fichier / Appuyer sur Contrôle + V</p>
    </div>
    <input type="file" name="image" id="image-file" style="position: absolute; opacity: 0; width: 1px; height: 1px; overflow: hidden;" accept="image/*" required>
    <input type="text" name="name" id="party-name" placeholder="Nom du parti" autofocus autocomplete="off" required>
    <div id="skills-container">
                    <script>
                        const skills = [
                            "nucleaire",
                            "education",
                            "emploie",
                            "droit_travail",
                            "droit_lgbtquia",
                            "feminisme",
                            "impot",
                            "pouvoir_achat",
                            "ecologie",
                            "retraite",
                            "salaire",
                            "droit_animeaux",
                            "agriculture",
                            "europe",
                            "immigration",
                            "sante"
                        ];

                        const labels = [
                            "Nucléaire",
                            "Education",
                            "Emploie",
                            "Droit du travail",
                            "Droit lgbtquia+",
                            "Féminisme",
                            "Impôt",
                            "Pouvoir d'achat",
                            "Écologie",
                            "Retraite",
                            "Salaire",
                            "Droit des animaux",
                            "Agriculture",
                            "Europe",
                            "Immigration",
                            "Santé"
                        ];

                        const options = ["-", "↑", "↓"];

                        skills.forEach((skill, index) => {
                            document.write(`<label for="${skill}">${labels[index]}:</label>`);
                            document.write(`<select id="${skill}" name="${skill}" required onchange="updateSkill('${skill}', this.value)">`);
                            options.forEach(option => {
                                document.write(`<option value="${option}">${option}</option>`);
                            });
                            document.write(`</select>`);
                        });
                    </script>
                </div>
                <button type="submit">Enregistrer</button>
            </form>
        </div>
        <div class="preview-section">
            <h2>Prévisualisation de la Carte</h2>
            <div class="preview" id="preview">
                <div class="card">
                    <img id="preview-image" src="#" alt="Preview">
                    <div class="content">
                        <div class="name" id="preview-name"></div>
                        <ul class="container-icon" id="preview-skills">
                            <script>
                                skills.forEach(skill => {
                                    document.write(`
                                        <li class="icon">
                                            <svg class="icon-svg"></svg>
                                            <div class="icon-name">${skill}</div>
                                            <div class="valeur" id="valeur-${skill}">-</div>
                                        </li>
                                    `);
                                });
                            </script>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const dropZone = document.getElementById('drop-zone');
    const imageFileInput = document.getElementById('image-file');
    const previewImage = document.getElementById('preview-image');
    const partyNameInput = document.getElementById('party-name');
    const previewName = document.getElementById('preview-name');

    partyNameInput.addEventListener('input', () => {
        previewName.textContent = partyNameInput.value;
    });

    dropZone.addEventListener('click', () => {
        imageFileInput.click();
    });

    imageFileInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });

    document.addEventListener('paste', (event) => {
    let pasteEvent = event.clipboardData || window.clipboardData;
    let items = pasteEvent.items;

    for (let i = 0; i < items.length; i++) {
        if (items[i].type.indexOf('image') !== -1) {
            let blob = items[i].getAsFile();
            handleFiles([blob]); // Appeler la fonction pour gérer le fichier collé
            break;
        }
    }
});


    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight() {
        dropZone.classList.add('highlight');
    }

    function unhighlight() {
        dropZone.classList.remove('highlight');
    }

    function handleDrop(e) {
        let dt = e.dataTransfer;
        let files = dt.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        const file = files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    dropZone.addEventListener('drop', handleDrop, false);


    function updateSkill(skill, value) {
        document.getElementById(`valeur-${skill}`).textContent = value;
    }


    </script>
</body>
</html>
