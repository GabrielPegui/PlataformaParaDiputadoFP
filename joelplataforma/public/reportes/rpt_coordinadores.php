<?php
include_once __DIR__ . '/../../config/connection.php';
require 'plantillaJ.php';

session_start();

$cedula_user = $_SESSION['usr_cedula'];

// informacion del capitan
$nombrede="select nombre,apellido,funcion from miembros where cedula=$cedula_user";
$resultadoC = $db->query($nombrede); 
$rowC = $resultadoC->fetch_assoc();

$nombreC = $rowC['nombre'];
$apellidoC = $rowC['apellido'];
$funcion = $rowC['funcion'];


if($funcion == 2){
   
   $sql="select cedula,nombre,apellido,telefono,sector from miembros where cedula_enlace=$cedula_user and funcion=3";

}else{

   header('Location: ../../src/view/reportes.php');
   exit();

}
 
 


$resultado = $db->query($sql); 






             
// reporte     

$v_subtitulo='EQUIPO COORDINADORES DE: '.$nombreC.' '.$apellidoC;
                

          

$tituloReporte = "Avance Enlace";
$pdf = new PDF("L", "mm", "letter");
$pdf->SetTitle($tituloReporte); 
$pdf->SetAuthor('');
$pdf->AliasNbPages();
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->setleftmargin(10);
$pdf->SetFont("Arial", "B",12);

$pdf->Cell(193, 2, $v_subtitulo, 0, 1, "L",FALSE);
$pdf->Ln(5);

$pdf->SetFillcolor(0, 143, 57);
$pdf->Settextcolor(255, 255, 255);

// encabezado de la tabla


$pdf->Cell(10, 5, "No", 1, 0, "C",TRUE);
$pdf->Cell(25, 5, "Cedula", 1, 0, "C",TRUE);
$pdf->Cell(60, 5, "Nombre", 1, 0, "C",TRUE);
$pdf->Cell(60, 5, "Apellido", 1, 0, "C",TRUE);
$pdf->Cell(28, 5, "Telefono", 1, 1, "C",TRUE);



$pdf->SetFont("Arial", "", 9); 

$pdf->SetTextColor(0,0,0);
// Detalle de la Tabla
    // $pdf->Cell(24, 5, "Cedula", 1, 0, "C",TRUE);

       $contador = 0;
     while ($fila = $resultado->fetch_assoc()) {
        $contador = $contador+1;

           $pdf->Cell(10, 5, $contador, 1, 0, "R");
           $pdf->Cell(25, 5, $fila['cedula'], 1, 0, "R");
           $pdf->Cell(60, 5, $fila['nombre'], 1, 0, "L");
           $pdf->Cell(60, 5, $fila['apellido'], 1, 0, "L");
           $pdf->Cell(28, 5, $fila['telefono'], 1, 1, "L");
         
           

            
            
        }
    

$pdf->Output('I', $tituloReporte . '.pdf');
  


?>
