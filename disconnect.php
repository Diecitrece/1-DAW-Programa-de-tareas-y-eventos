<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Disconnecting</title>
</head>
<body>
	<?php 
	session_start();
	session_destroy();
	?>
	<script language="javascript">
	window.location.replace("login.php");
	</script>
</body
</html>