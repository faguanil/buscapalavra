<?php

// Função recursiva pra percorrer todas as pastas do diretório
function buscarArquivos($diretorio, $pasta, &$i, $formatos, $termo_busca){
    
    $raiz = $pasta; 
    
    while($arquivo = $diretorio->read()){
        if (is_dir($raiz.$arquivo) && $arquivo !== '.' && $arquivo !== '..'){
    
            $newdir = $raiz.$arquivo;
            $diretorio2 = dir($newdir);
            buscarArquivos($diretorio2, $raiz.$arquivo.'/', $i, $formatos, $termo_busca);
    
        }
        else if (is_file($raiz.$arquivo)){
            $i++;
            $ext = pathinfo($raiz.$arquivo, PATHINFO_EXTENSION);
            if (in_array($ext, $formatos)){
                $arq = file_get_contents($raiz.$arquivo);
                //$pos = strpos($arq, $termo_busca);
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
    


// Aqui adicionamos a pasta que queremos fazer a leitura
$path = "arquivos/";
$diretorio = dir($path);
// Contador de Arquivos avaliados
$i = 0;
// Termo de Busca exato
$termo_busca = "unifei";
// Informe os formatos dos arquivos que serão analisados
$formatos = array("php", "txt", "html");


// Tabela para exibição de arquivos encontrados
echo '<table width="100%" border="1" cellspacing="0" cellspading="0">
        <tr>
            <th>Arquivo</th>
            <th>Caminho</th>
            <th>Ocorrências</th>
        </tr>';

buscarArquivos($diretorio, $path, $i, $formatos, $termo_busca);

echo '<tr>
            <td colspan="3">
                '.$i.' arquivos avaliados
            </td>
        </tr>
    </table>';