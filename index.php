<?php
ini_set('memory_limit', '-1');
//mysql_connect("localhost","root","");
//mysql_select_db("informark");

    //$oXml = new SimpleXMLElement("2439.xml"); //carrega o arquivo XML e retornando um Array
    //$sJson      = json_encode( $oXml );
	//$aContent   = json_decode( $sJson, TRUE );

	
	$sxe = new SimpleXMLElement('2439.xml', NULL, TRUE);
	
	$i=1;
	$qtd_paginas_ok = 1;
    foreach($sxe as $item){ 
		
		if($i>=1){
			
			foreach($item->par as $par){
				
				foreach($par->table as $vtable){
					
					foreach($par->table->column->row as $row){
						echo $row;
					}
					
				}
				
				
				$qtd_paginas_ok++;
				
			}
		
		
			
			if($i==50) exit;
			
			
				
			
				
		}
			
		$i++;

	
    } //fim do foreach
?>