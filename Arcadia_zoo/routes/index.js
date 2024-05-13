const express = require('express');
const router = express.Router();

// Importez le router des routes de consultation
const consultationRoutes = require('./consultationsRoutes.js');

// Route pour la page d'accueil
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});

// Utilisez le router pour les routes de consultation
router.use('/consultations', consultationRoutes);

module.exports = router;
