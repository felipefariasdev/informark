# Revista -> Objetivo -> Inserir na tabela todas as linhas do arquivo txt

1 - Entrar no site http://revistas.inpi.gov.br/rpi

2 - Realizar o download da revista Ex 2423 em pdf que fica na coluna marcas.

3 - Entrar no site: https://conversiontools.io/convert_pdf_to_txt/

4 - Converter o arquivo Ex: Marcas2423.pdf para Marcas2423.pdf.txt

5 -  No arquivo inserir_linhas.php na linha 7 modificar o nome do arquivo txt que será lido ex: Marcas2423.pdf.txt (Depois isso será modificado para que fique um processo automatizado)

6 -  Modificar os dados de conexão no arquivo functions.php
 
7 -  Execute via terminal o comando: php inserir_linhas.php (Depois de validar vamos agendar esse procedimento no cron)
	- A tabela rev_temp será removida.
	- A tabela rev_temp será criada.
	- Todas linhas do arquivo Marcas2423.pdf.txt serão inseridas na tabela rev_temp.
	
	
	