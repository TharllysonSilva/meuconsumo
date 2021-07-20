<?php
include 'functions.php';

#Conexão com o banco de dados
$redis = new Redis();
$redis->connect('127.0.0.1');

#Captura a data enviada pelo formulraio e a divide
$data = $_POST['data'];
$data = explode("-", $data);
$ano = $data[0];
$mes = $data[1];
$dia = $data[2];

#Pesquisa os dados de consumo do dia solicitado
//$pesquisa = "sensor01/".'18'."-".'05'."-".'2018'."*";
$pesquisa = "sensor01/".$dia."-".$mes."-".$ano."*";
$chaves = $redis->keys($pesquisa);
$retorno = array();
$somatorio = 0;

for($i=0;$i<count($chaves);$i++){
    $retorno[$i]['potencia'] = $redis->hGet($chaves[$i], "potencia");
    #Converte o valor do consumo para KWH - 240 é o numero de amostras em uma hora utilizado no sistema
    $retorno[$i]['potencia'] = ($retorno[$i]['potencia']) / (240*1000);
    $retorno[$i]['data'] = $redis->hGet($chaves[$i], "data");
		#Extrai somente a hora
    $retorno[$i]['data'] = substr($retorno[$i]['data'], 11, 2);
    $retorno[$i]['id'] = $redis->hGet($chaves[$i], "id");
    #Somatorio
    //$somatorio += $retorno[$i]['potencia'];
}

#Ordena o array de acordo com a data
$retorno = array_sort($retorno, 'data', SORT_ASC);

#Array para armazenar as horas do dia
$horas = ['0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'];
#Array para armazenar o retorno da requisição em JSON
$retorno_json = array();
#Array para armazenar o somatório de cada hora
$somatorio_horas = array();
#Faz o somatorio das horas individualmente
for($a=0; $a<24; $a++){
	$somatorio_horas[$a] = 0;
	for($b=0; $b<count($retorno); $b++){
		if ($retorno[$b]['data'] == $horas[$a]){
			$somatorio_horas[$a] += $retorno[$b]['potencia'];
		}
	}
  $retorno_json[$a]["horario"] = $a;
  $retorno_json[$a]["potencia"] = $somatorio_horas[$a];
}
//$somatorio_horas['somatorio'] = $somatorio;
//$retorno_json["somatorio"] = $somatorio;

echo json_encode($retorno_json);
//echo json_encode($retorno);

?>
