<?php

$guarda = explode('.',"texto.png");

$newvar = strtolower(end($guarda));

echo $newvar;

/*
for ( $i=0 ; $i < count($guarda) ; $i++ ){
	echo "Posicao: " . $i . " | Valor: " . $guarda[$i] . "\n"; 
}
*/

#$extensao = strtolower(end(explode('.', $argv[1])));

?>
