
<!-- @Gorpo Orko - 2020 -->

<?php
session_start();
if(!$_SESSION['nome']) {
  header('Location: ../../../../index.php');
  exit();
}


//inclui o arquivo de conexao com banco de dados
include('../../../../conexao.php');
$usuario = $_SESSION['nome'];
require '../../../../database.php';

$representante = $_GET['representante'];

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
  <!-- DataTables -->
  <link rel="stylesheet" href="../../../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../../../assets/css/style_claro_cinza.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../../../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../../../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../../../../assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../../assets/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../../../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../../../assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../../../../assets/plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="" src="../../../../assets/images/logo.svg" height="600" width="600">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" id="navbar_cor"> 
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link">Consulta Representantes</a>
      </li>
    </ul>



    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
           <!-- ================================================  SISTEMA DE PESQUISA  ================================================ -->
        <div class="navbar-search-block">
          <form method="get" class="form-inline"  action="../../resultado_pesquisa.php">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="text" name="buscar" type="search" placeholder="Insira o nome ou o código de barras do produto" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search" value="Pesquisar">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>


      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      
      
    </ul>
  </nav>
  <!-- /.navbar -->


<!-- ================================================  MENUS DA ESQUERDA ================================================ -->
<?php 
include('menu.php'); 
include('../../../../assets/customizar/customiza.php'); 
?>
<!-- Sidebar Menu -->



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Consulta Representante</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a href="../../logout.php">Logout</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <div class="image">
                       <?php


                        $soma_total = 0;
                        $pdo1 = Database::conectar();
                        $sql1 = "SELECT * FROM carrinho_representante_$representante ORDER BY id DESC limit 1";
                        foreach($pdo1->query($sql1)as $row1){
                          $array_valor = explode(",",$row1['valor']);
                          $array_quantidade = explode(",",$row1['quantidade']);
                           foreach ($array_valor as $key => $value_valor ) {
                            $valor=  $value_valor;
                            $quantidade =  $array_quantidade[$key];
                            $soma_total = $soma_total + $valor * $quantidade;
                            }
                            }
                             database::desconectar();





                             //pega o id 
                              $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                              $sql = "SELECT * FROM carrinho_representante_$representante ORDER BY id DESC limit 1";
                              foreach($pdo->query($sql)as $row){
                                  $id = $row['id'];
                                  $data = $row['data'];
                              }
                              database::desconectar();





                        $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                        $sql = 'SELECT * FROM representantes ';
                        foreach($pdo->query($sql)as $row){
                        if(mb_convert_case($row['representante'],MB_CASE_LOWER,mb_detect_encoding($row['representante'])) == $representante){
                        echo '<img src="../../../../assets/images/representantes/'.$row['imagem'].'" class="img-circle elevation-2" style="width: 5%;"><strong>Representante '.$representante.'</strong></div>';
                           

                            echo '
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
                            <b>Pedido ID:</b> '.$id.'<br>
                            <b>Feito em:</b> '.date('d/m/Y',  strtotime(str_replace('_', '-',mb_strimwidth(date($data),0,-3)))).'<br>
                            <b>Valor Total:</b>  R$'.number_format((float)$soma_total, 2, '.', '').' <br>
                            </div>
                            </div>';
                            }}
                            database::desconectar();
                            ?>






              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Detalhes do pedido</h3>
              </div>

              <div class="card-body">
                <form action="index.php" style="margin-bottom: 20px;">
                  <input type="hidden" name="representante" value="<?php echo $representante; ?>">
                    <select class="input100" name="pedido" id="produtos_cadastrados" onchange="this.form.submit()">
                    <option class="input100" value=""><?php
                                        if(isset($_GET['pedido'])){
                                        echo 'Pedido: '.$_GET['pedido'];
                                      }else{
                                        echo 'Selecione o pedido';
                                      }
                                        ?></option>
                                      
                      <?php
                      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                      $sql = "SELECT * FROM carrinho_representante_$representante ";
                      foreach($pdo->query($sql)as $row){
                        echo '<option class="input100" value="'.$row[0].'" >Pedido: '.$row[0].'</option>';
                      }
                      ?>
                    </select>
                </form>



                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <!-- INSERE DADOS NO TOPO DA TABELA -->
                    <?php
                    if(isset($_GET['pedido'])){
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE carrinho_representante_$representante");
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
                        <th style="color: black;">'.$table_fields[12].'</th>
                        <th style="color: black;">'.$table_fields[13].'</th>
                      ';
                      echo '</tr>
                      </th><tbody><!-- INSERE DADOS NA TABELA -->
                  <tr>';
                    
                    $id_pedido = $_GET['pedido'];
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM carrinho_representante_$representante WHERE  id = $id_pedido";
                    foreach($pdo->query($sql)as $row){
                      $array_id = explode(',', $row['id']);
                      $array_produto = explode(',', $row['produto']);
                      $array_tipo_produto = explode(',', $row['tipo_produto']);
                      $array_genero = explode(',', $row['genero']);
                      $array_referencia = explode(',', $row['referencia']);
                      $array_cor = explode(',', $row['cor']);
                      $array_tamanho = explode(',',$row['tamanho']);
                      $array_codigo_barra = explode(',', $row['codigo_barra']);
                      $array_valor = explode(',',$row['valor']);
                      $array_lote = explode(',', $row['lote']);
                      $array_quantidade = explode(',', $row['quantidade']);
                      $array_pago = explode(',', $row['pago']);
                      $array_data = explode(',', $row['data']);
                      


                      foreach ($array_produto as $key => $value_produto ) {
                        $produto =  $value_produto;
                        $id =  $array_id[0];
                        $tipo_produto =  $array_tipo_produto[$key];
                        $referencia =  $array_referencia[$key];
                        $genero =  $array_genero[$key];
                        $referencia =  $array_referencia[$key];
                        $cor =  $array_cor[$key];
                        $tamanho =  $array_tamanho[$key];
                        $codigo_barra =  $array_codigo_barra[$key];
                        $valor =  $array_valor[$key];
                        $lote =  $array_lote[$key];
                        $quantidade =  $array_quantidade[$key];
                        $pago =  $array_pago[0];
                        $data =  $array_data[0];
                       

                        echo '
                          <td style="color: black;">'.$id.'</td>
                          <td style="color: black;">'.$produto.'</td>
                          <td style="color: black;">'.$tipo_produto.'</td>
                          <td style="color: black;">'.$genero.'</td>
                          <td style="color: black;">'.$referencia.'</td>
                          <td style="color: black;">'.$cor.'</td>
                          <td style="color: black;">'.$tamanho.'</td>
                          <td style="color: black;">'.$codigo_barra.'</td>
                          <td style="color: black;">'.$valor.'</td>
                          <td style="color: black;">'.$lote.'</td>
                          <td style="color: black;">'.$quantidade.'</td>
                          <td style="color: black;">'.$pago.'</td>
                          <td style="color: black;">'.date('d/m/Y',  strtotime(str_replace('_', '-',mb_strimwidth(date($data),0,-3)))).'</td>
                        </tr>';
                    }
                  }
             
                    database::desconectar();
                    echo '</tbody></table> </div>

                  <div class="row no-print">
                        <div class="col-12">
                        <a href="print.php?representante='.$_GET['representante'].'&id_pedido='.$id_pedido.'" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>';
                  echo '         ';
                  echo '<a href="envia_email.php?representante='.$_GET['representante'].'&id_pedido='.$id_pedido.'" rel="noopener"  class="btn btn-default"><i class="fas fa-envelope"></i> Email</a>';
            
                  echo '
                    
                    <div style="float: right; margin-right:20px;">
                    <form action="envia_email.php?">
                      <input type="text" class="input100 btn-default" placeholder="&#xf0e0; Enviar por email para..." name="email" style="width: 300px; font-family:Arial, FontAwesome ">
                      <input type="hidden" name="representante" value="'.$_GET['representante'].'">
                      <input type="hidden" name="id_pedido" value="'.$id_pedido.'">
                      <button class="btn btn-default" type="submit" style="margin-bottom: 5px;">Enviar</button>
                    </div>
                    <form>
                ';

                  echo '</div></div></div>';
                  }else{
                    echo '</tbody></table> </div></div></div>';
                  }
                  ?>
                


            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</div>
  <!-- /.content-wrapper -->
    <footer class="main-footer">
    <strong>Corporate Smart Control - v_1.0 - Copyright &copy; 2022</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../../../assets/js/pages/dashboard.js"></script>

<!-- jQuery -->
<script src="../../../../assets/plugins/jquery/jquery.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../../../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../../../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../../../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src=".../../../../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../../../assets/plugins/jszip/jszip.min.js"></script>
<script src="../../../../assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../../../assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../../../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../../../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../../../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../../assets/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../../../assets/customizar/customizar.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "paging": true,"responsive": true, "lengthChange": false, "autoWidth": false,"responsive": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>


</body>
</html>

