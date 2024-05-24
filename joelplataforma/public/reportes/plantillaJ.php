<?php

/**
 * Plantilla para encabezado y pie de página
 * 
 * Fecha: 17/01/2023
 * Autor: Marco Robles
 * Web:   https://github.com/mroblesdev
 */

require 'fpdf.php';

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        global $subtitulo;
        global $tituloReporte;
        // Logo
        $this->Image("JOEL_RODRIGUEZ_LOGO.png", 90, 5, 50);

        // Arial bold 15
        $this->SetFont("Arial", "B", 12);

        // Título
        $this->Cell(1,1,"",0,1);
        $this->Cell(210, 40,'Diputado Circunscripcion 3 DN', 0, 1, 'C');  
       // $this->Cell(210, 10,'PROVINCIA '.'HERMANAS MIRABAL', 0, 1, 'C');
        //$this->Cell(10, 5,  mb_convert_encoding($tituloReporte, 'ISO-8859-1', 'UTF-8'), 0, 1, "L");
        
        //Fecha
        $this->SetFont("Arial", "", 9);
       

        //$this->Cell(0, 5, "Grado: " . $nombreGrado, 0, 1, "C");

        // Salto de línea
        /* $this->Ln(5); */
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->Cell(0, 10, "Fecha: " . date("d/m/Y"), 0, 1, "R");
        //LOGO DEL FINAL
        $this->Image("JOEL_RODRIGUEZ_LOGO.png", 0, 268,30);
    }
}
