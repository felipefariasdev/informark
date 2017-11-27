<?php include('functions.php');
$mysqli = connection();
create_table($mysqli);
echo "\n";
echo 'Data e hora inicio - '.date('d/m/Y H:i:s');
echo "\n\n";
$nome_revista_txt = '2423.txt';
$rpi = str_replace(".txt","",$nome_revista_txt);
$arquivo = fopen ('arquivos/'.$nome_revista_txt, 'r');
while(!feof($arquivo)){
    $conteudo_linha = fgets($arquivo, 1024);
	$arrayLineSpaces = arrayLineSpace($conteudo_linha);
    $arrayProcessos = getProcessos($arrayLineSpaces);
    if($arrayProcessos){
        insert($arrayProcessos,$rpi,$mysqli);
    }
}
echo 'Data e hora fim - '.date('d/m/Y H:i:s');
$mysqli->close();
?>