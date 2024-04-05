
<!-- @Gorpo Orko - 2020 -->

<?php
session_start();
if(!$_SESSION['nome']) {
  header('Location: ../../../index.php');
  exit();
}
//inclui o arquivo de conexao com banco de dados
include('../../../databases/conexao.php');
require '../../../databases/database.php';
$usuario = $_SESSION['nome'];


//Verifica se é usuario, se for redireciona para a home dos usuarios
//require '../databases/database.php';
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM usuarios";
foreach($pdo->query($sql)as $row){
  if($row['nome'] == $_SESSION['nome']){
    if($row['nivel'] == 'representante'){
    header('Location: ../../../index.php'); }
  }
}


//Verifica se é usuario, se for redireciona para a home dos usuarios
//require '../databases/database.php';
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM usuarios";
foreach($pdo->query($sql)as $row){
  if($row['nome'] == $_SESSION['nome']){
    if($row['nivel'] == 'user'){
    header('Location: ../../../loja/index.php'); }
  }
}


if(isset($_GET['id_confirmacao'])){
  $id = $_GET['id_confirmacao'];
  $informacao= $_GET['informacao'];
  $confirmacao = 'executado';
  $status= $_GET['status'];

  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "UPDATE informacoes_estoque set informacao=:informacao,confirmacao=:confirmacao, status=:status , data=now() WHERE id=:id";
  $q = $pdo->prepare($sql);
  $q->bindParam(':informacao', $informacao);
  $q->bindParam(':confirmacao', $confirmacao);
  $q->bindParam(':status', $status);
  $q->bindParam(':id', $id);
  $q->execute();
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
  <meta property="og:image" content="../../../assets/images/logo.svg"/>
  <link rel="shortcut icon" href="../../../assets/images/icon.png" />
  <script src="https://kit.fontawesome.com/a80232805f.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- <link rel="stylesheet" href="../../../assets/css/style_claro_cinza.css"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../../../assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../assets/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../../assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../../../assets/plugins/summernote/summernote-bs4.min.css">


   <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../../../assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../../../assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../../assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../../../assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="../../../assets/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="../../../assets/plugins/dropzone/min/dropzone.min.css">


</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="" src="../../../assets/images/logo.svg" height="600" width="600">
  </div>  -->

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
          <form method="get" class="form-inline"  action="resultado_pesquisa/resultado_pesquisa.php">
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
  <!-- Main Sidebar Container -->
  <aside class="menu_esquerda-link main-sidebar sidebar-dark-primary elevation-4 " id="cor_menu">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link" id="cor_logo">
      <img src="../../../assets/images/logo.svg" alt="Corporate Smart Control"class="brand-image " style="opacity: .8">
      <span class="brand-text font-weight-light">⠀⠀</span>
    </a>

    <!-- Sidebar que exibe o nome de usuario e foto de quem esta logado-->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <?php
            $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
            $sql = 'SELECT * FROM usuarios ';
            foreach($pdo->query($sql)as $row){
                if($row["usuario"] == $_SESSION['usuario']){
                echo '<img src="../../../assets/images/usuarios/'.$row['imagem'].'" class="img-circle elevation-2" alt="User Image">';
                echo '</div>';
                echo '<div class="info">';
                echo '<a href="perfil/edita_perfil.php?id='.$row['id'].'" class="d-block">'.$row['nome'].'</a>';      
            }}
            ?>
        </div>
      </div>


<!-- ================================================  MENUS DA ESQUERDA ================================================ -->
<?php 
include('../../../assets/customizar/customiza.php'); 
?>

      <!-- Sidebar Menu -->
      <nav class="mt-2" >
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

          <li class="nav-item ">
            <a href="index.php" class="nav-link "><i class="nav-icon fas fa-home"></i><p> Início</p></a>
          </li>


          <li class="nav-item "><a href="#" class="nav-link "><i class="nav-icon fas fa-tachometer-alt"></i><p> Dashboard<i class="right fas fa-angle-left"></i></p></a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="index.php" class="nav-link "><i class="fas fa-users nav-icon"></i><p>Usuários</p></a></li>
              <li class="nav-item"><a href="dashboard/dashboard_produtos.php" class="nav-link"><i class="fas fa-box nav-icon"></i><p>Produtos</p></a></li>
              <li class="nav-item"><a href="dashboard/dashboard_tabelas.php" class="nav-link"><i class="fas fa-table nav-icon"></i><p>Tabelas</p></a></li>
              <li class="nav-item"><a href="dashboard/dashboard_graficos.php" class="nav-link"><i class="fas fa-chart-bar nav-icon"></i><p>Gráficos</p></a></li>
            </ul>
          </li>


          <li class="nav-item ">
            <a href="informacoes/informacoes.php" class="nav-link "><i class="nav-icon fas fa-info"></i><p> Informações</p></a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-file-invoice"></i><p>Ordem Serviço<i class="fas fa-angle-left right"></i><span class="badge badge-info right"></p> </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"> <a href="ordem_servico/index.php" class="nav-link "><i class="nav-icon fas fa-file-invoice"></i><p>Gerar O.S.</p></a></li>
              <li class="nav-item"> <a href="ordem_servico/consulta_ordem_servico.php" class="nav-link "><i class="nav-icon fas fa-file-invoice"></i><p>Consultar O.S</p></a></li>
            </ul>
          </li>
          

          <li class="nav-item">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-user"></i><p>Usuários<i class="fas fa-angle-left right"></i><span class="badge badge-info right"></span></p> </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="cadastro_usuarios/cadastro_usuarios.php" class="nav-link"><i class="far fa-user nav-icon"></i><p>Cadastro de usuários</p></a> </li>
              <li class="nav-item"><a href="cadastro_usuarios/consulta_usuarios.php" class="nav-link"><i class="far fa-user nav-icon"></i><p>Verificar acessos</p></a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Representantes<i class="fas fa-angle-left right"></i><span class="badge badge-info right"></span></p> </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="representantes/index.php" class="nav-link"><i class="fas fa-users nav-icon"></i><p>Cadastro representantes</p></a> </li>
              <li class="nav-item"><a href="representantes/pedidos_representantes.php" class="nav-link"><i class="fas fa-users nav-icon"></i><p>Pedidos representantes</p></a></li>
              <li class="nav-item"><a href="representantes/consulta_representantes.php" class="nav-link"><i class="fas fa-users nav-icon"></i><p>Consulta Representantes</p></a></li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-cube"></i> <p>Produtos<i class="right fas fa-angle-left"></i> </p> </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"> <a href="produtos/produtos_cadastrados.php" class="nav-link"><i class="fas fa-cube nav-icon"></i><p>Produtos Cadastrados</p></a></li>
              <li class="nav-item"> <a href="produtos/index.php" class="nav-link"><i class="fas fa-cube nav-icon"></i><p>Produto Único</p></a></li>
              <li class="nav-item"> <a href="produtos/produto_composto.php" class="nav-link"> <i class="fas fa-cube nav-icon"></i> <p>Produto Composto</p></a></li>
              <li class="nav-item"> <a href="produtos/produto_composto_idade.php" class="nav-link"> <i class="fas fa-cube nav-icon"></i> <p>Produto Idade</p></a> </li>
              <li class="nav-item">  <a href="produtos/produto_composto_sapatilha.php" class="nav-link"> <i class="fas fa-cube nav-icon"></i> <p>Produto Sapatilhas</p></a> </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-archive"></i> <p>Relatórios<i class="right fas fa-angle-left"></i> </p> </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"> <a href="relatorios_produtos/index.php" class="nav-link"><i class="fas fa-archive nav-icon"></i><p>Relatório Produtos</p></a></li>
              </li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-laptop-code"></i><p>Desenvolvedor<i class="fas fa-angle-left right"></i><span class="badge badge-info right"></p> </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"> <a href="desenvolvedor/index.php" class="nav-link "><i class="nav-icon fas fa-database"></i><p>Editor Avançado</p></a></li>
              <li class="nav-item"> <a href="desenvolvedor/null.php" class="nav-link "><i class="nav-icon fas fa-laptop-code"></i><p>null</p></a></li>
            </ul>
          </li>


          <!-- /.sidebar-menu -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a href="logout.php">Logout</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
     


<!-- ================================================  INFORMAÇÕES DA DASHBOARD ================================================   -->
<section class="content">
<div class="container-fluid">
  <!-- CAIXAS DAS INFORMAÇÕES DO TOPO -->
        <div class="row">
          <!------------------------Usuários cadastrados---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Usuários Cadastrados</span>
                <span class="info-box-number"><?php
                  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                  $sql = "SELECT usuario FROM usuarios";
                  foreach($pdo->query($sql)as $row){
                    $usuario_cadastrado =  $row['usuario']; 
                    Database::desconectar();
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT COUNT(usuario) as acessou,data_atual FROM user_$usuario_cadastrado WHERE DATE(data_atual) = CURDATE() ";
                        foreach($pdo->query($sql)as $row){
                          echo ''.$usuario_cadastrado.'<br>';
                        }}
                  ?> </span>
              </div>
          </div></div>
          <!------------------------Acessos do dia---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fa fa-sign-in"></i></span>
              <div class="info-box-content">
                <span class="info-box-text"> <a href="" style="color: inherit;">Acessos do dia </a></span>
                <span class="info-box-number">
                  <?php
                  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                  $sql = "SELECT usuario FROM usuarios";
                  foreach($pdo->query($sql)as $row){
                    $usuario_acessou =  $row['usuario']; 
                    Database::desconectar();
                    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                    $sql = "SELECT COUNT(usuario) as acessou,data_atual FROM user_$usuario_acessou WHERE DATE(data_atual) = CURDATE() ";
                        foreach($pdo->query($sql)as $row){
                          if($row['acessou'] == 0){
                            echo "$usuario_acessou:0<br>";
                          }
                          if($row['acessou'] > 0){
                          echo ''.$usuario_acessou.': '.$row['acessou'].'<br>';
                        }}}
                  ?> 
                </span>
              </div></div> </div>
         

              <!------------------------Retiradas do dia---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dolly-flatbed"></i></span>
              <div class="info-box-content">
                <span class="info-box-text"><a href="dashboard/retiradas_do_dia.php" style="color: inherit;">Retiradas do dia</a></span>
                <span class="info-box-number"><?php  
                $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                $sql = "SELECT usuario FROM usuarios";
                foreach($pdo->query($sql)as $row){
                $usuario_selecionado =  $row['usuario'];
                Database::desconectar();
                $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                $sql = "SELECT SUM(quantidade) as quantidade, data_atual FROM retiradas_$usuario_selecionado WHERE DATE(data_atual) = CURDATE() ";
                foreach($pdo->query($sql)as $row){
                  if($row['quantidade'] == 0){
                            //echo '<br>';
                            echo ''.$usuario_selecionado.': 0<br>';
                          }
                  if($row['quantidade'] > 0){
                            echo ''.$usuario_selecionado.': '.$row['quantidade'].'<br>';
                          }}}
                  
                ?></span>
              </div></div></div>




         <!------------------------Produtos em baixa---------------------->
          <div class="clearfix hidden-md-up"></div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cart-arrow-down"></i></span>
              <div class="info-box-content">
                <span class="info-box-text"><a href=""  onclick="produtos_em_baixa()" style="color: inherit;">Produtos em baixa</a></span>
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
                      Database::desconectar();
                  }
                $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                $stmt = $pdo->query('SELECT * FROM usuarios');
                $row_count = $stmt->rowCount();
                foreach(range(0,$row_count -1) as $i){
                  if($i > 0){
                  echo '<br>';
                  }
                }
                  echo 'Quantidade:';
                  echo $contador;
                  ?> 
                </span>
          </div></div></div>
    </div>
    <!-- FINAL DAS CAIXAS DAS INFORMAÇÕES DO TOPO -->

<script type="text/javascript">/* POP UP INFORMANDO PRODUTOS EM BAIXA */
function produtos_em_baixa() {
    var js_array = confirm([<?php
     //echo '"'.implode('\n', $produtos_em_baixa ).'"';
      $arr = array();
      for ($index = 0; $index < count($produtos_em_baixa); $index++) {
          $arr[$index] = $produtos_em_baixa[$index]." | ".$tamanho_em_baixa[$index]." | ".$cor_em_baixa[$index]." | ".$quantidade_em_baixa[$index];
      }
      echo '"'.implode('\n', $arr ).'"';
      ?>]);
    }
</script>



<!-- =========================================INFORMAÇÕES DO ESTOQUE============================== -->           

    <div class="card collapsed-card "> 
    <div class="card-header "><h3 class="card-title">Informações do estoque </h3>
    <div class="card-tools">
    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
    </div>
    </div>
    <div class="card-body p-0">


              <?php  
                $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM informacoes ORDER BY informacao ASC';
  foreach($pdo->query($sql)as $row){

  if($row['confirmacao'] == 'pendente'){

    if($row['status'] == 'alerta'){
    echo '<div class="alert alert-danger alert-dismissible">
                  <form action="index.php" >
                  <input type="hidden" name="informacao" value="'.$row['informacao'].'">
                  <input type="hidden" name="status" value="'.$row['status'].'">
                  <input type="hidden" name="id_confirmacao" value="'.$row['id'].'">
                  <button  class="close" aria-hidden="true" type="submit" >&times;</button>
                  <h5><i class="icon fas fa-bell"></i>ALERTA | '.$row['informacao'].' | '.date( 'd-m-Y h:m' , strtotime( $row['data'] ) ).'</h5>
                </form></div>';
    }


    if($row['status'] == 'informacao'){
    echo '<div class="alert alert-info alert-dismissible">
                  <form action="index.php" >
                  <input type="hidden" name="informacao" value="'.$row['informacao'].'">
                  <input type="hidden" name="status" value="'.$row['status'].'">
                  <input type="hidden" name="id_confirmacao" value="'.$row['id'].'">
                  <button  class="close"  aria-hidden="true" type="submit" >&times;</button>
                  <h5><i class="icon fas fa-info"></i>INFORMAÇÃO | '.$row['informacao'].' | '.date( 'd-m-Y h:m' , strtotime( $row['data'] ) ).'</h5>
                </form></div>';
    }

    if($row['status'] == 'aviso'){
    echo '<div class="alert alert-warning alert-dismissible">
                  <form action="index.php" >
                  <input type="hidden" name="informacao" value="'.$row['informacao'].'">
                  <input type="hidden" name="status" value="'.$row['status'].'">
                  <input type="hidden" name="id_confirmacao" value="'.$row['id'].'">
                  <button class="close"  aria-hidden="true" type="submit" value="'.$row['id'].'">&times;</button>
                  <h5><i class="icon fas fa-exclamation-triangle"></i>AVISO | '.$row['informacao'].' | '.date( 'd-m-Y h:m' , strtotime( $row['data'] ) ).'</h5>
                </form></div>';
    }

    if($row['status'] == 'confirmacao'){
    echo '<div class="alert alert-success alert-dismissible">
                  <form action="index.php" >
                  <input type="hidden" name="informacao" value="'.$row['informacao'].'">
                  <input type="hidden" name="status" value="'.$row['status'].'">
                  <input type="hidden" name="id_confirmacao" value="'.$row['id'].'">
                  <button  class="close"  aria-hidden="true" type="submit" >&times;</button>
                  <h5><i class="icon fas fa-check"></i>CONFIRMAÇÃO | '.$row['informacao'].' | '.date( 'd-m-Y h:m' , strtotime( $row['data'] ) ).'</h5>
                </form></div>';
    }
  }
  Database::desconectar();
}
?>
 </div></div>  
<!-- ========================================= FIM DAS INFORMAÇÕES============================== -->



<!-- =========================================ATIVIDADE DOS USUARIOS============================== -->    
              <div class="card collapsed-card"> 
              <div class="card-header "><h3 class="card-title">Atividades dos usuários </h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
              </div>
              </div>
              <div class="card-body p-0">

              <?php  
                //require '../../../databases/database.php';
                $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                $sql = "SELECT usuario FROM usuarios";
                    foreach($pdo->query($sql)as $row){
                      $usuario = $row['usuario'];
                      echo '
                            <div class="card collapsed-card"> 
                              <div class="card-header alert-dark"><h3 class="card-title ">Atividades de '.ucfirst($row['usuario']).' </h3>
                                <div class="card-tools">
                                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">';
                      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                      $sql = "SELECT * FROM retiradas_$usuario ORDER BY id DESC limit 8";
                      foreach($pdo->query($sql)as $row){
                      echo '<li class="item">
                      <div class="product-img"> <img src="../../../assets/images/produtos/'.$row['imagem'].'" alt="Product Image" class="img-size-50"></div>
                      <div class="product-info"><a href="javascript:void(0)" class="product-title">'.$row['usuario'].' <span class="badge badge-warning float-right">'.(new DateTime($row['data_atual']))->format('d/m/Y H:i:s').'</span></a>
                        <span class="product-description">'.substr($row['produto'],0,999).' | Tamanho:'.$row['tamanho'].' | Cor:'.$row['cor'].' | Lote:'.$row['lote'].'| Quantidade:'.$row['quantidade'].'</span>
                      </div>
                      </li>';}       
                      echo '</ul></div></div>     ';
                    }
                     Database::desconectar();
                ?>


              <div class="card-footer text-center alert-primary">
                <a href="dashboard/consulta_saidas.php" class="uppercase " style="color: white;">Ver mais retiradas dos usuários...</a>
              </div></div></div>
            
<!-- ========================================= FIM DA ATIVIDADE DOS USUARIOS============================== -->
     



<!-- =========================================RETIRADAS SELECIONANDO DATA ============================== -->  
              <?php //se receber o perido selecionado mostra aberto, senao fechado
                if (isset($_GET['periodo'])) {
                  echo '<div class="card"> ';
                }else{
                  echo '<div class="card collapsed-card"> ';
                }
              ?>
   
              <div class="card-header "><h3 class="card-title">Verificar saída de produtos por período </h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
              </div>
              </div>
              <div class="card-body p-0">

              <form method="get" class="_form-inline"  action="">
                 
              <div class="row">
                      <div class="col-lg-3 col-6">      
                      <div class="  m-b-16" >
                      <div class="control-group  <?php echo !empty($tipo_produtoErro) ? 'error ' : ''; ?>">
                      <label >Funcionário:</label>
                       <div class="controls">
                        <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fas fa-user"></i>
                        </span>
                      </div>
                          <select class="form-control float-right" name="funcionario" id="funcionario" >
                              <option class="input100" value="selecione">Selecione o funcionário</option>
                              <?php 
                               $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                               $sql = "SELECT usuario FROM usuarios";
                               foreach($pdo->query($sql)as $row){
                                echo '<option class="input100" value="'.$row['usuario'].'">'.ucfirst($row['usuario']).'</option>';
                               }
                              ?>
                          </select>
                    </div></div></div></div></div>
                 
                    <!-- seleciona data com calendario -->
                    <div class="col-lg-3 col-6">
                      <label>Período:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="far fa-calendar-alt"></i>
                        </span>
                      </div>
                        <input type="text" class="form-control float-right" id="reservation" name="periodo">
                    </div></div> 

                    <!-- botao enviar consulta -->
                    <div class="col-lg-3 col-6">
                      <label></label>
                      <button type="submit" style="height: 38px; margin-top: 8px;"   class="btn btn-block btn-primary ">Consultar</button>
                  </div>

        </form>
</div></div>



<div class="card-body p-0">
  <ul class="products-list product-list-in-card pl-2 pr-2">

<?php 
if (isset($_GET['periodo'])) {
  $funcionario =  $_GET['funcionario'];
  $periodo =  $_GET['periodo'];
  
  $periodo1_ = explode("-",$periodo)[0];
  $dateTime1 = new DateTime($periodo1_);
  $periodo1 =  $dateTime1->format("Y-m-d");
  $data_a = strtotime($periodo1);
  echo 'Primeira data: '.date("m/d/Y", $data_a).'⠀⠀⠀⠀⠀⠀';

  $periodo2_ = explode("-",$periodo)[1];
  $dateTime2 = new DateTime($periodo2_);
  $periodo2 =  $dateTime2->format("Y-m-d");
  $data_b = strtotime($periodo2);
  echo 'Segunda data: '.date("m/d/Y", $data_b);



  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = "SELECT * FROM retiradas_$funcionario WHERE DATE_FORMAT(data_atual, '%Y-%m-%d') >= '$periodo1'   ";
  foreach($pdo->query($sql)as $row){

    if($row['data_atual'] <= $periodo2){



  echo '
  <li class="item">
        <div class="product-img"> <img src="../../../assets/images/produtos/'.$row['imagem'].'" alt="Product Image" class="img-size-50"></div>
        <div class="product-info"><a href="javascript:void(0)" class="product-title">'.$row['usuario'].' <span class="badge badge-warning float-right">'.(new DateTime($row['data_atual']))->format('d/m/Y H:i:s').'</span></a>
          <span class="product-description">'.substr($row['produto'],0,999).' | Tamanho:'.$row['tamanho'].' | Cor:'.$row['cor'].' | Lote:'.$row['lote'].'| Quantidade:'.$row['quantidade'].'</span>
        </div>
      </li>';
      //echo $periodo1;
          }

          }
  database::desconectar();


}
?>
<!-- ========================================= FIM RETIRADAS SELECIONANDO PERIODO ============================== -->     






</div></section>
 </div></div></div>
    <footer class="main-footer">
    <strong>Corporate Smart Control - v_1.0 - Copyright &copy; 2022</strong>
  </footer>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>




<!-- --------------------------------  JavaScript -------------------------------- -->





<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="../../../assets/js/bootstrap.min.js"></script>

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
<script src="../../../assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../../../assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../../../assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../../../assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../../../assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../../../assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../../../assets/plugins/moment/moment.min.js"></script>
<script src="../../../assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../../../assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../assets/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../../assets/customizar/customizar.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../../assets/js/pages/dashboard.js"></script>







<!-- Select2 -->
<script src="../../../assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../../assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../../assets/plugins/moment/moment.min.js"></script>
<script src="../../../assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="../../../assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../../assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../../assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="../../../assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>






<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>
</body>
</html>
<?php 
include_once('chat.php');
?>