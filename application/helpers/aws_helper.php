<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function copyObject($config_aws,$newKey,$originalPath,$delete=0)
{

  //Descargamos archivo y subimos
  $destino = "attachments/facturas_tmp";
  $tmp = explode("/",$originalPath);
  $nombre = strtolower(end($tmp));
  $ruta = $destino."/".$nombre;
  $result = downloadObject($config_aws,$originalPath,$destino);
  if(!is_object($result) and $result==-1)
  {
    return -1;
  }
  $return_data = subirImagen($config_aws,$newKey,$ruta);
  if($delete)
  {
    deleteObject($config_aws,$originalPath);
  }
  return $return_data;
  /*require_once(APPPATH.'third_party/aws/aws-autoloader.php');
  try{
    $s3 = new Aws\S3\S3Client(array(
      'version'     => $config_aws['s3']['version'],
      'region'      => $config_aws['s3']['region'],
      'credentials' => array(
        'key'    => $config_aws['s3']['key'],
        'secret' => $config_aws['s3']['secret']
      )
    ));

    $result = $s3->copyObject([
      'Bucket' => $config_aws['s3']['bucket'],
      'Key'    => $newKey,
      'CopySource' => $originalPath,
      ]);
    if($delete)
    {
      deleteObject($config_aws,$originalPath);
    }
    return $result;
  }catch (Aws\Exception\AwsException\S3Exception $e) {
      return -1;
  }
  */
  return $return_data;
}

function deleteObject($config_aws,$key)
{
  require_once(APPPATH.'third_party/aws/aws-autoloader.php');
  try{
    $s3 = new Aws\S3\S3Client(array(
      'version'     => $config_aws['s3']['version'],
      'region'      => $config_aws['s3']['region'],
      'credentials' => array(
        'key'    => $config_aws['s3']['key'],
        'secret' => $config_aws['s3']['secret']
      )
    ));

    $result = $s3->deleteObject([
    'Bucket' => $config_aws['s3']['bucket'],
    'Key'    => $key
    ]);
    return $result;
  }catch (Aws\Exception\AwsException\S3Exception $e) {
      return -1;
  }
  return $return_data;
}
function getURLObject($config_aws,$key)
{
  require_once(APPPATH.'third_party/aws/aws-autoloader.php');
  try{
    $s3 = new Aws\S3\S3Client(array(
      'version'     => $config_aws['s3']['version'],
      'region'      => $config_aws['s3']['region'],
      'credentials' => array(
        'key'    => $config_aws['s3']['key'],
        'secret' => $config_aws['s3']['secret']
      )
    ));

    $urls = array();
    $ahora = strtotime(date("Y-m-d H:i:s"));
    $cmd = $s3->getCommand('GetObject', [
        'Bucket' => $config_aws['s3']['bucket'],
        'Key'    => $key
    ]);

    $request = $s3->createPresignedRequest($cmd, '+6 days');
     $signedURL = (string) $request->getUri();
    return $signedURL;
  }
  catch (Aws\Exception\AwsException\S3Exception $e) {
      return "";
  }

}

function downloadObject($config_aws,$key,$destino)
{
  require_once(APPPATH.'third_party/aws/aws-autoloader.php');
  try{
    $s3 = new Aws\S3\S3Client(array(
      'version'     => $config_aws['s3']['version'],
      'region'      => $config_aws['s3']['region'],
      'credentials' => array(
        'key'    => $config_aws['s3']['key'],
        'secret' => $config_aws['s3']['secret']
      )
    ));

    $tmp = explode("/",$key);
    $nombre = strtolower(end($tmp));

    $result = $s3->getObject([
    'Bucket' => $config_aws['s3']['bucket'],
    'Key'    => $key,
    'SaveAs' => $destino."/".$nombre
    ]);

  }
  catch (Aws\Exception\AwsException\S3Exception $e) {
      return "";
  }

}
function getFolderURLS($config_aws,$parent,$folder_name,$tasacion_id,$index_session="imagenesTasacion",$subfolder=false)
{
  require_once(APPPATH.'third_party/aws/aws-autoloader.php');
  try{
    $s3 = new Aws\S3\S3Client(array(
      'version'     => $config_aws['s3']['version'],
      'region'      => $config_aws['s3']['region'],
      'credentials' => array(
        'key'    => $config_aws['s3']['key'],
        'secret' => $config_aws['s3']['secret']
      )
    ));
    $folder = $parent.$folder_name;

    $objects = $s3->ListObjects(array(
       'Bucket'       => $config_aws['s3']['bucket'], // Defines name of Bucket
       'Prefix'          => $folder."/", //Defines Folder name
       'delimiter'=>'/'
    ));
    $urls = array();
    $ahora = strtotime(date("Y-m-d H:i:s"));

    if(isset($_SESSION[$index_session][$tasacion_id]))
    {
      $resto = $ahora - $_SESSION[$index_session][$tasacion_id]['time'];
      if($resto>604000000) //Mayor de 7 dias  604000000
      {
        unset($_SESSION[$index_session][$tasacion_id]);
        $_SESSION[$index_session][$tasacion_id] = array();
        $_SESSION[$index_session][$tasacion_id]['time'] = $ahora;
        $_SESSION[$index_session][$tasacion_id]['imagenes'] = array();
      }
    }
    else {
      $_SESSION[$index_session][$tasacion_id] = array();
      $_SESSION[$index_session][$tasacion_id]['time'] = $ahora;
      $_SESSION[$index_session][$tasacion_id]['imagenes'] = array();
    }

    foreach($objects['Contents'] as $file)
    {
      if($file['Size']!=0 and ((strpos($file['Key'],"docs/")===false and strpos($file['Key'],"docsfina/")===false) or $subfolder))
      {
        //$signedURL = $s3->getObjectUrl($config_aws['s3']['bucket'], $file['Key'], '+10 minutes');
        if(!isset($_SESSION[$index_session][$tasacion_id]['imagenes'][ $file['Key'] ]))
        {
          $cmd = $s3->getCommand('GetObject', [
              'Bucket' => $config_aws['s3']['bucket'],
              'Key'    => $file['Key']
          ]);

          $request = $s3->createPresignedRequest($cmd, '+6 days');
           $signedURL = (string) $request->getUri();
           if(strpos( $file['Key'],"video")!==FALSE)
           {
            $_SESSION[$index_session][$tasacion_id]['video'] = $signedURL;
           }
           else
            $_SESSION[$index_session][$tasacion_id]['imagenes'][ $file['Key'] ] = $signedURL;
        }

      }

    }

    //Ya tenemos todas las imagenes guardadas
    $return_data['result'] = 1;


  }catch (Aws\Exception\AwsException\S3Exception $e) {
      $return_data['result'] = -1;
  }
  return $return_data;
}
function getFolderURLSAWS($config_aws,$parent,$folder_name,$tasacion_id,$index_session="docs",$subfolder=false)
{
  require_once(APPPATH.'third_party/aws/aws-autoloader.php');
  try{
    $s3 = new Aws\S3\S3Client(array(
      'version'     => $config_aws['s3']['version'],
      'region'      => $config_aws['s3']['region'],
      'credentials' => array(
        'key'    => $config_aws['s3']['key'],
        'secret' => $config_aws['s3']['secret']
      )
    ));
    $folder = $parent.$folder_name;

    $objects = $s3->ListObjects(array(
       'Bucket'       => $config_aws['s3']['bucket'], // Defines name of Bucket
       'Prefix'          => $folder."/", //Defines Folder name
       'delimiter'=>'/'
    ));
    $urls = array();
    $ahora = strtotime(date("Y-m-d H:i:s"));

    if(isset($_SESSION[$index_session][$tasacion_id]))
    {
      $resto = $ahora - $_SESSION[$index_session][$tasacion_id]['time'];
      if($resto>604000000) //Mayor de 7 dias  604000000
      {
        unset($_SESSION[$index_session][$tasacion_id]);
        $_SESSION[$index_session][$tasacion_id] = array();
        $_SESSION[$index_session][$tasacion_id]['time'] = $ahora;
        $_SESSION[$index_session][$tasacion_id]['imagenes'] = array();
      }
    }
    else {
      $_SESSION[$index_session][$tasacion_id] = array();
      $_SESSION[$index_session][$tasacion_id]['time'] = $ahora;
      $_SESSION[$index_session][$tasacion_id]['imagenes'] = array();
    }
  if(!isset($objects['Contents']))
  {
      $return_data['result'] = 0;
      return $return_data;
  }


    foreach($objects['Contents'] as $file)
    {
      if($file['Size']!=0 and ((strpos($file['Key'],"docs/")===false and strpos($file['Key'],"docsfina/")===false) or $subfolder))
      {
        //$signedURL = $s3->getObjectUrl($config_aws['s3']['bucket'], $file['Key'], '+10 minutes');
        if(!isset($_SESSION[$index_session][$tasacion_id]['imagenes'][ $file['Key'] ]))
        {
          $cmd = $s3->getCommand('GetObject', [
              'Bucket' => $config_aws['s3']['bucket'],
              'Key'    => $file['Key']
          ]);

          $request = $s3->createPresignedRequest($cmd, '+6 days');
           $signedURL = (string) $request->getUri();
           if(strpos( $file['Key'],"video")!==FALSE)
           {
            $_SESSION[$index_session][$tasacion_id]['video'] = $signedURL;
           }
           else
            $_SESSION[$index_session][$tasacion_id]['imagenes'][ $file['Key'] ] = $signedURL;
        }

      }

    }

    //Ya tenemos todas las imagenes guardadas
    $return_data['result'] = 1;


  }catch (Aws\Exception\AwsException\S3Exception $e) {
      $return_data['result'] = -1;
  }
  return $return_data;
} //Obtener

function getFolderContent($config_aws,$parent,$folder_name,$destino,$subfolder=false)
{
  require_once(APPPATH.'third_party/aws/aws-autoloader.php');
  try{
    $s3 = new Aws\S3\S3Client(array(
      'version'     => $config_aws['s3']['version'],
      'region'      => $config_aws['s3']['region'],
      'credentials' => array(
        'key'    => $config_aws['s3']['key'],
        'secret' => $config_aws['s3']['secret']
      )
    ));
    $folder = $parent.$folder_name;

    $objects = $s3->ListObjects(array(
       'Bucket'       => $config_aws['s3']['bucket'], // Defines name of Bucket
       'Prefix'          => $folder."/", //Defines Folder name
       'delimiter'=>'/'
    ));
    $lista_claves = array();
    foreach($objects['Contents'] as $file)
    {
      if($file['Size']!=0 and ((strpos($file['Key'],"docs/")===false and strpos($file['Key'],"docsfina/")===false and strpos($file['Key'],"video/")===false) or $subfolder))
      {
        $tmp = explode("/",$file['Key']);
        $nombre = strtolower(end($tmp));
        $result = $s3->getObject([
        'Bucket' => $config_aws['s3']['bucket'],
        'Key'    => $file['Key'],
        'SaveAs' => $destino."/".$nombre
        ]);
        array_push($lista_claves,$file['Key']);
      }

    }

    //Ya tenemos todas las imagenes guardadas
    $return_data['result'] = 1;
    $return_data['lista_claves'] = $lista_claves;


  }catch (Aws\Exception\AwsException\S3Exception $e) {
      $return_data['result'] = -1;
  }
  return $return_data;
}

function borrarClaves($config_aws,$lista_claves)
{
  require_once(APPPATH.'third_party/aws/aws-autoloader.php');
  try{
      $s3 = new Aws\S3\S3Client(array(
        'version'     => $config_aws['s3']['version'],
        'region'      => $config_aws['s3']['region'],
        'credentials' => array(
          'key'    => $config_aws['s3']['key'],
          'secret' => $config_aws['s3']['secret']
        )
      ));
    $respuesta = $s3->deleteObjects([
        'Bucket'  => $config_aws['s3']['bucket'],
        'Delete' => [
            'Objects' => array_map(function ($key) {
                return ['Key' => $key];
            }, $lista_claves)
        ],
    ]);

    return $respuesta;

  }catch (Aws\Exception\AwsException\S3Exception $e) {
      $return_data['result'] = -1;
  }
}

  function subirImagen($config_aws,$key,$ruta)
  {
    require_once(APPPATH.'third_party/aws/aws-autoloader.php');
    try{
      $s3 = new Aws\S3\S3Client(array(
        'version'     => $config_aws['s3']['version'],
        'region'      => $config_aws['s3']['region'],
        'credentials' => array(
          'key'    => $config_aws['s3']['key'],
          'secret' => $config_aws['s3']['secret']
        )
      ));

      $result = $s3->putObject(array(
       'Bucket' => $config_aws['s3']['bucket'],
       'Key'    => $key,
       'SourceFile'   => $ruta,
       //'ACL'    => 'public-read',
       //'ContentType' => 'image/jpeg'
      ));
      return $result;
    }
    catch (Aws\Exception\AwsException\S3Exception $e) {
      return -1;
    }
}

function createFolderS3($config_aws,$parent,$folder_name)
{
  require_once(APPPATH.'third_party/aws/aws-autoloader.php');
  try{
    $s3 = new Aws\S3\S3Client(array(
      'version'     => $config_aws['s3']['version'],
      'region'      => $config_aws['s3']['region'],
      'credentials' => array(
        'key'    => $config_aws['s3']['key'],
        'secret' => $config_aws['s3']['secret']
      )
    ));
    $folder = $parent.$folder_name;

    $result = $s3->putObject(array(
       'Bucket'       => $config_aws['s3']['bucket'], // Defines name of Bucket
       'Key'          => $folder."/", //Defines Folder name
       'Body'       => ""
    ));
    if($result['@metadata']['statusCode']==200)
      $return_data['result'] = 1;
    else {
      $return_data['result'] = -1;
    }

  }catch (Aws\Exception\AwsException\S3Exception $e) {
    $return_data['result'] = -1;
  }
  return $return_data;
}


function getS3Details($s3Bucket, $region,$awsKey,$awsSecret, $acl = 'private') {

    // Options and Settings
    //$awsKey = (!empty(getenv('AWS_ACCESS_KEY')) ? getenv('AWS_ACCESS_KEY') : AWS_ACCESS_KEY);
    //$awsSecret = (!empty(getenv('AWS_SECRET')) ? getenv('AWS_SECRET') : AWS_SECRET);

    $algorithm = "AWS4-HMAC-SHA256";
    $service = "s3";
    $date = gmdate("Ymd\THis\Z");
    $shortDate = gmdate("Ymd");
    $requestType = "aws4_request";
    $expires = "86400"; // 24 Hours
    $successStatus = "201";
    $max_file_size = 25000;
    $url = "//{$s3Bucket}.{$service}-{$region}.amazonaws.com";

    // Step 1: Generate the Scope
    $scope = [
        $awsKey,
        $shortDate,
        $region,
        $service,
        $requestType
    ];
    $credentials = implode('/', $scope);

    // Step 2: Making a Base64 Policy
    $policy = [
        'expiration' => gmdate('Y-m-d\TG:i:s\Z', strtotime('+23 hours')),
        'conditions' => [
            ['bucket' => $s3Bucket],
            ['acl' => $acl],
            ['starts-with', '$key', ''],
            ['starts-with', '$Content-Type', ''],
            ['content-length-range', 0,mbToBytes($max_file_size)],
            ['success_action_status' => $successStatus],
            ['x-amz-credential' => $credentials],
            ['x-amz-algorithm' => $algorithm],
            ['x-amz-date' => $date],
            ['x-amz-expires' => $expires],
        ]
    ];
    $base64Policy = base64_encode(json_encode($policy));

    // Step 3: Signing your Request (Making a Signature)
    $dateKey = hash_hmac('sha256', $shortDate, 'AWS4' . $awsSecret, true);
    $dateRegionKey = hash_hmac('sha256', $region, $dateKey, true);
    $dateRegionServiceKey = hash_hmac('sha256', $service, $dateRegionKey, true);
    $signingKey = hash_hmac('sha256', $requestType, $dateRegionServiceKey, true);

    $signature = hash_hmac('sha256', $base64Policy, $signingKey);

    // Step 4: Build form inputs
    // This is the data that will get sent with the form to S3
    $inputs = [
        'Content-Type' => '',
        'acl' => $acl,
        'success_action_status' => $successStatus,
        'policy' => $base64Policy,
        'X-amz-credential' => $credentials,
        'X-amz-algorithm' => $algorithm,
        'X-amz-date' => $date,
        'X-amz-expires' => $expires,
        'X-amz-signature' => $signature
    ];

    return compact('url', 'inputs');
}
function mbToBytes($megaByte)
{
  if (is_numeric($megaByte)) {
      return $megaByte * pow(1024, 2);
  }
  return 0;
}



?>
