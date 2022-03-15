const mysql = require('mysql');

const conexion  = mysql.createConnection({
    host: 'localhost', 
    user: 'root', 
    password: '', 
    database: 'sianew'
})

/*const conexion  = mysql.createConnection({
    host: 'us-cdbr-iron-east-01.cleardb.net', 
    user: 'b84edc25641db3', 
    password: '36094175', 
    database: 'heroku_55e1d1d5ed983d2'
})*/


conexion.connect( (error) =>{
    if(error){
        console.log('El error de conexion es: '+error);
        return;
    }
    console.log('Conectado a la BD correctamente');
})

module.exports  = conexion;