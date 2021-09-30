
    <?php
        include("../include/bd_usuario.php");
        $codigo=$_POST['codigo'];
        if(strlen($codigo)>8){
            $codigo=substr($codigo,0,8);
        }
        $sql="SELECT codigo,descripcion FROM material__db WHERE codigo=$codigo";
        $resultado=mysqli_query($conexion,$sql);
        $row=mysqli_fetch_array($resultado);
        echo "<tr><td>". $row['codigo']." </td>";
        echo "<td>". $row['descripcion']." </td>";
        echo "<td> <input type='number' min=1 max=50 value=1></td></tr>"
    ?>
