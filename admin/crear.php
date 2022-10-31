<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<title>Multiusuarios PHP MySQL: Niveles de Usuarios</title>
		
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

  input[type=password], select{
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

	h2{
		color: white
	}
	

	body{
		background-image: url("../img/carro.jpg");
	}
</style>
</head>
	<body>
<?php

require_once "../DBconect.php";

if(isset($_REQUEST['btn_register'])) //compruebe el nombre del botón "btn_register" y configúrelo
{
	$username	= $_REQUEST['txt_username'];	//input nombre "txt_username"
	$email		= $_REQUEST['txt_email'];	//input nombre "txt_email"
	$password	= $_REQUEST['txt_password'];	//input nombre "txt_password"
	$role		= $_REQUEST['txt_role'];	//seleccion nombre "txt_role"
		
	if(empty($username)){
		$errorMsg[]="Ingrese nombre de usuario";	//Compruebe input nombre de usuario no vacío
	}
	else if(empty($email)){
		$errorMsg[]="Ingrese email";	//Revisar email input no vacio
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errorMsg[]="Ingrese email valido";	//Verificar formato de email
	}
	else if(empty($password)){
		$errorMsg[]="Ingrese password";	//Revisar password vacio o nulo
	}
	else if(strlen($password) < 6){
		$errorMsg[] = "Password minimo 6 caracteres";	//Revisar password 6 caracteres
	}
	else if(empty($role)){
		$errorMsg[]="Seleccione rol";	//Revisar etiqueta select vacio
	}
	else
	{	
		try
		{	
			$select_stmt=$db->prepare("SELECT username, email FROM mainlogin 
										WHERE username=:uname OR email=:uemail"); // consulta sql
			$select_stmt->bindParam(":uname",$username);   
			$select_stmt->bindParam(":uemail",$email);      //parámetros de enlace
			$select_stmt->execute();
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);	
			if($row["username"]==$username){
				$errorMsg[]="Usuario ya existe";	//Verificar usuario existente
			}
			else if($row["email"]==$email){
				$errorMsg[]="Email ya existe";	//Verificar email existente
			}
			
			else if(!isset($errorMsg))
			{
				$insert_stmt=$db->prepare("INSERT INTO mainlogin(username,email,password,role) VALUES(:uname,:uemail,:upassword,:urole)"); //Consulta sql de insertar			
				$insert_stmt->bindParam(":uname",$username);	
				$insert_stmt->bindParam(":uemail",$email);	  		//parámetros de enlace 
				$insert_stmt->bindParam(":upassword",$password);
				$insert_stmt->bindParam(":urole",$role);
				
				if($insert_stmt->execute())
				{
					$registerMsg="Registro exitoso: Esperar página de inicio de sesión"; //Ejecuta consultas 
					header("refresh:-0;index.php"); //Actualizar despues de 2 segundo a la portada
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}

?>
	<div class="wrapper">
	
	<div class="container">
			
		<div class="col-lg-12">
		
		<?php
		if(isset($errorMsg))
		{
			foreach($errorMsg as $error)
			{
			?>
				<div class="alert alert-danger">
					<strong>INCORRECTO ! <?php echo $error; ?></strong>
				</div>
            <?php
			}
		}
		if(isset($registerMsg))
		{
		?>
			<div class="alert alert-success">
				<strong>EXITO ! <?php echo $registerMsg; ?></strong>
			</div>
        <?php
		}
		?> 
		<br><br><br><br>
<div class="login-form">  
<center><h2>Registrar Usuario </h2> 
<form method="post" class="form-horizontal">
    
<div class="form-group">
<label class="col-sm-9 text-left">Usuario</label>
<div class="col-sm-12">
<input type="text" name="txt_username" class="form-control" placeholder="Ingrese usuario" />
</div>
</div>

<div class="form-group">
<label class="col-sm-9 text-left">Email</label>
<div class="col-sm-12">
<input type="text" name="txt_email" class="form-control" placeholder="Ingrese email" />
</div>
</div>
    
<div class="form-group">
<label class="col-sm-9 text-left">Password</label>
<div class="col-sm-12">
<input type="password" name="txt_password" class="form-control" placeholder="Ingrese password" />
</div>
</div>
    <br>
<div class="form-group">
    <label class="col-sm-9 text-left">Seleccione Tipo</label>
    <div class="col-sm-12">
    <select class="form-control" name="txt_role">
        <option value="" selected="selected"> -Seleccione Rol - </option>
        <!--<option value="admin">Admin</option>-->
        <option value="personal">Personal</option>
        <option value="usuarios">Usuarios</option>
    </select>
    </div>
</div>
</center>
<hr>

<div class="form-group">
<div class="col-sm-12">
<center><input type="submit" name="btn_register" class="btn btn-primary btn-block" value="Registro"></center>
<!--<a href="index.php" class="btn btn-danger">Cancel</a>-->
</div>
</div>
<hr>

<center><div class="form-group">
<div class="col-sm-12">
¿Tienes una cuenta? <a href="admin_portada.php"><p class="text-info">volver al inicio</p></a>		
</div>
</div>
    
</form>
</div><!--Cierra div login-->
</center>
		</div>
		
	</div>
			
	</div>
										
	</body>
</html>