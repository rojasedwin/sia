const express = require('express');
//const dotenv =require('dotenv');
//const cookieParser = require('cookie-parser');


const app=express();


//PUERTO
app.set('port', process.env.PORT || 4500);

//ESCUCHA
app.listen(app.get('port'), () => {
    console.log('Servidor en puerto', app.get('port'));
});

//utilizar el motor de plantillas
app.set('view engine', '.ejs');

//carpetas publicas
app.use(express.static('public'));

//procesar form
app.use(express.urlencoded({extended: false }));
//enviar y recibir json
app.use(express.json());

//Variables de entorno
//dotenv.config({path: './env/.env'})

//Cookies
//app.use(cookieParser)

//RUTAS = Urls
app.use('/', require('./routes/router'))

