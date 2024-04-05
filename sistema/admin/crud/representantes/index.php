
<!-- @Gorpo Orko - 2020 -->

<?php
session_start();
if(!$_SESSION['nome']) {
  header('Location: ../../index.php');
  exit();
}


//inclui o arquivo de conexao com banco de dados
include('../../../../databases/conexao.php');
$usuario = $_SESSION['nome'];



require '../../../../databases/database.php';
//Acompanha os erros de validação
//id titulo descricao content_id imagem_db imagem link
// Processar so quando tenha uma chamada post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imagemErro = null;
    $representanteErro = null;
    $nome_fantasiaErro = null;
    $cnpjErro = null;
    $inscricao_estadualErro = null;
    $emailErro = null;
    $telefoneErro = null;
    $enderecoErro = null;
    $cidadeErro = null;
    $estadoErro = null;
    $cepErro = null;

    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;

        if (!empty($_POST['imagem'])) {
            $imagem = $_POST['imagem'];
        } else {
            $imagemErro = 'Por favor digite o seu imagem!';
            $validacao = False;
        }

        if (!empty($_POST['representante'])) {
            $representante = $_POST['representante'];
        } else {
            $representanteErro = 'Por favor digite o seu representante!';
            $validacao = False;
        }

        if (!empty($_POST['nome_fantasia'])) {
            $nome_fantasia = $_POST['nome_fantasia'];
        } else {
            $nome_fantasiaErro = 'Por favor digite o seu nome_fantasia!';
            $validacao = False;
        }

        if (!empty($_POST['cnpj'])) {
            $cnpj = $_POST['cnpj'];
        } else {
            $cnpjErro = 'Por favor digite o seu cnpj!';
            $validacao = False;
        }

        if (!empty($_POST['inscricao_estadual'])) {
            $inscricao_estadual = $_POST['inscricao_estadual'];
        } else {
            $inscricao_estadualErro = 'Por favor digite o seu inscricao_estadual!';
            $validacao = False;
        }

        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
        } else {
            $emailErro = 'Por favor digite o seu email!';
            $validacao = False;
        }

        if (!empty($_POST['telefone'])) {
            $telefone = $_POST['telefone'];
        } else {
            $telefoneErro = 'Por favor digite o seu telefone!';
            $validacao = False;
        }

        if (!empty($_POST['endereco'])) {
            $endereco = $_POST['endereco'];
        } else {
            $enderecoErro = 'Por favor digite o seu endereco!';
            $validacao = False;
        }

        if (!empty($_POST['cidade'])) {
            $cidade = $_POST['cidade'];
        } else {
            $cidadeErro = 'Por favor digite o seu cidade!';
            $validacao = False;
        }

        if (!empty($_POST['estado'])) {
            $estado = $_POST['estado'];
        } else {
            $estadoErro = 'Por favor digite o seu estado!';
            $validacao = False;
        }

        if (!empty($_POST['cep'])) {
            $cep = $_POST['cep'];
        } else {
            $cepErro = 'Por favor digite o seu cep!';
            $validacao = False;
        }

    }

//Inserindo no database:
     if ($validacao) {
        $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO  representantes  (imagem, representante, nome_fantasia, cnpj, inscricao_estadual, email, telefone, endereco, cidade, estado, cep, data_atual) VALUES(?,?,?,?,?,?,?,?,?,?,?,NOW())";
        $q = $pdo->prepare($sql);
        $q->execute(array($imagem, $representante, $nome_fantasia, $cnpj, $inscricao_estadual, $email, $telefone, $endereco, $cidade, $estado, $cep));
        database::desconectar();


        $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE `representante_$representante`";
        $q = $pdo->prepare($sql);
        $q->execute();
        database::desconectar();





        header("Location: index.php");
    }
}


//---------------------------------------------------------------------------------------------------------------------
//================== FUNÇÃO UPLOAD DE IMAGEM | REDIMENSIONAMENTO | MARCA DAGUA TCXS ===================================
//--------------------------------------------------->>>
// CAMINHO PARA SALVAR A IMAGEM | CAMINHO DA MARCA DAGUA
$targetDir = "../../../../assets/images/representantes/"; 
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
if(isset($_POST["submit"])){ 
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
                $statusMsg = "Desculpe, ocorreu um erro ao enviar seu arquivo."; 
            } 
        }else{ 
            $statusMsg = 'Desculpe, apenas arquivos JPG, JPEG e PNG podem fazer upload.'; 
        } 
    }else{ 
        $statusMsg = 'Selecione um arquivo para fazer upload.'; 
    } 
}



//========= FUNÇÃO USADA PELA ETAPA DO DELETE ==================
//-------------------DELETA OS PRODUTOS --------------
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $representante = $_GET['representante'];
    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM representantes where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    database::desconectar();
    //DELETA A TABELA DO REPRESENTANTE CASO ELE SEJA DELETADO
    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DROP DATABASE representante_$representante";
    $q = $pdo->prepare($sql);
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
        <a href="" class="nav-link">Cadastro de Representantes</a>
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
            <h1 class="m-0">Cadastro de Representantes</h1>
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
     


<! -- ================================================  CADASTRO DE REPRESENTANTES ================================================   -->
<form class="form-horizontal" action="index.php" method="post"  autocomplete="off" enctype="multipart/form-data">
<div class="site-cols-wrapper">

    <div class="site-right-col">
    <div class="site-right-col-inner">
            <!-- =====   UPLOAD IMAGEM ======   -->
          <div class="  m-b-16" >
                    <div class="control-group " style="margin-top: 35px;">
                        <div class="controls">
                          <?php 
                            if (!$statusMsg){
                             // exibiria a imagem da marca dagua 
                            echo "<div class='inputUploadImagemUnico'>";
                            echo "<img class='tamanho_imagemUnico' src='../../../../assets/images/icon.png' >";
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

                            <input  class="login100-form-btn m-b-16" type="submit" name="submit" value="Upload"></div>
                       </span></div></div></div>
    </div></div>

    <div class="site-left-col">
    <div class="site-left-col-inner">

          <!-- =========================================   representante =============================================== -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($representanteErro) ? 'error ' : ''; ?>">
            <label>Nome do Representante</label>
             <div class="controls">
            <input class="input100" type="text" name="representante" type="text" placeholder="<?php if (!empty($representanteErro)): echo $representanteErro; endif;?>"value="">
          </div></div></div>

          <!-- =========================================   nome_fantasia =============================================== -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($nome_fantasiaErro) ? 'error ' : ''; ?>">
            <label>Nome Fantasia</label>
             <div class="controls">
            <input class="input100" type="text" name="nome_fantasia" type="text" placeholder="<?php if (!empty($nome_fantasiaErro)): echo $nome_fantasiaErro; endif;?>"value="">
          </div></div></div>

          <!-- =========================================   cnpj =============================================== -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($cnpjErro) ? 'error ' : ''; ?>">
            <label>CNPJ</label>
             <div class="controls">
            <input class="input100" type="text" name="cnpj" type="text" placeholder="<?php if (!empty($cnpjErro)): echo $cnpjErro; endif;?>"value="">
          </div></div></div>

          <!-- =========================================   inscricao_estadual =============================================== -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($inscricao_estadualErro) ? 'error ' : ''; ?>">
            <label>Inscrição Estadual</label>
             <div class="controls">
            <input class="input100" type="text" name="inscricao_estadual" type="text" placeholder="<?php if (!empty($inscricao_estadualErro)): echo $inscricao_estadualErro; endif;?>"value="">
          </div></div></div>

          <!-- =========================================   email =============================================== -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($emailErro) ? 'error ' : ''; ?>">
            <label>Email</label>
             <div class="controls">
            <input class="input100" type="text" name="email" type="text" placeholder="<?php if (!empty($emailErro)): echo $emailErro; endif;?>"value="">
          </div></div></div>
          <!-- =====   IMAGEM | pega as infos da função de upload e retorna se o status esta True o nome da imagem para por na DB======   -->
        <div class="  m-b-16" >
            <div class="control-group <?php echo !empty($imagemErro) ? 'error ' : ''; ?>">
                <label >Imagem </label>
                    <div class="controls">
                      <input readonly class="input100" name="imagem" type="text" placeholder="<?php if (!empty($imagemErro)): echo $imagemErro; endif;?>"
                          value="<?php 
                          if ($statusMsg){
                                  echo $fileName;
                                }else{
                                  echo !empty($imagem) ? $imagem : '';
                                }
                           ?>">
       </span></div></div></div>

    </div>
    </div>


    <div class="site-center-col">
    <div class="site-center-col-inner">

        <!-- =========================================   telefone =============================================== -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($telefoneErro) ? 'error ' : ''; ?>">
            <label>Telefone</label>
             <div class="controls">
            <input class="input100" type="text" name="telefone" type="text" placeholder="<?php if (!empty($telefoneErro)): echo $telefoneErro; endif;?>"value="">
          </div></div></div>

          <!-- =========================================   endereco =============================================== -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($enderecoErro) ? 'error ' : ''; ?>">
            <label>Endereço</label>
             <div class="controls">
            <input class="input100" type="text" name="endereco" type="text" placeholder="<?php if (!empty($enderecoErro)): echo $enderecoErro; endif;?>"value="">
          </div></div></div>

          <!-- =========================================   cidade =============================================== -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($cidadeErro) ? 'error ' : ''; ?>">
            <label>Cidade</label>
             <div class="controls">
            <input class="input100" type="text" name="cidade" type="text" placeholder="<?php if (!empty($cidadeErro)): echo $cidadeErro; endif;?>"value="">
          </div></div></div>

          <!-- =========================================   estado =============================================== -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($estadoErro) ? 'error ' : ''; ?>">
            <label>Estado</label>
             <div class="controls">
            <input class="input100" type="text" name="estado" type="text" placeholder="<?php if (!empty($estadoErro)): echo $estadoErro; endif;?>"value="">
          </div></div></div>

          <!-- =========================================   cep =============================================== -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($cepErro) ? 'error ' : ''; ?>">
            <label>CEP</label>
             <div class="controls">
            <input class="input100" type="text" name="cep" type="text" placeholder="<?php if (!empty($cepErro)): echo $cepErro; endif;?>"value="">
          </div></div></div>

    <div class="form-actions">
    <button type="submit" class="botaoAdicionar m-b-16">Adicionar</button>
    </div> 


    </div>
    </div>

</div>
</form>




<!-- ============================== TABELA DE REPRESENTANTES ==============================   -->

    <h3 > Representantes Cadastrados </h3>
<tbody>
<!-- -------------- CODIGO PHP DA PESQUISA E CRUD------------- -->
<?php
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$info = null;

  if(isset($_GET['buscar'])){
      $buscar = $_GET['buscar'];
      //se for numerico pega os dados do leitor de codigo, se nao for numerico pesquisa por nome do produto
      if (is_numeric($buscar)){
      $sql = $pdo->prepare("SELECT * FROM representantes WHERE  representante LIKE '%$buscar%' ");
  }else{
    $sql = $pdo->prepare("SELECT * FROM representantes WHERE  nome_fantasia LIKE '%$buscar%' ");
  }
      $sql->execute();
      $info = $sql->fetchAll();
  }
  if (is_array($info) || is_object($info))
{
    //sistema de pesquisa ------------------------------------------------------------------------------>
    foreach ($info as $key => $row) {
      echo '<table> <tr> <td class="preto">';
      echo '<img  class="caixa_imagem"  src="../../../../assets/images/representantes/'.$row['imagem'].'"/> </td></a>';
      echo '<td class="preto"> <p class="textoTabela">Representante:'.$row['representante'].'</p> ';
      echo '<p class="textoTabela">Nome Fantasia: '.$row['nome_fantasia'].'</p> ';
      echo '<p class="textoTabela">CNPJ: '.$row['cnpj'].'</p> ';
      echo '<p class="textoTabela">Inscrição Estadual: '.$row['inscricao_estadual'].'</p>';
      echo '<p class="textoTabela">Email: '.$row['email'].'</p> </td>';
      echo '<td class="preto">  <p class="textoTabela">Telefone: '.$row['telefone'].'</p>';
      echo '<p class="textoTabela">Endereço: '.$row['endereco'].'</p>';
      echo '<p class="textoTabela">Cidade: '.$row['cidade'].'</p> ';
      echo '<p class="textoTabela">Estado: '.$row['estado'].'</p> ';
      echo '<p class="textoTabela">CEP: '.$row['cep'].'</p> ';
      echo '<td  data-label="" class="preto">';
      echo ' ';
      echo '<a class="botaoIcones" title="Editar" href="update.php?id='.$row['id'].'"><i class="fas fa-pencil-square-o" aria-hidden="true" ></i></a>';
      echo ' ';
      echo '<a href=""  class="botaoIcones" title="Deletar" onclick="exclusao('.$row['id'].')" name="excluir" id="excluir" value="<?='.$row['id'].'?>" "><i class="fas fa-trash" aria-hidden="true"></i></a>';
      echo '</form>';
      echo '</td>';
      echo '</td> </tr> </table>  <br>';
  }   
}else{
  //sistema do CRUD ------------------------------------------------------------------------------>
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = $pdo->prepare("SELECT * FROM representantes");
  $sql->execute();
  $info = $sql->fetchAll();
  foreach($info as $key => $row)
  { echo '<table> <tr> <td class="preto">';
      echo '<img  class="caixa_imagem"  src="../../../../assets/images/representantes/'.$row['imagem'].'"/> </td></a>';
      echo '<td class="preto"> <p class="textoTabela">Representante:'.$row['representante'].'</p> ';
      echo '<p class="textoTabela">Nome Fantasia: '.$row['nome_fantasia'].'</p> ';
      echo '<p class="textoTabela">CNPJ: '.$row['cnpj'].'</p> ';
      echo '<p class="textoTabela">Inscrição Estadual: '.$row['inscricao_estadual'].'</p>';
      echo '<p class="textoTabela">Email: '.$row['email'].'</p> </td>';
      echo '<td class="preto">  <p class="textoTabela">Telefone: '.$row['telefone'].'</p>';
      echo '<p class="textoTabela">Endereço: '.$row['endereco'].'</p>';
      echo '<p class="textoTabela">Cidade: '.$row['cidade'].'</p> ';
      echo '<p class="textoTabela">Estado: '.$row['estado'].'</p> ';
      echo '<p class="textoTabela">CEP: '.$row['cep'].'</p> ';
      echo '<td  data-label="" class="preto">';
      echo ' ';
      echo '<a class="botaoIcones" title="Editar" href="update.php?id='.$row['id'].'"><i class="fas fa-pencil-square-o" aria-hidden="true" ></i></a>';
      echo ' ';
      echo '<a href=""  class="botaoIcones" title="Deletar" onclick="exclusao('.$row['id'].','.htmlspecialchars(json_encode($row['representante']), ENT_QUOTES, 'UTF-8').')" name="excluir" id="excluir" value="<?='.$row['id'].'?>" "><i class="fas fa-trash" aria-hidden="true"></i></a>';
      echo '</form>';
      echo '</td>';
      echo '</td> </tr> </table>  <br>';
  }
  Database::desconectar();
}
?>
</tbody>
</div>
</div></div></div></div>





<!-- --------------------------------  JavaScript -------------------------------- -->

<script type="text/javascript">/* Mensagem de Alerta ao excluir um registro */
function exclusao($id,$representante) {
    var msg = confirm("Atenção: Deseja Excluir o "+$representante+" do sistema?");
    if (msg){
        alert($representante +" excluído com sucesso!");
        window.location.href=("index.php?id="+$id+"&representante="+$representante);
    }
    else{
        alert("Operação Cancelada, "+$representante+" não será Excluído!");
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
</body>
</html>
<?php 
include_once('chat.php');
?>

<!--
CREATE TABLE IF NOT EXISTS representantes (
id int(11) NOT NULL AUTO_INCREMENT,
imagem varchar(300) DEFAULT NULL,
representante varchar(300) DEFAULT NULL,
nome_fantasia varchar(300) DEFAULT NULL,
cnpj varchar(300) DEFAULT NULL,
inscricao_estadual varchar(300) DEFAULT NULL,
email varchar(300) DEFAULT NULL,
telefone varchar(300) DEFAULT NULL,
endereco varchar(300) DEFAULT NULL,
cidade varchar(300) DEFAULT NULL,
estado varchar(300) DEFAULT NULL,
cep varchar(300) DEFAULT NULL,
data_atual datetime DEFAULT NULL,
PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
                   -->