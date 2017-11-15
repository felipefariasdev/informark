<?php ini_set('memory_limit', '-1');

    $fileRevista = '2439.xml';
    $nomeRevista = str_replace(".xml","",$fileRevista);

    enviarEmail($nomeRevista,'INICIO');

    $conteudoRevista = new SimpleXMLElement($fileRevista, NULL, TRUE);                              //lendo a revista toda
    $pagina = 1;
    $qtdTotalProcessos = 0;
    foreach($conteudoRevista as $conteudoPaginaRevista){
        $qtdProcessosPorPagina = lerConteudoPagina($conteudoPaginaRevista,$pagina,$nomeRevista);    //lendo o conteudo de cada pagina
        if(isset($qtdProcessosPorPagina)) $qtdTotalProcessos += $qtdProcessosPorPagina;
        $pagina++;
    }
    $msgTotais = "$qtdTotalProcessos processos encontrados na revista ".$nomeRevista;

    enviarEmail($nomeRevista,'FIM',$msgTotais);

    function gerarInsert($values){
        $sql = "INSERT INTO revista_verificar_qtd (processo,revista,pagina) VALUES ";
        $sqlInsert = $sql.join(',', $values);
        echo $sqlInsert.";";
        echo "\n\n";
    }
    function enviarEmail($nomeRevista,$momento,$msgTotais=null){
        echo "Título do Email: $momento da verificação na revista $nomeRevista";
        echo "\n";
        if($msgTotais) echo "Corpo do Email: ".$msgTotais;
        echo "\n";
    }

/**
 * @param $paginaRevista
 * @param $pagina
 * @param $nomeRevista
 */
function lerConteudoPagina($conteudoPaginaRevista, $pagina, $nomeRevista){      //lendo o conteudo de cada pagina
        $qtdProcessosPorPagina = 0;
        foreach($conteudoPaginaRevista->par as $linhasPagina){                  //lendo as linhas da tabela
            $arrayProcessos = [];
            foreach($linhasPagina->table as $table){                            //lendo as linhas da tabela
                foreach($table->column->row as $coluna){                        //lendo as colunas de cada linha
                    $colunaConteudoLimpo = trim($coluna);                       // limpando os espaços
                    $qtdCaracteres = strlen($colunaConteudoLimpo);              // quantidade de caracteres
                    if($qtdCaracteres==9){                                      //verificando se tem 9 digitos
                        if( is_numeric($colunaConteudoLimpo)){                  // verificando se é numero
                            $arrayProcessos[] = $colunaConteudoLimpo;           // processos de cada pagina
                            $qtdProcessosPorPagina++;                           // total de processos nesssa pagina
                        }
                    }
                }
                if(!empty($qtdProcessosPorPagina)) {
                    $values = [];
                    foreach($arrayProcessos as $processo){
                        $values[] = "('$processo','$nomeRevista','$pagina')";
                    }
                    gerarInsert($values);
                }
            }
        }
        return $qtdProcessosPorPagina;
    }
?>