<?php ini_set('memory_limit', '-1');

    $fileRevista = '2439.xml';
    $nomeRevista = str_replace(".xml","",$fileRevista);

    enviarEmail($nomeRevista,'INICIO');

    $paginasRevista = new SimpleXMLElement($fileRevista, NULL, TRUE);
    $qtd_paginas = 1;
    $qtdTotalProcessos = 0;
    foreach($paginasRevista as $paginaRevista){
        $qtd_linhas_na_paginas = 1;
        foreach($paginaRevista->par as $linhasPagina){
            $arrayProcessos = [];
            foreach($linhasPagina->table as $table){
                $qtdProcessosPorPagina = 0;
                foreach($table->column->row as $coluna){
                    $colunaConteudoLimpo = trim($coluna);
                    $qtdCaracteres = strlen($colunaConteudoLimpo);
                    if($qtdCaracteres==9){
                        if( is_numeric($colunaConteudoLimpo)){
                            $arrayProcessos[] = $colunaConteudoLimpo;
                            $qtdProcessosPorPagina++;
                        }

                    }
                }
                if(!empty($qtdProcessosPorPagina)) {
                    $values = [];
                    foreach($arrayProcessos as $processo){
                        $values[] = "('$processo','$nomeRevista','$qtd_paginas')";
                    }
                    gerarInsert($values);
                }

            }
        }
        if(isset($qtdProcessosPorPagina)) $qtdTotalProcessos += $qtdProcessosPorPagina;
        $qtd_paginas++;
    }
    $msgTotais = "$qtdTotalProcessos processos encontrado na revista ".$nomeRevista;

    enviarEmail($nomeRevista,'FIM',$msgTotais);

    function gerarInsert($values){
        $sql = "INSERT INTO revista_verificar_qtd (processo,revista,pagina) VALUES ";
        $sqlInsert = $sql.join(',', $values);
        echo $sqlInsert.";";
        echo "\n\n";
    }
    function enviarEmail($nomeRevista,$momento,$msgTotais=null){
        echo "Titulo do Email: $momento da verificação na revista $nomeRevista";
        echo "\n";
        if($msgTotais) echo "Corpo do Email: ".$msgTotais;
        echo "\n\n";
    }

?>