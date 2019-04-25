<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php   
         // Aqui adicionamos a pasta que queremos fazer a leitura
		$path = "arquivos/";
		$diretorio = dir($path);
		 
		// Termo de Busca exato
		$termo_busca = "UNIFEI";
		 
		// Informe os formatos dos arquivos que serão analisados
		$formatos = array("php", "txt", "html");
		 
		echo "Termo pesquisado: ".$termo_busca;
		echo "<br><br>";


		 
		// Função recursiva pra percorrer todas as pastas do diretório
		function listarPastas($diretorio, $pasta, &$i, $formatos, $termo_busca){
			$contarquivos = 1;
			$raiz = $pasta; 
		 
			while($arquivo = $diretorio->read()){
				
				if (is_dir($raiz.$arquivo) && $arquivo !== '.' && $arquivo !== '..'){
					$contarquivos++;
					$newdir = $raiz.$arquivo;
					$diretorio2 = dir($newdir);
					
					listarPastas($diretorio2, $raiz.$arquivo.'/', $i, $formatos, $termo_busca);
		 
				}
				else if (is_file($raiz.$arquivo)){
					$i++;
		 
					$ext = pathinfo($raiz.$arquivo, PATHINFO_EXTENSION);
		 
					if (in_array($ext, $formatos)){
						
						$arq = file_get_contents($raiz.$arquivo);
						//$pos = strpos($arq, $termo_busca);
						$array = explode('/', $raiz.$arquivo);
						 
						$qtde = substr_count($arq, $termo_busca);
						if ($qtde){
							echo '<tr>
										<td>'.$i.'</td>
										<td><a href="'.$raiz.$arquivo.'" target="_blank">'.$raiz.$arquivo.'</a></td>
										<td>'.$qtde.'</td>
									</tr>';
						}
				 
					}
		 
				}
		 
			}
			$diretorio->close();
		}
		 
		$i = 0;


		echo '<table style="width:100%;" border="1">
				<tr>
					<th>Nº Arquivo</th>
					<th>Caminho</th>
					<th>Quantidade</th>
				</tr>';
		 
		listarPastas($diretorio, $path, $i, $formatos, $termo_busca);


		//echo '<br><b>'.$i . '</b> arquivos avaliados!';

        ?>
    </body>
</html>
