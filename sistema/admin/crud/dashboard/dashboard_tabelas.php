
<!-- @Gorpo Orko - 2020 -->

<?php
session_start();
if(!$_SESSION['nome']) {
  header('Location: ../../index.php');
  exit();
}
//inclui o arquivo de ../conexao com banco de dados
include('../../../../databases/conexao.php');
require '../../../../databases/database.php';
$usuario = $_SESSION['nome'];


//Verifica se é usuario, se for redireciona para a home dos usuarios
//require '../../databases/database.php';
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM usuarios";
foreach($pdo->query($sql)as $row){
  if($row['usuario'] == $_SESSION['nome']){
    if($row['nivel'] == 'user'){
    header('Location: ../../index.php'); }
  }
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
            <h1 class="m-0">TABELAS E IMPRESSÃO DE RELÁTORIOS</h1>
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
     


<! -- ================================================  INFORMAÇÕES DA DASHBOARD DE PRODUTOS ================================================   -->
<section class="content">
<div class="container-fluid">
<!-- ================================================ CAIXAS DAS INFORMAÇÕES DO TOPO ================================================ -->
        <div class="row">
          <!------------------------Quantidade de Produtos Cadastrados---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total de Produtos Cadastrados</span>
                <span class="info-box-number"><?php
                  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                  $sql = "SELECT produto FROM produtos";
                  $contador_produtos = 0;
                  foreach($pdo->query($sql)as $row){
                    $contador_produtos = $contador_produtos +1;
                  }database::desconectar();
                  echo $contador_produtos;
                  ?> </span>
              </div>
          </div></div>
          <!------------------------Quantidade Produtos em baixa---------------------->
          <div class="clearfix hidden-md-up"></div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cart-arrow-down"></i></span>
              <div class="info-box-content">
                <span class="info-box-text"><a href="" onclick="produtos_em_baixa()" style="color: inherit;">Total de Produtos em Baixa</a></span>
                <span class="info-box-number">
                  <?php
              $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
              $sql = "SELECT * FROM produtos";
              $contador = 0;
              $produtos_em_baixa = array();
              $tamanho_em_baixa = array();
              $cor_em_baixa = array();
              foreach($pdo->query($sql)as $row){
                  $produto =  $row['produto']; 
                  $tamanho =  $row['tamanho']; 
                  $cor =  $row['cor']; 
                  $quantidade = $row['quantidade'];
                  if($quantidade <= 5){
                    $contador = $contador + 1;
                    $produtos_em_baixa[]  =  $produto;
                    $tamanho_em_baixa[]  =  $tamanho;
                    $cor_em_baixa[]  =  $cor;
                  }
                  database::desconectar();
              }
              echo $contador;
              //echo json_encode($produtos_em_baixa, JSON_UNESCAPED_UNICODE);
            ?>  
                </span>
          </div></div></div>

          <script type="text/javascript">/* POP UP INFORMANDO PRODUTOS EM BAIXA */
          function produtos_em_baixa() {
              var js_array = confirm([<?php
               //echo '"'.implode('\n', $produtos_em_baixa ).'"';
                $arr = array();
                for ($index = 0; $index < count($produtos_em_baixa); $index++) {
                    $arr[$index] = $produtos_em_baixa[$index]." | ".$tamanho_em_baixa[$index]." | ".$cor_em_baixa[$index];
                }
                echo '"'.implode('\n', $arr ).'"';
                ?>]);
              }
          </script>
          <!------------------------Total de Produtos Acima do Estoque---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cart-plus"></i></span>
              <div class="info-box-content">
                <span class="info-box-text"> <a href="" onclick="produtos_acima_estoque()"  style="color: inherit;">Total de Produtos Acima do Estoque </a></span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos";
                    $contador = 0;
                    $produtos_acima_estoque = array();
                    $tamanho_acima_estoque = array();
                    $cor_acima_estoque = array();
                    foreach($pdo->query($sql)as $row){
                        $produto =  $row['produto']; 
                        $tamanho =  $row['tamanho']; 
                        $cor =  $row['cor']; 
                        $quantidade = $row['quantidade'];
                        if($quantidade >= 500){
                          $contador = $contador + 1;
                          $produtos_acima_estoque[]  =  $produto;
                          $tamanho_acima_estoque[]  =  $tamanho;
                          $cor_acima_estoque[]  =  $cor;
                        }
                        database::desconectar();
                    }
                    echo $contador;
                    //echo json_encode($produtos_acima_estoque, JSON_UNESCAPED_UNICODE);
                  ?>  
                </span>
              </div></div> </div>

              <script type="text/javascript">/* POP UP INFORMANDO PRODUTOS EM BAIXA */
          function produtos_acima_estoque() {
              var js_array = confirm([<?php
                $arr = array();
                for ($index = 0; $index < count($produtos_acima_estoque); $index++) {
                    $arr[$index] = $produtos_acima_estoque[$index]." | ".$tamanho_acima_estoque[$index]." | ".$cor_acima_estoque[$index];
                }
                echo '"'.implode('\n', $arr ).'"';
                ?>]);
              }
          </script>

          <!------------------------PRODUTOS EM FALTA---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-bell"></i></span>
              <div class="info-box-content">
                <span class="info-box-text"><a href=""  onclick="produtos_em_falta()" style="color: inherit;">Total de Produtos em Falta</a></span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos";
                    $contador = 0;
                    $produtos_em_falta = array();
                    $tamanho_em_falta = array();
                    $cor_em_falta = array();
                    foreach($pdo->query($sql)as $row){
                        $produto =  $row['produto'];
                        $tamanho =  $row['tamanho']; 
                        $cor =  $row['cor']; 
                        $quantidade = $row['quantidade'];
                        if($quantidade == 0){
                          $contador = $contador + 1;
                          $produtos_em_falta[] = $produto;
                          $tamanho_em_falta[]  =  $tamanho;
                          $cor_em_falta[]  =  $cor;
                        }
                        database::desconectar();
                    }
                    echo $contador;
                    //echo json_encode($produtos_em_falta, JSON_UNESCAPED_UNICODE);
                  ?> 
                </span>
              </div></div></div>

              <script type="text/javascript">/* POP UP INFORMANDO PRODUTOS EM BAIXA */
          function produtos_em_falta() {
              var js_array = confirm([<?php
                $arr = array();
                for ($index = 0; $index < count($produtos_em_falta); $index++) {
                    $arr[$index] = $produtos_em_falta[$index]." | ".$tamanho_em_falta[$index]." | ".$cor_em_falta[$index];
                }
                echo '"'.implode('\n', $arr ).'"';
                ?>]);
              }
          </script>


    </div>
    <!-- FINAL DAS CAIXAS DAS INFORMAÇÕES DO TOPO -->


<!-- ==================================================== TODOS PRODUTOS EM ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Todos Produtos em Estoque</h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>



<!-- ==================================================== CAMISETAS FPU50+ EM ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Camisetas FPU50+ </h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'camisa_fpu' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>

<!-- ==================================================== CAMISETAS REPELENTE EM ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Camisetas Repelentes</h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example3" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'camisa_repelente' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>            

<!-- ==================================================== CAMISETAS TERMICA EM ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Camisetas Térmicas </h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example4" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'camisa_termica' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>   

<!-- ==================================================== CAMISETAS CICLISMO EM ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Camisetas CICLISMO </h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example5" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'camisa_ciclismo' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>   


<!-- ==================================================== LYCRAS EM ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Lycras </h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example6" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'lycra' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>   


<!-- ==================================================== NEOLYCRAS EM ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Neolycras </h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example7" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'neolycra' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>   

<!-- ==================================================== BERMUDAS EM ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Bermudas </h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example8" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'bermuda' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>   


<!-- ==================================================== CALÇAS EM ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Calças </h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example9" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'calca' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>   




<!-- ==================================================== JAQUETAS EM ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Jaquetas </h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example10" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'jaqueta' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>   

<!-- ==================================================== FLOAT ADULTO EM ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Float Adulto </h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example11" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'float_adulto' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>   


<!-- ==================================================== COLETE ADULTO HOMOLOGADO ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Colete Adulto Homologado</h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example12" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_adulto_homologado' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>   


<!-- ==================================================== COLETE ADULTO EAF ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Colete Adulto EAF</h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example13" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_adulto_eaf' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>  


<!-- ==================================================== COLETE ADULTO KITE ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Colete Adulto Kitesurf</h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example14" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_adulto_kite' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>  


<!-- ==================================================== COLETE KIDS ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Colete Kids</h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example15" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_kids' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>  



<!-- ==================================================== COLETE KIDS HOMOLOGADO ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Colete Kids Homologado</h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example16" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_kids_homologado' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>  




<!-- ==================================================== FLOAT KIDS ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Float Kids</h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example17" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'float_kids' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>  






<!-- ==================================================== SAPATILHAS ESTOQUE======================================================== -->
      <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title">Sapatilhas</h3>
        <div class="card-tools">
              <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div></div>
        <div class="card-body p-0 " style="margin-left:20px; margin-right: 20px;">
              <div class="card-body">
                <table id="example18" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $q = $pdo->prepare("DESCRIBE produtos");
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
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'sapatilha' ORDER BY produto ASC";
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
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div></div>  















</div></section>
<!-- /.content-header -->
 </div></div></div>

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

<!-- jQuery 
<script src="../../../../assets/plugins/jquery/jquery.min.js"></script>-->


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
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $("#example2").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

    $("#example3").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');

  
  $("#example4").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');

  $("#example5").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example5_wrapper .col-md-6:eq(0)');

  $("#example6").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example6_wrapper .col-md-6:eq(0)');

  $("#example7").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example7_wrapper .col-md-6:eq(0)');

  $("#example8").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example8_wrapper .col-md-6:eq(0)');

  $("#example9").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example9_wrapper .col-md-6:eq(0)');

  $("#example10").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example10_wrapper .col-md-6:eq(0)');

  $("#example11").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example11_wrapper .col-md-6:eq(0)');

  $("#example12").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example12_wrapper .col-md-6:eq(0)');

  $("#example13").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example13_wrapper .col-md-6:eq(0)');

  $("#example14").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example14_wrapper .col-md-6:eq(0)');

  $("#example15").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example15_wrapper .col-md-6:eq(0)');

  $("#example16").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example16_wrapper .col-md-6:eq(0)');

  $("#example17").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example17_wrapper .col-md-6:eq(0)');

  $("#example18").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example18_wrapper .col-md-6:eq(0)');

});
</script>
</body>
</html>
<?php 
include_once('chat.php');
?>
