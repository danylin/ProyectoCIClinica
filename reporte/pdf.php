<?php
session_start();
include("../include/bd_usuario.php");
require_once("../TCPDF/tcpdf.php");
            $nroEvento=$_GET['codigo'];
            $sql="SELECT a.fecha_programacion,a.codigo_cierre, CONCAT(a.nombre_paciente,' ',a.apellido_paciente) paciente,b.nombre,a.nombre_responsable
            FROM sop__evento_acc_db a 
            INNER JOIN sop__eventos_db b ON
            a.id_evento=b.id_evento
            WHERE a.id_accion=$nroEvento;";
            $cantidadConsulta="SELECT SUM(cantidad-devolucion) total FROM sop__despacho_db WHERE id_evento_acc=$nroEvento;";
            $itemsConsulta="SELECT  COUNT(nombre) total FROM sop__despacho_db WHERE id_evento_acc=$nroEvento;";
            $resultado=mysqli_query($conexion,$sql);
            $cantidadTotal=mysqli_query($conexion,$cantidadConsulta);
            $cantidadItems=mysqli_query($conexion,$itemsConsulta);
            $row=mysqli_fetch_array($resultado);
            $resultadoCantidad=mysqli_fetch_array($cantidadTotal);
            $totalItems=mysqli_fetch_array($cantidadItems);
class MYPDF extends TCPDF {

     //Page header
        public function Header() {
            $conexion= mysqli_connect("localhost","root","","proyectocl");
            $sedeUsuario=$_SESSION['id_sede'];
            $sedeNombre="SELECT sede FROM sede__db_area WHERE id=$sedeUsuario";
            $resultadoSede=mysqli_query($conexion,$sedeNombre);
            $sede=mysqli_fetch_array($resultadoSede);
                    // Logo
                    $image_file = '../img/logotipo_auna.jpg';
                    $this->Image($image_file,180, 0, 20, '', 'JPG', '', 'R', false, 300, '', false, false, 0, false, false, false);
                    // Set font
                    $this->SetFont('helvetica', 'B', 12);
                    // Title
                    $this->Cell(0, 0, 'Reporte de Evento', 0, 1, 'L', 0, '', 0);
                    $this->Cell(0, 0, $sede['sede'], 0, 1, 'L', 0, '', 0);
                }
            
                // Page footer
                public function Footer() {
                    // Position at 15 mm from bottom
                    $this->SetY(-15);
                    // Set font
                    $this->SetFont('helvetica', 'I', 8);
                    // Page number
                    $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                }
            }
            
            // create new PDF document
            $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Nicola Asuni');
            $pdf->SetTitle('Reporte de Eventos');
            $pdf->SetSubject('TCPDF Tutorial');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            
            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);            

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

$pdf->SetFont('times', '', 12, '', true);

$pdf->AddPage();
$params = $pdf->serializeTCPDFtagParameters(array($row['codigo_cierre'], 'C39', '', '', 50, 15, 1, array('position'=>'', 'border'=>false, 'padding'=>2, 'fgcolor'=>array(0,0,0), 'bgcolor'=>false, 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
$html = '<style>

table tr td{
    text-align: center;
    border: 1px solid black;
}
</style>
<div id="informacio-general">
<table>
<tbody>
    <tr>
        <td width="185px">Nro de Encuentro</td>
        <td width="175px">'. $row['codigo_cierre'].'</td>
        <tcpdf method="write1DBarcode" params="'.$params.'" />
    </tr>
    <tr>
        <td width="185px">Fecha</td>
        <td width="175px">'.$row['fecha_programacion'].'</td>
    </tr>
    <tr>
        <td width="185px">Paciente</td>
        <td width="175px">'.$row['paciente'].'</td>
    </tr>
    <tr>
        <td width="185px">Procedimiento</td>
        <td width="175px">'.$row['nombre'].'</td>
    </tr>
    <tr>
        <td width="185px">Cirujano Principal</td>
        <td width="175px">'.$row['nombre_responsable'].'</td>
    </tr>
    <tr>
        <td width="185px">Número de Items</td>
        <td width="175px">'.$totalItems['total'].' </td>
    </tr>
    <tr>
        <td width="185px">Cantidad Total Utilizada</td>
        <td width="175px">'.$resultadoCantidad['total'].'</td>
    </tr>
</tbody>    
</table>
</div>
<div id="registroElementos">
<table id="elementos">
<tr>
    <td width="120px" bgcolor="#4dbac4">BarCode</td>
    <td width="80px" bgcolor="#4dbac4">Codigo de Material</td>
    <td width="225px" bgcolor="#4dbac4">Descripcion del Material</td>
    <td width="75px" bgcolor="#4dbac4">Cantidad</td>
    <td width="75px" bgcolor="#4dbac4">Tipo</td>
    <td width="75px" bgcolor="#4dbac4">Subtipo</td>
</tr>   ';
$materiales="SELECT id_material,nombre,(cantidad-devolucion) resultado,tipo,subtipo
FROM sop__despacho_db
WHERE id_evento_acc=$nroEvento and tipo=''
ORDER BY nombre asc";
$resultado=mysqli_query($conexion,$materiales);
$consultaresultado=mysqli_fetch_all($resultado);
foreach($consultaresultado as $row){
    $params = $pdf->serializeTCPDFtagParameters(array($row[0], 'C39', '', '', 32, 15, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>2, 'fgcolor'=>array(0,0,0), 'bgcolor'=>false, 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
    $html.='
    <tr>
    <td><tcpdf method="write1DBarcode" params="'.$params.'" /></td>
    <td>'.$row[0].'</td>
    <td>'.$row[1].'</td>
    <td>'.$row[2].'</td>
    <td>'.$row[3].'</td>
    <td>'.$row[4].'</td>
    </tr>';
};

$html.='</table>
</div>
';
$materiales="SELECT id_material,nombre,(cantidad-devolucion) resultado,tipo,subtipo
FROM sop__despacho_db
WHERE id_evento_acc=$nroEvento and tipo='I'";
$resultado=mysqli_query($conexion,$materiales);
$filas=mysqli_num_rows($resultado);
if($filas>0){
    $html.= '<div><table id="elementos">
    <tr>
    <td width="120px" bgcolor="#4dbac4">BarCode</td>
    <td width="80px" bgcolor="#4dbac4">Codigo de Material</td>
    <td width="225px" bgcolor="#4dbac4">Descripcion del Material</td>
    <td width="75px" bgcolor="#4dbac4">Cantidad</td>
    <td width="75px" bgcolor="#4dbac4">Tipo</td>
    <td width="75px" bgcolor="#4dbac4">Subtipo</td>
    </tr>
    <tbody>';
    while ($row=mysqli_fetch_array($resultado)){
        $params = $pdf->serializeTCPDFtagParameters(array($row['id_material'], 'C39', '', '', 32, 15, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>2, 'fgcolor'=>array(0,0,0), 'bgcolor'=>false, 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
        $html.= '<tr>
        <td><tcpdf method="write1DBarcode" params="'.$params.'" /></td>
        <td>'.$row['id_material'].'</td>
        <td>'.$row['nombre'].'</td>
        <td>'.$row['resultado'].'</td>
        <td>'.$row['tipo'].'</td>
        <td>'.$row['subtipo'].'</td>
        </tr>
     </tbody></table></div>';
}
}
$materiales="SELECT id_material,nombre,(cantidad-devolucion) resultado,tipo,subtipo
FROM sop__despacho_db
WHERE id_evento_acc=$nroEvento and tipo='K'";
$resultado=mysqli_query($conexion,$materiales);
$filas=mysqli_num_rows($resultado);
if($filas>0){
    $html.= '<table>
    <tr>
    <td width="120px" bgcolor="#4dbac4">BarCode</td>
    <td width="80px" bgcolor="#4dbac4">Codigo de Material</td>
    <td width="225px" bgcolor="#4dbac4">Descripcion del Material</td>
    <td width="75px" bgcolor="#4dbac4">Cantidad</td>
    <td width="75px" bgcolor="#4dbac4">Tipo</td>
    <td width="75px" bgcolor="#4dbac4">Subtipo</td>
    </tr>
    <tbody>';
    while ($row=mysqli_fetch_array($resultado)){
        $params = $pdf->serializeTCPDFtagParameters(array($row['id_material'], 'C39', '', '', 32, 15, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>2, 'fgcolor'=>array(0,0,0), 'bgcolor'=>false, 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
        $html.= '<tr>
        <td><tcpdf method="write1DBarcode" params="'.$params.'" /></td>
        <td>'.$row['id_material'].'</td>
        <td>'.$row['nombre'].'</td>
        <td>'.$row['resultado'].'</td>
        <td>'.$row['tipo'].'</td>
        <td>'.$row['sub tipo'].'</td>
        </tr>
     </tbody></table>';
}
}
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
ob_end_clean();
$pdf->Output('example_001.pdf', 'I');

?>
