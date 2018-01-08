<?php

// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = 'uploads/';

// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb

// Array com as extensões permitidas
$_UP['extensoes'] = array('tsv');

// Renomeia o arquivo? (Se true, o arquivo será salvo como .tsv e um nome único)
$_UP['renomeia'] = false;

// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['file']['error'] != 0) {
  die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['file']['error']]);
  exit; // Para a execução do script
}

// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
// Faz a verificação da extensão do arquivo
$preextensao = explode('.', $_FILES['file']['name']);
// Se fizer tudo direto o php retorna um erro
// PHP Notice:  Only variables should be passed by reference 
$extensao = strtolower(end($preextensao));
if (array_search($extensao, $_UP['extensoes']) === false) {
  echo "Por favor, envie arquivos com as seguinte(s) extensões: tsv";
  exit;
}

// Faz a verificação do tamanho do arquivo
if ($_UP['tamanho'] < $_FILES['file']['size']) {
  echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
  exit;
}

// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
// Primeiro verifica se deve trocar o nome do arquivo
if ($_UP['renomeia'] == true) {
  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .tsv
  $nome_final = md5(time()).'.tsv';
} else {
  // Mantém o nome original do arquivo
  $nome_final = $_FILES['file']['name'];
}
  
// Depois verifica se é possível mover o arquivo para a pasta escolhida
if (move_uploaded_file($_FILES['file']['tmp_name'], $_UP['pasta'] . $nome_final)) {
  // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
  echo "Upload efetuado com sucesso!";
  echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>' . "\n\n";

  $delm="\t";
  $colunaClass=1;

  $arquivo = fopen($_UP['pasta'] . $nome_final, "r");

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

} else {
  // Não foi possível fazer o upload, provavelmente a pasta está incorreta
  echo "Não foi possível enviar o arquivo, tente novamente";
}
