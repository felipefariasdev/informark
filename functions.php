<?php
function connection(){
	$host = "localhost";        // alterar o host ex: site.com.br ou algum ip
	$usuario = "root";          // alterar o usuário do banco de dados
	$senha = "";                // alterar a senha
	$banco = "informark";       // alterar o nome do banco de dados

	$mysqli = new mysqli($host, $usuario, $senha, $banco);
	if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
	return $mysqli;
}
function create_table($mysqli){
    $sql = "DROP TABLE `rev_temp`";
	$mysqli->query($sql);
    if ($mysqli->error) {
        try {
            throw new Exception("MySQL error $mysqli->error <br> Query:<br> $sql", $mysqli->errno);
        } catch(Exception $e ) {
            echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
            echo nl2br($e->getTraceAsString());
        }
    }
	$sql = "CREATE TABLE `rev_temp` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `processo` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))";
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
function insert($arrayProcessos,$mysqli){
    foreach($arrayProcessos as $arrayProcesso){
        $sql = "INSERT INTO rev_temp (processo) VALUES ('".$arrayProcesso."')";
        $mysqli->query($sql);
        if ($mysqli->error) {
            try {
                throw new Exception("MySQL error $mysqli->error <br> Query:<br> $sql", $mysqli->errno);
            } catch(Exception $e ) {
                echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
                echo nl2br($e->getTraceAsString());
            }
        }
        echo $sql;
        echo "\n";
    }

}
function arrayLineSpace($conteudoLine){
    $array_caracteres_spaces = explode(" ",$conteudoLine);
    $array_caracteres_space_line = [];
    foreach($array_caracteres_spaces as $array_caracteres_space){
        $array_caracteres_space_line[] = $array_caracteres_space;
    }
    return $array_caracteres_space_line;
}
function getProcessos($arrayLineSpaces){
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
?>