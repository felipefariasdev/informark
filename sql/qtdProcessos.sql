/* VERIFICAR A QUANTIDADE DE PROCESSOS REPETIDOS NA REVISTA  */
SELECT 
	processo, COUNT(DISTINCT processo) AS qtdProcessos
FROM
	tabela_que_ainda_nao_foi_criada
GROUP BY processo
HAVING COUNT(processo) >= 0
ORDER BY qtdProcessos asc
;