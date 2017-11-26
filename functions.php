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
	$mysqli->query("DROP TABLE `rev_temp`");
    $mysqli->query("CREATE TABLE `rev_temp` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `conteudo_linha` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))");
    if ($mysqli->error) {
		try {    
			throw new Exception("MySQL error $mysqli->error <br> Query:<br> $sql", $msqli->errno);    
		} catch(Exception $e ) {
			echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
			echo nl2br($e->getTraceAsString());
		}
	}
}
function insert($conteudo_linha,$mysqli){
	$sql = "INSERT INTO rev_temp (conteudo_linha) VALUES ('".$conteudo_linha."')";
    $mysqli->query($sql);
    if ($mysqli->error) {
		try {    
			throw new Exception("MySQL error $mysqli->error <br> Query:<br> $sql", $msqli->errno);    
		} catch(Exception $e ) {
			echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
			echo nl2br($e->getTraceAsString());
		}
	}
	echo $sql;
	echo "\n";
}
?>