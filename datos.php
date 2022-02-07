<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>
<body>
	<?php 
			$server = "localhost";
			$database = "app_calendar";
			$user = "root";
			$password = "";

			//Conectar a la BBDD
			if(!($mysqli = new mysqli($server, $user, $password, $database)))
			   {
				die("Error: No se pudo conectar");
			   }

			//Comprobar la conexión
			if(mysqli_connect_errno())
			{
				printf("Falló la conexión %s\n". mysqli_connect_error());
				exit();
			}


			$mysqli->set_charset("utf8");

			//Aquí comienza el programa
	?>
</body>
</html>