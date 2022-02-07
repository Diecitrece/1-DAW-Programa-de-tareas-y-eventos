<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
	<style>
		#table_createEvent td
		{
			border-bottom: 1px solid black;
			height: 50px;
			font-size: 19px;
			
		}
		#table_createEvent
		{
			height: 100%;
		}
	</style>
</head>
<body>
	<?php 
	include("datos.php");
	session_start();
	$usuario = $_SESSION["user"];
	$date = date("Y-m-d H:i:s.v");
	?>
	<form action="calendar.php" method="POST">
		<table style="border-collapse: collapse; display: block;" id="table_createEvent">
			<tr><td>Nombre del evento: <input type="text" name="NombreEvento" required></td></tr>
			<tr>
				<td>Descripción del evento:</td>
				<td>Localización del evento:</td>
				<tr>
					<td><textarea name="DescEvento" required></textarea></td>
					<td><textarea name="LocEvento" placeholder="No se requiere esta información"></textarea></td>
				</tr>
			</tr>
			<tr>
				<td>Fecha de inicio: <input type="text" name="InicioEvento" required placeholder=<?php echo date("Y-m-d");?>></td>
				<td>Hora de inicio: <input type="text" name="HInicioEvento" required placeholder=<?php echo date("H:i");?>></td>
			</tr>
			<tr>
				<td>Fecha de finalización: <input type="text" name="FinEvento" required placeholder=<?php echo date("Y-m-d");?>></td>
				
				<td>Hora de finalización: <input type="text" name="HFinEvento" required placeholder=<?php echo date("H:i");?>></td>
			</tr>
			<tr><td><input type="submit" value="Crear"></td></tr>
			
		</table>
	</form>
	
</body>
</html>