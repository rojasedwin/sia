const jwt   = require('jsonwebtoken');
const bcryptjs   = require('bcryptjs');
const conexion   = require('../database/db');
const {promisify}   = require('util');

//Metodos
exports.register = (req, res)=>{
    
    console.log('user_name + user_lastname + user_login + user_pass');
}

exports.save = async (req, res)=>{
    
   try{
    const nombre =req.body.user_name;
    const apellido=req.body.user_lastname;
    const login=req.body.user_login;
    const pass=req.body.user_pass;
    let passHash=await bcryptjs.hash(pass,8);
    //console.log(nombre+" "+apellido+" "+login+" "+passHash);
 
    //Inserto en BBDD
    conexion.query('INSERT INTO users set ?', {user_name:nombre, user_lastname:apellido, user_login:login, user_pass:passHash}, (error, results)=>{
     if(error){
         console.log('El error de query es: '+error);
         return;
     }else{
         res.redirect('/');
     }
 
    });

   }catch(error){
    console.log(error);

   }
}

exports.login = async (req, res)=>{
    
    try{
     
     const login=req.body.user_login;
     const pass=req.body.user_pass;
     let passHash=await bcryptjs.hash(pass,8);
     console.log(login+" "+passHash);

     let alert='false';

     if(!login || !pass){
         res.render('login',{
             alert:true,
             alertTitle: "Advertencia",
             alertMessage: "Ingrese un usuario y password",
             alertIcon:"error",
             showConfirmButton: true,
             timer: false,
             ruta: "login"

         })
     }else{
        
     }
  
     //Inserto en BBDD
     /*conexion.query('INSERT INTO users set ?', {user_name:nombre, user_lastname:apellido, user_login:login, user_pass:passHash}, (error, results)=>{
      if(error){
          console.log('El error de query es: '+error);
          return;
      }else{
          res.redirect('/');
      }
  
     });*/
 
    }catch(error){
     console.log(error);
 
    }
 }