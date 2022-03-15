const jwt   = require('jsonwebtoken');
const bcryptjs   = require('bcryptjs');
const conexion   = require('../database/db');
const {promisify}   = require('util');


exports.save = async (req, res)=>{
    
   try{
    const nombre =req.body.user_name;
    const apellido=req.body.user_lastname;
    const login=req.body.user_login;
    const pass=req.body.user_pass;
    let passHash=await bcryptjs.hash(pass,8);
    //console.log(nombre+" "+apellido+" "+login+" "+passHash);
 
    //Inserto en BBDD
    conexion.query('INSERT INTO users set ?', {user_name:nombre, user_lastname:apellido, user:login, pass:passHash}, (error, results)=>{
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
    try {
        const user = req.body.user
        const pass = req.body.pass       

        if(!user || !pass ){
            res.render('login',{
                alert:true,
                alertTitle: "Advertencia",
                alertMessage: "Ingrese un usuario y password",
                alertIcon:'info',
                showConfirmButton: true,
                timer: false,
                ruta: 'login'
            })
        }else{
            conexion.query('SELECT * FROM users WHERE user = ?', [user], async (error, results)=>{
                if( results.length == 0 || ! (await bcryptjs.compare(pass, results[0].pass)) ){
                    res.render('login', {
                        alert: true,
                        alertTitle: "Error",
                        alertMessage: "Usuario y/o Password incorrectas",
                        alertIcon:'error',
                        showConfirmButton: true,
                        timer: false,
                        ruta: 'login'    
                    })
                }else{
                    //creamos una var de session y le asignamos true si INICIO SESSION       
				//req.session.loggedInAdmin = true;                
				//req.session.user = results[0].user_name;
				res.render('login', {
					alert: true,
					alertTitle: "Conexión exitosa",
					alertMessage: "¡LOGIN CORRECTO!",
					alertIcon:'success',
					showConfirmButton: false,
					timer: 1500,
					ruta: ''
				});        			
                }
            })
        }
    } catch (error) {
        console.log(error)
    }
}