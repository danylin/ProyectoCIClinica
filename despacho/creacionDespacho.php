
    <?php
        include("../include/bd_usuario.php");
        error_reporting(0);
        $devolucion=$_POST['devolucion'];
        $tipoEvento=$_POST['tipoEvento'];
        if(isset($_POST['nombre'])){
            $nombreManual=$_POST['nombre'];
            $cantidadManual=$_POST['cantidad'];
            $tipo='';
            if($devolucion==1){
                echo "<tr style='background-color: rgba(241, 91, 91, 0.3);><td> S/N <input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='00000000'></td>";
                echo "<td>$nombreManual <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='$nombreManual'</td>";
                echo "<td> <input type='number' min=1 max=50 value=$cantidadManual name='cantidad_Material[]'></td>";
                echo "<td>".$tipo."<input type='hidden' value=".$tipo." name='tipo[]'></td>";
                echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=1 onchange='isChecked(this);'></td>";
                echo "</tr>";    
            } else{
                echo "<tr '><td> S/N <input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='00000000'></td>";
                echo "<td>$nombreManual <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='$nombreManual'</td>";
                echo "<td><input type='number' min=1 max=50 value=$cantidadManual name='cantidad_Material[]'></td>";
                echo "<td><p></p><input type='hidden' value='' name='tipo[]'></td>";
                echo "<td><select name='subtipos[]'>";
                if($tipoEvento=="Cirugia"){
                  echo "<option value='Material de Anestesia'>Material de Anestesia</option>";
                  echo "<option value='Medicación de Anestesia'>Medicación de Anestesia</option>";
                  echo "<option value='Dispensación regular'>Dispensación regular</option>";
                  echo "<option value='Adicionales'>Adicionales</option>";
                } elseif($tipoEvento=="Quimioterapia"){
                  echo "<option value='Hidratación prequimioterapia'>Hidratación prequimioterapia</option>";
                  echo "<option value='Dispensación regular'>Dispensación regular</option>";
                  echo "<option value='Alta postquimioterapia'>Alta postquimioterapia</option>";
                }
                echo "</select></td>";
                echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=1 onchange='isChecked(this)'></td>";
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
                    $sql="SELECT codigo,descripcion,tipo FROM material__db WHERE gtin=$codigo";
                    $resultado=mysqli_query($conexion,$sql);
                    $row=mysqli_fetch_array($resultado);
                    $tipo=$row['tipo'];
                }else{
                    $sql="SELECT codigo,descripcion,tipo FROM material__db WHERE codigo=$codigo";
                    $resultado=mysqli_query($conexion,$sql);
                    $row=mysqli_fetch_array($resultado);
                    $tipo=$row['tipo'];
                }
                if(isset($row)){
                    if ($devolucion==1){
                        echo "<tr style='background-color: rgba(241, 91, 91, 0.3);'><td>". $row['codigo']. "<input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='". $row['codigo']."'></td>";
                        echo "<td>". $row['descripcion']." <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='". $row['descripcion']."'></td>";
                        echo "<td> <input type='number' min=1 max=50 value=1 name='cantidad_Material[]'></td>";
                        echo "<td>".$tipo."<input type='hidden' value=".$tipo." name='tipo[]'></td>";
                        echo "<td><select name='subtipos[]'>";
                        if($tipoEvento=="Cirugia"){
                          echo "<option value='Material de Anestesia'>Material de Anestesia</option>";
                          echo "<option value='Medicación de Anestesia'>Medicación de Anestesia</option>";
                          echo "<option value='Dispensación regular'>Dispensación regular</option>";
                          echo "<option value='Adicionales'>Adicionales</option>";
                        } elseif($tipoEvento=="Quimioterapia"){
                          echo "<option value='Hidratación prequimioterapia'>Hidratación prequimioterapia</option>";
                          echo "<option value='Dispensación regular'>Dispensación regular</option>";
                          echo "<option value='Alta postquimioterapia'>Alta postquimioterapia</option>";
                        }
                        echo "</select></td>";
                        echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=0 onchange='isChecked(this)'></td>";
                        echo "</tr>";
                    }else{
                        echo "<tr><td>". $row['codigo']. "<input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='". $row['codigo']."'></td>";
                        echo "<td>". $row['descripcion']." <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='". $row['descripcion']."'></td>";
                        echo "<td> <input type='number' min=1 max=50 value=1 name='cantidad_Material[]'></td>"; 
                        echo "<td>".$tipo."<input type='hidden' name='tipo[]' value=".$tipo." ></td>";
                        echo "<td><select name='subtipos[]'>";
                        if($tipoEvento=="Cirugia"){
                          echo "<option value='Material de Anestesia'>Material de Anestesia</option>";
                          echo "<option value='Medicación de Anestesia'>Medicación de Anestesia</option>";
                          echo "<option value='Dispensación regular'>Dispensación regular</option>";
                          echo "<option value='Adicionales'>Adicionales</option>";
                        } elseif($tipoEvento=="Quimioterapia"){
                          echo "<option value='Hidratación prequimioterapia'>Hidratación prequimioterapia</option>";
                          echo "<option value='Dispensación regular'>Dispensación regular</option>";
                          echo "<option value='Alta postquimioterapia'>Alta postquimioterapia</option>";
                        }
                        echo "</select></td>";
                        echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=0 onchange='isChecked(this)'></td>";
                        echo "</tr>";   
                    }
                }else {
                    echo '<script language="javascript">';
                    echo 'alert("No se encontro un item con el codigo introducido. Revise el codigo e intente de nuevo")';
                    echo '</script>';
                }
            }
    ?>
