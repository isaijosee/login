<?php

include("conexion.php");
$con=conectar();

$id=$_POST['id'];
$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];
$role=$_POST['role'];


$sql="UPDATE `mainlogin` SET  username='$username', email='$email', password='$password',role='$role' WHERE id='$id'";
$query=mysqli_query($con,$sql);

    if($query){
        Header("Location: admin_portada.php");
    }
?>