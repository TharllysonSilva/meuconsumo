<?php
	session_start();
	//Elimina as sessões utilizando a funcao unset
	//Que elimina os indices de um array
	unset($_SESSION['usuario']);
	unset($_SESSION['email']);

	//echo 'Esperamos você de volta em breve!!!';

	header('Location: index.php');

?>
