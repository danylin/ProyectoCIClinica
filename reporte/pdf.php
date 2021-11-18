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
            $nroEvento=$_GET['codigo'];
            include("../include/bd_usuario.php");
            $sedeUsuario=$_SESSION['id_sede'];
            $sedeNombre="SELECT sede FROM sede__db_area WHERE id=$sedeUsuario";
            $resultadoSede=mysqli_query($conexion,$sedeNombre);
            $sede=mysqli_fetch_array($resultadoSede);
            $sql="SELECT a.fecha_programacion,a.codigo_cierre, CONCAT(a.nombre_paciente,' ',a.apellido_paciente) paciente,b.nombre,a.nombre_responsable
            FROM sop__evento_acc_db a 
            INNER JOIN sop__eventos_db b ON
            a.id_evento=b.id_evento
            WHERE a.id_accion=$nroEvento;";
            $resultado=mysqli_query($conexion,$sql);
            $row=mysqli_fetch_array($resultado);
                    // Logo
                    $image_file = '../img/logotipo_auna.jpg';
                    $texto="Reporte de Movimiento de Materiales de Farmacia";
                    $this->Image($image_file,180, 0, 20, '', 'JPG', '', 'R', false, 300, '', false, false, 0, false, false, false);
                    // Set font
                    $this->SetFont('helvetica', 'B', 12);
                    // Title
                    $this->Cell(0, 0, $sede['sede'], 0, 1, 'L', 0, '', 0);
                    $this->Cell(0, 0, $texto, 0, 1, 'L', 0, '', 0);
                    $this->Cell(0, 0, $row['nombre'], 0, 1, 'L', 0, '', 0);
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
$html = '<style>

table tr td{
    text-align: center;
    vertical-align: middle;
    
}
h4{
    padding:0;
    margin:0;
}
</style>';
$pdf->MultiCell(55, 5, 'Nro de Encuentro/Cierre', 0, 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, $row['codigo_cierre'], 0, 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, $pdf->write1DBarcode($row['codigo_cierre'], 'C39', '', '', 55, 9, 0.4, array('position'=>'', 'border'=>false, 'padding'=>2, 'fgcolor'=>array(0,0,0), 'bgcolor'=>false, 'text'=>false, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), ''), 0, 'L', 0, 1, '', '', true);
$pdf->MultiCell(55, 5, 'Fecha de Cierre', 0, 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, $row['fecha_programacion'], 0, 'L', 0, 1, '', '', true);
$pdf->MultiCell(55, 5, 'Paciente', 0, 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, $row['paciente'] , 0, 'L', 0, 1, '', '', true);
$pdf->MultiCell(55, 5, 'Médico Tratante', 0, 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, $row['nombre_responsable'], 0, 'L', 0, 1, '', '', true);
$pdf->MultiCell(55, 5, 'Número de Items', 0, 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, $totalItems['total'], 0, 'L', 0, 1, '', '', true);
$pdf->MultiCell(55, 5, 'Cantidad Utilizada', 0, 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, $resultadoCantidad['total'], 0, 'L', 0, 1, '', '', true);
$html.='
<h4>Materiales de Compra</h4>
<table id="elementos" border="0.5" nobr="true">
<tr>
    <td width="120px" bgcolor="#ABABAB">CodSAP</td>
    <td width="420px" bgcolor="#ABABAB">Descripcion del Material</td>
    <td width="75px" bgcolor="#ABABAB">Cantidad</td>
    <td width="45px" bgcolor="#ABABAB">Tipo</td>
</tr>   ';
$materiales="SELECT id_material,nombre,SUM(cantidad-devolucion) resultado,tipo,subtipo
FROM sop__despacho_db
WHERE id_evento_acc=$nroEvento and tipo=''
GROUP BY nombre
ORDER BY nombre asc";
$resultado=mysqli_query($conexion,$materiales);
$consultaresultado=mysqli_fetch_all($resultado);
foreach($consultaresultado as $row){
    if($row['2']!=0){
        $params = $pdf->serializeTCPDFtagParameters(array($row[0], 'C128', '', '', 32, 12, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>2, 'fgcolor'=>array(0,0,0), 'bgcolor'=>false, 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), ''));
        $html.='
        <tr>
        <td><tcpdf method="write1DBarcode" params="'.$params.'" /></td>
        <td align="left">'.$row[1].'</td>
        <td>'.$row[2].'</td>
        <td>'.$row[3].'</td>
        </tr>';
    }
};
$html.='</table>';
$materiales="SELECT id_material,nombre,SUM(cantidad-devolucion) resultado,tipo,subtipo
FROM sop__despacho_db
WHERE id_evento_acc=$nroEvento and tipo='I'
GROUP BY nombre
ORDER BY nombre asc";
$resultado=mysqli_query($conexion,$materiales);
$filas=mysqli_num_rows($resultado);
if($filas>0){
    $contar=0;
    while ($row=mysqli_fetch_array($resultado)){
        if($row['resultado']!=0){
            if($contar==0){
                $html.= '<h4>Materiales Tipo I</h4><table id="elementos" border="0.5" nobr="true">
                <tr>
                <td width="120px" bgcolor="#ABABAB">CodSAP</td>
                <td width="420px" bgcolor="#ABABAB">Descripcion del Material</td>
                <td width="75px" bgcolor="#ABABAB">Cantidad</td>
                <td width="45px" bgcolor="#ABABAB">Tipo</td>
                </tr>
                <tbody>';
                $contar=1;
            }
            $params = $pdf->serializeTCPDFtagParameters(array($row['id_material'], 'C128', '', '', 32, 12, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>2, 'fgcolor'=>array(0,0,0), 'bgcolor'=>false, 'text'=>false, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), ''));
            $html.= '<tr>
            <td><tcpdf method="write1DBarcode" params="'.$params.'" /></td>
            <td align="left">'.$row['nombre'].'</td>
            <td>'.$row['resultado'].'</td>
            <td>'.$row['tipo'].'</td>
            </tr>';
        }
    }   
    $html.= '</tbody></table>';
}
$materiales="SELECT id_material,nombre,SUM(cantidad-devolucion) resultado,tipo,subtipo
FROM sop__despacho_db
WHERE id_evento_acc=$nroEvento and tipo='K'
GROUP BY nombre
ORDER BY nombre asc";
$resultado=mysqli_query($conexion,$materiales);
$filas=mysqli_num_rows($resultado);
if($filas>0){
    $contar=0;
    while ($row=mysqli_fetch_array($resultado)){
        if($row['resultado']!=0){
            if ($contar==0){
                $html.= '<h4>Materiales Tipo K</h4><table border="0.5" nobr="true">
                <tr>
                <td width="120px" bgcolor="#ABABAB">CodSAP</td>
                <td width="420px" bgcolor="#ABABAB">Descripcion del Material</td>
                <td width="75px" bgcolor="#ABABAB">Cantidad</td>
                <td width="45px" bgcolor="#ABABAB">Tipo</td>
                </tr>
                <tbody>';
                $contar=1;
            }
            $params = $pdf->serializeTCPDFtagParameters(array($row['id_material'], 'C128', '', '', 32, 12, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>2, 'fgcolor'=>array(0,0,0), 'bgcolor'=>false, 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), ''));
            $html.= '<tr>
            <td><tcpdf method="write1DBarcode" params="'.$params.'" /></td>
            <td align="left">'.$row['nombre'].'</td>
            <td>'.$row['resultado'].'</td>
            <td>'.$row['tipo'].'</td>
            </tr>';
        }
    }
$html.='</tbody></table>';
}

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
ob_end_clean();
$pdf->Output('Reporte de Evento.pdf', 'I');

?>
