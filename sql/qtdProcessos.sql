/* VERIFICAR A QUANTIDADE DE PROCESSOS REPETIDOS NA REVISTA  */
SELECT 
	processo, COUNT(DISTINCT processo) AS qtdProcessos
FROM
	rev_temp
GROUP BY processo
HAVING COUNT(processo) >= 0
ORDER BY qtdProcessos asc
;