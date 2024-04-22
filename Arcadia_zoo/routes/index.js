const express = require('express');
const router = express.Router();

// Route pour la page d'accueil
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});

// Route pour incrémenter les consultations d'un animal
router.post('/increment/:animalName', (req, res) => {
    const animalName = req.params.animalName;
    // Logique pour incrémenter les consultations de l'animal
    // Assurez-vous que cette logique est correctement implémentée
    // et qu'elle interagit correctement avec la base de données le cas échéant
    res.status(200).send(`Les consultations pour ${animalName} ont été incrémentées.`);
});

// Importez le router des routes de consultation
const consultationRoutes = require('./consultationsRoutes.js');

// Utilisez le router pour les routes de consultation
router.use('/consultations', consultationRoutes);

module.exports = router;
