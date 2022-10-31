<?php
include 'funcion.php';

$config = include 'conexion.php';

$resultado = [
  'error' => false,
  'mensaje' => 'desea borrar el paciente'
];


try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET['id'];
  $consultaSQL = "DELETE FROM alumnos WHERE id =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  header('Location: personal_portada.php');

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "header.php"; ?>


<div class="container mt-2">
  <div class="row">
    <div class="col-md-12">
      <label for="borrar">borrar</label>
      <input type="button" value="">
      <div class="alert alert-danger" role="alert">
        <?= $resultado['mensaje'] ?>
      </div>
    </div>
  </div>
</div>



