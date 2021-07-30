<?php
	//chamando o connect para a porta de acesso do BD
	$redis = new Redis();
	$redis->connect('127.0.0.1');

	#Captura os dados enviados pelo formulário
	$username = (string)($_POST['usuario']);
	$email = (string)($_POST['email']);
	$password = (string)($_POST['senha']);
	//$nivel_acesso =

	#Variaveis para armanezar o retorno de usuario e email
	$usuario_existe = false;
	$email_existe = false;

	#Verifica se já exite o nome de usuario
	if ($redis->hGet("users",$username)) {
		$usuario_existe = true;
	}
	#Verifica se já exite o email do usuario
	if ($redis->hGet("emails",$email)) {
		$email_existe = true;
	}

	#Verifica as variaves de retorno
	if ($usuario_existe || $email_existe) {
		$retorno_get = '';
		if ($usuario_existe) {
			$retorno_get.= "erro_usuario=1&";
		}
		if ($email_existe) {
			$retorno_get.= "erro_email=1&";
		}
		#Se já existe retorna o erro na URL
		header('Location: cadastrar.php?'.$retorno_get);
		die();
	}

	#Tudo ok, registra o usuario agora
	$userid = $redis->incr("next_user_id");
	$redis->hset("users",$username,$userid);
	$redis->hset("emails",$email,$userid);
	$redis->hMSet("user:$userid", array('user' => $username, 'email' => $email,
										'password' => $password));

	echo "alert('Cadastro realizado com sucesso!! Realize o login agora.')";
	header('Location: index.php'.$retorno_get);
?>
