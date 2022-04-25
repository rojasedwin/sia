<form id='condiciones_form_item' name='condiciones_form_item'>

<input type='hidden' name='condicion_id' id='condicion_id' value='<?php echo $item['condicion_id'];?>'>
<div class="row form_reduced form_color_inputs">

    <div class='form-group <?=$bootstrap['col-12']?> validation_inline nopadding' id='validation_condicion_errors'></div>

    <div style='clear:both;height:1px;'>&nbsp;</div>

    <?php

    $atributos    = array('name'=>'laboratorio_id',
    'data-style'      =>'btn-warning btn-sm maxheigh-300',
    'data-live-search'=>'true',
    'data-width'      =>'100%',
    'tabindex'        =>'-1',
    'id'              =>'laboratorio_id',
    'data-dropup-auto'=>'false');
    $clases       = array('');
    $extra_select = array('option-value'=>'laboratorio_id',
    'option-show'     =>'laboratorio_nombrecomercial',
    'option-data'     =>$laboratorios,
    'option-default'  =>'-- Seleccione --');
    echo pintarCampoForm("select",2,"Laboratorio",$item['laboratorio_id'],$atributos,$clases, $extra_select);

      $atributos = array('name'       =>'condicion_nombre',
                         'placeholder'=>'Nombre de la Condición');
      $clases    = array('');
      echo pintarCampoForm("text",6,"Nombre de la Condición",$item['condicion_nombre'],$atributos,$clases, "");



      $atributos    = array('name'            =>'proveedor_id[]',
                            'data-style'      =>'btn-info btn-sm maxheigh-300',
                            'data-live-search'=>'true',
                            'data-actions-box'=>'true',
                            'data-width'      =>'100%',
                            'tabindex'        =>'-1',
                            'id'              =>'proveedor_id',
                            'data-dropup-auto'=>'false');
      $clases       = array('');
      $extra_select = array('option-value'    =>'proveedor_id',
                            'option-show'     =>'proveedor_nombrecomercial',
                            'option-data'     =>$proveedores);
      $seleccionados = $misproveedores;

      echo pintarCampoForm("select multiple",4,"Proveedor",$seleccionados,$atributos,$clases, $extra_select);

      $atributos = array('name'       =>'condicion_cantidad_minima',
                         'placeholder'=>'Cantidad Mínima para la Condición');
      $clases    = array('');
      echo pintarCampoForm("text",6,"Cantidad Mínima para la Condición",(($item['condicion_cantidad_minima']!=-1)?$item['condicion_cantidad_minima']:''),$atributos,$clases, "");

      $atributos = array('name'       =>'condicion_cantidad_maxima',
                         'placeholder'=>'Cantidad Máxima para la Condición');
      $clases    = array('');
      echo pintarCampoForm("text",6,"Cantidad Máxima para la Condición",(($item['condicion_cantidad_maxima']!=-1)?$item['condicion_cantidad_maxima']:''),$atributos,$clases, "");


      echo clearForm();

      $atributos = array('name'       =>'condicion_cantidad_minima_eur',
                         'placeholder'=>'Cantidad Mínima en Euros para la Condición');
      $clases    = array('');
      echo pintarCampoForm("text",6,"Cantidad Mínima en Euros para la Condición",(($item['condicion_cantidad_minima_eur']!=-1)?$item['condicion_cantidad_minima_eur']:''),$atributos,$clases, "");

      $atributos = array('name'       =>'condicion_cantidad_maxima_eur',
                         'placeholder'=>'Cantidad Máxima en Euros para la Condición');
      $clases    = array('');
      echo pintarCampoForm("text",6,"Cantidad Máxima en Euros para la Condición",(($item['condicion_cantidad_maxima_eur']!=-1)?$item['condicion_cantidad_maxima_eur']:''),$atributos,$clases, "");

      $atributos = array('name'            =>'condicion_tipo_descuento',
                         'data-style'      =>'btn-rojosuave btn-sm maxheigh-300',
                         'data-live-search'=>'false',
                         'data-width'      =>'100%',
                         'tabindex'        =>'-1',
                         'data-actions-box'=>'false',
                         'title'           =>'Seleccionar tipo',
                         'id'              =>'condicion_tipo_descuento',
                         'data-dropup-auto'=>'false');
      $clases    = array('');
      echo pintarCampoForm("select",3,"Tipo Descuento","",$atributos,$clases, "");

      echo "<option value=''>-- Seleccione --</option>";
      echo "<option ".(($item['condicion_tipo_descuento']==0)?'selected':'')." value='0'>% Porcentaje</option>";
      echo "<option ".(($item['condicion_tipo_descuento']==1)?'selected':'')." value='1'>€ Directo</option>";

      echo finCampoSelect();

      $atributos = array('name'       =>'condicion_cantidad_descuento',
      'placeholder'=>'Cantidad Descuento');
$clases    = array('');
echo pintarCampoForm("text",3,"Cantidad Descuento",$item['condicion_cantidad_descuento'],$atributos,$clases, "");


$atributos = array('name'       =>'unidades_oferta',
'placeholder'=>'Por cada X unidades');
$clases    = array('');
echo pintarCampoForm("text",3,"Por cada X Unidades",(($item['unidades_oferta']!=0)?$item['unidades_oferta']:''),$atributos,$clases, "");

$atributos = array('name'       =>'unidades_regalo_oferta',
'placeholder'=>'Me regalan');
$clases    = array('');
echo pintarCampoForm("text",3,"Me regalan",(($item['unidades_regalo_oferta']!=0)?$item['unidades_regalo_oferta']:''),$atributos,$clases, "");


    ?>
    <div style='clear:both;height:1px;'>&nbsp;</div>

</div>
</form>
