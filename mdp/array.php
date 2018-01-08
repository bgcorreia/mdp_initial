<?php

$delm="\t";
$colunaClass=1;

$arquivo = fopen("GSE19439_pdata_NEW.tsv", "r");

if ($arquivo) {
  
	while(!feof($arquivo)){ 
	  $linhas[] = explode($delm, fgets($arquivo));
	}

	fclose($arquivo);
	  
	unset($linhas[0]);
	unset($linhas[count($linhas)]);

	foreach($linhas as $elemento){
	  $arrayClass_before[] = $elemento[$colunaClass];
	}

	// Remove duplicates class and organize id values 
	$arrayClass = array_values(array_unique($arrayClass_before));

	// Show class
	foreach ($arrayClass as $item) {
	  echo $item . "\n";
	}
  
}

?>
