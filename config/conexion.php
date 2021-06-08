<?php
	$mysqli = new mysqli("localhost","root","","tiendamascotas");
	if (mysqli_connect_errno()) {
		echo "No se puede conectar 🚫";
	}
?>