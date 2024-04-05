
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
//-----------------------------------------------------------------------------------------------------------------




//-------------------DELETA OS PRODUTOS --------------
if(isset($_GET['deletar'])){
    $id = $_GET['deletar'];
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
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../../../assets/css/adminlte.min.css">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
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
          <h1 class="m-0">TABELAS EDITAVEIS</h1>
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
          <!------------------------Quantidade de Usuários Cadastrados---------------------->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1" type="button"  data-toggle="modal" data-target="#modal-usuarios"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Usuários Cadastrados</span>
                <span class="info-box-number"><?php
                $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                $sql = "SELECT * FROM usuarios";
                $contador_usuarios = 0;
                foreach($pdo->query($sql)as $row){
                  $contador_usuarios = $contador_usuarios +1;
              }database::desconectar();
              echo $contador_usuarios;
          ?> </span>
      </div>
  </div></div>






<! -- ================================================  CAIXA DE MODAL POPUP PARA INSERÇÃO DE NOVO USUARIO ================================================   -->
  <div class="modal fade" id="modal-usuarios">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Adicionar Usuário</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" action="index.php" method="post"  autocomplete="off" enctype="multipart/form-data">
            <div class="site-cols-wrapper">

                <!-- =====   IMAGEM | pega as infos da função de upload e retorna se o status esta True o nome da imagem para por na DB======   -->
                <div class="  m-b-16" >
                    <div class="control-group <?php echo !empty($imagemErro) ? 'error ' : ''; ?>">
                        <label >Imagem </label>
                        <div class="controls">
                          <input class="form-control" name="file" type="file" 
                          >
                      </span></div></div></div>
                       <!-- =====   NOME   ======   -->
                        <div class=" m-b-16" >
                          <div class="control-group  <?php echo !empty($tituloErro) ? 'error ' : ''; ?>">
                          <label >NOME EXIBIÇÃO</label>
                           <div class="controls">
                          <input class="form-control" type="text" name="nome" value="<?php
                                                      echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
                                                      ?>" class="form-control"/>
                        </div></div></div>


                        <!-- =====   USUARIO ======   -->
                        <div class=" m-b-16" >
                          <div class="control-group  <?php echo !empty($tituloErro) ? 'error ' : ''; ?>">
                          <label >USUARIO</label>
                           <div class="controls">
                          <input class="form-control" type="text" name="usuario" value="<?php
                                                      echo (isset($usuario) && ($usuario != null || $usuario != "")) ? $usuario : '';
                                                      ?>" class="form-control" />
                        </div></div></div>


                        <!-- =====   SENHA ======   -->
                        <div class=" m-b-16" >
                          <div class="control-group  <?php echo !empty($tituloErro) ? 'error ' : ''; ?>">
                          <label >SENHA</label>
                           <div class="controls">
                          <input class="form-control" type="text" name="senha" value="<?php
                                                      echo (isset($senha) && ($senha != null || $senha != "")) ? $senha : '';
                                                      ?>" class="form-control" />
                        </div></div></div>

                    
                <!-- =====   NÍVEL DE ACESSO ======   -->
                        <div class="  m-b-16" >
                          <div class="control-group  <?php echo !empty($nivelErro) ? 'error ' : ''; ?>">
                          <label >NÍVEL DE ACESSO</label>
                           <div class="controls">
                              <select class="form-control" name="nivel" id="nivel">
                                  <option class="form-control" value=""></option>
                                  <option class="form-control" value="user">Usuário</option>
                                  <option class="form-control" value="admin">Administrador</option>
                                  <option class="form-control" value="representante">Representante</option>
                              </select>
                        </div></div></div>


                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button  type="submit" class="btn btn-primary">Salvar</button>
                    </div>

                    </div>
                    </div>
                    </form>
    </div></div> </div>






































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













<!-- =========================================MODALS EXTERNOS E TABELA EDITAVEL PHP MYSQL ================================================ -->

<?php include('modal_cadastro_produtos.php'); ?>

<?php include('modal_tabela.php'); ?>

<!--   ----------------------------------------------       -->


</div></section></div></div></div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <strong>Corporate Smart Control - Copyright &copy; 2021.</strong>
  <div class="float-right d-none d-sm-inline-block">
    <b>Versão</b> 1.0.0
</div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
</aside>
</div>
<!-- --------------------------------  JavaScript -------------------------------- -->
<script type="text/javascript" src="jquery.tabledit.js"></script>
<!-- AdminLTE App -->
<script src="../../../../assets/js/adminlte.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php 
include_once('chat.php');
?>
