<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="js/jquery-1.12.4-jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
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
		background-image: url("img/img-5.jpg");
		background-repeat: no-repeat;
		background-size: cover;

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

$config = include 'conexion.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El alumno no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $alumno = [
      "id"        => $_GET['id'],
      "nombre"    => $_POST['nombre'],
      "apellido"  => $_POST['apellido'],
      "email"     => $_POST['email'],
      "edad"      => $_POST['edad']
    ];
    
    $consultaSQL = "UPDATE alumnos SET
        nombre = :nombre,
        apellido = :apellido,
        email = :email,
        edad = :edad
        
        WHERE id = :id";
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($alumno);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET['id'];
  $consultaSQL = "SELECT * FROM alumnos WHERE id =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $alumno = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$alumno) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el alumno';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>




<?php
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El paciente ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>


<?php
if (isset($alumno) && $alumno) {
  ?>
  <div class="login-form">
    <div class="row">
      <div class="col-md-12">
       <center><h2 class="mt-4">Editando el paciente <?= escapar($alumno['nombre']) . ' ' . escapar($alumno['apellido'])  ?></h2></center> 
        <hr>
        <form method="post">
        <center> <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= escapar($alumno['nombre']) ?>" class="form-control">
          </div></center>
          <br>
          <center> <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="<?= escapar($alumno['apellido']) ?>" class="form-control">
          </div></center>
          <br>
          <center><div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= escapar($alumno['email']) ?>" class="form-control">
          </div></center>
          <br>
         <center><div class="form-group">
            <label for="edad">Edad</label>
            <input type="text" name="edad" id="edad" value="<?= escapar($alumno['edad']) ?>" class="form-control">
          </div></center>
          <br>
          <center><div class="form-group">
            <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
            <input type="submit" name="submit" class="btn btn-danger" value="Actualizar">
            <a href="personal_portada.php"><button  type="button" class="btn btn-light ">regresar</button></a>
       
          </div></center>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

  </body>
