<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Página de inicio</title>
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
		display: flex;
		justify-content: center;
		align-items: center;
		flex-direction: column;
	}
	#big
	{
		text-align: center;
		width: 30%;
		background-color: pink;
		
	}
	#small
	{
		text-align: center;
		width: 100%;
	}
	form
	{
		

		background-color: #51774E;
		border: 2px solid red;
		text-align: center;
		height: 50%;
	}
	#textbox
	{

		width: auto;
	}
	
	
	
</style>
</head>
<body>
	<!--Esto hace visible la ventana para introducir el correo electrónico-->
		<script language="javascript">
			document.addEventListener('input', function (event) 
			{

			// Nos aseguramos de que solo sirva para este menú
			if (event.target.id !== 'elect') return;

			// Ponemos cosas
			if ((event.target.value)=="Registrarse")
				{
					var small = document.getElementById('small');
						small.style.display = "block";
				}
			if ((event.target.value)=="Entrar")
				{
					var small = document.getElementById('small');
						small.style.display = "none";
				}

			}, false);
		</script>
	
	<h1>¡Bienvenid@ al calendario de eventos de Andrés Ayelo!</h1>
	<div id="total">
		<div id="big">

			<form id="dual" action="check_log.php" method="POST" style="display:block">

			<p>Usuario: <input id=textbox type="text" name="user" value="" placeholder="Usuario(*)" required></p>
			<p>Contraseña: <input id=textbox type="password" name="password" value="" placeholder="Contraseña(*)" required></p>


			<select id="elect">
				<option name="log" value="Entrar" selected>Entrar</option>
				<option name="reg" value="Registrarse">Registrarse</option>
			</select>



			<input type="submit" value="Enviar">
			<div id="small" style=" display:none">
				<p>Para registrarse es necesario un correo electrónico y un número de teléfono<br><input id="cajacorreo" type="email" name="mailbox" value="" placeholder="example@gmail.com" </p>
				<input id="cajatlf" type="tel" name="tlfbox" value="" placeholder="Número de teléfono" </p>
				<p>Nombre: <input id=cajanom type="text" name="name" value="" placeholder="Nombre público"></p>
			</div>
			</form>
		</div>
		
	</div>
	<!--Esto elige a qué documento se envía todo, y con la funcion enviar-->
	<script language="javascript">

		document.addEventListener('input', function (event) 
		{

		// Nos aseguramos de que solo sirva para este menú
		if (event.target.id !== 'elect') return;

		// Ponemos cosas
		if ((event.target.value)=="Registrarse")
			{
				var cajacorreo = document.getElementById('cajacorreo');
					cajacorreo.required = true;
				var cajatlf = document.getElementById('cajatlf');
					cajatlf.required = true;
				var cajatlf = document.getElementById('cajanom');
					cajatlf.required = true;
				
			}
		if ((event.target.value)=="Entrar")
			{
				var cajacorreo = document.getElementById('cajacorreo');
					cajacorreo.required = false;
				var cajatlf = document.getElementById('cajatlf');
					cajatlf.required = false;
				var cajatlf = document.getElementById('cajanom');
					cajatlf.required = false;
			}

		}, false);
		
	function enviar()
		{
		document.forms["dual"].submit();
		
		return true;
			
		}

	</script>
	
</body>
</html>