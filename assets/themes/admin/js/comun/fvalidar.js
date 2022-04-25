function EsTelefonoMovil(tel) {
				var test = /^[67]\d{8}$/;
				var telReg = new RegExp(test);
				return telReg.test(tel);
	}
	function EsTelefono(tel) {
		var test = /^[679]\d{8}$/;
		var telReg = new RegExp(test);
		return telReg.test(tel);
	}
function validarEntero(valor){

     var re = /^(-)?[0-9]*$/;
     return re.test(valor);
}

function EsEmail(w_email) {

	var test = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var emailReg = new RegExp(test);

	return emailReg.test(w_email);
}
function makeid()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 14; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}
