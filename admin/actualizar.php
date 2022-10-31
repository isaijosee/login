<?php 
    include("conexion.php");
    $con=conectar();

$id=$_GET['id'];

$sql="SELECT * FROM mainlogin WHERE id='$id'";
$query=mysqli_query($con,$sql);

$row=mysqli_fetch_array($query);
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
        <title>Actualizar</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        
    </head>
    <body>

    <div class="col-md-3 m-auto">
<div class="card">


    <div class="card-body">
                    <form action="edit.php" method="POST">
                    

                    <div class="form-group p-1">
                    <input type="hidden" name="id" value="<?php echo $row['id']  ?>">
                    </div>

                    <div class="form-group p-1">
                    <input type="text" class="form-control " name="username" placeholder="Username" value="<?php echo $row['username']  ;?>">
                    </div>
                    <div class="form-group p-1">
                    <input type="text" class="form-control " name="email" placeholder="Email" value="<?php echo $row['email'];  ?>">
                    </div>
                    <div class="form-group p-1">
                    <input type="text" class="form-control " name="password" placeholder="Pass" value="<?php echo $row['password'] ;?>">
                    </div>
                    <div class="form-group p-1">
                    <input type="text" class="form-control " name="role" placeholder="Rol" value="<?php echo $row['role'] ; ?>">
                    </div>
                    <div class="form-group p-1">
                    <input type="submit" class="btn btn-primary btn-block" value="Actualizar">
                    </div>
                    </form>
                    </div>
                    </div>
                    </div>
    </body>
</html>
