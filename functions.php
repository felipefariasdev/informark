<?php
/**
 * @return mysqli
 */
function connection(){
	$host = "localhost";        // alterar o host ex: site.com.br ou algum ip
	$usuario = "root";          // alterar o usuário do banco de dados
	$senha = "";                // alterar a senha
	$banco = "informark";       // alterar o nome do banco de dados

	$mysqli = new mysqli($host, $usuario, $senha, $banco);
	if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
	return $mysqli;
}

/**
 * @param $mysqli
 */
function create_table($mysqli){
    $sql = "DROP TABLE `ultima_revista_pdf_temp`";
	$mysqli->query($sql);
    if ($mysqli->error) {
        try {
            throw new Exception("MySQL error $mysqli->error <br> Query:<br> $sql", $mysqli->errno);
        } catch(Exception $e ) {
            echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
            echo nl2br($e->getTraceAsString());
        }
    }
	$sql = "CREATE TABLE `ultima_revista_pdf_temp` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `processo` INT(9) NOT NULL,
  `rpi` INT(4) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = MyISAM;";
	$mysqli->query($sql);
    if ($mysqli->error) {
		try {    
			throw new Exception("MySQL error $mysqli->error <br> Query:<br> $sql", $mysqli->errno);
		} catch(Exception $e ) {
			echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
			echo nl2br($e->getTraceAsString());
		}
	}
}
function multiexplode ($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

/**
 * @param $conteudoLine
 * @return array
 */
function arrayLineSpace($conteudoLine){ // separa o conteudo de cada linha por espaço
    $array_caracteres_spaces = multiexplode(array(" ","-"),$conteudoLine);
    $array_caracteres_space_line = [];
    foreach($array_caracteres_spaces as $array_caracteres_space){
        $array_caracteres_space_line[] = $array_caracteres_space;
    }
    return $array_caracteres_space_line;
}

function getProcessos($arrayLineSpaces){ // armazena no array o conjunto de caracteres que foi identificado como um processo
    /** @var TYPE_NAME $arrayProcessos */
    $arrayProcessos = [];
    foreach($arrayLineSpaces as $arrayLineSpace){                         // lendo os campos separado por espacos
        $validatorProcesso = validatorProcesso($arrayLineSpace);             // verifica se esse campo é um processo
        if($validatorProcesso!=false){
            $arrayProcessos[] = $validatorProcesso;                 // adiciona os processos no array.
        }
    }
    return $arrayProcessos;
}
function validatorProcesso($campo){ // verifica se aquele conjunto de caracteres é um processo
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
 * @param $arrayProcessos
 * @param $mysqli
 */
function insert($arrayProcessos,$rpi,$mysqli){ // insert os processos
    foreach($arrayProcessos as $processo){
        $sql = "INSERT INTO ultima_revista_pdf_temp (processo,rpi) VALUES (".$processo.",".$rpi.")";
        $mysqli->query($sql);
        if ($mysqli->error) {
            try {
                throw new Exception("MySQL error $mysqli->error <br> Query:<br> $sql", $mysqli->errno);
            } catch(Exception $e ) {
                echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
                echo nl2br($e->getTraceAsString());
            }
        }
        //echo $sql;
        //echo "\n";
    }
}
?>