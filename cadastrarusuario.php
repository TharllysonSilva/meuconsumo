<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pt-br"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Unifacema MeuConsumo - Cadastrar usuário</title>
  <meta name="description" content="MeuConsumo">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="assets/css/normalize.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/themify-icons.css">
  <link rel="stylesheet" href="assets/css/flag-icon.min.css">
  <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
  <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
  <link rel="stylesheet" href="assets/scss/style.css">
  <link rel="stylesheet" href="assets/css/estilo-pessoal.css">

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

  <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body>

<?php
//Inclui a barra lateral através do arquivo php
include 'barra-lateral.php';
 ?>

<!-- Painel direito -->
<div id="right-panel" class="right-panel">
  <!-- Cabeçalho -->
  <div class="breadcrumbs barra-superior">
    <div class="col-sm-12">
      <div class="page-header float-left" style="padding-left: 0px">
        <div class="page-title">
          <h1>Cadastrar Usuário</h1>
        </div>
      </div>
    </div>
  </div>

  <!-- Formulário de cadastro -->
  <div class="content mt-3">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form action="cadastrar.php" name="form" id="form" method="post" class="">
                <div class="form-group">
                  <label for="usuario">Nome de usuário</label>
                  <input type="text" id="usuario" name="usuario" placeholder="joao" class="form-control">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" id="email" name="email" placeholder="joao@teste.com" class="form-control">
                </div>
                <div class="form-group">
                  <label for="senha">Senha</label>
                  <input type="password" id="senha" name="senha" placeholder="12345" class="form-control">
                </div>
                <div class="form-group">
                  <label>Nível de acesso</label>
                  <div class="form-check form-check" name="nivel_acesso">
                    <label for="inline-radio1" class="form-check-label" style="margin-right: 30px">
                      <input type="radio" id="radio-admin" name="inline-radios" value="option1" class="form-check-input">Admin
                    </label>
                    <label for="inline-radio2" class="form-check-label ">
                      <input type="radio" id="inline-radio2" name="inline-radios" value="option2" class="form-check-input">User
                    </label>
                  </div>
                </div>
                <div class="form-actions form-group">
                  <button type="submit" class="btn btn-success btn-sm botao" style="width: 100px">Salvar</button>
                  <button type="reset" class="btn btn-danger btn-sm botao" style="width: 100px">Cancelar</button>
                </div>
              </form>
            </div>
          </div>
        </div><!-- /# column -->
      </div>
    </div><!-- .animated -->
  </div><!-- .content -->
</div><!-- Fim do painel direito -->

  <script src="assets/js/lib/jquery/jquery.min.js"></script>
  <script src="assets/js/lib/bootstrap/popper.min.js"></script>
  <script src="assets/js/plugins.js"></script>
  <script src="assets/js/main.js"></script>
  <!--  Amchart  -->
  <script src="assets/js/lib/chart-amchart/amcharts.js"></script>
  <script src="assets/js/lib/chart-amchart/serial.js"></script>
  <script src="assets/js/lib/chart-amchart/relatoriomensal.js"></script>
  <script src="assets/js/lib/chart-amchart/light.js"></script>

  <script language="javascript" type="text/javascript">

  </script>

</body>
</html>
