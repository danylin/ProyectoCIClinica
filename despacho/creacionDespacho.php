
    <?php
        include("../include/bd_usuario.php");
        error_reporting(0);
        $devolucion=$_POST['devolucion'];
        $tipoEvento=$_POST['tipoEvento'];
        $evento=$_POST['evento'];
            if($_POST['codigo']=="."){
                echo '<script language="javascript">';
                echo 'busquedaManual();';
                echo '</script>';
            }else{
                if ($evento!="Procedimiento Medico" || $evento="Control Logistico"){
                    if($tipoEvento=="Todos"){
                        echo '<script language="javascript">';
                        echo 'alert("Elija un subtipo antes de ingresar el codigo")';
                        echo '</script>'; 
                    }
                    else {
                        if(isset($_POST['nombre'])){
                            $nombreManual=$_POST['nombre'];
                            $cantidadManual=$_POST['cantidad'];
                            $tipo='';
                            $gtin=$_POST['codgtin'];
                            $crf=$_POST['crf'];
                            $nuevoProducto="INSERT INTO sop__materialsc_db(nombre,gtin,crf) values('$nombreManual','$gtin','$crf')";
                            $consulta=mysqli_query($conexion,$nuevoProducto);
                            $query="UPDATE sop__materialsc_db SET id_sc=CONCAT('SC_',id) WHERE nombre='$nombreManual'";
                            $consulta=mysqli_query($conexion,$query);
                            $codigoNuevoProducto="SELECT DISTINCT *FROM sop__materialsc_db WHERE nombre='$nombreManual'";
                            $consulta=mysqli_query($conexion,$codigoNuevoProducto);
                            $fila=mysqli_fetch_array($consulta);
                            $codigo=$fila['id_sc'];
                            if($devolucion==1){
                                echo "<tr class='nuevaEntradaD' style='background-color: rgba(241, 91, 91, 0.3);><td>$codigo</td>";
                                echo "<td style='text-align:left'>$nombreManual <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='$nombreManual'</td>";
                                echo "<td> <input type='number' min=1 max=50 value=$cantidadManual name='cantidad_Material[]'></td>";
                                echo "<td>".$tipo."<input type='hidden' value=".$tipo." name='tipo[]'></td>";
                                echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=1 onchange='isChecked(this);'></td>";
                                echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='1'</td>";
                                echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
                                echo "<div class='mostrarGTIN'><button id='mostrarGTIN' onclick='GTIN(this)'>GTIN</button></div>";
                                echo "</td>";
                                echo "</tr>";    
                            } else{
                                echo "<tr class='nuevaEntrada'><td>$codigo</td>";
                                echo "<td style='text-align:left'>$nombreManual <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='$nombreManual'</td>";
                                echo "<td><input type='number' min=1 max=50 value=$cantidadManual name='cantidad_Material[]'></td>";
                                echo "<td><p></p><input type='hidden' value='' name='tipo[]'></td>";
                                echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=1 onchange='isChecked(this)'></td>";
                                echo "<td><input type='hidden' id='update' value='0'</td>";
                                echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='0'</td>";
                                echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
                                echo "<div class='mostrarGTIN'><button id='mostrarGTIN' onclick='GTIN(this)'>GTIN</button></div>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            
                        }
                        else{
                                $codigo=$_POST['codigo'];
                                if(strpos($codigo,"$")==true){
                                    if (strpos($codigo,'$K$')==true){
                                        $codigo=substr($codigo,0,8);
                                        $sql="SELECT codigo,descripcion FROM material__db WHERE codigo=$codigo";
                                        $tipo='K';
                                    } elseif (strpos($codigo,'$I$')==true) {
                                        $codigo=substr($codigo,0,8);
                                        $sql="SELECT codigo,descripcion FROM material__db WHERE codigo=$codigo";
                                        $tipo='I';
                                    } else{
                                        $codigo=substr($codigo,0,8);
                                        $sql="SELECT codigo,descripcion FROM material__db WHERE codigo=$codigo";
                                        $tipo='';
                                    }
                                    $resultado=mysqli_query($conexion,$sql);
                                    $row=mysqli_fetch_array($resultado);
                                }else{
                                    if(strlen($codigo)!=8){
                                        if(strlen($codigo)>16){
                                            $codigo=substr($codigo,0,16);
                                            $sql="SELECT codigo,descripcion FROM material__db WHERE gtin=$codigo";
                                            $resultado=mysqli_query($conexion,$sql);
                                            $row=mysqli_fetch_array($resultado);
                                            $tipo='';
                                        }else {
                                        $sql="SELECT codigo,descripcion FROM material__db WHERE gtin=$codigo";
                                        $resultado=mysqli_query($conexion,$sql);
                                        $row=mysqli_fetch_array($resultado);
                                        $tipo='';
                                        }
                                    }
                                    else{
                                        $sql="SELECT codigo,descripcion FROM material__db WHERE codigo=$codigo";
                                        $resultado=mysqli_query($conexion,$sql);
                                        $row=mysqli_fetch_array($resultado);
                                        if(isset($row)){
                                            $tipo='';
                                        }else{
                                        $sql="SELECT codigo,descripcion FROM material__db WHERE gtin=$codigo";
                                        $resultado=mysqli_query($conexion,$sql);
                                        $row=mysqli_fetch_array($resultado);
                                        $tipo='';
                                        }
                                        
                                    }
                                }
                                if(isset($row)){
                                    if ($devolucion==1){
                                        echo "<tr class='nuevaEntradaD' style='background-color: rgba(241, 91, 91, 0.3);'><td>". $row['codigo']. "</td>";
                                        echo "<td style='text-align:left'>". $row['descripcion']." <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='". $row['descripcion']."'></td>";
                                        echo "<td> <input type='number' min=1 max=50 value=1 name='cantidad_Material[]'></td>";
                                        echo "<td>".$tipo."<input type='hidden' value=".$tipo." name='tipo[]'></td>";
                                        echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=0 onchange='isChecked(this)'></td>";
                                        echo "<td><input type='hidden' id='update' value='0'</td>";
                                        echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='1'</td>";
                                        echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
                                        echo "<div class='mostrarGTIN'><button id='mostrarGTIN' onclick='GTIN(this)'>GTIN</button></div>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }else{
                                        echo "<tr class='nuevaEntrada'><td>". $row['codigo']."</td>";
                                        echo "<td style='text-align:left'>". $row['descripcion']." <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='". $row['descripcion']."'></td>";
                                        echo "<td> <input type='number' min=1 max=50 value=1 name='cantidad_Material[]'></td>"; 
                                        echo "<td>".$tipo."<input type='hidden' name='tipo[]' value=".$tipo." ></td>";
                                        echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=0 onchange='isChecked(this)'></td>";
                                        echo "<td><input type='hidden' id='update' value='0'</td>";
                                        echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='0'</td>";
                                        echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
                                        echo "<div class='mostrarGTIN'><button id='mostrarGTIN' onclick='GTIN(this)'>GTIN</button></div>";
                                        echo "</td>";
                                        echo "</tr>";   
                                    }
                                }else {
                                    echo '<script language="javascript">';
                                    echo 'alert("No se encontro un item con el codigo introducido. Revise el codigo e intente de nuevo")';
                                    echo '</script>';
                                }
                            }    
                    }
                }    
            }
    ?>
