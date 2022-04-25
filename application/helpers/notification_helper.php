<?php
error_reporting(0);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function guardar_notificacion($data)
{
  $CI =& get_instance();
  return $CI->db->insert('users_notification',$data);
}
function mandar_noti_pusher_taller($asunto,$mensaje,$additionalData)
{
  $CI =& get_instance();
  $config_pusher = $CI->config->item('pusher_config');
  require_once(APPPATH.'third_party/pusher/autoload.php');
  $options = array(
    'cluster' => $config_pusher['cluster'],
    'encrypted' => true
  );
  $pusher = new Pusher\Pusher(
    $config_pusher['key'],
    $config_pusher['secret'],
    $config_pusher['app_id'],
    $options
  );
  $pusher->trigger('canal-taller', $additionalData['type'], $additionalData);
}
function mandar_noti_pusher($config_pusher,$lista_usuarios,$asunto,$mensaje,$additionalData)
{
  require_once(APPPATH.'third_party/pusher/autoload.php');
  $options = array(
    'cluster' => $config_pusher['cluster'],
    'encrypted' => true
  );
  $pusher = new Pusher\Pusher(
    $config_pusher['key'],
    $config_pusher['secret'],
    $config_pusher['app_id'],
    $options
  );
  $additionalData['usuarios'] = $lista_usuarios;
  $pusher->trigger('canal-tasaciones', $additionalData['type'], $additionalData);
}


function mandar_noti($listado_usuarios,$asunto,$mensaje,$additionalData,$sonido=true)
{
  $ahora = date("Y-m-d H:i:s");
  $data_notifications = array();
  $individual_noti = array("notification_type"=>"app",
 "notification_subject"=> $asunto,"notification_text"=> $mensaje,"notification_send_time"=>$ahora,
"notification_sended"=>1);
if(isset($additionalData['idtasacion'])) $individual_noti['notification_object'] = $additionalData['idtasacion'];
  foreach($listado_usuarios as $user_id)
  {
    $individual_noti['user_id'] = $user_id;
    array_push($data_notifications,$individual_noti);
  }
  if(count($data_notifications)>0)
  {
    $CI =& get_instance();
    $CI->db->insert_batch('users_notification', $data_notifications);
    $config_pusher = $CI->config->item('pusher_config');
  }
  $sonido_android = $sonido;
  $sonido_ios = $sonido;
  if(is_string($sonido))
  {
    $sonido_ios = $sonido.".caf"; //.".caff"
  }
  if(isset($additionalData['soundname']))
  {
    $sonido_android = $additionalData['soundname'];
    $sonido_ios = $additionalData['soundname'].".caf";
  }
  mandar_noti_pusher($config_pusher,$listado_usuarios,$asunto,$mensaje,$additionalData);
  mandar_noti_android($listado_usuarios,$asunto,$mensaje,$additionalData,$sonido_android);
  mandar_noti_ios($listado_usuarios,$asunto,$mensaje,$additionalData,$sonido_ios);
}
function mandar_noti_android($listado_usuarios,$asunto,$mensaje,$additionalData,$sonido=true)
{
  $CI =& get_instance();
  //echo $_SERVER['DOCUMENT_ROOT'].'/include/ApnsPHP/Autoload.php';
  require_once(APPPATH.'third_party/GCM.php');
  $gcm = new GCM();
  $tokens = $CI->db->select('*')->from('users_push')->where_in('user_id',$listado_usuarios)
  ->where('push_type','android')->get()->result_array();
  $mis_tokens = array(); $cont = 0;
  $regID = array();
  if(count($tokens)>0)
  {
    foreach($tokens as $t)
    {
			array_push($regID,$t['push_token']);
      $mis_tokens[ $t['push_id'] ] = $t['push_token'];
      $tokens_contador[$cont] = $t['push_token'];
      $cont++;
    }
  }
  else {
    return 0;
  }
  //$title = "CrestaNevada";
  //$message = array("message" => $mensaje,'title'=> $title,'sound'=> false,'tipo'=>"Nuevo chat");
  $additionalData["message" ] = $mensaje;
  $additionalData["title" ] = $asunto;

  if(is_string($sonido))
  {
    //$additionalData["soundname" ] = $sonido;
    //$additionalData["android_channel_id" ] = "canalconce";
  }
  //debug($regID);
  if(count($regID)>0)
  {
    $result = $gcm->send_notification($regID, $additionalData);
    //debug($result);
    $resultados = json_decode($result);
    $a_borrar = array();
    foreach($resultados->results as $id=>$respuesta)
    {
      if(isset($respuesta->error)) $a_borrar[$id] = $tokens_contador[$id];
    }

    //Borramos todos los que no sean canonical id. Es decir, contengan el registration id
    if(count($a_borrar)>0)
      $CI->db->where_in('push_token',$a_borrar)->delete('users_push');

  }
  else
    $result = "ON";
  /***************
    ------ SI NO EXISTE NO ENVIAMOS PERO SEGUIMOS BORRANDO LAS NOTIFICAIONES
    *******/

  return $result;
  //return 1;
}


function mandar_noti_ios($listado_usuarios,$asunto,$mensaje,$additionalData,$sonido=true)
{
  $aviso_traza="";
  $CI =& get_instance();
  //echo $_SERVER['DOCUMENT_ROOT'].'/include/ApnsPHP/Autoload.php';
  require_once(APPPATH.'third_party/ApnsPHP/Autoload.php');

  //echo "Por aqui llego con ".$lista_usuarios." asunto ".$asunto." y ".$mensaje;
  $tokens = $CI->db->select('*')->from('users_push')->where_in('user_id',$listado_usuarios)
  ->where('push_type','ios')->get()->result_array();
  $mis_tokens = array(); $cont = 0;
  if(count($tokens)>0)
  {
    foreach($tokens as $t)
    {
      $mis_tokens[ $t['push_id'] ] = $t['push_token'];
      $tokens_contador[$cont] = $t['push_token'];
      $cont++;
    }
  }
  else {
    return 0;
  }

  try{
  //echo "Entro en IOS";
  $push = new ApnsPHP_Push(
    ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,//, ENVIRONMENT_SANDBOX ENVIRONMENT_PRODUCTION
    APPPATH.'config/push_certificate.pem'
  );
  $push->setProviderCertificatePassphrase('heyuapp');
  @$push->connect();
  }
  catch (Exception $e) {
    $error_token=true;
    //echo 'Error con el permiso: ',  $e->getMessage(), "\n";
    return 0;
    //@mysql_query("delete from token_notificaciones where token='$token' and tipo='IOS'");
  }

  foreach($mis_tokens as $push_id=>$push_token)
  {
    try{
    $message = new ApnsPHP_Message($push_token);
    $message->setCustomIdentifier(sprintf("CrestaNevada", 1));
    // Set a simple welcome text
    $message->setText($mensaje);
    // Play the default sound
    if($sonido)
    {
      if(is_string($sonido))
      {
        $message->setSound($sonido);
      }
      else {
        $message->setSound();
      }
    }

    // Set badge icon to "3"
    $message->setBadge(1);

    foreach($additionalData as $key=>$value)
      $message->setCustomProperty($key,$value);

    // Add the message to the message queue
    $push->add($message);
    }
    catch (Exception $e) {
      $error_token=true;
      //echo 'Error Con el token: '.$token.' ',  $e->getMessage(), "\n";
      $CI->db->where('push_id',$push_id)->delete('users_push');
    }
  }

  $errores = $push->send();
  $push->disconnect();
  if(count($errores)>0)
  {
    foreach($errores as $contador=>$id)
      $a_borrar[$id] = $tokens_contador[$id];
    $ids_borrar = join("','",$a_borrar);
    $CI->db->where_in('push_token',$a_borrar)->delete('users_push');
  }
  /*
  echo "Errores<pre>";
  print_r($errores);
  echo "</pre>";
  */

  //$result = "OK";
  return 1;
  //return 1;
}
