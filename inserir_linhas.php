<?php include('functions.php');
$mysqli = connection();
create_table($mysqli);
echo "\n";
echo 'Data e hora inicio - '.date('d/m/Y H:i:s');
echo "\n\n";
$arquivo = fopen ('arquivos/Marcas2423.pdf.txt', 'r');
while(!feof($arquivo)){
    $conteudo_linha = fgets($arquivo, 1024);
	$arrayLineSpaces = arrayLineSpace($conteudo_linha);
    $arrayProcessos = getProcessos($arrayLineSpaces);
    if($arrayProcessos){
        insert($arrayProcessos,$mysqli);
    }
}
echo 'Data e hora fim - '.date('d/m/Y H:i:s');
$mysqli->close();
?>