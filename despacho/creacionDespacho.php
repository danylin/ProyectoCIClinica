
    <?php
        include("../include/bd_usuario.php");
        error_reporting(0);
        $devolucion=$_POST['devolucion'];
        $tipoEvento=$_POST['tipoEvento'];
        if($tipoEvento=='Todos'){
            echo '<script language="javascript">';
            echo 'alert("Elija un subtipo antes de ingresar el codigo")';
            echo '</script>';
        }else {
            if(isset($_POST['nombre'])){
                $nombreManual=$_POST['nombre'];
                $cantidadManual=$_POST['cantidad'];
                $tipo='';
                $nuevoProducto="INSERT INTO sop__materialsc_db(nombre) values('$nombreManual')";
                $consulta=mysqli_query($conexion,$nuevoProducto);
                $codigoNuevoProducto="SELECT DISTINCT *FROM sop__materialsc_db WHERE nombre='$nombreManual'";
                $consulta=mysqli_query($conexion,$codigoNuevoProducto);
                $fila=mysqli_fetch_array($consulta);
                $codigo=$fila['id'];
                if($devolucion==1){
                    echo "<tr style='background-color: rgba(241, 91, 91, 0.3);><td> $codigo <input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='00000000'></td>";
                    echo "<td style='text-align:left'>$nombreManual <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='$nombreManual'</td>";
                    echo "<td> <input type='number' min=1 max=50 value=$cantidadManual name='cantidad_Material[]'></td>";
                    echo "<td>".$tipo."<input type='hidden' value=".$tipo." name='tipo[]'></td>";
                    echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=1 onchange='isChecked(this);'></td>";
                    echo "<td><input type='hidden' id='devolucionItem' value='1'</td>";
                    echo "</tr>";    
                } else{
                    echo "<tr><td> $codigo <input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='00000000'></td>";
                    echo "<td style='text-align:left'>$nombreManual <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='$nombreManual'</td>";
                    echo "<td><input type='number' min=1 max=50 value=$cantidadManual name='cantidad_Material[]'></td>";
                    echo "<td><p></p><input type='hidden' value='' name='tipo[]'></td>";
                    echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=1 onchange='isChecked(this)'></td>";
                    echo "<td><input type='hidden' id='update' value='0'</td>";
                    echo "<td><input type='hidden' id='devolucionItem' value='0'</td>";
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
                    }elseif(strlen($codigo)==13){
                        $sql="SELECT codigo,descripcion FROM material__db WHERE gtin=$codigo";
                        $resultado=mysqli_query($conexion,$sql);
                        $row=mysqli_fetch_array($resultado);
                        $tipo=$row['tipo'];
                    }else{
                        $sql="SELECT codigo,descripcion FROM material__db WHERE codigo=$codigo";
                        $resultado=mysqli_query($conexion,$sql);
                        $row=mysqli_fetch_array($resultado);
                        $tipo=$row['tipo'];
                    }
                    if(isset($row)){
                        if ($devolucion==1){
                            echo "<tr style='background-color: rgba(241, 91, 91, 0.3);'><td>". $row['codigo']. "<input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='". $row['codigo']."'></td>";
                            echo "<td style='text-align:left'>". $row['descripcion']." <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='". $row['descripcion']."'></td>";
                            echo "<td> <input type='number' min=1 max=50 value=1 name='cantidad_Material[]'></td>";
                            echo "<td>".$tipo."<input type='hidden' value=".$tipo." name='tipo[]'></td>";
                            echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=0 onchange='isChecked(this)'></td>";
                            echo "<td><input type='hidden' id='update' value='0'</td>";
                            echo "<td><input type='hidden' id='devolucionItem' value='1'</td>";
                            echo "</tr>";
                        }else{
                            echo "<tr><td>". $row['codigo']. "<input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='". $row['codigo']."'></td>";
                            echo "<td style='text-align:left'>". $row['descripcion']." <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='". $row['descripcion']."'></td>";
                            echo "<td> <input type='number' min=1 max=50 value=1 name='cantidad_Material[]'></td>"; 
                            echo "<td>".$tipo."<input type='hidden' name='tipo[]' value=".$tipo." ></td>";
                            echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=0 onchange='isChecked(this)'></td>";
                            echo "<td><input type='hidden' id='update' value='0'</td>";
                            echo "<td><input type='hidden' id='devolucionItem' value='0'</td>";
                            echo "</tr>";   
                        }
                    }else {
                        echo '<script language="javascript">';
                        echo 'alert("No se encontro un item con el codigo introducido. Revise el codigo e intente de nuevo")';
                        echo '</script>';
                    }
                }    
        }
    ?>
