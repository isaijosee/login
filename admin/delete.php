<?php

include("conexion.php");
$con=conectar();

$id=$_GET['id'];

$sql="DELETE FROM mainlogin  WHERE id='$id'";
$query=mysqli_query($con,$sql);

    if($query){
        Header("Location: admin_portada.php");
    }
?>