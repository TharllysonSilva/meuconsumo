<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pt-br"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Unifacema MeuConsumo - Alterar senha</title>
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
          <h1>Alterar senha</h1>
        </div>
      </div>
    </div>
  </div>

  <!-- Formulario de senhas -->
  <div class="content mt-3">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form action="" method="post" class="">
                <div class="form-group">
                  <label for="senhaatual">Senha atual</label>
                  <input type="password" id="senhaatual" name="senhaatual" placeholder="Senha atual" class="form-control">
                </div>
                <div class="form-group">
                  <label for="novasenha">Nova senha</label>
                  <input type="password" id="novasenha" name="novasenha" placeholder="Nova senha" class="form-control">
                </div>
                <div class="form-group">
                  <label for="confirmarnovasenha">Confirmar nova senha</label>
                  <input type="password" id="confirmarnovasenha" name="confirmarnovasenha" placeholder="Confirmar nova senha" class="form-control">
                </div>
                <div class="form-actions form-group">
                  <button type="submit" class="btn btn-success btn-sm botao" style="width: 100px">Salvar</button>
                  <button type="reset" class="btn btn-danger btn-sm botao" style="width: 100px">Cancelar</button>
                 </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- Fim do painel direito-->

<script src="assets/js/lib/jquery/jquery.min.js"></script>
<script src="assets/js/lib/bootstrap/popper.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/main.js"></script>
<!--  Amchart  -->
<script src="assets/js/lib/chart-amchart/amcharts.js"></script>
<script src="assets/js/lib/chart-amchart/serial.js"></script>
<script src="assets/js/lib/chart-amchart/relatoriomensal.js"></script>
<script src="assets/js/lib/chart-amchart/light.js"></script>

</body>
</html>
