<?php
include("conexion.php");
$con=conectar();

$id=$_POST['id'];
$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];
$role=$_POST['role'];


$sql="INSERT INTO `mainlogin`(`id`, `username`, `email`, `password`, `role`) VALUES('$id','$username','$email','$password','$role')";
$query= mysqli_query($con,$sql);

if($query){
    Header("Location: admin/admin_portada.php");
    
}else {
}
?>