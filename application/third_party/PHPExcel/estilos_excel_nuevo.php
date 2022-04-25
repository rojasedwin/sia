<?php

/*********************************************************

				ESTILOS

*************************************************************/
$styleArray = array(
      'font' => array(
        'name' => 'Arial',
        'size' => '12'
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
          'argb' => 'FFFFFFFF',
        ),
      ),
    );

$cabeceratienda = array(
      'font' => array(
        'name' => 'Arial',
        'size' => '15',
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
          'rgb' => 'BFDFFF',
        ),
      ),
    );

$nombrestienda = array(
      'font' => array(
        'name' => 'Arial',
        'size' => '12',
      )
    );

$leyenda = array(
      'font' => array(
        'name' => 'Arial',
        'size' => '8',
      )
    );
$letra8 = array(
      'font' => array(
        'name' => 'Arial',
        'size' => '8',
      )
    );
$letra16 = array(
      'font' => array(
        'name' => 'Arial',
        'size' => '16',
      )
    );
$letra14 = array(
      'font' => array(
        'name' => 'Arial',
        'size' => '14',
      )
    );

$error_rojo = array(
      'font' => array(
        'color' => array('rgb' => 'E30000'),
        'bold' => true
      )
    );

$error_verde = array(
      'font' => array(
        'color' => array('rgb' => '4A880A'),
        'bold' => true
      )
    );
$letra_verde = array(
      'font' => array(
        'color' => array('rgb' => '15c601'),
        'bold' => false
      )
    );
$letra_naranja = array(
      'font' => array(
        'color' => array('rgb' => 'ff7423'),
        'bold' => false
      )
    );
$letra_azul = array(
      'font' => array(
        'color' => array('rgb' => '0994e5'),
        'bold' => false
      )
    );


$cabeceranombre = array(
      'font' => array(
        'name' => 'Arial',
        'size' => '16',
		'color' => array('rgb' => 'FFFFFF'),
		'bold' => true
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
          'rgb' => '000000',
        ),
      ),
    );

$cabeceratipo = array(
      'font' => array(
        'name' => 'Arial',
        'size' => '16',
		'color' => array('rgb' => 'FFFFFF'),
		'bold' => true
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
          'rgb' => '84B1DC',
        ),
      ),
    );

$cabeceraespecifica = array(
      'font' => array(
        'name' => 'Arial',
        'size' => '10',
		'color' => array('rgb' => 'FFFFFF'),
		'bold' => true
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
          'rgb' => '2978AE',
        ),
      ),
    'borders' => array(
		'bottom' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb' => 'CCCCCC'),
		),
                'right' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb' => 'CCCCCC'),
		),
	),
    );

$cabeceratotal = array(
      'font' => array(
        'name' => 'Arial',
        'size' => '12',
		'color' => array('rgb' => 'FFFFFF'),
		'bold' => true
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
          'rgb' => 'C4E6EC',
        ),
      ),
    );
$cab_grupo = array(
      'font' => array(
        'name' => 'Arial',
        'size' => '12',
		'color' => array('rgb' => 'FFFFFF'),
		'bold' => true
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
          'rgb' => 'E1141D',
        ),
      ),
    );

$nombre_grupo = array(
      'font' => array(
        'name' => 'Arial',
        'size' => '12',
		'color' => array('rgb' => '000000'),
		'bold' => true
      )
    );


$todos_bordes = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => '00000000'),
		),
	),
);
$sinbordes = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FFFFFFFF'),
		),
	),
);
$borde_izq = array(
	'borders' => array(
		'left' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => '00000000'),
		),
	),
);
$borde_der = array(
	'borders' => array(
		'right' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => '00000000'),
		),
	),
);
$borde_sup = array(
	'borders' => array(
		'top' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => '00000000'),
		),
	),
);
$borde_inf = array(
	'borders' => array(
		'bottom' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => '00000000'),
		),
	),
);




$gris_claro = array(
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
          'rgb' => 'DDDEE2',
        ),
      ),
 );

 $gris_muy_claro = array(
       'fill' => array(
         'type' => PHPExcel_Style_Fill::FILL_SOLID,
         'startcolor' => array(
           'rgb' => 'f5f5f5',
         ),
       ),
  );

 $verde_claro = array(
       'fill' => array(
         'type' => PHPExcel_Style_Fill::FILL_SOLID,
         'startcolor' => array(
           'rgb' => 'D2F2EB',
         ),
       ),
  );

  $naranja_claro = array(
        'fill' => array(
          'type' => PHPExcel_Style_Fill::FILL_SOLID,
          'startcolor' => array(
            'rgb' => 'f9c981',
          ),
        ),
   );
   $rojo_claro = array(
         'fill' => array(
           'type' => PHPExcel_Style_Fill::FILL_SOLID,
           'startcolor' => array(
             'rgb' => 'f98f81',
           ),
         ),
    );

   $azul_claro = array(
         'fill' => array(
           'type' => PHPExcel_Style_Fill::FILL_SOLID,
           'startcolor' => array(
             'rgb' => '9edded',
           ),
         ),
    );

 $fila_par = array(
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
          'rgb' => 'FFFFFF',
        ),
      ),
     'borders' => array(
		'bottom' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb' => 'CCCCCC'),
		),
                'right' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb' => 'CCCCCC'),
		),
	),
    );

 $fila_impar = array(
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
          'rgb' => 'DEEDF8',
        ),
      ),
     'borders' => array(
		'bottom' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb' => 'CCCCCC'),
		),
                'right' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb' => 'CCCCCC'),
		),
	),
    );

    $verde_muy_claro = array(
          'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
              'rgb' => 'f0fcfa',
            ),
          ),
     );

?>
