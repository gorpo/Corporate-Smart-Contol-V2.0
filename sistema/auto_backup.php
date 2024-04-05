<?php

include('../databases/conexao.php');

$tables = '*';

//Call the core function


//Core function

//$conexao = mysqli_connect($Host,$user,$pass, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

mysqli_query($conexao, "SET NAMES 'utf8'");

//get all of the tables
$tables = '*';
if ($tables == '*') {
    $tables = array();
    $result = mysqli_query($conexao, 'SHOW TABLES');
    while ($row = mysqli_fetch_row($result)) {
        $tables[] = $row[0];
    }
} else {
    $tables = is_array($tables) ? $tables : explode(',', $tables);
}

$return = '';
//cycle through
foreach ($tables as $table) {
    $result = mysqli_query($conexao, 'SELECT * FROM ' . $table);
    $num_fields = mysqli_num_fields($result);
    $num_rows = mysqli_num_rows($result);

    $return .= 'DROP TABLE IF EXISTS ' . $table . ';';
    $row2 = mysqli_fetch_row(mysqli_query($conexao, 'SHOW CREATE TABLE ' . $table));
    $return .= "\n\n" . $row2[1] . ";\n\n";
    $counter = 1;

    //Over tables
    for ($i = 0; $i < $num_fields; $i++) {   //Over rows
        while ($row = mysqli_fetch_row($result)) {
            if ($counter == 1) {
                $return .= 'INSERT INTO ' . $table . ' VALUES(';
            } else {
                $return .= '(';
            }

            //Over fields
            for ($j = 0; $j < $num_fields; $j++) {
                $row[$j] = addslashes($row[$j]);
                $row[$j] = str_replace("\n", "\\n", $row[$j]);
                if (isset($row[$j])) {
                    $return .= '"' . $row[$j] . '"';
                } else {
                    $return .= '""';
                }
                if ($j < ($num_fields - 1)) {
                    $return .= ',';
                }
            }

            if ($num_rows == $counter) {
                $return .= ");\n";
            } else {
                $return .= "),\n";
            }
            ++$counter;
        }
    }
    $return .= "\n\n\n";
}

//save file
$timezone = new DateTimeZone('America/Sao_Paulo');
$agora = new DateTime('now', $timezone);
//echo $agora->format('d/m/Y H:i'); // Exibe no formato desejado

$fileName = 'db-backup-dia-' . $agora->format('d_m_Y') . '-hora-' . $agora->format('H_i') . '-hashmd5-' . (md5(implode(',', $tables))) . '.sql';
$handle = fopen('backup_database/' . $fileName . '', 'w+');
fwrite($handle, $return);
if (fclose($handle)) {
    //echo "Done, the file name is: ".$fileName;
    //ap�s logar no sistema, realiza o backup da database e leva o usuario para pagina inicial
    header('Location: ./admin/crud/index.php');
    exit;
}
