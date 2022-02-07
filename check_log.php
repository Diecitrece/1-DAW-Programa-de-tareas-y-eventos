<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Log_Info</title>
<style>

	h1
	{
		text-align: center;
		color: darkred;
		margin-top: 5%;
	}
	body
	{
		background-color: #8FF087;
	}
	#total
	{
		text-align: center;
	}
</style>
</head>
<body>
	<h1>INFORME DE ENTRADA</h1>
	<div id="total">
		<?php 
			session_start();
			$usuarioL = $_POST["user"];
			$nombreL = $_POST["name"];
			$contraL = $_POST["password"];
			$correoL = $_POST["mailbox"];
			$tlfL = $_POST["tlfbox"];
			include("datos.php");
			$sql = "select count(*) as x from usuarios where user = '$usuarioL' and password ='$contraL'";
			$vista = $mysqli -> query($sql);
			$existe=0;
			$registro=$vista->fetch_object();
			if ($registro->x==1){
				$existe=1; 
			}

			$vista->close();
			//Ahora hacemos la distincción entre logearse y registrarse
			if ($correoL != "")
			{
				//esto significa que nos estamos registrando
				if ($existe==1)
				{
				echo ("<p>El usuario ".$usuarioL." ya existe, por favor inténtelo de nuevo<br></p>");
				echo ("<a id= envolver href=login.php><button>Volver al log</button></a>");
				}

				if ($existe==0)
				{
					$sql = 'insert into usuarios (user, password, nombre, telefono, email) values ("'.$usuarioL.'", "'.$contraL.'", "'.$nombreL.'", "'.$tlfL.'", "'.$correoL.'")';
					$meter = $mysqli->query($sql);
					echo("<p>El usuario <span style=color:#FF8700;font-weight:bold>".$usuarioL."</span> se ha registrado correctamente</p><br><br>");
					$_SESSION["user"]=$usuarioL;
					header('Refresh: 4; URL="calendar.php"');
					echo("Se le redireccionará al chat en unos instantes...");

				}
			}
			else if ($correoL == "")
			{
				//esto significa que nos estamos logeando
				if ($existe==1)
				{
				echo ("<p>El usuario <span style=color:#FF8700;font-weight:bold>".$usuarioL."</span> se ha logeado correctamente</p>");
				$_SESSION["user"]=$usuarioL;
				header('Refresh: 4; URL="calendar.php"');
				echo("Se le redireccionará al chat en unos instantes...");
				}
				else if ($existe==0)
				{
				echo ("<p>Error. Usuario o contraseña incorrecta<br><p>");
				echo ("<a id=envolver href='login.php'><button>Volver al log</button></a>");
				}
			}
				
				$mysqli->close();
		?>
	</div>
</body>
</html>