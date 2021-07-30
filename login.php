<?php

	session_start();
	//chamando o connect para a porta de acesso do BD
	$redis = new Redis();
	$redis->connect('127.0.0.1');

	#Captura os dados enviados pelo formulário
	$username = $_POST['usuario'];
	$password = $_POST['senha'];

	#Retorna o id do usuario, caso exista
	$userid = $redis->hGet("users",$username);

	#Retorna a senha do usuario, caso exista
	$realpassword = $redis->hGet("user:$userid","password");

	#Se o usuario e senha estiverem corretos, inicia a sessão do usuario
	if ($userid && $realpassword==$password){
		//echo "Entrou aqui";
		$_SESSION['id_usuario'] = $userid;
		$_SESSION['usuario'] = $redis->hGet("user:$userid","user");
		$_SESSION['email'] = $dados_usuario['email'];
		#Com o usuario logado, encaminha para pagina 'home'
		header('Location: home.php');
	}else {
		header('Location: index.php?erro=1');
	}

?>
