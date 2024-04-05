<?php
session_start();

use Mpdf\Mpdf;
require_once __DIR__ . '../../../../../assets/mpdf/autoload.php';
require '../../../../databases/database.php';


if(isset($_GET['produto'])){

$produto = $_GET['produto'];

$mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
$html_topo = '
<html>
<head>
<style>
    @page {
      size: auto;
      odd-header-name: html_MyHeader1;
      odd-footer-name: html_MyFooter1;
    }

    @page chapter2 {
        odd-header-name: html_MyHeader2;
        odd-footer-name: html_MyFooter2;
    }

    @page noheader {
        odd-header-name: _blank;
        odd-footer-name: _blank;
    }

    div.chapter2 {
        page-break-before: always;
        page: chapter2;
    }

    div.noheader {
        page-break-before: always;
        page: noheader;
    }
</style>
</head>
<body>
    <htmlpageheader name="MyHeader2">
        <div style="border-bottom: 1px solid #000000; font-weight: bold;  font-size: 10pt;"><img src="../../../../assets/images/logo_black.svg"></div>
    </htmlpageheader>

    <htmlpagefooter name="MyFooter2">
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
            <tr>
                <td width="63%"><span style="font-weight: bold; font-style: italic;">VOPEN -  CNPJ 36.333.392/0001-58. Rodovia SC-434, 11440 Sala 2 - Garopaba/SC.</span></td>
                <!-- <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td> -->
                <td width="33%" style="text-align: right; ">Página {PAGENO}/{nbpg} | {DATE j-m-Y}</td>
            </tr>
        </table>
    </htmlpagefooter>
';
    

$html_div_inicio = '<div class="chapter2"><br>
<h3>Relatório '.ucwords(str_replace('_',' ',$produto)).'</h3>';


$mpdf->WriteHTML($html_topo);
$mpdf->WriteHTML($html_div_inicio);

        // FOREACH PHP PARA PEGAR OS DADOS--------------------------------------------------->>
        $array_soma_total = array();
        $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
        $sql = "SELECT * FROM produtos WHERE tipo_produto = '$produto' ORDER BY produto ASC";
        foreach($pdo->query($sql)as $row){
          $produto =   $row['produto'];
          $referencia =   $row['referencia'];
          $cor = $row['cor'];
          $tamanho =   $row['tamanho'];
          $codigo_barra =   $row['codigo_barra'];
          $valor =   $row['valor'];
          $lote =   $row['lote'];
          $quantidade =   $row['quantidade'];
          $valor_unitario = str_replace (',', '.', $row['valor']); 
          $imagem = $row['imagem'];

          $html_foreach1 = '<img src="../../../../assets/images/produtos/'.$imagem.'" width=60 height=60> <b>'.$produto.'</b> <br> Cor:'.$cor.' | Tamanho:'.$tamanho.' | Quantidade:'.$quantidade.' <br>Referência:'.$referencia.' |  Codigo Barra:'.$codigo_barra.' | Lote:'.$lote.'<br> Valor unitário: R$'.$valor.' | Valor Total em estoque: R$'.str_replace (".", ",", $valor_unitario * $quantidade).'<br><br>';

        $mpdf->WriteHTML($html_foreach1);

        $array_soma_total[] = str_replace (".", ",", $valor_unitario * $quantidade);

        }
        Database::desconectar();
  

    $html_div_calculo_total = array_sum($array_soma_total);





$html_div_fim = '</div>';
$html_final ='</body></html>';


$mpdf->WriteHTML($html_div_fim);
$mpdf->WriteHTML('Valor de todos os produtos em estoque: R$'.$html_div_calculo_total);
$mpdf->WriteHTML($html_final);
$mpdf->Output();
}
?>