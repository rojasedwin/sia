<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function getAds($add_id,$user_access_token)
{
  $return_data = array();
  $return_data['result'] = 1;

  //fetch lead info from FB API
  $graph_url = 'https://graph.facebook.com/v3.1/' . $add_id. "?access_token=" . $user_access_token;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $graph_url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  $output = curl_exec($ch);
  echo "<pre>";
  print_r($output);
  echo "</pre>";
  curl_close($ch);

  $addData = json_decode($output);
  echo "<pre>";
  print_r($addData);
  echo "</pre>";
}

function getLead($leadgen_id,$user_access_token) {
    $return_data = array();
    $return_data['result'] = 1;

    //fetch lead info from FB API
    $graph_url = 'https://graph.facebook.com/v3.3/' . $leadgen_id. "?access_token=" . $user_access_token."&fields=field_data,ad_name,campaign_id,vehicle,is_organic,platform,partner_name";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $graph_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $output = curl_exec($ch);
    curl_close($ch);

    //work with the lead data and pass to an array

    $leaddata = json_decode($output);
    $return_data['query'] = $graph_url;
    if(isset($leaddata->error))
    {
      $return_data['result'] = 0;
      $return_data['data'] = $leaddata;

      return $return_data;
    }

    $lead = array();
    $campos_obtener = array("adset_name","campaign_name","ad_name","test");
    foreach($campos_obtener as $co)
      if(isset($leaddata->$co))
      $lead[ $co ] = $leaddata->$co;

    for( $i=0; $i<count( $leaddata->field_data ); $i++ ) {
        $lead[$leaddata->field_data[$i]->name]=$leaddata->field_data[$i]->values[0];
        //error_log(print_r($lead, true));
    }
    $return_data['data'] = $lead;
    return $return_data;
}

?>
