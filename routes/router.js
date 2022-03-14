const express = require('express');
const router = express.Router();

const conexion  = require('../database/db');

router.get('/', (req, res) => {
   conexion.query('Select * from users',(error,results)=>{
       if(error){
        console.log('El error de conexion es: '+error);
        return;
       }else{
       res.render('index',{results:results});
        //res.send(results);
        //console.log(results);
       }
   });
    
});

router.get('/login', (req, res) => {
    res.render('login',{alert:false});
    
});

router.get('/register', (req, res) => {
    res.render('register');

});

router.get('/dashboard', (req, res) => {
    res.render('dashboard');
});

/*router.post('/login', (req, res) => {
    console.log('aqui');
});

router.post('/register', crud.register);*/


const crud  = require('../controller/authController');

router.post('/save', crud.save);
router.post('/login', crud.login);

module.exports = router;