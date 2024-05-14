const mysql = require('mysql2');

const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '', 
  database: 'arcadia_zoo'
});

module.exports = pool.promise(); 