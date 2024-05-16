const mysql = require('mysql2/promise');

const mysqlPool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'arcadia_zoo'
});

module.exports = mysqlPool;
