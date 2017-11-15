<?php
function createDropTableRevistaTemporaria(){
    mysql_query("DROP TABLE ".NOME_TABELA_TEMPORARIA); //excluir a tabela

    // criar a tabela
    $sql = "CREATE TABLE ".NOME_TABELA_TEMPORARIA." (
  `id` INT NOT NULL AUTO_INCREMENT,
  `processo` INT NOT NULL,
  `revista` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = MyISAM;
";
    mysql_query($sql);
}

/**
 * @param $values
 */
function gerarInsert($values){ /* modelo de insert */
    if($values){
        $sql = "INSERT INTO ".NOME_TABELA_TEMPORARIA." (processo,revista) VALUES ";
        $sqlInsert = $sql.join(',', $values);
        //echo $sqlInsert.";";
        //echo "\n\n";
        mysql_query($sqlInsert);
    }
}

/**
 * @param $paginaRevista
 * @param $pagina
 * @param $nomeRevista
 */
function lerConteudoPagina($conteudoPaginaRevista, $pagina, $nomeRevista){  /* ler o conteúdo de cada página e returnar a quantidade de processos */
    $qtdPaginas = 0;

    foreach($conteudoPaginaRevista->par as $linhasPagina){

        foreach($linhasPagina->table as $table){                            // 3  - lendo as linhas da table
            $getInsertValues = getInsertValues($table, $nomeRevista);       // 4    - captura os processos que serão inseridos
            gerarInsert($getInsertValues);                                 // 5    - insere os processos

        }
        $qtdPaginas++;
    }

    return ($qtdPaginas);                                        // 6 - retornar a quantidade de processos na pagina.

}

/**
 * @param $table
 * @param $nomeRevista
 */
function getInsertValues($table, $nomeRevista) { /* retorna o array dos processo que serão inseridos */
    $arrayProcessos = getProcessos($table); // captura os processos encontrados
    if(count($arrayProcessos)>0) {
        $values = [];
        foreach($arrayProcessos as $processo){
            $values[] = "('$processo','$nomeRevista')"; // adiciona os processos em um array
        }
        return $values; // retorna o array com os processos encontrados que serão inseridos.
    }
}

/**
 * @param $table
 * @return TYPE_NAME
 */
function getProcessos($table){
    /** @var TYPE_NAME $arrayProcessos */
    $arrayProcessos = [];
    foreach($table->column->row as $campo){                         // lendo os campos
        $validatorProcesso = validatorProcesso($campo);             // verifica se esse campo é um processo
        if($validatorProcesso!=false){
            $arrayProcessos[] = $validatorProcesso;                 // adiciona os processos no array.
        }
    }
    return $arrayProcessos;
}

/**
 * @param $campo
 * @return bool|string
 */
function validatorProcesso($campo){ /* verifica se o campo é realmente um processo */
    $campoClear         = trim($campo);                         // limpando os espaços
    $qtdCaracteres      = strlen($campoClear);                  // quantidade de caracteres
    if($qtdCaracteres==9) {                                     // verificando se tem 9 digitos
        if( is_numeric($campoClear)){                           // verificando se é numero
            return $campoClear;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

/**
 * @param $nomeRevista
 * @param $momento
 * @param null $msgCorpoEmail
 */
function enviarEmail($nomeRevista, $momento, $msgCorpoEmail = null){ /* modelo de email que será enviado */
    echo "Título do Email: $momento da verificação na revista $nomeRevista";
    echo "\n";
    //if($msgCorpoEmail) echo "Corpo do Email: ".$msgCorpoEmail; echo "\n";

}
function getMsgCorpoEmail($qtdTotalProcessos,$nomeRevista) {
    return "$qtdTotalProcessos processos encontrados na revista ".$nomeRevista;
}