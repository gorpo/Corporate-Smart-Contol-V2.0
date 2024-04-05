<!-- @Guilherme Paluch 2021 --><?php 
session_start();
if(!$_SESSION['nome']) {
  header('Location: ../../../../index.php');
  exit();
}

//inclui o arquivo de conexao com banco de dados
include('../../../../databases/conexao.php');



require '../../../../databases/database.php';
//Acompanha os erros de validação
//id informacao descricao content_id imagem_db imagem link
// Processar so quando tenha uma chamada post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $informacaoErro = null;

    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;
        if (!empty($_POST['informacao'])) {
            $informacao = $_POST['informacao'];
            $confirmacao = $_POST['confirmacao'];
            $status = $_POST['status'];
        } else {
            $informacaoErro = 'Por favor digite a informacao!';
            $validacao = False;
        }

    }
//---------------------------------------------------------------------------------------------------------------------
//Inserindo  na database:
    if ($validacao) {
        $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO informacoes (informacao,confirmacao,status,data) VALUES(?,?,?,NOW())";
        $q = $pdo->prepare($sql);
        $q->execute(array($informacao,$confirmacao,$status));
        database::desconectar();
        header("Location: informacoes.php");
    }
}



// Bloco if utilizado pela etapa Delete
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM informacoes where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    database::desconectar();
    header("Location: informacoes.php");
}




// Bloco if utilizado pela etapa das informações
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
  header("Location: informacoes.php");
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
      <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link">Usuários do Sistema</a>
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
            <h1 class="m-0">Informações aos Usuários</h1>
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
     


<! -- ================================================  CADASTRO DE INFORMAÇÕES ================================================   -->

    <form  action="informacoes.php" method="post"  autocomplete="off" enctype="multipart/form-data">
          <!-- =====   informacao ======   -->
           <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Insira a informação e marque um status</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="" style="width: 50%;height: 30px;margin-top: 3px; margin-right: 5%;">
                    <input class="input100" type="text" name="informacao" value="<?php
                                        echo (isset($informacao) && ($informacao != null || $informacao != "")) ? $informacao : '';
                                        ?>" class="form-control"/>
                  </div>
                  <div style="width: 15%;">
                    <div class="custom-control  custom-checkbox">
                            <input class="custom-control-input custom-control-input-info" type="checkbox" name="status" id="status" value="informacao" >
                            <label for="status" class="custom-control-label  text-info">Informação</label>
                            </div>

                            <div class="custom-control  custom-checkbox">
                            <input class="custom-control-input custom-control-input-success" type="checkbox" name="status" id="status2" value="confirmacao" >
                            <label for="status2" class="custom-control-label text-success">Confirmação</label>
                            </div>

                  </div>

                  <div style="width: 15%;">
                    <div class="custom-control  custom-checkbox">
                            <input class="custom-control-input custom-control-input-warning" type="checkbox" name="status" id="status3" value="aviso" >
                            <label for="status3" class="custom-control-label text-warning">Aviso</label>
                            </div>

                            <div class="custom-control  custom-checkbox">
                            <input class="custom-control-input custom-control-input-danger" type="checkbox" name="status" id="status4" value="alerta" >
                            <label for="status4" class="custom-control-label text-danger">Alerta</label>
                            </div>
                  </div>

                  <div style="width: 10%;;margin-top: 3px;">
                          <input type="hidden" name="confirmacao" value="pendente">
                          <button type="submit" class="login100-form-btn m-b-16 btn btn-primary" >Adicionar</button>
                  </div>

                </div>
              </div>
            </div>
    </form>






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
                  <form action="informacoes.php" >
                  <input type="hidden" name="informacao" value="'.$row['informacao'].'">
                  <input type="hidden" name="status" value="'.$row['status'].'">
                  <input type="hidden" name="id_confirmacao" value="'.$row['id'].'">
                  <button  class="close" aria-hidden="true" type="submit" >&times;</button>
                  <h5><i class="icon fas fa-bell"></i>ALERTA | '.$row['informacao'].' | '.date( 'd-m-Y h:m' , strtotime( $row['data'] ) ).'</h5>
                </form></div>';
    }


    if($row['status'] == 'informacao'){
    echo '<div class="alert alert-info alert-dismissible">
                  <form action="informacoes.php" >
                  <input type="hidden" name="informacao" value="'.$row['informacao'].'">
                  <input type="hidden" name="status" value="'.$row['status'].'">
                  <input type="hidden" name="id_confirmacao" value="'.$row['id'].'">
                  <button  class="close"  aria-hidden="true" type="submit" >&times;</button>
                  <h5><i class="icon fas fa-info"></i>INFORMAÇÃO | '.$row['informacao'].' | '.date( 'd-m-Y h:m' , strtotime( $row['data'] ) ).'</h5>
                </form></div>';
    }

    if($row['status'] == 'aviso'){
    echo '<div class="alert alert-warning alert-dismissible">
                  <form action="informacoes.php" >
                  <input type="hidden" name="informacao" value="'.$row['informacao'].'">
                  <input type="hidden" name="status" value="'.$row['status'].'">
                  <input type="hidden" name="id_confirmacao" value="'.$row['id'].'">
                  <button class="close"  aria-hidden="true" type="submit" value="'.$row['id'].'">&times;</button>
                  <h5><i class="icon fas fa-exclamation-triangle"></i>AVISO | '.$row['informacao'].' | '.date( 'd-m-Y h:m' , strtotime( $row['data'] ) ).'</h5>
                </form></div>';
    }

    if($row['status'] == 'confirmacao'){
    echo '<div class="alert alert-success alert-dismissible">
                  <form action="informacoes.php" >
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




        <div class="panel panel-default">
            <table class="table table-striped ">
                <thead>
              <tr>
                  <td class="coluna1" scope="col">ID</td>
                  <td class="coluna1" scope="col">INFORMAÇÃO</td>
                  <td class="coluna1" scope="col">STATUS</td>
                  <td class="coluna1" scope="col">CONFIRMAÇÃO</td>
                  <td class="coluna1" scope="col">DATA</td>
                  <td class="coluna1" scope="col">DELETAR</td>
              </tr>
          </thead>
                <tbody>
                    <?php
        //include '../../../../databases/database.php';
        $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
        $sql = 'SELECT * FROM informacoes ORDER BY id DESC';

        foreach($pdo->query($sql)as $row)
        {
            echo '<tr>'; 
            echo '<td class="coluna2" data-label="ID" scope="row">'. $row['id'] . '</td>';
            echo '<td class="coluna2" data-label="Informação">'. $row['informacao'] . '</td>';
            echo '<td class="coluna2" data-label="Informação">'. $row['status'] . '</td>';
            if ($row['confirmacao'] == 'executado') {
              echo '<td class="coluna2 text-success" data-label="Informação">'. $row['confirmacao'] . '</td>';
            }

            if ($row['confirmacao'] == 'pendente') {
              echo '<td class="coluna2 text-danger" data-label="Informação">'. $row['confirmacao'] . '</td>';
            }
            
            echo '<td class="coluna2" data-label="Data">'. $row['data'] . '</td>';
            echo '<td  class="coluna2" data-label="crud">';
            //echo ' ';
            //echo '<a class="botaoIcones" href="update.php?id='.$row['id'].'"><i class="fas fa-pencil-square-o" aria-hidden="true" ></i></a>';
            //echo ' ';
            echo '<a  class="botaoIcones" href="informacoes.php?id='.$row['id'].'"><i class="fas fa-trash" aria-hidden="true"></i></a>';
            echo '</td>';
            echo '</tr>';
        }
        database::desconectar();
        ?>
                </tbody>
            </table>
        </div>
    


     
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
        $('.site-right-col2').addClass('site-right-col-resized2');
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
        $('.site-center-col2').removeClass('site-center-col-resized2');
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
</body>

</html>
<?php 
include_once('chat.php');
?>