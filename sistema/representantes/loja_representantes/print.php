<?php
session_start();
if(!$_SESSION['nome']) {
  header('Location: ../../index.php');
  exit();
}
//inclui o arquivo de conexao com banco de dados
include('../../databases/conexao.php');
require '../../databases/database.php';
$usuario = $_SESSION['nome'];


$representante = $_GET['representante'];
$nome_db = $_GET['nome_db'];
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VOPEN</title>
  <meta property="og:site_name" content="VOPEN"/>
  <meta property="og:title" content="VOPEN"/>
  <meta property="og:url" content="https://vopen.com.br/"/>
  <meta property="og:description" content="Sistema de administração VOPEN"/>
  <meta property="og:image" content="../../assets/images/logo.svg"/>
  <link rel="shortcut icon" href="../../assets/images/icon.png" />
  <script src="https://kit.fontawesome.com/a80232805f.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../assets/css/style_claro_cinza.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../../assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../../assets/plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
       <!-- title row -->
       <img src="../../assets/images/logo_black.svg" alt="Visa">
                <hr style="border: 1px solid black;">
              <div class="row">
                <div class="col-6">
                
              </div>
                <div class="col-12">
                  <h4>
                    <div class="image">
                        <?php
                        $representante = $_GET['representante'];
                        //$rep =  mb_convert_case($row['representante'],MB_CASE_LOWER,mb_detect_encoding($row['representante'])) ;
                        $pdo = Database::conectar();
                        $sql = 'SELECT * FROM representantes ';
                        foreach($pdo->query($sql)as $row){
                            if(mb_convert_case($row['representante'],MB_CASE_LOWER,mb_detect_encoding($row['representante'])) == $representante){
                            echo '<img src="../../assets/images/representantes/'.$row['imagem'].'" class="img-circle " style="width: 2%; filter: grayscale(100%);"><strong>Representante '.$representante.'</strong></div>';
                           

                            echo '<small class="float-right">'.date('d/m/Y').'</small>
                            </h4></div></div>
                            <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                            <address>
                            <strong>'.$row['nome_fantasia'].'</strong><br>
                            '.$row['endereco'].'<br>
                            '.$row['cidade'].', '.$row['estado'].'<br>
                            Telefone: '.$row['telefone'].'<br>
                            Email: '.$row['email'].'
                            </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                            <address>
                            <strong>VOPEN</strong><br>
                            Rodovia SC-434, 11440 Sala 2<br>
                            Garopaba, Santa Catarina<br>
                            Telefone: (48) 99145.4300 <br>
                            Email: comercial@vopen.com.br
                            </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                            <br>
                            <br>
                            <b>Pedido ID:</b> '.$_GET['nome_db'].'<br>
                            <b>Feito em:</b> '.date('d/m/Y',  strtotime(str_replace('_', '-',mb_strimwidth(date($_GET['nome_db']),0,-3)))) .'<br>
                            </div>
                            </div>';
                            }}
                            database::desconectar();
                            ?>



              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Detalhes da compra</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <!-- INSERE DADOS NO TOPO DA TABELA -->
                    <?php
                    $nome_db = $_GET['nome_db'];
                    //echo $nome_db, $representante;
                    $pdo = Database::conectar($dbNome="representante_$representante");
                    $q = $pdo->prepare("DESCRIBE $nome_db");
                    $q->execute();
                    $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
                    $teste = implode('|', $table_fields);
                    echo '
                        <th style="color: black;">'.$table_fields[0].'</th>
                        <th style="color: black;">'.$table_fields[1].'</th>
                        <th style="color: black;">'.mb_strimwidth($table_fields[2],0,4).'</th>
                        <th style="color: black;">'.$table_fields[3].'</th>
                        <th style="color: black;">'.mb_strimwidth($table_fields[5],0,8).'</th>
                        <th style="color: black;">'.$table_fields[6].'</th>
                        <th style="color: black;">'.$table_fields[7].'</th>
                        <th style="color: black;">'.mb_strimwidth($table_fields[8],0,6).'</th>
                        <th style="color: black;">'.$table_fields[9].'</th>
                        <th style="color: black;">'.$table_fields[10].'</th>
                        <th style="color: black;">'.mb_strimwidth($table_fields[11],0,5).'</th>
                      ';
                      echo '</tr>
                      </th><tbody><!-- INSERE DADOS NA TABELA -->
                  <tr>';
                    
                    
                    //$pdo = Database::conectar($dbNome="representante_$representante");
                    $sql = "SELECT * FROM $nome_db";
                    foreach($pdo->query($sql)as $row){
                        echo '
                    <td style="color: black;">'.$row['id'].'</td>
                    <td style="color: black;">'.$row['produto'].'</td>
                    <td style="color: black;">'.$row['tipo_produto'].'</td>
                    <td style="color: black;">'.$row['genero'].'</td>
                    <td style="color: black;">'.$row['referencia'].'</td>
                    <td style="color: black;">'.$row['cor'].'</td>
                    <td style="color: black;">'.$row['tamanho'].'</td>
                    <td style="color: black;">'.$row['codigo_barra'].'</td>
                    <td style="color: black;">'.$row['valor'].'</td>
                    <td style="color: black;">'.$row['lote'].'</td>
                    <td style="color: black;">'.$row['quantidade'].'</td>
                  </tr>';
                    };
                    database::desconectar();
                    ?>
                </tbody></table> </div>
                  
              <!-- /.card-body -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
        <p class="lead"></p>

        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">

        </p>
      </div>
      <!-- /.col -->
      <div class="col-6">
        <?php
        $soma_total = 0;
        $pdo = Database::conectar($dbNome="representante_$representante");
        $sql = "SELECT * FROM $nome_db";
        foreach($pdo->query($sql)as $row){
          $soma_total = $soma_total + str_replace (',', '.', $row['valor']) * $row['quantidade'];
        }




      echo '  <p class="lead"><b>Valor Tolal:</b></p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%; color: black;">Subtotal:</th>
              <td style="color: black;">'.number_format((float)$soma_total, 2, '.', '').'</td>
            </tr>
            <tr>
              <th style="color: black;">Tax (10%)</th>
              <td style="color: black;">'.number_format((float)$soma_total/100*10, 2, '.', '').'</td>
            </tr>
            <tr>
              <th style="color: black;">Total:</th>
              <td style="color: black;">'.number_format((float)$soma_total/100*10+$soma_total, 2, '.', '') .'</td>
            </tr>
          </table>
        </div>
      </div>';
      ?>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- ========================================= FIM DA ATIVIDADE DOS USUARIOS============================== -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- --------------------------------  JavaScript -------------------------------- -->
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="../../assets/js/bootstrap.min.js"></script>

<!-- Jquery que faz o layout dos inputs e botoes adicionais ficar responsivo -->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>


<!-- jQuery -->
<script src="../../assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../../assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../../assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../../assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../../assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../../assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../../assets/plugins/moment/moment.min.js"></script>
<script src="../../assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../../assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../assets/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../assets/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../assets/js/pages/dashboard.js"></script>

<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
