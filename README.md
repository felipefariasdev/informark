# Revista

1 - no arquivo config.php você modifica os dados de conexão com o banco de dados e o nome da tabela temporaria que seja criada, atualmente essa tabela se chama revista_temporaria_auditoria, mas isso pode ser modificado.

2 - http://localhost/revista/inserir_revista_na_tabela.php?nome_revista=2439
    - Esse link vai excluir a tabela caso ela exista e criar uma nova.
    - Em seguida será inserido todos os o numero da revista, e o numero do processo na tabela que foi criada.

3 - Para conferir os dados execute as seguintes querys:
    
    /* VERIFICAR A QUANTIDADE TOTAL DE PROCESSOS NA REVISTA  */
    SELECT count(*) FROM informark.revista_temporaria_auditoria;
    
    /* VERIFICAR A QUANTIDADE DE PROCESSOS REPERIDOS NA REVISTA  */
    SELECT 
        revista, processo, COUNT(processo) AS qtdProcessos
    FROM
        revista_temporaria_auditoria
    GROUP BY processo
    HAVING COUNT(processo) >= 0
    ORDER BY qtdProcessos DESC
    ;
    

