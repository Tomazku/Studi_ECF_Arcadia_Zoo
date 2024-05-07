const mongoose = require('mongoose');

const animalSchema = new mongoose.Schema({
  name: {
    type: String,
    required: true
  },
  species: { 
    type: String,
    required: true
  },
  description: {
    type: String,
    required: true
  },
  consultations: { 
    type: Number,
    default: 0
  }
});

const Animal = mongoose.model('Animal', animalSchema);

module.exports = Animal;