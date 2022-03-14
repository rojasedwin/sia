const jwt   = require('jsonwebtoken');
const bcryptjs   = require('bcryptjs');
const conexion   = require('../database/db');
const {promisify}   = require('util');

//Metodos
exports.register = async(req, res)=>{
    const user_name= req.body.user_name;
    const user_lastname= req.body.user_lastname;
    const user_login= req.body.user_login;
    const user_pass= req.body.user_pass;
    console.log(user_name + user_lastname + user_login + user_pass);
}