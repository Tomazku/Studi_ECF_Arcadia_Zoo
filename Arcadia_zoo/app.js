var express = require('express');
var path = require('path');
var cookieParser = require('cookie-parser');
var logger = require('morgan');
var cors = require('cors');
var createError = require('http-errors');

var indexRouter = require('./routes/index');
var usersRouter = require('./routes/users');
var consultationsRouter = require('./routes/consultationsRoutes'); // Ajoutez ceci si ce n'est pas déjà fait

var app = express();

// Configuration de CORS
const corsOptions = {
    origin: 'http://arcadia-zoo', // Remplacez par l'origine exacte de votre frontend
    optionsSuccessStatus: 200 // Pour les navigateurs hérités qui ne gèrent pas les codes de statut 204
};
app.use(cors(corsOptions)); // Appliquer CORS globalement

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
app.use('/consultations', consultationsRouter); // Utilisez votre router consultations ici

// Middleware pour la gestion des erreurs non trouvées (404)
app.use(function(req, res, next) {
  next(createError(404));
});

// Middleware pour la gestion des erreurs globales
app.use(function(err, req, res, next) {
  // Définit les locals, fournit uniquement des erreurs en développement
  res.locals.message = err.message;
  res.locals.error = req.app.get('env') === 'development' ? err : {};

  // Ajout de status pour Jade
  res.locals.status = err.status || 500;

  // Provide a title for the error page
  res.locals.title = "Error Page";

  // render the error page
  res.status(err.status || 500);
  res.render('error');
});

// Connexion à MongoDB
const mongoose = require('mongoose');
mongoose.connect('mongodb://localhost:27017/Arcadia_zoo').then(() => {
    console.log('Connexion à MongoDB réussie');
}).catch((err) => {
    console.error('Erreur de connexion à MongoDB:', err);
});

module.exports = app;
