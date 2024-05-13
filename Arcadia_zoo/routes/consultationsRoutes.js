// Importer les modules nécessaires
const express = require('express');
const router = express.Router();
const Animal = require('./animal'); // Assurez-vous que le chemin d'accès est correct

// D'autres routes peuvent être ici

// Route pour incrémenter les consultations pour un animal spécifique
router.post('/increment-consultations/:animalId', async (req, res, next) => {
  try {
    const { animalId } = req.params;
    const animal = await Animal.findById(animalId);
    if (!animal) {
      res.status(404).json({ message: 'Animal non trouvé' });
      return;
    }
    animal.consultations++;
    await animal.save();
    res.json({ consultations: animal.consultations });
  } catch (error) {
    console.error('Erreur lors de l\'incrémentation des consultations:', error);
    res.status(500).json({ message: 'Erreur interne du serveur' });
  }
});

// Assurez-vous d'exporter le router à la fin du fichier
module.exports = router;
