# Revista -> Objetivo -> Inserir na tabela todos processos encontrado no arquivo pdf

1 - Entrar no site http://revistas.inpi.gov.br/rpi

2 - Realizar o download da revista Ex 2423 em pdf que fica na coluna marcas. 

Link para download: http://revistas.inpi.gov.br/pdf/Marcas2423.pdf

3 - Entrar no site: https://conversiontools.io/convert_pdf_to_txt/

4 - Converter o arquivo Ex: Marcas2423.pdf para Marcas2423.pdf.txt (renomear o arquivo para 2423.txt)

5 -  No arquivo inserir_linhas.php na linha 7 modificar o nome do arquivo txt que será lido ex: 2423.txt

6 -  Modificar os dados de conexão no arquivo functions.php
 
7 -  Execute via terminal o comando: php inserir_linhas.php

A tabela ultima_revista_pdf_temp será removida.

A tabela ultima_revista_pdf_temp será criada.

Todas os processos encontrados no arquivo 2423.txt serão inseridas na tabela ultima_revista_pdf_temp.
	
/* VERIFICAR A QUANTIDADE DE PROCESSOS REPETIDOS NA REVISTA  */

SELECT 
	rpi, processo, COUNT(DISTINCT processo) AS qtdProcessos
FROM
	ultima_revista_pdf_temp
GROUP BY processo
HAVING COUNT(processo) > 0
ORDER BY qtdProcessos DESC
;	