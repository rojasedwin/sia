<?php

class Excel {

    private $excel;

    public function __construct() {
        // initialise the reference to the codeigniter instance
        require_once APPPATH.'third_party/PHPExcel.php';
        $this->excel = new PHPExcel();
    }

    public function load($path) {
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $this->excel = $objReader->load($path);
    }

    public function save($path) {
        // Write out as the new file
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save($path);
    }

    public function stream($filename) {
        header('Content-type: application/ms-excel');
        header("Content-Disposition: attachment; filename=\"".$filename."\"");
        header("Cache-control: private");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function  __call($name, $arguments) {
        // make sure our child object has this method
        if(method_exists($this->excel, $name)) {
            // forward the call to our child object
            return call_user_func_array(array($this->excel, $name), $arguments);
        }
        return null;
    }


  
    /*Leer excel condiciones productos*/
    public function leer_excelCondicionesProductos($archivo, $miscodnacional, $condicion_id ){

      $inputFileType = PHPExcel_IOFactory::identify($archivo);
      $objReader = PHPExcel_IOFactory::createReader($inputFileType);
      $objPHPExcel = $objReader->load($archivo);

      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestRow();
      if($highestRow>7000) $highestRow= 7000;

      $highestColumn = $sheet->getHighestColumn();
      $fila_inicio_datos = 2;
      $mis_lineas = array();
      $hoy = strtotime(date("Y-m-d"));
      $limit = 30*6*60*60*24; //6 meses
      //$highestRow = 60;
      for ($row = $fila_inicio_datos; $row <= $highestRow; $row++){

        if(trim($sheet->getCell("A".$row)->getValue()," ")!="")
        {
         

          $tmp = array();
          $cod_nacional =trim($sheet->getCell("A".$row)->getValue()," ");
		   //$index = $row;
		   $index = $cod_nacional;
		  
		  
          if(!array_key_exists($cod_nacional,$miscodnacional) and !array_key_exists($cod_nacional,$mis_lineas) ){
				$tmp['cod_nacional'] =$cod_nacional;
				$tmp['condicion_id'] =$condicion_id;
            $mis_lineas[ $index ] = $tmp;
          }



         



        }

      }

      return $mis_lineas;

    }


    /*Leer excel pasos*/
    public function leer_excelPasos($archivo, $name_real,  $paso_id ){

      $inputFileType = PHPExcel_IOFactory::identify($archivo);
      $objReader = PHPExcel_IOFactory::createReader($inputFileType);
      $objPHPExcel = $objReader->load($archivo);
      $sheetCount = $objPHPExcel->getSheetCount();
	  
	  $worksheet = $objPHPExcel->getSheetNames();
	  
	   $mis_lineas['detalle'] = array();
	   $mis_lineas['errores'] = false;

		if(!in_array('Balance Lista',$worksheet)){
			 $mis_lineas['errores'] = true;
			 return $mis_lineas;
			 exit;
		}
      $sheet = $objPHPExcel->getSheet(6);
	  


     $sheet_name=$sheet->getTitle();


      $highestRow = $sheet->getHighestRow();
      if($highestRow>7000) $highestRow= 7000;

      $highestColumn = $sheet->getHighestColumn();
      $fila_inicio_datos = 2;
     
    
      $hoy = strtotime(date("Y-m-d"));
      $limit = 30*6*60*60*24; //6 meses
      //$highestRow = 60;
      $tot_filas=0;
      $unidades=0;
	 
	  
	  if( $sheet_name=="Balance Lista"){
		  for ($row = $fila_inicio_datos; $row <= $highestRow; $row++){

			if(trim($sheet->getCell("D".$row)->getValue()," ")!="")
			{
			  $index = $row;

			  $tmp = array();
			
			  $cod_nacional =trim($sheet->getCell("D".$row)->getValue()," ");
				  

				//SI no existe el cod nacional en el array actual inicializo en cero
				if( !isset($mis_lineas['detalle'][ $cod_nacional ]) ){
					$mis_lineas['detalle'][ $cod_nacional ] =array();
					$mis_lineas['detalle'][ $cod_nacional ]['cod_nacional'] =$cod_nacional;
					$mis_lineas['detalle'][ $cod_nacional ]['nombre_excel'] =$name_real;
					$mis_lineas['detalle'][ $cod_nacional ]['num_unidades'] =0;

				}
				$valor_columnaL=trim($sheet->getCell("L".$row)->getValue()," ");
				$valor_columnaS=trim($sheet->getCell("S".$row)->getValue()," ");
				$mis_lineas['detalle'][ $cod_nacional ]['num_unidades'] +=($valor_columnaL/2)+($valor_columnaS); 

			}//fin de if
			$tot_filas++;
		  }//fin del for
		  $mis_lineas['resumen'][ 0 ]['nombre_excel'] = $name_real;
		  $mis_lineas['resumen'][ 0 ]['num_registros'] = $tot_filas;
	  }else{
		  $mis_lineas['errores'] = truee;
	  }

      return $mis_lineas;

    }


    public function leer_excelPasos2($archivo ){

      $inputFileType = PHPExcel_IOFactory::identify($archivo);
      $objReader = PHPExcel_IOFactory::createReader($inputFileType);
      $objPHPExcel = $objReader->load($archivo);
      $sheetCount = $objPHPExcel->getSheetCount();

      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestRow();
      if($highestRow>7000) $highestRow= 7000;

      $highestColumn = $sheet->getHighestColumn();
      $fila_inicio_datos = 2;
      $mis_lineas['detalle'] = array();
      $mis_lineas['error'] = array();
    
      $hoy = strtotime(date("Y-m-d"));
      $limit = 30*6*60*60*24; //6 meses
      //$highestRow = 60;
     
      for ($row = $fila_inicio_datos; $row <= $highestRow; $row++){

        if(trim($sheet->getCell("A".$row)->getValue()," ")!="")
        {
          $index = $row;

          $tmp = array();
        
          $cod_nacional =trim($sheet->getCell("A".$row)->getValue()," ");
          $unidades =trim($sheet->getCell("C".$row)->getValue()," ");
         	       
	        $tmp['cod_nacional'] =$cod_nacional;
          $tmp['num_unidades'] =$unidades;

          $mis_lineas['detalle'][ $index ] = $tmp;


        }
     
      }//fin del for
     
      return $mis_lineas;

    }













   
}

?>
