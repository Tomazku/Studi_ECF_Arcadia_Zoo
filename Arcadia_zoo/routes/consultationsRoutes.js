// Importer les modules nécessaires
const express = require('express');
const router = express.Router();
const Animal = require('./animal.js');

// Route pour incrémenter les consultations pour un animal spécifique
router.post('/increment-consultations/:animalId', async (req, res, next) => {
  try {
    const { animalId } = req.params;

    // Trouver l'animal dans la base de données
    const animal = await Animal.findById(animalId);

    // Vérifier si l'animal existe
    if (!animal) {
      return res.status(404).json({ message: 'Animal non trouvé' });
    }

    // Incrémenter les consultations de l'animal
    animal.consultations++;

    // Enregistrer les modifications dans la base de données
    await animal.save();

    // Répondre avec les nouvelles consultations de l'animal
    res.json({ consultations: animal.consultations });
  } catch (error) {
    // Gérer les erreurs
    next(error);
  }
});

// Exporter le router
module.exports = router;
