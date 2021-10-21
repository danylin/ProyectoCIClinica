
    <?php
        include("../include/bd_usuario.php");
        error_reporting(0);
        $devolucion=$_POST['devolucion'];
        if(isset($_POST['nombre'])){
            $nombreManual=$_POST['nombre'];
            $cantidadManual=$_POST['cantidad'];
            if($devolucion==1){
                echo "<tr style='background-color: rgba(241, 91, 91, 0.3);><td> S/N <input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='00000000'></td>";
                echo "<td>$nombreManual <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='$nombreManual'</td>";
                echo "<td> <input type='number' min=1 max=50 value=$cantidadManual name='cantidad_Material[]'></td>";
                echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=1 onchange='isChecked(this);'></td>";
                echo "</tr>";    
            } else{
                echo "<tr '><td> S/N <input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='00000000'></td>";
                echo "<td>$nombreManual <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='$nombreManual'</td>";
                echo "<td> <input type='number' min=1 max=50 value=$cantidadManual name='cantidad_Material[]'></td>";
                echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=1 onchange='isChecked(this)'></td>";
                echo "</tr>";
            }
            
        }
        else{
            $codigo=$_POST['codigo'];
            if(strpos($codigo,"$")==true){
                $codigo=substr($codigo,0,8);
                $sql="SELECT codigo,descripcion FROM material__db WHERE codigo=$codigo";
            }else{
                $sql="SELECT codigo,descripcion FROM material__db WHERE gtin=$codigo";
            }
            $resultado=mysqli_query($conexion,$sql);
            $row=mysqli_fetch_array($resultado);
            if ($devolucion==1){
                echo "<tr style='background-color: rgba(241, 91, 91, 0.3);'><td>". $row['codigo']. "<input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='". $row['codigo']."'></td>";
                echo "<td>". $row['descripcion']." <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='". $row['descripcion']."'></td>";
                echo "<td> <input type='number' min=1 max=50 value=1 name='cantidad_Material[]'></td>";
                echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=1 onchange='isChecked(this)'></td>";
                echo "</tr>";
            }else{
                echo "<tr ><td>". $row['codigo']. "<input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='". $row['codigo']."'></td>";
                echo "<td>". $row['descripcion']." <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='". $row['descripcion']."'></td>";
                echo "<td> <input type='number' min=1 max=50 value=1 name='cantidad_Material[]'></td>"; 
                echo "<td><input type='checkbox' id='chkEliminar' name='chk1' value=1 onchange='isChecked(this)'></td>";
                echo "</tr>";   
            }
        }
    ?>
