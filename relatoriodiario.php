<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pt-br"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MeuConsumo - Relatório Diário</title>
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

<!-- Painel Direito -->
<div id="right-panel" class="right-panel">
  <!-- Cabeçalho -->
  <div class="breadcrumbs barra-superior">
    <div class="col-sm-12">
      <div class="page-header float-left" style="padding-left: 0px">
        <div class="page-title">
          <h1>Relatório Diario</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- Formulário de envio -->
  <div class="content mt-3">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-form-relatorio-dia" style="margin-bottom: 0px">
            <div class="card-body">
              <form class="form-inline" id="formulario" method="post">
                <div class="form-group mx-sm-3 mb-2">
                  <label for="Data" class="sr-only">Data</label>
                  <input type="date" class="form-control campo-data" id="data" name="data" placeholder="">
                </div>
                <button type="submit" class="btn btn-danger mb-2 botao-gerar" id="btn-gerar">Gerar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- Fim do formulário-->

  <!-- Gráfico -->
  <div class="content mt-3">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div id="chartdiv" style="width: 100%; height: 450px"></div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div><!-- Fim do gráfico-->

</div><!-- Fim do painel direito -->

<script src="assets/js/lib/jquery/jquery.min.js"></script>
<script src="assets/js/lib/bootstrap/popper.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/main.js"></script>
<!--  Amchart  -->
<script src="assets/js/lib/chart-amchart/amcharts.js"></script>
<script src="assets/js/lib/chart-amchart/serial.js"></script>
<script src="assets/js/lib/chart-amchart/relatoriodiario.js"></script>
<script src="assets/js/lib/chart-amchart/light.js"></script>

</body>
</html>
