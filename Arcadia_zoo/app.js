var createError = require('http-errors');
var express = require('express');
var path = require('path');
var cookieParser = require('cookie-parser');
var logger = require('morgan');

var indexRouter = require('./routes/index');
var usersRouter = require('./routes/users');

var app = express();

// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'jade');

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', indexRouter);
app.use('/users', usersRouter);

// Middleware pour la gestion des erreurs non trouvées (404)
app.use(function(req, res, next) {
  next(createError(404));
});

// Middleware pour la gestion des erreurs globales
app.use(function(err, req, res, next) {
  // Si une erreur de connexion à MongoDB
  if (err.name === 'MongoError') {
    console.error('Erreur de connexion à MongoDB :', err);
    err.message = 'Erreur de connexion à la base de données';
    err.status = 500; // Ou un autre code d'erreur approprié
  }

  // Rendu de la page d'erreur
  res.status(err.status || 500);
  res.render('error', { error: err });
});

// Connexion à MongoDB
const mongoose = require('mongoose');

mongoose.connect('mongodb://localhost:27017/Arcadia_zoo', { useNewUrlParser: true, useUnifiedTopology: true })
  .then(() => console.log('Connexion à MongoDB réussie'))
  .catch((err) => console.error('Erreur de connexion à MongoDB', err));

// Middleware pour la gestion des erreurs de connexion à MongoDB
mongoose.connection.on('error', (err) => {
  console.error('Erreur de connexion à MongoDB :', err);
});
