<!-- @Guilherme Paluch 2021 -->



<?php
session_start();
if(!$_SESSION['nome']) {
  header('Location: ../logout.php');
  exit();
}


//inclui o arquivo de conexao com banco de dados
include('../../../../databases/conexao.php');
require '../../../../databases/database.php';
$usuario = $_SESSION['nome'];

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: ../logout.php");
}

if (!empty($_POST) && ($_POST["submit"] != 'upload_imagem')) { 
    $nomeErro = null;
    $usuarioErro = null;
    $telefoneErro = null;
    $imagemErro = null;
    $emailErro = null;
    $senhaErro = null;
   

    $nome = $_POST['nome'];
    $usuario = $_POST['usuario'];
    $imagem = $_POST['imagem'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $cadastro =  date_create()->format('Y-m-d H:i:s');

    //Validação
    $validacao = true;
    if (empty($nome)) {
        $nomeErro = 'Por favor digite o nome!';
        $validacao = false;
    }

    if (empty($usuario)) {
        $usuarioErro = 'Por favor selecione o tipo donome!';
        $validacao = false;
    }

    if (empty($imagem)) {
        $imagemErro = 'Por favor digite o nome da imagem!';
        $validacao = false;
    }

    if (empty($email)) {
        $emailErro = 'Por favor digite o email!';
        $validacao = false;
    }

    if (empty($senha)) {
        $senhaErro = 'Por favor digite a senha!';
        $validacao = false;
    }
    
    // update data somente desta forma pode ser passado ao PDO o NOW() para dar update no mysql(data) - ATENÇÃO, o data=now nao usa os =:
    if ($validacao) {
        //altera os dados no banco de dados do usuario
        $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE usuarios set nome=:nome,usuario=:usuario, telefone=:telefone, imagem=:imagem, email=:email, senha=:senha WHERE id=:id";
        $q = $pdo->prepare($sql);
        $q->bindParam(':nome', $nome);
        $q->bindParam(':usuario', $usuario);
        $q->bindParam(':telefone', $telefone);
        $q->bindParam(':imagem', $imagem);
        $q->bindParam(':email', $email);
        $q->bindParam(':senha', $senha);
        $q->bindParam(':id', $id);
        $q->execute();
        database::desconectar($dbNome='csc_'.$_SESSION['email_cliente']);

        //altera os dados do banco de dados da homepage para login inicial
        $pdo = Database::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE usuarios set nome=:nome,usuario=:usuario, telefone=:telefone, imagem=:imagem, email=:email, senha=:senha WHERE id=:id";
        $q = $pdo->prepare($sql);
        $q->bindParam(':nome', $nome);
        $q->bindParam(':usuario', $usuario);
        $q->bindParam(':telefone', $telefone);
        $q->bindParam(':imagem', $imagem);
        $q->bindParam(':email', $email);
        $q->bindParam(':senha', $senha);
        $q->bindParam(':id', $id);
        $q->execute();
        database::desconectar();

        try{
        //altera a tabela user_ retiradas_
        $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $temp_nome = $_SESSION['usuario'];
        $sql = "RENAME TABLE user_$temp_nome TO user_$usuario, retiradas_$temp_nome TO retiradas_$usuario;";
        $q = $pdo->prepare($sql);
        $q->execute();
        database::desconectar($dbNome='csc_'.$_SESSION['email_cliente']);
    }catch (Exception $e) {
        //nada aqui
    }

        session_destroy();
        header("Location: edita_perfil.php");

    }


} else {
    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM usuarios  where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $nome = $data['nome'];
    $imagem = $data['imagem'];
    $email = $data['email'];
    $senha = $data['senha'];
    $usuario = $data['usuario'];
    $telefone = $data['telefone'];

    database::desconectar();
}

//---------------------------------------------------------------------------------------------------------------------
//================== FUNÇÃO UPLOAD DE IMAGEM | REDIMENSIONAMENTO | MARCA DAGUA TCXS ===================================
//--------------------------------------------------->>>
// CAMINHO PARA SALVAR A IMAGEM | CAMINHO DA MARCA DAGUA
$targetDir = "../../../../assets/images/usuarios/"; 
$watermarkImagePath = '../../../../assets/images/watermark_transparente.png'; 
// FUNÇAO RESPONSAVEL PELO REDIMENSINAMENTO 
function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    //-----ATENÇÃO --- ATENÇÃO -----ATENÇÃO --- ATENÇÃO-----ATENÇÃO --- ATENÇÃO-----ATENÇÃO --- ATENÇÃO
    //REMOVER A LINHA ERRO REPORTING PARA VOLTAR VER ERROS DO PHP
    error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
    //---------------------------------------------------------->>
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }

    $src = imagecreatefromjpeg($file);
    if (!$src){
           $src= imagecreatefromstring(file_get_contents($file));
        }

    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    return $dst;
}
//SETA STATUS DA MENSAGEM PARA SABER SE SUBIU E RETORNA OS DADOS
$statusMsg = ''; 
if(isset($_POST["submit"]) && ($_POST['submit'] == 'upload_imagem')){ 
    //echo $_POST["submit"];
    if(!empty($_FILES["file"]["name"])){ 
        // Caminho de upload de arquivo
        $fileName = basename($_FILES["file"]["name"]); 
        $targetFilePath = $targetDir . $fileName; 
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION); 
        // Permitir certos formatos de arquivo
        $allowTypes = array('jpg','png','jpeg'); 
        if(in_array($fileType, $allowTypes)){ 
            // Upload file to the server 
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
                // Carregue o carimbo e a foto para aplicar a marca d'água
                //echo $targetFilePath;
                 $im = resize_image($targetFilePath, 200, 200); 
            
                $watermarkImg = imagecreatefrompng($watermarkImagePath); 
                switch($fileType){ 
                    case 'jpg': 
                        $im = imagecreatefromjpeg($targetFilePath); 
                    case 'jpeg': 
                        $im = imagecreatefromjpeg($targetFilePath); 
                        break; 
                    case 'png': 
                        $im = imagecreatefrompng($targetFilePath); 
                        break; 
                    default: 
                        $im = imagecreatefromjpeg($targetFilePath); 
                } 
                // SETA AS MARGENS PARA A MARCA DAGUA PODENDO REALINHAR ELA
                $marge_right = 00; 
                $marge_bottom = 00;                  
                // PEGA O WIDHT E HEIGHT DA MARCA DAGUA
                $sx = imagesx($watermarkImg); 
                $sy = imagesy($watermarkImg);                 
                // Copie a imagem da marca d'água em nossa foto usando os deslocamentos de margem e
                // a largura da foto para calcular o posicionamento da marca d'água.
                //redimensiona a imagem 
                $im = imagescale($im,250,250);
                imagecopy($im, $watermarkImg, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($watermarkImg), imagesy($watermarkImg)); 
                // Salvar imagem e LIBERA A MEMORIA
                imagepng($im, $targetFilePath); 
                imagedestroy($im);      
                if(file_exists($targetFilePath)){ 
                    $statusMsg = "A imagem foi redimensionada e adicionada marca dagua com sucesso!"; 
                }else{ 
                    $statusMsg = "Upload da imagem falhou, tente novamete."; 
                }  
            }else{ 
                $statusMsg = "Desculpe, osenhareu um erro ao enviar seu arquivo."; 
            } 
        }else{ 
            $statusMsg = 'Desculpe, apenas arquivos JPG, JPEG e PNG podem fazer upload.'; 
        } 
    }else{ 
        $statusMsg = 'Selecione um arquivo para fazer upload.'; 
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
  <meta property="og:url" content="https://Corporatesmartcontrol.com/"/>
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
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" id="navbar_senha"> 
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
              <input class="form-control form-control-navbar" type="text" name="buscar" type="search" placeholder="Insira o nome ou o código de barras do nome" aria-label="Search">
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
            <h1 class="m-0">Atualizar Usuário </h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
     


<! -- ================================================  EDITAR PERFIL ================================================   -->

        <!-- <h3 class="tituloRed">[AVISO]<br>Atualizar: <?php echo $data['nome']; ?><br>Data Cadastro: <?php $data_db = strtotime($data['cadastro']); echo date('d/m/Y', $data_db) ?> </h3> -->
    

    <form class="form-horizontal" action="edita_perfil.php?id=<?php echo $id ?>"  method="post"  autocomplete="off" enctype="multipart/form-data">



<div class="site-cols-wrapper">

    <div class="site-right-col">
    <div class="site-right-col-inner">
            <!-- =====   UPLOAD IMAGEM ======   -->
          <div class=" m-b-16" >
                    <div class="control-group " style="margin-top: 35px;">

                        <div class="controls">
                          <?php 
                            if (!$statusMsg){
                             // exibiria a imagem da marca dagua 
                            echo "<div class='inputUploadImagemUnico'>";
                            echo "<img class='tamanho_imagemUnico' src='../../../../assets/images/usuarios/".$imagem."' >";
                            echo "</div>";
                            }else{
                              echo "<div class='inputUploadImagemUnico'>";
                              echo "<img class='tamanho_imagemUnico' src='$targetFilePath'>";
                              echo "</div>";
                            }
                            ?>
                            <div class="areaBotoesUpload">
                               <!-- GAMBIARRA PARA TIRAR O TEXTO DO BTN UPLOAD E ALICAR CSS  --->
                              <label  class="login100-form-btn m-b-16" for='selecao-arquivo' autofocus>Selecione uma imagem &#187;</label>
                              <input id='selecao-arquivo' type='file'  name="file" >

                            <input  class="login100-form-btn m-b-16" type="submit" name="submit" value="upload_imagem"></div>
                       </span></div></div></div>
    </div></div>


        <div class="site-left-col">
    <div class="site-left-col-inner">
            <!-- =====   nome ======   style="margin-bottom: 20px;"-->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($nomeErro) ? 'error ' : ''; ?>">
            <label>nome</label>
             <div class="controls">
            <input class="input100" type="text" name="nome" type="text" placeholder="<?php if (!empty($nomeErro)): echo $nomeErro; endif;?>" value="<?php echo !empty($nome) ? $nome : ''; ?>">
           
            </span>
          </div></div></div>

          <!-- =====   usuario ======   style="margin-bottom: 20px;"-->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($usuarioErro) ? 'error ' : ''; ?>">
            <label>usuario</label>
             <div class="controls">
            <input class="input100" type="text" name="usuario" type="text" placeholder="<?php if (!empty($usuarioErro)): echo $usuarioErro; endif;?>" value="<?php echo !empty($usuario) ? $usuario : ''; ?>">
           
            </span>
          </div></div></div>

          <!-- =====   senha ======   style="margin-bottom: 20px;"-->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($senhaErro) ? 'error ' : ''; ?>">
            <label>senha</label>
             <div class="controls">
            <input class="input100" type="text" name="senha" type="text" placeholder="<?php if (!empty($senhaErro)): echo $senhaErro; endif;?>" value="<?php echo !empty($senha) ? $senha : ''; ?>">
           
            </span>
          </div></div></div>

    </div>
    </div>


    <div class="site-center-col">
    <div class="site-center-col-inner">
            <!-- =====   email ======   -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($emailErro) ? 'error ' : ''; ?>">
            <label >E-mail</label>
             <div class="controls">
            <input class="input100" type="text" name="email" type="text" placeholder="<?php if (!empty($emailErro)): echo $emailErro; endif;?>" value="<?php echo !empty($email) ? $email : ''; ?>">
           
            </span>
          </div></div></div>

          <!-- =====   telefone ======   style="margin-bottom: 20px;"-->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($telefoneErro) ? 'error ' : ''; ?>">
            <label>telefone</label>
             <div class="controls">
            <input class="input100" type="text" name="telefone" type="text" placeholder="<?php if (!empty($telefoneErro)): echo $telefoneErro; endif;?>" value="<?php echo !empty($telefone) ? $telefone : ''; ?>">
           
            </span>
          </div></div></div>
          

           <!-- =====   IMAGEM | pega as infos da função de upload e retorna se o status esta True o nome da imagem para por na DB======   -->
        <div class="  m-b-16" >
            <div class="control-group <?php echo !empty($imagemErro) ? 'error ' : ''; ?>">
                <label >Imagem </label>
                    <div class="controls">
                      <input class="input100" name="imagem" type="text" placeholder="<?php if (!empty($imagemErro)): echo $imagemErro; endif;?>"
                          value="<?php 
                          if ($statusMsg){
                                  echo $fileName;
                                }else{
                                  echo !empty($imagem) ? $imagem : '';
                                }
                           ?>">
       </span></div></div></div>
       <div class="form-actions">
    <button type="submit" name="submit" class="botaoAdicionar m-b-16">Atualizar</button>
    </div> 


    </div>
    </div>


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
</body>
</html>
<?php 
include_once('chat.php');
?>
