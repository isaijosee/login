<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<title>Crear paciente</title>
		
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<style type="text/css">
	.login-form {
    border-radius: 10px;
    padding: 30px 40px 67px; 
    width: 60%;
    background-size: cover;
    background-position: center; 
    border: 2px solid rgb(0, 0, 0);
    background-color: #; 

		width: 740px;
    margin: 20px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    input[type=text], select {
    width: 50%;
    padding: 10px 20px;
    margin: 10px 0;
    display: inline-block;
    border: 2px solid rgb(0, 0, 0);
    border-radius: 10px;
    box-sizing: border-box; 
  }
  input[type=submit] {
    width: 30%;
    height: 40px;
    background-color: #990000;
    color: white;
    padding: 4px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  } 
  input[type=submit]:hover {
    background-color: #990000;
  }
  [type=button] {
    width: 30%;
    height: 40px;
    background-color: #990000;
    color: white;
    padding: 4px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  } 
  [type=button]:hover {
    background-color: #990000;
  }


  input[type=email], select{
    width: 50%;
    padding: 10px;
    margin: 4px;
    border-radius: 10px; 
    border: none;
    border: 2px solid rgb(0, 0, 0);
    box-sizing: border-box;
  }
  .img_de_fondo{
		background-image: url("img/img-fondo.jpg");
		background-repeat: no-repeat;
		background-size:cover;
    align-items:center;
    

	}



</style>
</head>

<body class="img_de_fondo">
  


<?php

include 'funcion.php';

session_start();

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El paciente ' . escapar($_POST['nombre']) . ' ha sido agregado con éxito'
  ];

  $config = include 'conexion.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $alumno = [
      "nombre"   => $_POST['nombre'],
      "apellido" => $_POST['apellido'],
      "email"    => $_POST['email'],
      "edad"     => $_POST['edad'],
    ];

    $consultaSQL = "INSERT INTO alumnos (nombre, apellido, email, edad)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($alumno)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($alumno);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>


<?php
if (isset($resultado)) {
  ?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<div class="login-form text-white" style="border:solid 2px;">
  <div class="row">
    <div class="col-md-12">
    <center><h2 class="mt-4-">Crear Usuario</h2></center>
      <hr>
      <form method="post" action="crear.php" >
        <div class="form-group">
         <center> <label for="nombre">Nombre: </label></center>
         <center><input type="text" name="nombre" id="nombre" class="form-control"></center> 
        </div>
         <br>
        <div class="form-group">
          <center><label for="apellido">Apellido: </label></center>
          <center><input type="text" name="apellido" id="apellido" class="form-control"></center>
        </div>
        <br>
        <div class="form-group">
        <center><label for="email">Email: </label></center>
        <center><input type="email" name="email" id="email" class="form-control"></center>
        </div>
        <br>
        <div class="form-group">
        <center><label for="edad">Edad: </label></center>
        <center><input type="text" name="edad" id="edad" class="form-control"></center>
        </div>
        <br>
       <center> <div class="form-group">
          <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
         <input type="submit" name="submit" class="btn btn-danger" value="Enviar">
          <a href="personal_portada.php"><button  type="button" class="btn btn-light ">Regresar</button></a>
       </div></center>
      </form>
    </div>
  </div>
</div>
</body>
</html>