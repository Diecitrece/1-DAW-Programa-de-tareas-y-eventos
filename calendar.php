<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Calendario</title>
	<style>
	</style>
</head>
<body>
	<link href="EstilosCalendar.css" rel="stylesheet">
	<link href="EstilosCalendar2.css" rel="stylesheet">
	<script type="text/javascript" src="jquery.js"></script>
	<script language="javascript">
		document.addEventListener('input', function (event) 
		{

		// Nos aseguramos de que solo sirva para este menú
		if (event.target.id !== "Range") return;

		// Ponemos cosas
		if ((event.target.value)=="Este día")
			{
				document.getElementById('filtro_desplegable').style.display = "none";
				document.getElementById('filtro_desplegable2').required = "false";
			}
		if ((event.target.value)=="Este mes")
			{
				document.getElementById('filtro_desplegable').style.display = "none";
				document.getElementById('filtro_desplegable2').required = "false";
			}
		if ((event.target.value)=="Mes concreto")
			{
				document.getElementById('filtro_desplegable').style.display = "";
				document.getElementById('filtro_desplegable2').required = "true";
			}
		if ((event.target.value)=="Este año")
			{
				document.getElementById('filtro_desplegable').style.display = "none";
				document.getElementById('filtro_desplegable2').required = "false";
			}
		

		}, false);
		
	</script>
	<script language="javascript">
		function displayEvents()
		{
			document.getElementById("eventoCrear").style.display = "none";
			document.getElementById("eventoShow").style.display = "";
		}
		function displayCreateEvent()
		{
			$(document).ready(function() {
                $('#eventoCrear').load("createEvent.php");
            });
			document.getElementById("eventoCrear").style.display = "";
			document.getElementById("eventoShow").style.display = "none";
		}
		
		
		
	</script>
	
	<?php
	//error_reporting(0);
	session_start();
	if (isset($_SESSION['user']) )
	{
		include("datos.php");
		$usuario = $_SESSION['user'];
		$sql = "SELECT usuarios.nombre as a, usuarios.telefono as b, usuarios.email as c FROM usuarios WHERE usuarios.user = '$usuario'";
		$vista = $mysqli -> query($sql);
		$registro = $vista->fetch_object();
		$nomusuario = $registro->a;
		$tlf = $registro->b;
		$email = $registro->c;
		$vista->close();
		
		if (!empty($_POST))
		{
			if (!empty($_POST["NombreEvento"]))
			{
				$CrearNombre = $_POST["NombreEvento"];
				$CrearDesc = $_POST["DescEvento"];
				$CrearLoc = $_POST["LocEvento"];	
				$CrearInicio = ($_POST["InicioEvento"]." ".$_POST["HInicioEvento"].":00.000000");
				$CrearFinal = ($_POST["FinEvento"]." ".$_POST["HFinEvento"].":00.000000");
			
				if ($CrearLoc == "")
				{
					$CrearLoc == "No concretada";
				}

				if ($CrearNombre!=$_SESSION["textAnterior"])
				{
					if ($CrearNombre != "")
					{
						$sql = "INSERT INTO agenda (user, nombre_evento, fecha_inicio, fecha_final, descripcion_evento, localizacion_evento) VALUES ('$usuario', '$CrearNombre', '$CrearInicio', '$CrearFinal', '$CrearDesc', '$CrearLoc')";
						$vista = $mysqli -> query($sql);
						$_SESSION["textAnterior"] = $CrearNombre;
						echo("<script>location.reload()</script>");
					}
				}
			}
		}
			
	}
	
	?>
	<div id="total">
		<div id="barra" style="display: ">
			<div id="barra_1" onClick="displayEvents()">
				<p style="font-weight: bold">HOME</p>
			</div>
			<div id="barra_2" onClick="displayCreateEvent()">
				<p style="font-weight: bold">CREAR EVENTO</p>
			</div>
			<div id="barra_3" onClick="disconnect()">
				<p style="font-weight: bold"><?php echo $nomusuario."<br><span style='color:white;'>Salir</span>";?></p>
			</div>
		</div>
		<div id="cuerpo">
			<div id="menu">
				<div id="filtro">
					<form id="menuform" action="calendar.php" method="POST">
						<table id="filtrotable" style="width: 100%;">
							<tr>
								<td>
								<select style="width: 70%" id="Reference" name="selected_reference">
									<option>Comienza</option>
									<option>Acaba</option>
								</select>
								</td>
								<td><select id="Range" style="width: 70%" name="selected_range">
									<option value="Este día">Este día</option>
									<option value="Este mes">Este mes</option>
									<option value="Mes concreto">Mes concreto</option>
									<option value="Este año">Este año</option>
									
								</select></td>
							</tr>
							<tr id="filtro_desplegable" style="display:none;">
								<td><select id="filtro_desplegable1" style="width: 70%" name="selected_month">
									<option value="Enero">Enero</option>
									<option value="Febrero">Febrero</option>
									<option value="Marzo">Marzo</option>
									<option value="Abril">Abril</option>
									<option value="Mayo">Mayo</option>
									<option value="Junio">Junio</option>
									<option value="Julio">Julio</option>
									<option value="Agosto">Agosto</option>
									<option value="Septiembre">Septiembre</option>
									<option value="Octubre">Octubre</option>
									<option value="Noviembre">Noviembre</option>
									<option value="Diciembre">Diciembre</option>
								</select></td>
								<td><input id="filtro_desplegable2" style="width: 70%" type="text" name="selected_year" placeholder="Año (<?php echo (date("Y"));?>)"></td>
							</tr>
							<tr>
								<td colspan="2"><input type="button" class="applybutton" value="Aplicar" onClick="enviar()"></td>
								
							</tr>
						</table>
					</form>
				</div>
				<div id="eventlist">
					<?php
					if (!empty($_POST))
					{
						if (!empty($_POST["selected_reference"]))
						{
							$selected_month=$_POST["selected_month"];
							$selected_year=$_POST["selected_year"];
							$selected_reference=$_POST["selected_reference"];
							$selected_range=$_POST["selected_range"];
						
							if ($selected_month == "Enero")
								{
									$selected_month = "01";
								}
								else if ($selected_month == "Febrero")
								{
									$selected_month = "02";
								}
								else if ($selected_month == "Marzo")
								{
									$selected_month = "03";
								}
								else if ($selected_month == "Abril")
								{
									$selected_month = "04";
								}
								else if ($selected_month == "Mayo")
								{
									$selected_month = "05";
								}
								else if ($selected_month == "Junio")
								{
									$selected_month = "06";
								}
								else if ($selected_month == "Julio")
								{
									$selected_month = "07";
								}
								else if ($selected_month == "Agosto")
								{
									$selected_month = "08";
								}
								else if ($selected_month == "Septiembre")
								{
									$selected_month = "09";

								}
								else if ($selected_month == "Ocubre")
								{
									$selected_month = "10";
								}
								else if ($selected_month == "Noviembre")
								{
									$selected_month = "11";
								}
								else if ($selected_month == "Diciembre")
								{
									$selected_month = "12";
								}


							$sql = "SELECT usuarios.nombre as username, agenda.fecha_inicio as ini, agenda.fecha_final as fin, agenda.nombre_evento as name, agenda.id_evento as id FROM agenda INNER JOIN usuarios on agenda.user = usuarios.user";
							$vista = $mysqli -> query($sql);
							while ($registro = $vista->fetch_object())
							{
								if ($selected_reference=="Comienza")
								{
									$filtro_time=$registro->ini;
								}
								else if ($selected_reference=="Acaba")
								{
									$filtro_time=$registro->fin;
								}
								$end_time = $registro->fin;
								//Ahora separas el string de $filtro_time para obtener la hora y la fecha
								$split_date = explode("-", $filtro_time);
								$split_time = explode(":", $filtro_time);
								$splited_year = $split_date[0];
								$splited_month = $split_date[1];
								$splited_day = explode(" ",$split_date[2])[0];
								$splited_hours = explode(" ",$split_time[0])[1];
								$splited_minutes = $split_time[1];
								
								$date = date("Y-m-d H:i:s.v");
								
								$split_date_end = explode("-", $end_time);
								$split_time_end = explode(":", $end_time);
								$splited_year_end = $split_date_end[0];
								$splited_month_end = $split_date_end[1];
								$splited_day_end = explode(" ",$split_date_end[2])[0];
								$splited_hours_end = explode(" ",$split_time_end[0])[1];
								$splited_minutes_end = $split_time_end[1];
								if ($selected_range == "Este día")
								{
									if ($splited_day == date("d") && ($splited_month == date("m")) && ($splited_year == date("Y")))
									{
										if ($end_time <= $date)
										{
											echo("<form id='hiddenform_event' action='calendar.php' method='post' >
												<input style='display:none' type='text' name='id_evento' value='$registro->id'>
												
												<input style='display:none' type='text' name='done' value='done'>");
											
											echo ("<button id='eventfin' title='Evento finalizado'><span style='font-weight:bold; text-decoration:underline;'>".$registro->name."</span><br>".explode(" ", $filtro_time)[0]."<br>".explode(":", explode(" ", $filtro_time)[1])[0].":".explode(":", explode(" ", $filtro_time)[1])[1]."</button></form>");
										}
										else
										{
											
											
											echo("<form id='hiddenform_event' action='calendar.php' method='post' >
												<input style='display:none' type='text' name='id_evento' value='$registro->id'>");
											echo ("<button id='menuevent'><span style='font-weight:bold; text-decoration:underline;'>".$registro->name."</span><br>".explode(" ", $filtro_time)[0]."<br>".explode(":", explode(" ", $filtro_time)[1])[0].":".explode(":", explode(" ", $filtro_time)[1])[1]."</button></form>");
										}
										
									}
								}
								else if ($selected_range == "Este mes")
								{
									if ($splited_month == date("m") && ($splited_year == date("Y")))
									{
										if ($end_time <= $date)
										{
											echo("<form id='hiddenform_event' action='calendar.php' method='post' >
												<input style='display:none' type='text' name='id_evento' value='$registro->id'>
												
												<input style='display:none' type='text' name='done' value='done'>");
											
											echo ("<button id='eventfin' title='Evento finalizado'><span style='font-weight:bold; text-decoration:underline;'>".$registro->name."</span><br>".explode(" ", $filtro_time)[0]."<br>".explode(":", explode(" ", $filtro_time)[1])[0].":".explode(":", explode(" ", $filtro_time)[1])[1]."</button></form>");
										}
										else
										{
											
											
											echo("<form id='hiddenform_event' action='calendar.php' method='post' >
												<input style='display:none' type='text' name='id_evento' value='$registro->id'>");
											echo ("<button id='menuevent'><span style='font-weight:bold; text-decoration:underline;'>".$registro->name."</span><br>".explode(" ", $filtro_time)[0]."<br>".explode(":", explode(" ", $filtro_time)[1])[0].":".explode(":", explode(" ", $filtro_time)[1])[1]."</button></form>");
										}
									}
								}
								else if ($selected_range == "Este año")
								{
									if ($splited_year == date("Y"))
									{
										if ($end_time <= $date)
										{
											echo("<form id='hiddenform_event' action='calendar.php' method='post' >
												<input style='display:none' type='text' name='id_evento' value='$registro->id'>
												
												<input style='display:none' type='text' name='done' value='done'>");
											
											echo ("<button id='eventfin' title='Evento finalizado'><span style='font-weight:bold; text-decoration:underline;'>".$registro->name."</span><br>".explode(" ", $filtro_time)[0]."<br>".explode(":", explode(" ", $filtro_time)[1])[0].":".explode(":", explode(" ", $filtro_time)[1])[1]."</button></form>");
										}
										else
										{
											
											
											echo("<form id='hiddenform_event' action='calendar.php' method='post' >
												<input style='display:none' type='text' name='id_evento' value='$registro->id'>");
											echo ("<button id='menuevent'><span style='font-weight:bold; text-decoration:underline;'>".$registro->name."</span><br>".explode(" ", $filtro_time)[0]."<br>".explode(":", explode(" ", $filtro_time)[1])[0].":".explode(":", explode(" ", $filtro_time)[1])[1]."</button></form>");
										}
									}
								}
								else if ($selected_range == "Mes concreto")
								{
									if (($splited_month == $selected_month)&&($splited_year == $selected_year))
									{
										if ($end_time <= $date)
										{
											echo("<form id='hiddenform_event' action='calendar.php' method='post' >
												<input style='display:none' type='text' name='id_evento' value='$registro->id'>
												
												<input style='display:none' type='text' name='done' value='done'>");
											
											echo ("<button id='eventfin' title='Evento finalizado'><span style='font-weight:bold; text-decoration:underline;'>".$registro->name."</span><br>".explode(" ", $filtro_time)[0]."<br>".explode(":", explode(" ", $filtro_time)[1])[0].":".explode(":", explode(" ", $filtro_time)[1])[1]."</button></form>");
										}
										else
										{
											
											
											echo("<form id='hiddenform_event' action='calendar.php' method='post' >
												<input style='display:none' type='text' name='id_evento' value='$registro->id'>");
											echo ("<button id='menuevent'><span style='font-weight:bold; text-decoration:underline;'>".$registro->name."</span><br>".explode(" ", $filtro_time)[0]."<br>".explode(":", explode(" ", $filtro_time)[1])[0].":".explode(":", explode(" ", $filtro_time)[1])[1]."</button></form>");
										}
									}
								}

							}
							$vista->close();
						
						}
						
					}
					
					?>
				</div>
			</div>
			<?php
				if (array_key_exists('id_evento', $_POST))
				{
					echo("<div id='eventoShow' class='eventoShowSi' style='font-size: 21px;'>");
						if (array_key_exists('done', $_POST))
						{
							$done = "<span style='color:darkred; font-weight:bold;'> Evento finalizado</span>";
							if ($_POST["done"]!="done")
								{
									$done = "";
								}
						}
						else
						{
							$done = "";
						}

						$id_event = $_POST["id_evento"];
						$sql = "SELECT usuarios.nombre as username, agenda.nombre_evento as name, agenda.fecha_inicio as ini, agenda.fecha_final as fin, agenda.descripcion_evento as texto, agenda.localizacion_evento as loc FROM agenda INNER JOIN usuarios on usuarios.user = agenda.user WHERE agenda.id_evento = '$id_event'";
						$vista = $mysqli -> query($sql);
						$registro = $vista->fetch_object();
						echo 
						("	
							<div>
							<h2 style='text-decoration:underline;'>".$registro->name."</h2><span style='font-weight:bold;'>Creado por </span>$registro->username
							<p><span style='font-weight:bold;'>Descripción del evento: </span><br>$registro->texto</p>
							<p><span style='font-weight:bold;'>Fecha de inicio: </span>".explode(' ', $registro->ini)[0]." 
							a las ".explode(':', explode(' ', $registro->ini)[1])[0].":".explode(":", explode(' ', $registro->ini)[1])[1]." ".$done."<br></p>
							<p><span style='font-weight:bold;'>Fecha de finalización: </span> ".explode(' ', $registro->fin)[0]." 
							a las ".explode(':', explode(' ', $registro->fin)[1])[0].":".explode(":", explode(' ', $registro->fin)[1])[1]." ".$done."<br></p>
							<p><span style='font-weight:bold;'>Localización: </span>$registro->loc</p>
							</div>
						");
						$vista->close();
						$sql = "SELECT usuarios.nombre as user, COUNT(usuarios.nombre) as number FROM usuarios INNER JOIN participantes on usuarios.user = participantes.user WHERE id_evento = '$id_event'";
						$vista = $mysqli -> query($sql);
						$registro = $vista->fetch_object();
						echo("<div><span style='font-weight:bold;'>Número de participantes: </span>".$registro->number."<br></div>");
						$numparticipantes = $registro->number;		
						$vista->close();
						$sql = "SELECT usuarios.nombre as user, COUNT(usuarios.nombre) as number FROM usuarios INNER JOIN participantes on usuarios.user = participantes.user WHERE id_evento = '$id_event' GROUP BY usuarios.nombre";
						$vista = $mysqli -> query($sql);
						if ($done=="")
						{
							if ($numparticipantes != "0")
							{
								echo("<div id='userdisplayer'>");
								while($registro = $vista->fetch_object())
								{
									echo($registro->user."<br>");
								}
								echo("</div>");
							}
						}
						
						$vista->close();

						//Aquí compruebas si el usuario está o no participando en el evento, y dependiendo de eso se le muestran unas opciones u otras, incluyendo la de poder eliminar el evento si el usuario es el creador del mismo
						echo ("<div id='eventbuttons'>");
						$sql = "SELECT count(participantes.user) as C FROM participantes WHERE participantes.user = '$usuario' AND participantes.id_evento = '$id_event'";
						$vista = $mysqli -> query($sql);
						$registro = $vista->fetch_object();
						if ($done =="")
							{
							if ($registro->C == "0")
								//No se ha unido
							{
								echo
								("
									<form method='POST'>
										<input type='text' style='display:none;' name='id_evento' value='$id_event'>
										<button id='interactive_event' type='submit' name='unirse' >Unirse</button>
									</form>
								");
							}
							else if ($registro->C == "1")
								//Se ha unido
							{
								echo
								("
									<form method='POST'>
										<input type='text' style='display:none;' name='id_evento' value='$id_event'>
											<button type='submit' id='interactive_event' type='submit' name='nounirse' value='nounirse'>Salir del evento</button>
										</form>
								");
							}
						}
						$vista->close();
						//Si el usuario logeado es el creador del evento, que pueda borrarlo
						$sql = "SELECT agenda.user  as a FROM agenda WHERE agenda.id_evento = '$id_event'";
						$vista = $mysqli -> query($sql);
						$registro = $vista -> fetch_object();
						if ($registro->a == $usuario)
						{
							echo
								("
									<form method='POST'>
										<input type='text' style='display:none;' name='id_evento' value='$id_event'>
											<button type='submit' id='interactive_event' type='submit' name='borrarevento' value='borrarevento'>Eliminar evento</button>
										</form>
								");
						}
						$vista->close();
						echo("</div>");
					echo("</div>");
				}
				else
				{
					echo ("<div id='eventoShow' class='eventoShowNo'>
								<h2>EVENTO NO SELECCIONADO</h2>
							</div>");
				}
				if (array_key_exists('id_evento', $_POST))
				{
					$id_event = $_POST["id_evento"];
					if (array_key_exists('unirse', $_POST))
					{
						$sql="INSERT INTO participantes (participantes.id_evento, participantes.user) VALUES ('$id_event', '$usuario')";
						$vista = $mysqli -> query($sql);
						unset($_POST['unirse']);
						echo("<script>window.location.replace('calendar.php');</script>");
					}
					if (array_key_exists('nounirse', $_POST))
					{
						$sql="DELETE FROM participantes WHERE participantes.id_evento = '$id_event' AND participantes.user = '$usuario'";
						$vista = $mysqli -> query($sql);
						unset($_POST['nounirse']);
						echo("<script>window.location.replace('calendar.php');</script>");
					}
					if (array_key_exists('borrarevento', $_POST))
					{
						$sql="DELETE FROM agenda WHERE agenda.id_evento = '$id_event'";
						$vista = $mysqli -> query($sql);
						unset($_POST['borrarevento']);
						echo("<script>window.location.replace('calendar.php');</script>");
					}
				}
				echo('<div id="eventoCrear"></div>');
			echo("</div>");
			?>
			
		</div>
	</div>
	<script language="javascript">
	function disconnect()
		{
			window.location.replace("disconnect.php");
		}
		
	function enviar()
		{
		document.forms["menuform"].submit();
		
		return true;
			
		}
		
	function select_event()
		{
		document.forms["hiddenform_event"].submit();
		
		return false;
			
		}
	</script>
</body>
</html>