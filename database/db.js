const mysql = require('mysql');

const conexion  = mysql.createConnection({
    host: 'localhost', 
    user: 'root', 
    password: '', 
    database: 'sianew'
})

conexion.connect( (error) =>{
    if(error){
        console.log('El error de conexion es: '+error);
        return;
    }
    console.log('Conectado a la BD correctamente');
})

module.exports  = conexion;