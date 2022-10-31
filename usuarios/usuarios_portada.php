<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<title>Multiusuarios PHP MySQL: Niveles de Usuarios</title>
		
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Teko:wght@300&display=swap" rel="stylesheet">
<script src="../js/jquery-1.12.4-jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<style type="text/css">
	.login-form {
		width: 340px;
    	margin: 20px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }
    body{
      background-color: #EEEEEE;
      font-family: 'Satisfy', 'cursive';
      font-size: 210%;
    }
    h1{
      font-size: 200%;
    }
    table{
      background: #EAEAEA;
    }
    .img_de_fondo{
		background-image: url("img/auto4.jpg");
		background-repeat: no-repeat;
		background-size: cover;

	}
</style>
</head>
<body class="img_de_fondo">

	
	<div class="wrapper">
	
	<div class="container">
			
		<div class="col-lg-12">
		 
			<center>
				<h1>PAGINA DE USUARIO</h1>
  <h3>¡¡Usuarios registrados exitosamente!!</h3>
				
				<h3>
				<?php
				
				session_start();

				if(!isset($_SESSION['usuarios_login']))	
				{
					header("location: ../index.php");
				}

				if(isset($_SESSION['admin_login']))	
				{
					header("location: ../admin/admin_portada.php");
				}

				if(isset($_SESSION['personal_login']))	
				{
					header("location: ../personal/personal_portada.php");
				}

				if(isset($_SESSION['user_login']))
				{
				?>
					Bienvenidos,
				<?php
						echo $_SESSION['usuarios_login'];
				}
				?>
				</h3>
			</center>
			<a href="../cerrar_sesion.php"><button class="btn btn-danger text-left"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cerrar Sesion</button></a>
            <hr>
		</div>
		

<?php
include 'funcion.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include 'conexion.php';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  if (isset($_POST['apellido'])) {
    $consultaSQL = "SELECT * FROM alumnos WHERE apellido LIKE '%" . $_POST['apellido'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM alumnos";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $alumnos = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['apellido']) ? 'Lista de alumnos (' . $_POST['apellido'] . ')' : 'Lista de alumnos';
?>


<?php
if ($error) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="apellido" name="apellido" placeholder="Buscar por apellido" class="form-control">
        </div>
        <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
        <button type="submit" name="submit" class="btn btn-danger">Ver resultados</button>
      </form>
    </div>
  </div>
</div>

<div class="container">
<thead class="thead-dark">
    <div class="col-md-12">
      <center><h2 class="mt-3">LISTA DE USUARIO</h2></center>
      <table class="table">
        <thead>
        <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
      <th scope="col">Email</th>
      <th scope="col">Edad</th>
        </thead>
        <tbody>
          <?php
          if ($alumnos && $sentencia->rowCount() > 0) {
            foreach ($alumnos as $fila) {
              ?>
              <tr>
                <td><?php echo escapar($fila["id"]); ?></td>
                <td><?php echo escapar($fila["nombre"]); ?></td>
                <td><?php echo escapar($fila["apellido"]); ?></td>
                <td><?php echo escapar($fila["email"]); ?></td>
                <td><?php echo escapar($fila["edad"]); ?></td>
                
              </tr>
              <?php
            }
          }
		 
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>
	

		
	

	</body>
</html>