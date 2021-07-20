<?php
    
    include 'functions.php';

    //if(isset($_POST["data_inicio"]) && isset($_POST["data_final"])) {

        #Conexão com o banco de dados
        $redis = new Redis();
        $redis->connect('127.0.0.1');

        $data_inicio = $_POST['dataini'];
        $data_final = $_POST['datafim'];

        #Pesquisa todos as chaves de consumo 
        $pesquisa = "sensor01/*";
        $chaves = $redis->keys($pesquisa);

        $retorno = array();
        //$somatorio = 0;

        for($i=0;$i<count($chaves);$i++){
            #Retorna a data na posição '$i'
            $data_retornada = $redis->hGet($chaves[$i], "data");
            $data_retornada = substr($data_retornada, 0, 10);

            #Se a data retorna estiver entre o intervalo pesquisado entra no 'if' e armazenar para retorno
            if ((strtotime($data_retornada)>=strtotime($data_inicio)) AND (strtotime($data_retornada)<=strtotime($data_final))) {

                #Retorna o valor do consumo
                $retorno[$i]['consumo'] = $redis->hGet($chaves[$i], "potencia"); 
                #Converte o valor do consumo para KWH - 120 é o numero de amostras em uma hora utilizado no sistema
                //$retorno[$i]['consumo'] = ($retorno[$i]['consumo']) / (120*1000);
                #Retorna o valor da data
                $retorno[$i]['data'] = $redis->hGet($chaves[$i], "data");
                #Extrai somente o dia e mes  
                $retorno[$i]['data'] = substr($retorno[$i]['data'], 0, 5);

                #Somatorio
                //$somatorio += $retorno[$i]['consumo'];
            } 
        }   

        #Coloca o array de retorno na ordem de acordo com a data
        $retorno = array_sort($retorno, 'data', SORT_ASC);
        //$retorno["somatorio"] = $somatorio;

        #Faz o somatorio dos dias separadamente
        $retorno_json = array();
        $aux = 0;
        $somatorio_diario = array();
        #Faz o somatorio das horas individualmente
        for($a=0; $a<31; $a++){
            
            $somatorio_diario[$a] = 0;

            for($b=0; $b<count($retorno); $b++){
                #Extrai somente o dia da data
                $aux = substr($retorno[$b]['data'], 0, 2);
                if ($aux == $a){
                    $somatorio_diario[$a] += $retorno[$b]['consumo'];
                }
            }
            $retorno_json[$a]["data"] = $retorno[$a]["data"];
            $retorno_json[$a]["consumo"] = $somatorio_diario[$a];   
        }

        echo json_encode($retorno_json);
        
    //}

    
?>
