var createError = require('http-errors');
var express = require('express');
var path = require('path');
var cookieParser = require('cookie-parser');
var logger = require('morgan');
var cors = require('cors');

var indexRouter = require('./routes/index');
var usersRouter = require('./routes/users');
var animalRouter = require('./routes/animal'); // Assurez-vous d'importer votre router pour les animaux

var app = express();

// Configuration de CORS
const corsOptions = {
    origin: 'http://arcadia-zoo', 
    optionsSuccessStatus: 200 
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
app.use('/animal', animalRouter); // Utilisez votre router animal ici

// Middleware pour la gestion des erreurs non trouvées (404)
app.use(function(req, res, next) {
  next(createError(404));
});

// Middleware pour la gestion des erreurs globales
app.use(function(err, req, res, next) {
  // Set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get('env') === 'development' ? err : {};

  // Provide a title for the error page
  res.locals.title = "Error Page";

  // render the error page
  res.status(err.status || 500);
  res.render('error');
});
