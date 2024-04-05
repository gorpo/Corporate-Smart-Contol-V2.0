
<!-- @Gorpo Orko - 2020 -->

<?php
session_start();
if(!$_SESSION['nome']) {
  header('Location: ../../index.php');
  exit();
}

$usuario = $_SESSION['nome'];

//inclui o arquivo de conexao com banco de dados
include('../../../../databases/conexao.php');
require '../../../../databases/database.php';



//CRIA A TABELA DE ORDEM DE SERVIÇO CASO NAO EXISTA
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = $pdo->prepare("CREATE TABLE IF NOT EXISTS ordem_servico (
id int(11) NOT NULL AUTO_INCREMENT,
produto varchar(300) DEFAULT NULL,
quantidade varchar(300) DEFAULT NULL,
data datetime DEFAULT NULL,
PRIMARY KEY (id)
 ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;");
$sql->execute();
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);


//Acompanha os erros de validação
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $produtoErro = null;
    $tipo_produtoErro = null;
    $quantidadeErro = null;
    $validacao = null;
    if (!empty($_GET)) {
        $validacao = True;

        if (!empty($_GET['produto'])) {
            $produto = $_GET['produto'];
        } else {
            $produtoErro = 'Por favor selecione o seu produto!';
            $validacao = False;
        }

        if (!empty($_GET['quantidade'])) {
            $quantidade = $_GET['quantidade'];
        } else {
            $quantidadeErro = 'Por favor digite a quantidade!';
            $validacao = False;
        }
  }

//Inserindo os valores em arrays de uma session:
     $indice = 0;
    if ($validacao) {
        $array_ordem_servico = array('produto'=>$produto, 'quantidade'=>$quantidade);
        if(isset($_SESSION['ordem_servico'][$indice])){
          $indice = count($_SESSION['ordem_servico']) ;
          $_SESSION['ordem_servico'][$indice] = array($array_ordem_servico);
          header("Location: index.php");
       }else{
          $_SESSION['ordem_servico'][$indice] = array($array_ordem_servico);
          header("Location: index.php");
            }

      
    }
}


//inserindo na database
if(isset($_GET['gravar'])){
  $informacao = $_GET['gravar'];
  $produto_array = array();
  $quantidade_array = array();
  foreach ($_SESSION['ordem_servico'] as $key => $value) {
  foreach ($_SESSION['ordem_servico'][$key] as $key=>$value){
    $produto_array[] = $value['produto'];
    $quantidade_array[] = $value['quantidade'];
  }
 }
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT INTO  ordem_servico  (produto, quantidade, data) VALUES(?,?,NOW())";
$q = $pdo->prepare($sql);
$q->execute(array(implode(",",$produto_array),implode(",",$quantidade_array)));
database::desconectar();
header("Location: print.php?informacao=$informacao");
}









//-------------------DELETA OS PRODUTOS --------------
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM produtos where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    database::desconectar();
    header("Location: index.php");
}
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
  <link rel="stylesheet" href="../../../../assets/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../../../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../../../assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../../../../assets/plugins/summernote/summernote-bs4.min.css">
   <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../../assets/css/adminlte.min.css">
  
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
        <a href="" class="nav-link">Ordem de Serviço</a>
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
          <form method="get" class="form-inline"  action="../resultado_pesquisa/resultado_pesquisa.php">
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Cadastrar Ordem de Serviço</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a href="../logout.php">Logout</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
     


<! -- ================================================  CONSULTA DE ORDEM DE SERVIÇO ================================================   -->
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Selecione a O.S.</h3>
              </div>
              <div class="card-body">
                <form class="form-horizontal" action="consulta_ordem_servico.php"  autocomplete="off" enctype="multipart/form-data">
          <!-- =====   tipo de produto ======   -->
          <div class="  m-b-16" >
            <div class="control-group">
             <div class="controls">
                <select class="input100" name="ordem_servico" id="ordem_servico" onchange="submit();">
                    <option class="input100" value="">Selecione</option>
                    <?php 
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                      $sql = "SELECT * FROM ordem_servico";
                      foreach($pdo->query($sql)as $row){
                        echo '<option class="input100" value="'.$row['id'].'">O.S. '.$row['id'].'</option>';
                      }
                      database::desconectar();
                    ?>
                </select>
            </span>
          </div></div></div>
</form>
</div></div>



<!-- ==================================================== TODOS PRODUTOS EM ESTOQUE======================================================== -->
      <?php 

      if(isset($_GET['ordem_servico'])){
        echo '<div class="card card-primary ">
              <div class="card-header">
                <h3 class="card-title">Ordem de serviço</h3>
                <div class="card-tools">
                      <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div></div>
                <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
                      <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th style="color: black;">O.S.</th>
                                    <th style="color: black;">Produto</th>
                                    <th style="color: black;">Quantidade</th>
                                    <th style="color: black;">Data</th>
                                    </tr>
                                </th><tbody><!-- INSERE DADOS NA TABELA -->
                            <tr>';
                              
                    //pega a id da tabela de ordem de serviços para dar o numero da ordem de serviço
                    $id = $_GET['ordem_servico'];
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM ordem_servico WHERE id = '$id'";
                      foreach($pdo->query($sql)as $row){
                        $id = $row['id'];
                        $produto_array = explode(",",$row['produto']);
                        $quantidade_array = explode(",",$row['quantidade']);
                        $data = $row['data'];
                        foreach ($produto_array as $key => $value) {
                          $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                          $sql = "SELECT * FROM produtos WHERE id = '$value'";
                            foreach($pdo->query($sql)as $row){
                              $produto = $row['produto'];
                              echo '
                                <td style="color: black;">'.$_GET['ordem_servico'].'</td>
                                <td style="color: black;">'.$row['produto'].'</td>
                                <td style="color: black;">'.$quantidade_array[$key].'</td>
                                <td style="color: black;">'.date('d/m/Y',  strtotime(str_replace('_', '-',mb_strimwidth(date($data),0,-3)))).'</td>
                              </tr>';
                            }
                        }
                    }
                    database::desconectar();
                  echo '</tbody></table> </div>
              <form action="print_consulta.php">
              <div class="row no-print">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Informações Extras</label>
                        <input type="hidden" name="id" value="'.$id.'">
                        <textarea class="form-control" rows="3"  cols="500" placeholder="Enter ..." name="informacao" id="informacao"></textarea> 
                        <button class="btn btn-default" type="submit"><i class="fas fa-print"></i> Print </button>
                </div>
                </div>
              </form>';

      }

      ?>
                
               


             
                 
</div></div></div>

</div></div>



<!-- --------------------------------  JavaScript -------------------------------- -->

<script type="text/javascript">/* Mensagem de Alerta ao excluir um registro */
function exclusao($id) {
    var msg = confirm("Atenção: Deseja Excluir esse Registro?");
    if (msg){
        alert("Arquivo excluído com sucesso!");
        window.location.href=("index.php?id="+$id);
    }
    else{
        alert("Operação Cancelada, o Registro não será Excluído!");
    }
}    
</script>


<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="../../../../assets/js/bootstrap.min.js"></script>

<!-- Jquery que faz o layout dos inputs e botoes adicionais ficar responsivo -->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
function resizeSidebar() {
    var window_width = $(window).width();
    if ( window_width < 800 ) {
        $('.site-left-col').addClass('site-left-col-resized');
        $('.site-left-col-inner').addClass('site-left-col-inner-resized');
        $('.site-center-col').addClass('site-center-col-resized');
        $('.site-center-col-inner').addClass('site-center-col-inner-resized');
        $('.site-right-col').addClass('site-right-col-resized');
        $('.site-center-col').addClass('site-center-col-resized');
        $('.site-center-col-inner').addClass('site-center-col-inner-resized');
        $('.coluna-barrapesquisa').addClass('coluna-barrapesquisa-resized');
        $('.coluna-barrapesquisa-inner').addClass('coluna-barrapesquisa-inner-resized');
        $('.coluna-botaopesquisa').addClass('coluna-botaopesquisa-resized');
        $('.coluna-botaopesquisa-inner').addClass('coluna-botaopesquisa-inner-resized');
    } else {
        $('.site-left-col').removeClass('site-left-col-resized');
        $('.site-left-col-inner').removeClass('site-left-col-inner-resized');
        $('.site-center-col').removeClass('site-center-col-resized');
        $('.coluna-barrapesquisa-inner').removeClass('coluna-barrapesquisa-inner-resized');
        $('.coluna-barrapesquisa').removeClass('coluna-barrapesquisa-resized');
        $('.coluna-botaopesquisa-inner').removeClass('coluna-botaopesquisa-inner-resized');
        $('.coluna-botaopesquisa').removeClass('coluna-botaopesquisa-resized');
    }
}
jQuery(function(){
    resizeSidebar();
    
    $(window).resize(function(){
        resizeSidebar();
    });
});
</script>

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
<script src="../../../../assets/customizar/customizar.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../../../assets/js/pages/dashboard.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="../../../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>

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
<script src="../../../../assets/plugins/pdfmake/pdfmake.js"></script>
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
    "paging": false,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": true,
      "responsive": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis",]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


});
</script>


</body>
</html>
<?php 
include_once('chat.php');
?>
