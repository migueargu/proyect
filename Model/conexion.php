<?php
$mysqli_conexion=new mysqli("localhost", "root", "", "inmoLeads");
if($mysqli_conexion->connect_errno){
    echo "Error de conexion".$mysqli_conexion->connect_errno;
}
else{
    echo "";
}

?>