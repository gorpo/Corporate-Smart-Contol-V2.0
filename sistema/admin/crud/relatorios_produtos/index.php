
<!-- @Gorpo Orko - 2020 -->

<?php
session_start();
if(!$_SESSION['nome']) {
  header('Location: ../../index.php');
  exit();
}
//inclui o arquivo de conexao com banco de dados
include('../../../../databases/conexao.php');
require '../../../../databases/database.php';
$usuario = $_SESSION['nome'];



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
            <h1 class="m-0">Relatórios</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a href="../../../../logout.php">Logout</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
     


<! -- ================================================  INFORMAÇÕES DA DASHBOARD ================================================   -->
<section class="content">
<div class="container-fluid">
  <!-- CAIXAS DAS INFORMAÇÕES DO TOPO -->
        <div class="row">



          <!------------------------Relatório camisetas FPU50+---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/camiseta.svg"></span>
              <a href="gerador_relatorio.php?produto=camisa_fpu"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Camisetas FPU50+</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'camisa_fpu' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      try{
                      $valor_unitario = str_replace (',', '.', $row['valor']);
                      }catch(Exception $e){
                      $valor_unitario = $row['valor'];
                         }
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>

              

              <!------------------------Relatório camisetas Repelente---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/camiseta.svg"></span>
              <a href="gerador_relatorio.php?produto=camisa_repelente"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Camisetas Repelente</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'camisa_repelente' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>

              <!------------------------Relatório camisetas Térmica---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/camiseta.svg"></span>
              <a href="gerador_relatorio.php?produto=camisa_termica"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Camisetas Térmica</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'camisa_termica' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>

              <!------------------------Relatório camisetas Ciclismo---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/camiseta.svg"></span>
              <a href="gerador_relatorio.php?produto=camisa_ciclismo"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Camisetas Ciclismo</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'camisa_ciclismo' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>

              <!------------------------Relatório Lycra---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/camiseta.svg"></span>
              <a href="gerador_relatorio.php?produto=lycra"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Lycra</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'lycra' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>


              <!------------------------Relatório NeoLycra---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/camiseta.svg"></span>
              <a href="gerador_relatorio.php?produto=neolycra"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Neolycra</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'neolycra' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>


              <!------------------------Relatório Bermuda---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/camiseta.svg"></span>
              <a href="gerador_relatorio.php?produto=bermuda"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Bermuda</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'bermuda' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>

              <!------------------------Relatório Calça---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/camiseta.svg"></span>
              <a href="gerador_relatorio.php?produto=calca"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Calça</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'calca' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>

              <!------------------------Relatório jaqueta---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/camiseta.svg"></span>
              <a href="gerador_relatorio.php?produto=jaqueta"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Jaqueta</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'jaqueta' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>


              <!------------------------Relatório Float Adulto---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/camiseta.svg"></span>
              <a href="gerador_relatorio.php?produto=float_adulto"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Float Adulto</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'float_adulto' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>

              <!------------------------Relatório Colete Adulto Homologado---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/camiseta.svg"></span>
              <a href="gerador_relatorio.php?produto=colete_adulto_homologado"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Colete Adulto Homologado</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_adulto_homologado' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>

              <!------------------------Relatório Colete Adulto EAF---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/camiseta.svg"></span>
              <a href="gerador_relatorio.php?produto=colete_adulto_eaf"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Colete Adulto EAF</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_adulto_eaf' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>


              <!------------------------Relatório Colete Adulto Kite---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/camiseta.svg"></span>
              <a href="gerador_relatorio.php?produto=colete_adulto_kite"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Colete Adulto Kitesurf</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_adulto_kite' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>


               <!------------------------Relatório Colete Kids Homologado---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/coletinho_kids.svg"></span>
              <a href="gerador_relatorio.php?produto=colete_kids_homologado"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Colete Kids Homologado</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_kids_homologado' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>
              

          <!------------------------Relatório Coletes Kids---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/coletinho_kids.svg"></span>
              <a href="gerador_relatorio.php?produto=colete_kids"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Colete Kids</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_kids' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>

          <!------------------------Relatório Float Kids---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/float_kids.svg"></span>
              <a href="gerador_relatorio.php?produto=float_kids"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Float Kids</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'float_kids' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>

          <!------------------------Relatório Sapatilha Kids---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><img src="../../../../assets/images/icones/sapatilha.svg"></span>
              <a href="gerador_relatorio.php?produto=sapatilha"  style="color: inherit;">
                <div class="info-box-content">
                <span class="info-box-text">Sapatilha Kids</span>
                <span class="info-box-number">
                  <?php
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'sapatilha' ORDER BY produto ASC";
                    $quantidade = array();
                    foreach($pdo->query($sql)as $row){
                      $quantidade[] = $row['quantidade'];
                      $valor_unitario = str_replace (',', '.', $row['valor']); 
                        }
                        Database::desconectar();
                    echo "Total de produtos: ".array_sum($quantidade)."<br>";
                    //echo "Valor total: R$".str_replace ('.', ',', $valor_unitario * array_sum($quantidade)) ;
                  ?> 
                </span>
              </a></div></div></div>

          

              



          


























    </div>
    <!-- FINAL DAS CAIXAS DAS INFORMAÇÕES DO TOPO -->




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
</body>
</html>
<?php 
include_once('chat.php');
?>
