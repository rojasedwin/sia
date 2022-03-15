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
                    //inicio de sesión OK
                    const id = results[0].id
                    console.log(id)
                   const token = jwt.sign({id: id}, 'secret', {
                        expiresIn: '7d'
                   })
                   console.log(token)
                    //generamos el token SIN fecha de expiracion
                 console.log("TOKEN: "+token+" para el USUARIO : "+user)
                   console.log("TOKEN: "+id+" para el USUARIO : "+user)

                   const cookiesOptions = {
                        expires: new Date(Date.now()+process.env.JWT_COOKIE_EXPIRES * 24 * 60 * 60 * 1000),
                        httpOnly: true
                   }
                   res.cookie('jwt', token, cookiesOptions)
                   res.render('login', {
                        alert: true,
                        alertTitle: "Conexión exitosa",
                        alertMessage: "¡LOGIN CORRECTO!",
                        alertIcon:'success',
                        showConfirmButton: false,
                        timer: 800,
                        ruta: 'dashboard'
                   })
                }
            })
        }
    } catch (error) {
        console.log(error)
    }
}