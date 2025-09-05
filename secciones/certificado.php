<?php 
require('../librerias/fpdf/fpdf.php');

include_once("../configuracion/bd.php");
$conexionBD=BD::crearInstancia();

//print_r($_GET);
$idcurso=(isset($_GET['idcurso']))?$_GET['idcurso']:"";
$idalumno=(isset($_GET['idalumno']))?$_GET['idalumno']:"";


function agregarTexto($pdf,$texto,$posicionHorizontal,$posicionVertical,$alineacion,$f,$t,$s,$r,$g,$b) 
{
    $pdf->SetFont($f,$t,$s);	
    $pdf->SetXY($posicionHorizontal,$posicionVertical);
    $pdf->SetTextColor($r,$g,$b);
    $pdf->Cell(0,10,$texto,0,0,$alineacion);	
}

function AgregarImagen($pdf, $imagen, $x, $y) {
$pdf->Image($imagen,$x,$y,0);	
}

$sqlcurso_alumno= $conexionBD->prepare("SELECT alumnos.nombre, 
alumnos.apellidos, cursos.nombre_curso 
FROM alumnos,cursos WHERE alumnos.id=? AND cursos.id=? ;");
$sqlcurso_alumno->execute([$idalumno,$idcurso]);
$cursosAlumno=($sqlcurso_alumno->fetchAll());
//print_r($cursosAlumno);
$pdf = new FPDF('L','mm',array(254,190));
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
AgregarImagen($pdf,'../src/certificado_.jpg', 0,0);
agregarTexto($pdf,ucwords(utf8_decode($cursosAlumno[0]['nombre']." ".$cursosAlumno[0]['apellidos'])),60,70, 'L', 'Helvetica','',30,0,84,115);
agregarTexto($pdf,$cursosAlumno[0]['nombre_curso'],-250,110, 'C', 'Helvetica','',20,0,84,115);
agregarTexto($pdf,date("d/m/Y"),-350,155, 'C', 'Helvetica','',11,0,84,115);

$pdf->Output();

/*
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'¡Hola, Mundo!');
$pdf->Output();
*/

?>