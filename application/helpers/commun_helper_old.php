<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
  $gmt = 1*60*60;
  $gmt =  date('Z');
function debug($var)
{
  echo "<pre>";
  print_r($var);
  echo "</pre>";
}
function last_query()
{
  $CI =& get_instance();
  echo $CI->db->last_query();
}
function getMyTime()
{
  $utc_offset =  date('Z');
  $ahora = gmdate("Y-m-d H:i:s",time() + $utc_offset);
  return $ahora;
}
function rutime($ru, $rus, $index) {
    return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
     -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
}
function hex2rgba($color, $opacity = false) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
          return $default;

	//Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
}

function folderSize ($dir)
{
    $size = 0;
    foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
        $size += is_file($each) ? filesize($each) : folderSize($each);
    }
    return $size;
}
function guardar_log($data)
{
  $CI =& get_instance();
  return $CI->db->insert('log_acciones',$data);
}
function encodeURIComponent($str) {
   $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
   return strtr(rawurlencode($str), $revert);
}
function indexar_array($array)
{
  if(count($array)>0)
  {
      $new_array = array();
    foreach($array as $valor)
      $new_array[ $valor ] = $valor;
    return $new_array;
  }
  return array();
}
function indexar_array_vacio($array)
{
  if(count($array)>0)
  {
    $new_array = array();
    foreach($array as $valor)
      $new_array[ $valor ] = "";
    return $new_array;
  }
  return array();
}
function indexar_array_por_campo($array,$campo)
{
  if(count($array)>0)
  {
    $new_array = array();
    foreach($array as $datos)
      $new_array[ $datos[ $campo ] ] = $datos;
    return $new_array;
  }
  return array();
}
function devolver_array_por_campo($array,$campo)
{
  if(count($array)>0)
  {
    $new_array = array();
    foreach($array as $datos)
      array_push($new_array,$datos[ $campo ]);
    return $new_array;
  }
  return array();
}
function encodeItem($input){
  return md5($input);
}

function cambiar_formato($fecha)
{
  if($fecha!="")
  {
  $tmp = explode("-",$fecha);
  return $tmp[2]."-".$tmp[1]."-".$tmp[0];
  }
  return "";
}
function sumar_dias($fecha,$dias)
{
  $fecha_ini = strtotime($fecha);
  $un_dia = 24*60*60; $dias_sumados = 0;
  while($dias_sumados<$dias)
  {
    $fecha_ini += $un_dia;
    $dias_sumados++;
  }
  return date("Y-m-d",$fecha_ini);
}
function sumar_dias_laborables($fecha,$dias,$laborables)
{
  $fecha_ini = strtotime($fecha);
  $un_dia = 24*60*60; $dias_sumados = 0;
  while($dias_sumados<$dias)
  {
    $fecha_ini += $un_dia;
    if(in_array(date("w",$fecha_ini),$laborables))  $dias_sumados++;
  }
  return date("Y-m-d",$fecha_ini);
}
function calcular_dias($fecha1,$fecha2)
{
  $fecha_ini = strtotime($fecha1);
  $fecha_fin = strtotime($fecha2);
  $final = 1;
  //echo "Fini ".$fecha_ini." y ".$fecha_fin;
  if($fecha_ini==$fecha_fin) return 0;
  if($fecha_ini>$fecha_fin)
  {
    $final = -1;
    $fecha_ini = strtotime($fecha2);
    $fecha_fin = strtotime($fecha1);
  }
  $un_dia = 24*60*60; $dias_sumados = 0;
  while($fecha_ini<$fecha_fin)
  {
    $fecha_ini += $un_dia;
    $dias_sumados++;
  }
  return $dias_sumados*$final;
}
function calcular_tiempo($fecha_ini,$fecha_fin)
{
  $f_ini = strtotime($fecha_ini);
  $f_fin = strtotime($fecha_fin);
  $resto = $f_fin - $f_ini;
  $dias = floor($resto/(60*60*24));
  //echo "Tengo resto ".$resto;

  if($dias>0)
  {
    if($dias==1) return "1 día";
    else return $dias." días";
  }
  $horas = floor($resto/(60*60));
  $devolver = "";
  if($horas>0)
  {
    if($horas==1) $devolver = "1 hora ";
    else $devolver = $horas." horas ";
  }
  $minutos = floor(($resto - ($horas*60*60))/60);
  if($minutos>0)
  {
    if($minutos==1) $devolver .= " 1 minuto";
    else  $devolver .= $minutos." minutos";
  }
  elseif($devolver=="") {
    return " 1 minuto ";
  }

  return $devolver;
}
function calcular_tiempo_detalle($fecha_ini,$fecha_fin)
{
  $f_ini = strtotime($fecha_ini);
  $f_fin = strtotime($fecha_fin);
  $resto = $f_fin - $f_ini;
  $dias = floor($resto/(60*60*24));
  //echo "Tengo resto ".$resto;

  if($dias>0)
  {
    $temp = "";
    if($dias==1) $temp = "1 día";
    else $temp = $dias." días";
    $resto -= $dias*(60*60*24);
    $horas = floor($resto/(60*60));
    $devolver = "";
    if($horas>0)
    {
      if($horas==1) return $temp. " y 1 hora ";
      else return $temp." y ". $horas." horas ";
    }
    return $temp;
  }
  $horas = floor($resto/(60*60));
  $devolver = "";
  if($horas>0)
  {
    if($horas==1) $devolver = "1 hora ";
    else $devolver = $horas." horas ";
  }
  $minutos = floor(($resto - ($horas*60*60))/60);
  if($minutos>0)
  {
    if($minutos==1) $devolver .= " 1 minuto";
    else  $devolver .= $minutos." minutos";
  }
  elseif($devolver=="") {
    return " 1 minuto ";
  }

  return $devolver;
}
function mostrar_tiempo_hace($strtotime)
{
  $resto = $strtotime;
  $dias = floor($resto/(60*60*24));
  //echo "Tengo resto ".$resto;

  if($dias>0)
  {
    $temp = "";
    if($dias==1) $temp = "1 día";
    else $temp = $dias." días";
    $resto -= $dias*(60*60*24);
    $horas = floor($resto/(60*60));
    $devolver = "";
    if($horas>0)
    {
      if($horas==1) return $temp. " y 1 hora ";
      else return $temp." y ". $horas." horas ";
    }
    return $temp;
  }
  $horas = floor($resto/(60*60));
  $devolver = "";
  if($horas>0)
  {
    if($horas==1) $devolver = "1 hora ";
    else $devolver = $horas." horas ";
  }
  $minutos = floor(($resto - ($horas*60*60))/60);
  if($minutos>0)
  {
    if($minutos==1) $devolver .= " 1 minuto";
    else  $devolver .= $minutos." minutos";
  }
  elseif($devolver=="") {
    return " 1 minuto ";
  }

  return $devolver;
}
function fecha_ultimo_dia_mes($fecha=null)
{
  $fecha = ($fecha==null ? date("Y-m-d") : $fecha);
  $fecha = new DateTime($fecha);
  $fecha->modify('last day of this month');
  return $fecha->format('Y-m-d');
}
function ultimo_dia_mes($fecha)
{
  $fecha = new DateTime($fecha);
  $fecha->modify('last day of this month');
  return $fecha->format('j');
}
function primer_dia_mes($fecha)
{
  $fecha = new DateTime($fecha);
  $fecha->modify('first day of this month');
  return $fecha->format('j');
}
function dia_fecha($fecha)
{
	$fecha = strtotime($fecha);
	// Obtenemos y traducimos el nombre del día
	$dia=date("w",$fecha);
	if ($dia==1) $dia="Lunes";
	if ($dia==2) $dia="Martes";
	if ($dia==3) $dia="Miércoles";
	if ($dia==4) $dia="Jueves";
	if ($dia==5) $dia="Viernes";
	if ($dia==6) $dia="Sábado";
	if ($dia==6) $dia="Domingo";

	return $dia;
}
function fecha_red($fecha)
{
  return date("M j Y",strtotime($fecha));
}
function fecha_red2($fecha)
{
  return date("M j Y",$fecha);
}
function redondear($num,$decimales)
{
  $factor = pow(10,$decimales);
  return round($num * $factor) / $factor;
}
function obtenerExtensionFichero($str) {
    $tmp = explode(".", $str);
    return end($tmp);
}

function parseSimbolos($str) {
    $str = preg_replace("/¡|\(|\)|<|>|¿|\?|!|\^|'|:|;|,|@|#|\$|%|€|&|\"|~|\+|\*|\/|\||\\|\[|\]||\{|\}|=/","",$str);

    $str = parseCaracteresRaros($str);

    return $str;
}

function parseCaracteresRaros($str) {
    $str = str_replace('ñ', 'n', $str);
    $str = str_replace('Ñ', 'N', $str);
    $str = str_replace('@', 'o-a', $str);
    $str = str_replace('á', 'a', $str);
    $str = str_replace('é', 'e', $str);
    $str = str_replace('í', 'i', $str);
    $str = str_replace('ó', 'o', $str);
    $str = str_replace('ú', 'u', $str);
    $str = str_replace('Á', 'A', $str);
    $str = str_replace('É', 'E', $str);
    $str = str_replace('Í', 'I', $str);
    $str = str_replace('Ó', 'O', $str);
    $str = str_replace('Ú', 'U', $str);
    $str = str_replace('à', 'a', $str);
    $str = str_replace('è', 'e', $str);
    $str = str_replace('ì', 'i', $str);
    $str = str_replace('ò', 'o', $str);
    $str = str_replace('ù', 'u', $str);
    $str = str_replace('À', 'A', $str);
    $str = str_replace('È', 'E', $str);
    $str = str_replace('Ì', 'I', $str);
    $str = str_replace('Ò', 'O', $str);
    $str = str_replace('Ù', 'U', $str);
    $str = str_replace('ä', 'a', $str);
    $str = str_replace('ë', 'e', $str);
    $str = str_replace('ï', 'i', $str);
    $str = str_replace('ö', 'o', $str);
    $str = str_replace('ü', 'u', $str);
    $str = str_replace('Ä', 'A', $str);
    $str = str_replace('Ë', 'E', $str);
    $str = str_replace('Ï', 'I', $str);
    $str = str_replace('Ö', 'O', $str);
    $str = str_replace('Ü', 'U', $str);
    $str = str_replace('â', 'a', $str);
    $str = str_replace('ê', 'e', $str);
    $str = str_replace('î', 'i', $str);
    $str = str_replace('ô', 'o', $str);
    $str = str_replace('û', 'u', $str);
    $str = str_replace('Â', 'A', $str);
    $str = str_replace('Ê', 'E', $str);
    $str = str_replace('Î', 'I', $str);
    $str = str_replace('Ô', 'O', $str);
    $str = str_replace('Û', 'U', $str);
    $str = str_replace('ã', 'a', $str);
    $str = str_replace('õ', 'o', $str);
    $str = str_replace('Ã', 'A', $str);
    $str = str_replace('Õ', 'O', $str);
    $str = str_replace('ç', 'c', $str);
    $str = str_replace('Ç', 'c', $str);
    $str = str_replace(' ', '_', $str);

    return trim($str);
}

function esImagen($path) {
  $path = trim($path,"/");
    $imageSizeArray = getimagesize($path);
    $imageTypeArray = $imageSizeArray[2];
    return (bool)(in_array($imageTypeArray , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)));
}
function getPlayer($ruta,$id="idplayer",$clase=""){

  $path = trim($ruta,"/");
  if(!file_exists($path)) return "<img class='".$clase."' src='/attachments/no_imagen.png'>";
  $formato = obtenerExtensionFichero($ruta);
  $player = "";
  if(esImagen($ruta))
  {
    $player = '<img  id="'.$id.'" class="'.$clase.'" src="'.$ruta.'">';
  }
  else {


  if ($formato != 'swf')
      $player = '<video class="'.$clase.'" controls  style=""  id="'.$id.'" preload="metadata">';

  if ($formato == 'mp4' || $formato == 'mov') {
      $player .= '<source src="'.$ruta.'#t=0.8" type="video/mp4" title="mp4">';
  }
  if ($formato == 'mpeg' || $formato == 'mpg') {
      $player .= '<source src="'.$ruta.'#t=0.8" type="video/mpeg" title="mpeg">';
  }
  if ($formato == 'avi') {
      $player .= '<source src="'.$ruta.'#t=0.8" type="video/x-msvideo" title="avi">';
  }
  if ($formato == 'webm') {
      $player .= '<source src="'.$ruta.'#t=0.8" type="video/webm" title="webm">';
  }
  if ($formato == 'ogv') {
      $player .= '<source src="'.$ruta.'#t=0.8" type="video/ogg" title="ogg">';
  }

  if ($formato == 'swf') {
      $player = '<object width="100%" height="100%" type="application/x-shockwave-flash" data="'.$ruta.'">
                  <param name="movie" value="'.$ruta.'" />
              </object>';
  }
  else {
      $player .= '<object width="100%" height="100%" type="application/x-shockwave-flash" data="mediaelement/flashmediaelement.swf">
                      <param name="movie" value="mediaelement/flashmediaelement.swf" />
                      <param name="flashvars" value="controls=false&file='.$ruta.'" />
                      <!-- Image fall back for non-HTML5 browser with JavaScript turned off and no Flash player installed
                      <img src="../media/echo-hereweare.jpg" width="640" height="360" alt="Here we are"
                      title="No video playback capabilities" />-->
                  </object>
              </video>';
  }
} //Es video

return $player;
}

/*function url_banner($url)
{
  return base_url()."/".url_title($url);
}*/

function getPreviewGaleria($name,$image,$activity="")
{
  $preview = "";
  $preview .= "<div class='preview_collaborator'><h1>".$name."</h1><h2>".$activity."</h2><img src='".$image."'>";

  $preview .= "</div>"; //<div class='preview_collaborator_cover'>&nbsp;</div>
  return $preview;
}

function getPreviewCollaborator($name,$image,$activity="")
{
  $preview = "";
  $preview .= "<div class='preview_collaborator'><h1>".$name."</h1><h2>".$activity."</h2><img src='".$image."'>";

  $preview .= "</div>"; //<div class='preview_collaborator_cover'>&nbsp;</div>
  return $preview;
}

function getRedPreviewCollaborator($name,$image,$activity="")
{
  $preview = "";
  $preview .= "<div class='preview_collaborator preview_collaborator_red'><h1>".$name."</h1><h2>".$activity."&nbsp;</h2><img src='".$image."'>";

  $preview .= "</div>"; //<div class='preview_collaborator_cover'>&nbsp;</div>
  return $preview;
}
function getRelatedPreviewCollaborator($name,$image,$activity="")
{
  $preview = "";
  $preview .= "<div class='preview_collaborator_relateds'><h1>".$name."</h1><img src='".$image."' /></div>";

  return $preview;
}


function getPreviewProduct($name,$image,$price="",$discount="")
{
  $preview = "";
  $preview .= "<div class='preview_collaborator'><img src='".$image."'><h1>".$name."</h1>";
  if($discount!="" and $discount>0)
    $preview .= "<h2><span class='tachado'>".$price."€ </span>".formatear_numero($price-$discount,2)."€</h2>";
  else
    $preview .= "<h2>".$price."€</h2>";
  $preview .= "<div class='preview_collaborator_cover'>&nbsp;</div></div>";
  return $preview;
}

function formatear_numero($numero,$decimales)
{
  return number_format($numero,$decimales,".","");
}
function formatear_numero_factura($numero,$decimales=2)
{
  return number_format($numero,$decimales,",",".");
}
function quitar_ceros($numero)
{
  return $numero + 0;
}
function getImagenesDirectorio($dir,$extensiones = array("jpg"=>1,"jpeg"=>1,"png"=>1))
{
    $imagenes = array();
    if (!file_exists($dir)) return $imagenes;

    $dirint = dir($dir);
    while (($archivo = $dirint->read()) !== false)
    {
      $tmp = explode(".",$archivo);
      $extension = strtolower(end($tmp));
      if (isset($extensiones[ $extension ])){
          array_push($imagenes,$archivo);
            //echo $directory."/".$archivo;
        }
    }
    $dirint->close();
    return $imagenes;
}
function limpiarDirectorio($dir,$tiempo)
{
  //Tiempo viene originalmente en minutos
  $ahora = strtotime("-".$tiempo."minutes ");
  $files = glob($dir.'/*'); // get all file names
  foreach($files as $file){ // iterate files
    if(is_file($file) and (filemtime($file)<$ahora or $tiempo==0) )
    {
      unlink($file);
    }
  }
}

function limpiarDirectorioVehiculo($dir,$v)
{
  //Tiempo viene originalmente en minutos
  if($v['veh_imagen_principal']=="" and $v['veh_imagen_secundaria1']=="" and $v['veh_imagen_secundaria2']=="")
  {
    //echo "<br>SALDRIA<br>";
    return 1;
  }
  if($v['veh_imagen_principal']=="") $v['veh_imagen_principal']= "vacio";
  if($v['veh_imagen_secundaria1']=="") $v['veh_imagen_secundaria1']= "vacio";
  if($v['veh_imagen_secundaria2']=="") $v['veh_imagen_secundaria2']= "vacio";
  $files = glob($dir.'/*'); // get all file names
  foreach($files as $file){ // iterate files
    if(is_file($file) and strpos($file,$v['veh_imagen_principal'])===false
    and strpos($file,$v['veh_imagen_secundaria1'])===false and strpos($file,$v['veh_imagen_secundaria2'])===false)
    {
      //echo "<br>Entaría con ".$file;
      unlink($file);
    }
    else {
      //echo "<br>SALVARIA con ".$file;
    }
  }
}


function print_user_address($data)
{
  echo "<span style='font-style:italic;'>".$data['user_address_fullname']."</span> ";
  echo $data['user_address_1']." ,".$data['user_zip']." ,".$data['user_city']." ,".$data['user_state']."(".$data['user_country'].")";
  if($data['user_phone_1']!="" || $data['user_phone_2']!="")
  {
    echo "<br />";
    if($data['user_phone_1']!="") echo " ".$data['user_phone_1']." ";
    if($data['user_phone_2']!="") echo " ".$data['user_phone_2']." ";

  }
}

function print_order_address($data)
{
  echo "<span style='font-style:italic;'>".$data['order_address_fullname']."</span> ";
  echo $data['order_address_1']." ,".$data['order_zip']." ,".$data['order_city']." ,".$data['order_state']."(".$data['order_country'].")";
  if($data['order_phone_1']!="" || $data['order_phone_2']!="")
  {
    echo "<br />";
    if($data['order_phone_1']!="") echo " ".$data['order_phone_1']." ";
    if($data['order_phone_2']!="") echo " ".$data['order_phone_2']." ";

  }
}
function print_order_address_form($data)
{
  echo $data['order_address_fullname']."\n";
  echo $data['order_address_1']." ,".$data['order_zip']." ,".$data['order_city']." ,".$data['order_state']."(".$data['order_country'].")";
  if($data['order_phone_1']!="" || $data['order_phone_2']!="")
  {
    echo "\n";
    if($data['order_phone_1']!="") echo " ".$data['order_phone_1']." ";
    if($data['order_phone_2']!="") echo " ".$data['order_phone_2']." ";

  }
}

function limpia_espacios($cadena){
	$cadena = str_replace(' ', '', $cadena);
	return $cadena;
}

function print_duration($duration_in_seg)
{
  $duration = $duration_in_seg;
  $hour = floor($duration_in_seg/3600);
  $duration -= $hour*3600;
  $min = floor($duration/60);
  $duration -= $min*60;
  return sprintf("%02d", $hour).":".sprintf("%02d", $min).":".sprintf("%02d", $duration);
}

function createFromFormat($format, $time)
{
    $is_pm  = (stripos($time, 'PM') !== false);
    $time   = str_replace(array('AM', 'PM'), '', $time);
    $format = str_replace('A', '', $format);

    $date   = DateTime::createFromFormat(trim($format), trim($time));

    if ($is_pm)
    {
        $date->modify('+12 hours');
    }

    return $date;
}

function rellenar_izq($string,$rellenar_con,$veces=6)
{
  return str_pad($string,$veces,$rellenar_con,STR_PAD_LEFT);
}
function rellenar_der($string,$rellenar_con,$veces=6)
{
  return str_pad($string,$veces,$rellenar_con,STR_PAD_RIGHT);
}
function getMesesEsp(){
  return array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
}

function fecha_esp($fecha,$gmt=-7)
  {
      if($gmt==-7) $gmt =  date('Z');

      //$gmt = 6*60*60;
      $mi_fecha = strtotime($fecha)+$gmt;
      //$week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
      $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
      $month = date ("n",$mi_fecha);
      $week_day_now = date ("w");
      $date = date("d ",$mi_fecha).$months[$month].date(" Y H:i",$mi_fecha);
      return $date;
  }
  function fecha_esp_contrato($fecha)
    {
        global $gmt;
        $gmt =  date('Z');
        $mi_fecha = strtotime($fecha)+$gmt;
        //$week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
        $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $month = date ("n",$mi_fecha);
        $week_day_now = date ("w");
        $date = date("d ",$mi_fecha)." de ".$months[$month]." de ".date(" Y ",$mi_fecha);
        return $date;
    }
function fecha_esp_diasemana($fecha)
  {
  $mi_fecha = strtotime($fecha);
      //$week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
      $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
      $month = date ("n",$mi_fecha);
      $week_day_now = date ("w");
      $date = dia_fecha($fecha)." ".date("d ",$mi_fecha).$months[$month].date(" Y",$mi_fecha);
      return $date;
  }
function fecha_esp_red($fecha)
  {
  $mi_fecha = strtotime($fecha);
      //$week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
      $months = array ("", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
      $month = date ("n",$mi_fecha);
      $week_day_now = date ("w");
      $date = date("d ",$mi_fecha).$months[$month].date(" Y",$mi_fecha);
      return $date;
  }
  function fecha_esp_superred($fecha)
    {
    $mi_fecha = strtotime($fecha);
        //$week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
        $months = array ("", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
        $month = date ("n",$mi_fecha);
        $week_day_now = date ("w");
        $date = date("d ",$mi_fecha).$months[$month].date(" y",$mi_fecha);
        return $date;
    }
    function fecha_esp_superred_diames($fecha)
      {
      $mi_fecha = strtotime($fecha);
          //$week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
          $months = array ("", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
          $month = date ("n",$mi_fecha);
          $week_day_now = date ("w");
          $date = date("d ",$mi_fecha).$months[$month];
          return $date;
      }
  function mes_anio_completa($fecha)
  {
    $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $month = date ("n",$fecha);
    $date = $months[$month].date(" Y",$fecha);
    return $date;
  }
function mes_anio($fecha)
{
  $months = array ("", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
  $month = date ("n",$fecha);
  $date = $months[$month].date(" Y",$fecha);
  return $date;
}
function mesanio($fecha)
{
  $mi_fecha = strtotime($fecha);
  $months = array ("", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
  $month = date ("n",$mi_fecha);
  $date = $months[$month].date("Y",$mi_fecha);
  return $date;
}

function callAPIAcumbamail($end_point,$request,$auth_token, $data = array()){
    $url = $end_point.$request.'/';
    $fields = array(
        'auth_token'=> $auth_token,
        'response_type' => 'json',
    );
    if(count($data)!=0){
        $fields=array_merge($fields,$data);
    }
    $postdata = http_build_query($fields);
    $opts = array('http' => array(
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata));
    $response = @file_get_contents($url,
                                   false,
                                   stream_context_create($opts));
    $json = json_decode($response,true);
    if(is_array($json)){
        return $json;
    }else{
        return $response;
    }
}

function avisarPusher($canal,$evento,$datos)
{
  require_once(APPPATH.'third_party/pusher/autoload.php');
  //require __DIR__ . '/vendor/autoload.php';
    $options = array(
      'cluster' => 'eu',
      'encrypted' => true
    );
    $pusher = new Pusher\Pusher(
      'fb1ed28d0114d56efdbb',
      '472486762fdc9fc9af8a',
      '521375',
      $options
    );
    $pusher->trigger($canal, $evento, $datos);
}
function create_zip_informes($destination) {
	//if we have good files...

  $files = glob('attachments/informes/*.pdf'); // get all file names
  $listado_facturas = array();
  foreach($files as $file){ // iterate files
    //echo "Entro con ".$file;
    array_push($listado_facturas,$file);
  }

	if(count($listado_facturas)>0) {
    $destination = "attachments/informes/mis_informes.zip";
		//create the archive
		$zip = new ZipArchive(); $overwrite = file_exists($destination);
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			echo -1;
		}
		//add emitiras
		if(count($listado_facturas))
		foreach($listado_facturas as $idfactura=>$file) {
      $tmp = explode("/", $file);
      $file_destino = end($tmp);
      //echo "Voy con ".$file_destino;
			$zip->addFile($file,$file_destino);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

		//close the zip -- done!
		$zip->close();

		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		echo -2;
	}
}

function create_zip_fotos($idvehiculo) {
	//if we have good files...

  $files = glob('attachments/vehiculos/'.$idvehiculo.'/*'); // get all file names
  $listado_ficheros = array();
  foreach($files as $file){ // iterate files
    //echo "Entro con ".$file;
    if($file!=".." or $file!=".")
      array_push($listado_ficheros,$file);
  }

	if(count($listado_ficheros)>0) {
    $destination = "attachments/tmp/fotos_".$idvehiculo.".zip";
		//create the archive
		$zip = new ZipArchive(); $overwrite = file_exists($destination);
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			echo -1;
		}
		//add emitiras
		if(count($listado_ficheros))
		foreach($listado_ficheros as $idfactura=>$file) {
      $tmp = explode("/", $file);
      $file_destino = end($tmp);
      //echo "Voy con ".$file_destino;
			$zip->addFile($file,$file_destino);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

		//close the zip -- done!
		$zip->close();

		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		echo -2;
	}
}

function create_zip_facturas() {
	//if we have good files...

  $files = glob('attachments/facturas_tmp/*'); // get all file names
  $listado_ficheros = array();
  foreach($files as $file){ // iterate files
    //echo "Entro con ".$file;
    if($file!=".." or $file!=".")
      array_push($listado_ficheros,$file);
  }

	if(count($listado_ficheros)>0) {
    $destination = "attachments/tmp/facturas.zip";
		//create the archive
		$zip = new ZipArchive(); $overwrite = file_exists($destination);
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			echo -1;
		}
		//add emitiras
		if(count($listado_ficheros))
		foreach($listado_ficheros as $idfactura=>$file) {
      $tmp = explode("/", $file);
      $file_destino = end($tmp);
      //echo "Voy con ".$file_destino;
			$zip->addFile($file,$file_destino);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

		//close the zip -- done!
		$zip->close();

		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		echo -2;
	}

}

function create_zip_facturascedentes() {
	//if we have good files...

  $files = glob('attachments/facturascedentes_tmp/*'); // get all file names
  $listado_ficheros = array();
  foreach($files as $file){ // iterate files
    //echo "Entro con ".$file;
    if($file!=".." or $file!=".")
      array_push($listado_ficheros,$file);
  }

	if(count($listado_ficheros)>0) {
    $destination = "attachments/tmp/facturascedentes.zip";
		//create the archive
		$zip = new ZipArchive(); $overwrite = file_exists($destination);
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			echo -1;
		}
		//add emitiras
		if(count($listado_ficheros))
		foreach($listado_ficheros as $idfactura=>$file) {
      $tmp = explode("/", $file);
      $file_destino = end($tmp);
      //echo "Voy con ".$file_destino;
			$zip->addFile($file,$file_destino);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

		//close the zip -- done!
		$zip->close();

		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		echo -2;
	}

}

function create_zip_facturastaller() {
	//if we have good files...

  $files = glob('attachments/facturascedentes_tmp/*'); // get all file names
  $listado_ficheros = array();
  foreach($files as $file){ // iterate files
    //echo "Entro con ".$file;
    if($file!=".." or $file!=".")
      array_push($listado_ficheros,$file);
  }

	if(count($listado_ficheros)>0) {
    $destination = "attachments/tmp/facturastaller.zip";
		//create the archive
		$zip = new ZipArchive(); $overwrite = file_exists($destination);
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			echo -1;
		}
		//add emitiras
		if(count($listado_ficheros))
		foreach($listado_ficheros as $idfactura=>$file) {
      $tmp = explode("/", $file);
      $file_destino = end($tmp);
      //echo "Voy con ".$file_destino;
			$zip->addFile($file,$file_destino);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

		//close the zip -- done!
		$zip->close();

		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		echo -2;
	}

}

function create_zip_fotos_tasacion($tasacion_id,$matricula) {	//if we have good files...

  $files = glob('attachments/tmp/fotos'.$tasacion_id.'/*'); // get all file names
  $listado_ficheros = array();
  foreach($files as $file){ // iterate files
    //echo "Entro con ".$file;
    if($file!=".." or $file!=".")
      array_push($listado_ficheros,$file);
  }

	if(count($listado_ficheros)>0) {
    $destination = "attachments/tmp/fotos_".$matricula.".zip";
		//create the archive
		$zip = new ZipArchive(); $overwrite = file_exists($destination);
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			echo -1;
		}
		//add emitiras
		if(count($listado_ficheros))
		foreach($listado_ficheros as $idfactura=>$file) {
      $tmp = explode("/", $file);
      $file_destino = end($tmp);
      //echo "Voy con ".$file_destino;
			$zip->addFile($file,$file_destino);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

		//close the zip -- done!
		$zip->close();

		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		echo -2;
	}
}

//Para cada cliente obtener los coches de su interes.
function buscarCocheInteres($clientes,$coches)
{
  foreach($clientes as $index=>$cli)
  {

    if($cli['coches_ofertados']==0) //Si tiene ofertados le mandamos solo esos.
    {

    //Primera PAsada con coches de interes.
    foreach($coches as $co)
    {
        //Si no se le ha enviado y tiene menos de 6.
        if(!isset($clientes[$index]['coches_enviados'][ $co['vehiculo_id'] ]) and count($clientes[$index]['coches_interes'])<6)
        {
          if($co['vehiculo_id']=="15") debug($co);

          if($cli['cliente_tipo']!=$co['veh_stock_id']) continue;

          if(!(strpos($cli['cliente_combustible'],$co['veh_combustible'])!==FALSE)) continue;
          if(!(strpos($cli['cliente_cambio'],$co['veh_cambio'])!==FALSE))  continue;

          if($co['vehiculo_id']=="15") echo "Sigo 111 ";

          if($cli['cliente_km_max']<$co['veh_km']) continue;

          if($co['vehiculo_id']=="15") echo "Sigo 112 ";

          if($cli['cliente_precio_max']<$co['veh_preciofina']) continue;

          if($co['vehiculo_id']=="15") echo "Sigo 2 ";

          if(!(strpos($cli['cliente_segmento'],$co['veh_segmento'])!==FALSE))  continue;

          if($co['vehiculo_id']=="15") echo "Sigo 22 ";

          if($co['vehiculo_id']=="15") echo "Sigo 222 ";

          if($cli['cliente_marca_modelo']!="")
          {
            if($co['vehiculo_id']=="15") echo "Voy a comprobar marca y modelos ".$co['veh_marca']." y ".$co['veh_modelo']."<br> ";
            if(
              !(strpos(strtolower($cli['cliente_marca_modelo']),strtolower($co['veh_marca']))!==FALSE)
              and
              !(strpos(strtolower($cli['cliente_marca_modelo']),strtolower($co['veh_modelo']))!==FALSE)
              )
                continue;
          }
            if($co['vehiculo_id']=="15") echo "<br>LO INSERTOOO!!!<br> ";
          //Ha pasado todos los filtros!!.
          $clientes[$index]['coches_interes'][ $co['vehiculo_id'] ] = $co;
          $clientes[$index]['coches_con_interes'] = 1;

        } //Si no existe en coches enviados.

    } //Foreach COCHES

    //Primera PAsada con coches de interes.
    if(count($clientes[$index]['coches_interes'])<6)
    foreach($coches as $co)
    {
        //Si no se le ha enviado o lo hemos insertado en la ronda anterior. y tiene menos de 6.
        if(!isset($clientes[$index]['coches_enviados'][ $co['vehiculo_id'] ]) and !isset($clientes[$index]['coches_interes'][ $co['vehiculo_id'] ])
        and count($clientes[$index]['coches_interes'])<6)
        {
          $clientes[$index]['coches_interes'][ $co['vehiculo_id'] ] = $co;
        } //Si no existe en coches enviados.
    } //Foreach COCHES

  } //Si no tiene ofertaos.
  }
  return $clientes;
}

function eliminar_tildes($cadena)
{

    //Codificamos la cadena en formato utf8 en caso de que nos de errores
    //$cadena = ($cadena);

    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );

    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena
    );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena
    );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena
    );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena
    );

    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );

    return $cadena;
}

function aviso_prox_itv($fecha_prox_itv)
{
  $currentDateTime = new DateTime;
  $time_itv = new DateTime($fecha_prox_itv);

  $desde_itv = $currentDateTime->diff($time_itv);
  $meses_prox_itv = 12 * $desde_itv->y + $desde_itv->m;
  $dias = $desde_itv->d;

  $desde_itv = $currentDateTime->diff($time_itv);
  $meses_itv = 12 * $desde_itv->y + $desde_itv->m;


  if($meses_prox_itv<=0 and $dias<=0) return "ITV caducada ";
  elseif($meses_prox_itv<=0 and $dias>=0) return "ITV ".$dias." dias!! ";//.$meses_vehiculo." y ";//.$meses_itv;
  elseif($meses_prox_itv==1) return "ITV en 1 mes ";
  elseif($meses_prox_itv==2) return "ITV en 2 meses ";

  return "";
} //Prox itv
function aviso_itv($fecha_vehiculo,$fecha_itv)
{
  $currentDateTime = new DateTime;
  $time_vehiculo = new DateTime($fecha_vehiculo);
  if($fecha_itv == '0000-00-00') $fecha_itv = $fecha_vehiculo;
  $time_itv = new DateTime($fecha_itv);

  $desde_fvehiculo = $currentDateTime->diff($time_vehiculo);
  $meses_vehiculo = 12 * $desde_fvehiculo->y + $desde_fvehiculo->m;


  $desde_itv = $currentDateTime->diff($time_itv);
  $meses_itv = 12 * $desde_itv->y + $desde_itv->m;

  if($meses_vehiculo<=48) //A los 4 años
  {
    if($meses_itv>=48) return "ITV";
    elseif($meses_itv>=47) return "ITV 1 mes";
    elseif($meses_itv>=46) return "ITV en 2 meses";
  }
  elseif($meses_vehiculo<=129) //Cada 2 años. 131 meses 10 años y 11 meses.
  {
    if($meses_itv>=24) return "ITV caducada ";//;//.$meses_vehiculo." y ";//.$meses_itv;
    elseif($meses_itv>=23) return "ITV 1 mes ";//;//.$meses_vehiculo." y ";//.$meses_itv;
    elseif($meses_itv>=22) return "ITV en 2 meses ";//.$meses_vehiculo." y ";//.$meses_itv;

  }
  elseif($meses_vehiculo<=132) //Justo va a cunmplir 11.
  {
    if($meses_vehiculo>=132 and $meses_itv>=6) return "ITV caducada ";//.$meses_vehiculo." y ";//.$meses_itv;
    elseif($meses_vehiculo>=131 and $meses_itv>=6) return "ITV 1 mes ";//.$meses_vehiculo." y ";//.$meses_itv;
    elseif($meses_vehiculo>=130 and $meses_itv>=6) return "ITV en 2 meses ";//.$meses_vehiculo." y ";//.$meses_itv;
  }
  else { //Cada año
    if($meses_itv>=12) return "ITV caducada ";//.$meses_vehiculo." y ";//.$meses_itv;
    elseif($meses_itv>=11) return "ITV 1 mes ";//.$meses_vehiculo." y ";//.$meses_itv;
    elseif($meses_itv>=10) return "ITV en 2 meses ";//.$meses_vehiculo." y ";//.$meses_itv;

  }
  return "";
}

function verificar_rango($date_inicio, $date_fin, $date_nueva) {
  $date_inicio = strtotime($date_inicio);
  $date_fin = strtotime($date_fin);
  $date_nueva = strtotime($date_nueva);
  if (($date_nueva >= $date_inicio) && ($date_nueva <= $date_fin))
    return true;
  return false;
}