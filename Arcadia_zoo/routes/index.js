var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});

module.exports = router;

// routes/index.js

const express = require('express');
const router = express.Router();

// Route pour incrémenter les consultations d'un animal
router.post('/increment/:Truche', (req, res) => {
    const animalName = req.params.animalName;
    // Logique pour incrémenter les consultations de l'animal
    res.status(200).send(`Les consultations pour ${animalName} ont été incrémentées.`);
});

module.exports = router;

// Importez le router des routes de consultation
const consultationRoutes = require('./routes/consultationRoutes');

// Utilisez le router pour les routes de consultation
app.use('/consultations', consultationRoutes);
