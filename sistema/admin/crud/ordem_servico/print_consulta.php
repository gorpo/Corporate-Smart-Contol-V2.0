<?php
session_start();
if(!$_SESSION['nome']) {
  header('Location: ../index.php');
  exit();
}
//inclui o arquivo de conexao com banco de dados
include('../../../../databases/conexao.php');
require '../../../../databases/database.php';
$usuario = $_SESSION['nome'];

$ordem_servico = $_SESSION['ordem_servico'];
$informacao = $_GET['informacao'];
$id = $_GET['id'];
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Corporate Smart Control</title>
  <meta property="og:site_name" content="Corporate Smart Control"/>
  <meta property="og:title" content="Corporate Smart Control"/>
  <meta property="og:url" content="https://corporatesmartcontrol.com/"/>
  <meta property="og:description" content="Corporate Smart Control"/>
  <meta property="og:image" content="../../../../assets/images/logo.svg"/>
  <link rel="shortcut icon" href="../../../../assets/images/icon.png" />
  <script src="https://kit.fontawesome.com/a80232805f.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../../../assets/css/style_claro_cinza.css">
  <link rel="stylesheet" href="../../../../assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../../../../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="../../../../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../../../../assets/plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="../../../../assets/css/adminlte.min.css">
  <link rel="stylesheet" href="../../../../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="../../../../assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../../../../assets/plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">


 <!-- title row -->
 <img src="../../../../assets/images/logo_black.svg" alt="">
 <hr style="border: 1px solid black;">
 <div class="card">



                <?php  
                $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                $q = $pdo->prepare("SELECT * FROM ordem_servico WHERE id = '$id'");
                $q->execute();
                $ordem_servico = $q->fetchAll(PDO::FETCH_COLUMN);
                $numero_os =  $ordem_servico[0];

                   

              echo '<div class="card-header">
                <h1 class="card-title"><b>ORDEM DE SERVIÇO Nº:'.$numero_os.'</b> </h1>
              </div>';

               ?>

              <div class="card-body">
                <table id="example1" class=" table-bordered table-striped"> <!-- estava dentro de class table -->
                    <thead>
                      <tr>
                        <th style="color: black;">O.S.</th>
                        <th style="color: black;">Produto</th>
                        <th style="color: black;">Referencia</th>
                        <th style="color: black;">Cor</th>
                        <th style="color: black;">Tamanho</th>
                        <th style="color: black;">Data</th>
                        <th style="color: black;">Quantidade</th>
                      </tr>

                    <!-- INSERE DADOS NO TOPO DA TABELA -->
                    <?php
                  
                      echo '
                      <tbody><!-- INSERE DADOS NA TABELA -->
                  <tr>';
                    
                    



                    //pega a id da tabela de ordem de serviços para dar o numero da ordem de serviço
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("SELECT * FROM ordem_servico WHERE id = '$id'");
                    $q->execute();
                    $ordem_servico = $q->fetchAll(PDO::FETCH_COLUMN);
                    $numero_os =  $ordem_servico[0];




                    //faz os foreach para alimentar a tabela
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = $pdo->prepare("SELECT * FROM ordem_servico WHERE id = '$id' ");
                    $sql->execute();
                    $info = $sql->fetchAll();
                    foreach($info as $key => $row){
                      $array_produto =  explode(",", $row['produto']);
                      $array_quantidade =  explode(",", $row['quantidade']);
                      foreach($array_produto as $key=>$value){
                        $id_produto = $value;
                        $quantidade = $array_quantidade[$key];
                        $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                        $sql = "SELECT * FROM produtos WHERE id = '$id_produto'";
                        foreach($pdo->query($sql)as $row){
                          echo '<td style="color: black;">'.$numero_os.'</td>
                    <td style="color: black;">'.$row['produto'].'</td>
                    <td style="color: black;">'.$row['referencia'].'</td>
                    <td style="color: black;">'.$row['cor'].'</td>
                    <td style="color: black;">'.$row['tamanho'].'</td>
                    <td style="color: black;">'.date('d/m/Y',  strtotime(str_replace('_', '-',mb_strimwidth(date($row['data']),0,-3)))).'</td>
                    <td style="color: black;">'.$quantidade.'</td>
                  </tr>';
                      }
                      }
                    }
                    database::desconectar();
                    ?>
                </tbody></table> </div>
              <!-- /.card-body -->

              <div class="form-group">
                  <label>Informações Extras</label>
                  <textarea class="form-control" rows="15"  cols="100" placeholder="Enter ..." name="gravar" id="gravar"><?php echo $informacao; ?></textarea> 
                </div>



  </div>
<hr style="border: 1px solid black;">
 <p><b>Telefone: (48) 99145.4300  |  Email: comercial@vopen.com.br |  Rodovia SC-434, 11440 Sala 2 | Garopaba, Santa Catarina</b><br><p>
</div>

<!-- ./wrapper -->

<!-- --------------------------------  JavaScript -------------------------------- -->
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="../../../../assets/js/bootstrap.min.js"></script>

<!-- Jquery que faz o layout dos inputs e botoes adicionais ficar responsivo -->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>


<!-- jQuery -->
<script src="../../../../assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../../../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../../../../assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../../../../assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../../../../assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../../../../assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../../../../assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../../../../assets/plugins/moment/moment.min.js"></script>
<script src="../../../../assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../../../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../../../../assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../../../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../../assets/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../../../assets/customizar/customizar.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../../../assets/js/pages/dashboard.js"></script>


<!-- GERA A IMPRESSAO E APOS IMPRIMIR FECHA A PARTE DE IMPRESSAO  E VOLTA PARA A PAGINA INICIAL-->
<script>
   window.onafterprint = function(e){
        $(window).off('mousemove', window.onafterprint);
        console.log('Print Dialog Closed..');
        window.location.href = 'consulta_ordem_servico.php';
    };

    window.print();

    setTimeout(function(){
        $(window).one('mousemove', window.onafterprint);
    }, 1);
</script> 




<!-- remove a URL  da impressao-->
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style> 




</body>
</html>
<?php 
include_once('chat.php');
?>
