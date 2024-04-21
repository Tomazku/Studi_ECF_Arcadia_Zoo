const mongoose = require('mongoose');

const animalSchema = new mongoose.Schema({
  name: {
    type: String,
    required: true
  },
  type: {
    type: String,
    required: true
  },
  description: {
    type: String,
    required: true
  },
  consultationCount: {
    type: Number,
    default: 0
  }
});

const Animal = mongoose.model('Animal', animalSchema);

module.exports = Animal;

//Création d'un Animal :

router.post('/consultations', async (req, res, next) => {
    try {
      const { name, species } = req.body;
      const newAnimal = await Animal.create({ name, species });
      res.status(201).json(newAnimal); // Renvoie le nouvel animal créé
    } catch (error) {
      next(error); // Gérer les erreurs
    }
  });
  
  //Lecture d'un Animal :

  router.get('/consultations/animal/:id', async (req, res, next) => {
    try {
      const animal = await Animal.findById(req.params.id);
      if (!animal) {
        return res.status(404).json({ message: 'Animal non trouvé' });
      }
      res.json(animal); // Renvoie les détails de l'animal trouvé
    } catch (error) {
      next(error); // Gérer les erreurs
    }
  });
  
  //Mise à Jour d'un Animal :

  router.put('/consultations/animal/:id', async (req, res, next) => {
    try {
      const { name, species } = req.body;
      const updatedAnimal = await Animal.findByIdAndUpdate(req.params.id, { name, species }, { new: true });
      if (!updatedAnimal) {
        return res.status(404).json({ message: 'Animal non trouvé' });
      }
      res.json(updatedAnimal); // Renvoie l'animal mis à jour
    } catch (error) {
      next(error); // Gérer les erreurs
    }
  });

  //Suppression d'un Animal :

  router.delete('/consultations/animal/:id', async (req, res, next) => {
    try {
      const deletedAnimal = await Animal.findByIdAndDelete(req.params.id);
      if (!deletedAnimal) {
        return res.status(404).json({ message: 'Animal non trouvé' });
      }
      res.json({ message: 'Animal supprimé avec succès' });
    } catch (error) {
      next(error); // Gérer les erreurs
    }
  });
  
  