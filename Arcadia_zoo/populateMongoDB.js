const mongoose = require('mongoose');
const mysqlPool = require('./config/mysqlConnection');
const Animal = require('./models/animal');

mongoose.connect('mongodb://localhost:27017/Arcadia_zoo', { useNewUrlParser: true, useUnifiedTopology: true });

async function populateMongoDB() {
  try {
    const [mysqlAnimals] = await mysqlPool.query('SELECT * FROM animal');

    for (const mysqlAnimal of mysqlAnimals) {
      const newAnimal = new Animal({
        name: mysqlAnimal.prenom,
        species: mysqlAnimal.race_id, // Mettez ici la correspondance correcte pour le champ 'species'
        description: mysqlAnimal.etat, // Mettez ici la correspondance correcte pour le champ 'description'
        consultations: 0 // Initialiser les consultations à 0
      });

      await newAnimal.save();
    }

    console.log('Les animaux ont été transférés de MySQL à MongoDB');
    mongoose.disconnect();
  } catch (error) {
    console.error('Erreur lors du transfert des animaux de MySQL à MongoDB:', error);
    mongoose.disconnect();
  }
}

populateMongoDB();
