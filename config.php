<?php
define("NOME_TABELA_TEMPORARIA", "revista_temporaria_auditoria"); // se necessário pode ser alterada

$fileRevista = '2439.xml';  // alterar a revista

$host = "localhost";        // alterar o host ex: site.com.br ou algum ip
$usuario = "root";          // alterar o usuário do banco de dados
$senha = "";                // alterar a senha
$banco = "informark";       // alterar o nome do banco de dados

mysql_connect($host,$usuario,$senha);
mysql_select_db($banco);