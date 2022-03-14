const express = require('express');
const router = express.Router();

//const conexion  = require('../database/db');
const authController    = require('../controller/authController');

router.get('/', (req, res) => {
    res.render('index');
});

router.get('/login', (req, res) => {
    res.render('login');
    
});

router.get('/register', (req, res) => {
    res.render('register');
    console.log('hola');
});

router.get('/dashboard', (req, res) => {
    res.render('dashboard');
});

router.post('/register', (req, res) => {
    console.log('hola');
});

//router.post('/register', authController.register);

module.exports = router;