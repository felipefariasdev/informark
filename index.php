<?php ini_set('memory_limit', '-1');

include('config.php');
include('funcoes.php');

$nomeRevista = str_replace(".xml","",$fileRevista);

enviarEmail($nomeRevista,'INICIO');                                                             // 1 - Rnvia um email dizendo a o processo foi iniciado.

createDropTableRevistaTemporaria();                                                             // 2 - Remove e cria a tabela novamente.

$conteudoRevista = new SimpleXMLElement($fileRevista, NULL, TRUE);                              // 3 - Realiza a leitura do conteudo da revista
$pagina = 1;
$qtdTotalProcessos = 0;
foreach($conteudoRevista as $conteudoPaginaRevista){
    $qtdTotalProcessos = lerConteudoPagina($conteudoPaginaRevista,$pagina,$nomeRevista);    // 4 - Leitura dos processos por pagina e insert na tabela


    if(isset($qtdProcessosPorPagina)) $qtdTotalProcessos += $qtdProcessosPorPagina;
    $pagina++;
}

enviarEmail($nomeRevista,'FIM',getMsgCorpoEmail($qtdTotalProcessos,$nomeRevista));              // 5 - Envio de email com o final
?>