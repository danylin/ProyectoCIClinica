
    <?php
        include("../include/bd_usuario.php");
        if(isset($_POST['nombre'])){
            $nombreManual=$_POST['nombre'];
            $cantidadManual=$_POST['cantidad'];
            echo "<tr><td> S/N <input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='00000000'></td>";
            echo "<td>$nombreManual <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='$nombreManual'</td>";
            echo "<td> <input type='number' min=1 max=50 value=$cantidadManual name='cantidad_Material[]'></td></tr>";
        }
        else{
            $codigo=$_POST['codigo'];
            if(strlen($codigo)>8){
                $codigo=substr($codigo,0,8);
            }
            $sql="SELECT codigo,descripcion FROM material__db WHERE codigo=$codigo";
            $resultado=mysqli_query($conexion,$sql);
            $row=mysqli_fetch_array($resultado);
            echo "<tr><td>". $row['codigo']. "<input type='hidden' name='hidden_codigo[]' id='codigo' class='codigo' value='". $row['codigo']."'></td>";
            echo "<td>". $row['descripcion']." <input type='hidden' name='hidden_nombre[]' id='nombre' class='nombre' value='". $row['descripcion']."'></td>";
            echo "<td> <input type='number' min=1 max=50 value=1 name='cantidad_Material[]'></td></tr>";
        }
    ?>
