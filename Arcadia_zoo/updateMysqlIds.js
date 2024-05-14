const mongoose = require('mongoose');
const Animal = require('./models/animal');
const mysqlPool = require('./config/mysqlConnection');

mongoose.connect('mongodb://localhost:27017/Arcadia_zoo', { useNewUrlParser: true, useUnifiedTopology: true });

async function updateMysqlIds() {
  const [mysqlAnimals] = await mysqlPool.query('SELECT * FROM animal');

  for (const mysqlAnimal of mysqlAnimals) {
    await Animal.updateOne({ name: mysqlAnimal.prenom }, { mysqlId: mysqlAnimal.animal_id });
  }

  console.log('Mise à jour des IDs MySQL terminée');
  mongoose.disconnect();
}

updateMysqlIds().catch(console.error);
