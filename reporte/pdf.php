<?php

require_once("../TCPDF/tcpdf.php");
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'../img/logotipo_auna.png';
        $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, 'Reporte de Eventos', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

}
$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => true,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);
include("../include/bd_usuario.php");
            $nroEvento=$_GET['codigo'];
            $nroEncuentro=$_GET['encuentro'];
            $sql="SELECT a.fecha_programacion,a.codigo_cierre, CONCAT(a.nombre_paciente,' ',a.apellido_paciente) paciente,b.nombre,a.nombre_responsable
            FROM evento_acc_db a 
            INNER JOIN eventos_db b ON
            a.id_evento=b.id_evento
            WHERE a.id_accion=$nroEvento;";
            $cantidadConsulta="SELECT SUM(cantidad-devolucion) total FROM despacho_db WHERE id_evento_acc=$nroEvento;";
            $itemsConsulta="SELECT  COUNT(nombre) total FROM despacho_db WHERE id_evento_acc=$nroEvento;";
            $resultado=mysqli_query($conexion,$sql);
            $cantidadTotal=mysqli_query($conexion,$cantidadConsulta);
            $cantidadItems=mysqli_query($conexion,$itemsConsulta);
            $row=mysqli_fetch_array($resultado);
            $resultadoCantidad=mysqli_fetch_array($cantidadTotal);
            $totalItems=mysqli_fetch_array($cantidadItems);
            $codigoPaciente=$row['codigo_cierre'];
            
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Reporte de Evento');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH,'Reporte de Evento');
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

$pdf->SetFont('dejavusans', '', 12, '', true);

$pdf->AddPage();

$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

$html = '<style>
table{
    width: 100%;
}

table tr td{
    text-align: center;
    border: 1px solid black;
    width: 26%;
}

</style>
<div id="informacio-general">
<table>
<tbody>
    <tr>
        <td>Nro de Encuentro</td>
        <td>'. $row['codigo_cierre'].'</td>
        <td>'.$pdf->write1DBarcode($codigoPaciente, 'C128A', 105, '', 90, 15, 0.4, $style, 'N').'</td>
    </tr>
    <tr>
        <td>Fecha</td>
        <td>'.$row['fecha_programacion'].'</td>
    </tr>
    <tr>
        <td>Paciente</td>
        <td>'.$row['paciente'].'</td>
    </tr>
    <tr>
        <td>Procedimiento</td>
        <td>'.$row['nombre'].'</td>
    </tr>
    <tr>
        <td>Cirujano Principal</td>
        <td>'.$row['nombre_responsable'].'</td>
    </tr>
    <tr>
        <td>Número de Items</td>
        <td>'.$totalItems['total'].' </td>
    </tr>
    <tr>
        <td>Cantidad Total Utilizada</td>
        <td>'.$resultadoCantidad['total'].'</td>
    </tr>
</tbody>    
</table>
</div>
<div id="registroElementos">
<table id="elementos">
<tr>
    <td bgcolor="cyan">Codigo de Material</td>
    <td bgcolor="cyan">Descripcion del Material</td>
    <td bgcolor="cyan">Cantidad</td>
    <td bgcolor="cyan">Tipo</td>
</tr>   ';
$materiales="SELECT id_material,nombre,(cantidad-devolucion) resultado,tipo
FROM despacho_db
WHERE id_evento_acc=$nroEvento";
$resultado=mysqli_query($conexion,$materiales);
$consultaresultado=mysqli_fetch_all($resultado);
foreach($consultaresultado as $row){
    $html.='
    <tr>
    <td>'.$row[0].'</td>
    <td>'.$row[1].'</td>
    <td>'.$row[2].'</td>
    <td>'.$row[3].'</td>
    </tr>';
};

$html.='</table>
</div>
';

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
ob_end_clean();
$pdf->Output('example_001.pdf', 'I');

?>