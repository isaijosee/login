<?php
function conectar(){
    $host="b7lofr9uqlk0z6vh6den-mysql.services.clever-cloud.com";
    $user="u5pnv6f2wskqv3nt";
    $pass="6ks15jig2tHVUrzDv1cm";
    $bd="b7lofr9uqlk0z6vh6den";

    $con=mysqli_connect($host,$user,$pass);

    mysqli_select_db($con,$bd);

    return $con;
}
?>