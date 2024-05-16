const express = require('express');
const router = express.Router();
const Animal = require('../models/animal');
const mysqlPool = require('../config/mysqlConnection');


// Route pour incrémenter les consultations pour un animal spécifique
router.post('./increment-consultations/:animalName', async (req, res, next) => {
  console.log('ploplo');
  const { animalName } = req.params;
  console.log('Requête pour incrémenter les consultations pour:', animalName);

  try {
    // Vérifiez d'abord dans MySQL
    const [results] = await mysqlPool.query('SELECT * FROM animal WHERE prenom = ?', [animalName]);
    console.log('Résultats MySQL:', results);

    if (results.length === 0) {
      return res.status(404).json({ message: 'Animal non trouvé dans MySQL' });
    }

    // Si l'animal existe dans MySQL, procédez dans MongoDB en utilisant le prénom
    const animal = await Animal.findOne({ name: animalName });
    console.log('Animal MongoDB:', animal);

    if (!animal) {
      return res.status(404).json({ message: 'Animal non trouvé dans MongoDB' });
    }
    animal.consultations++;
    await animal.save();
    res.json({ consultations: animal.consultations });
  } catch (error) {
    console.error('Erreur lors de l\'incrémentation des consultations:', error);
    res.status(500).json({ message: 'Erreur interne du serveur' });
  }
});

// Route pour obtenir le nombre de consultations pour un animal spécifique
router.get('/get-consultations/:animalName', async (req, res) => {
  const { animalName } = req.params;
  console.log('Requête pour obtenir les consultations pour:', animalName);

  try {
    // Vérifiez d'abord dans MySQL
    const [results] = await mysqlPool.query('SELECT * FROM animal WHERE prenom = ?', [animalName]);
    console.log('Résultats MySQL:', results);

    if (results.length === 0) {
      return res.status(404).json({ message: 'Animal non trouvé dans MySQL' });
    }

    // Si l'animal existe dans MySQL, procédez dans MongoDB en utilisant le prénom
    const animal = await Animal.findOne({ name: animalName });
    console.log('Animal MongoDB:', animal);

    if (!animal) {
      return res.status(404).json({ message: 'Animal non trouvé dans MongoDB' });
    }
    res.json({ consultations: animal.consultations });
  } catch (error) {
    console.error('Erreur lors de la récupération des consultations:', error);
    res.status(500).json({ message: 'Erreur interne du serveur' });
  }
});

module.exports = router;
