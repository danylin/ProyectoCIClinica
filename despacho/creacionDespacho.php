
    <?php
    /*Este apartado registrará un material en la base de datos sop__despacho_db.
    Se tendrá dos casos:
    1ro: El material se encuentra en la base de datos sop__despacho_db mediante el uso de codigo QR, codigo de barras o ingreso manual del digito
    2do: No se encuentra el material por lo que se debera entrar a la busqueda manual, en caso no se encuentre se procedera a registrar el nuevo producto a la base de datos sop__mateerialsc_db*/
        include("../include/bd_usuario.php");
        error_reporting(0);
        $devolucion=$_POST['devolucion'];
        $tipoEvento=$_POST['tipoEvento'];
        $evento=$_POST['evento'];
        $codEvento=$_GET['codEvento'];
            if($_POST['codigo']=="."){
                echo '<script language="javascript">';
                echo 'busquedaManual();';
                echo 'document.getElementById("codigo").focus();';
                echo '</script>'; //Esto es un atajo para aperturar rapidamente la busqueda manual
            }else{
                    if($tipoEvento=="Todos" && $evento!="Procedimiento Medico"){
                        echo '<script language="javascript">';
                        echo 'alert("Elija un subtipo antes de ingresar el codigo")';
                        echo '</script>'; //El sistema no dejara ingresar nuevos productos a menos que se eliga algun tipo de evento diferente a Todos
                    }
                    else {    
                        if(isset($_POST['nombre'])){
                            //Al verificarse que existe algun valor enviado en nombre, el sistema reconocera un nuevo producto el cual sera registrado a la base de datos de sop__despacho_db y sop_materialsc_db
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
                                //El presente apartado ingresa los datos necesarios para la fila que se mostrara en pantalla evidenciando si es una devolucion o no
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
                            //El presente apartado verificara que tipo de codigo fue ingresado y procederá a ser buscado en la base de datos materiales_db
                                $codigo=$_POST['codigo'];
                                if(strpos($codigo,"$")==true){ //El presente caso leera un codigo QR
                                    if (strpos($codigo,'$K$')==true){ //Ciertos codigos presentan las letras K o I por lo que sera necesario diferenciarlas
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
                                    if(strlen($codigo)!=8){ //El presente caso detecara si es un codigo de barras
                                        if(strlen($codigo)>16){//Si el codigo es demasiado extenso se recortara en el 16vo caracter (esto debido a que la base de datos tiene como maximo en el codigo GTIN 16 caracteres)
                                            $codigo=substr($codigo,0,16);
                                            $sql="SELECT codigo,descripcion FROM material__db WHERE gtin=$codigo";
                                            $resultado=mysqli_query($conexion,$sql);
                                            $row=mysqli_fetch_array($resultado);
                                            $tipo='';
                                        }else { //En caso que sea menor se ingresara directamente en la condicional WHERE
                                        $sql="SELECT codigo,descripcion FROM material__db WHERE gtin=$codigo";
                                        $resultado=mysqli_query($conexion,$sql);
                                        $row=mysqli_fetch_array($resultado);
                                        $tipo='';
                                        }
                                    }
                                    else{ //Finalmente este caso es si se ingresa el codigo numero manualmente en la barra de busqueda observando si es un codigo GTIN o ID dentro de la base de datos
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
                                $queryExistencia="SELECT*FROM sop__despacho_db WHERE id_material='".$row['codigo']."' and id_evento_acc=$codEvento and subtipo='$tipoEvento'"; 
                                $consultaSQL=mysqli_query($conexion,$queryExistencia);
                                if(isset($row)){
                                    if ($devolucion==1){
                                        if (mysqli_fetch_array($consultaSQL)===null){
                                            echo '<script language="javascript">';
                                            echo 'alert("No se puede ingresar esta devolucion. Verifique el subtipo y si ha ingresado el material correspondiente (Asegurese de guardar y actualizar la pagina para tener la base de datos actualizada")';
                                            echo '</script>'; //El sistema no dejara ingresar nuevos productos a menos que se eliga algun tipo de evento diferente a Todos
                                        }else{
                                        //De manera similar al apartado de creacion de un nuevo material se registrara la fila con los siguientes datos y se diferenciara si es devolucion no mediante un background-color de tono rojizo
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
                                        }
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
                                    //En caso no se encuentre un material bajo ninguna de las condicionales mencionadas arriba el sistema mostrara la siguiente alerta
                                    echo '<script language="javascript">';
                                    echo 'alert("No se encontro un item con el codigo introducido. Revise el codigo e intente de nuevo")';
                                    echo '</script>';
                                }
                            }    
                    }
                }    
            
    ?>
