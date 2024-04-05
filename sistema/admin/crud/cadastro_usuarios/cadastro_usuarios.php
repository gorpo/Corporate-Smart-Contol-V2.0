
<!-- @Gorpo Orko - 2020 -->

<?php
session_start();
$token = $_SESSION['token'];


if(!$_SESSION['nome']) {
  header('Location: ../../index.php');
  exit();
}

//inclui o arquivo de conexao com banco de dados
include('../../../../databases/conexao.php');
//require '../../../../databases/database.php';
$usuario = $_SESSION['nome'];

// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id');
    $nome = filter_input(INPUT_POST, 'nome');
    $sobrenome = filter_input(INPUT_POST, 'sobrenome');
    $usuario = filter_input(INPUT_POST, 'usuario');
    $telefone = filter_input(INPUT_POST, 'telefone');
    $email = filter_input(INPUT_POST, 'email');
    $imagem = filter_input(INPUT_POST, 'imagem');
    $senha = filter_input(INPUT_POST, 'senha');
    $nivel = filter_input(INPUT_POST, 'nivel');
} else if (!isset($id)) {
// Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $usuario = (isset($_GET["usuario"]) && $_GET["usuario"] != null) ? $_GET["usuario"] : "";
}

// Cria a conexão com o banco de dados
try {
     include('../../../../databases/database.php');
    $conexao = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
} catch (PDOException $erro) {
    echo "<p class=\"bg-danger\">Erro na conexão:" . $erro->getMessage() . "</p>";
}$pdo = Database::desconectar();



//verifica o email do cliente para por no usuario e identificar o login dele
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$email_sessao = $_SESSION['email'];
$sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = '$email_sessao'");
$sql->execute();
$info = $sql->fetchAll();
foreach($info as $key => $row){
    $email_cliente = $row['email_cliente'];
}$pdo = Database::desconectar();


// Bloco If que Salva os dados no Banco - atua como Create e Update
//==================================CADASTRA APENAS ADMINS E USUARIOS DO SISTEMA
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "" && $_REQUEST["nivel"] != "representante") {
    try {
        if ($id != "") {
            $stmt = $conexao->prepare("UPDATE usuarios SET nome=?, sobrenome=?, usuario=?, telefone=?, email=?,email_cliente=?, senha=?, nivel=?, cadastro=?, token=? WHERE id = ?");
            $stmt->bindParam(10, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO usuarios (nome, sobrenome, usuario, telefone, email, email_cliente,  senha, nivel, prazo, imagem, cadastro, token) VALUES (?, ?, ?, ?, ?, ?, ?,?, 'indeterminado', ? , NOW(), ?)");
        }
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $sobrenome);
        $stmt->bindParam(3, $usuario);
        $stmt->bindParam(4, $telefone);
        $stmt->bindParam(5, $email);
        $stmt->bindParam(6, $email_cliente);
        $stmt->bindParam(7, $senha);
        $stmt->bindParam(8, $nivel);
        $stmt->bindParam(9, $imagem);
        $stmt->bindParam(10 , $token);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                //insere o usuario no banco de dados do chat
                $pdo = Database::conectar($dbNome='csc_chat');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = $pdo->prepare("INSERT INTO `user_cpmvj` ( `user_first_name`, `user_last_name`, `user_email`, `user_password`, `user_image`, `user_status`,`user_datetime`, `user_verification_code`) VALUES 
                (?,?,?,?,?,?,now(),?);");
                $sql->execute(array( $nome, $sobrenome, $email, $senha, $imagem, 'Offline',  bin2hex(random_bytes(16))));
                $pdo = Database::desconectar();

                //cria o banco de dados das retiradas do usuario----------------
                  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $sql = $pdo->prepare("CREATE TABLE IF NOT EXISTS retiradas_$usuario (
                  id int(11) NOT NULL AUTO_INCREMENT,
                  usuario varchar(300) DEFAULT NULL,
                  produto varchar(300) DEFAULT NULL,
                  tipo_produto varchar(300) DEFAULT NULL,
                  genero varchar(300) DEFAULT NULL,
                  imagem varchar(300) DEFAULT NULL,
                  referencia varchar(300) DEFAULT NULL,
                  cor varchar(300) DEFAULT NULL,
                  tamanho varchar(300) DEFAULT NULL,
                  codigo_barra varchar(300) DEFAULT NULL,
                  lote varchar(300) DEFAULT NULL,
                  quantidade varchar(300) DEFAULT NULL,
                  data_atual datetime DEFAULT NULL,
                  PRIMARY KEY (id)
                   ) "); //ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;
                  $sql->execute();
                  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $sqla = $pdo->prepare("CREATE TABLE IF NOT EXISTS user_$usuario (id int NOT NULL AUTO_INCREMENT,usuario VARCHAR(300), senha VARCHAR(300), ip VARCHAR(70), data_atual datetime, cor VARCHAR(300),PRIMARY KEY (id) )");
                  $sqla->execute();


                  //envia o email
                header('Location: envia_email.php?email='.$email.'&nome='.$nome.' &token='.$token.' ');
                

            } else {
                echo "<p class=\"bg-danger\">Erro ao tentar efetivar cadastro</p>";
            }
        } else {
            echo "<p class=\"bg-danger\">Erro: Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p class=\"bg-danger\">Erro: " . $erro->getMessage() . "</p>";
    }
}




if(isset($_GET['envio'])){
    //limpa os campos para proximo cadastro
    $id = null;
    $nome = null;
    $sobrenome = null;
    $usuario = null;
    $telefone = null;
    $email = null;
    $imagem = null;
    $senha = null;
    $nivel = null;
    echo  "<script>alert('Email enviado com Sucesso!');</script>";
}


// Bloco If que Salva os dados no Banco - atua como Create e Update
//==================================CADASTRA APENAS REPRESENTANTES
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "" && $_REQUEST["nivel"] == "representante") {
    try {
        $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $sql = $pdo->prepare("CREATE TABLE IF NOT EXISTS `login_representantes` (
                  id int(11) NOT NULL AUTO_INCREMENT,
                  `usuario` varchar(200) NOT NULL,
                  `imagem` varchar(200) NOT NULL,
                  `senha` varchar(329) NOT NULL,
                  `nome` varchar(999) NOT NULL,
                  `cadastro` datetime NOT NULL,
                  `nivel` varchar(999) NOT NULL,
                  PRIMARY KEY (id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $sql->execute();

        if ($id != "") {
            $stmt = $conexao->prepare("UPDATE login_representantes SET nome=?, usuario=?,senha=?,cadastro=?, nivel=? WHERE id = ?");
            $stmt->bindParam(10, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO login_representantes (nome, usuario,imagem, senha,cadastro,nivel) VALUES (?, ?, ?, ?, NOW(),?)");
        }
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $usuario);
        $stmt->bindParam(3, $imagem);
        $stmt->bindParam(4, $senha);
        $stmt->bindParam(5, $nivel);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $sqla = $pdo->prepare("CREATE TABLE IF NOT EXISTS user_$usuario (id int NOT NULL AUTO_INCREMENT,usuario VARCHAR(300), senha VARCHAR(300), ip VARCHAR(70), data_atual datetime, cor VARCHAR(300),PRIMARY KEY (id) )");
                  $sqla->execute();
                //limpa os campos para proximo cadastro
                $id = null;
                $nome = null;
                $usuario = null;
                $imagem = null;
                $senha = null;
                $nivel = null;
            } else {
                echo "<p class=\"bg-danger\">Erro ao tentar efetivar cadastro</p>";
            }
        } else {
            echo "<p class=\"bg-danger\">Erro: Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p class=\"bg-danger\">Erro: " . $erro->getMessage() . "</p>";
    }
}



// Bloco if utilizado pela etapa Delete
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "" && $usuario != "" ) {
    try {
        $stmt = $conexao->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt2 = $conexao->prepare("DROP TABLE user_$usuario");
        $stmt2->bindParam(1, $usuario, PDO::PARAM_INT);
        if ($stmt->execute()) {
            //echo "<p class=\"tituloBranco\">Usuário $usuario removido com exito do sistema.</p>";
            $id = null;
        } else {
            echo "<p class=\"bg-danger\">Erro: Não foi possível executar a declaração sql</p>";
        }
        if ($stmt2->execute()) {
            //echo "<p class=\"tituloBranco\">Todos os dados de login e IP do usuário foram deletados.</p>";
            $usuario = null;
        } else {
            echo "<p class=\"tituloBranco\">Erro: Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        //echo "<p class=\"tituloBranco\">Usuário ainda não tinha logado no sistema, sem database de IP para deletar.</a>";
    }
}



// Bloco if utilizado pela etapa Delete
if (isset($_REQUEST["act2"]) && $_REQUEST["act2"] == "del2" && $id != "" && $usuario != "" ) {
    $stmt2 = $conexao->prepare("DROP TABLE user_$usuario");
        $stmt2->execute();
 
    try {
        echo $usuario;
        $stmt = $conexao->prepare("DELETE FROM login_representantes WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->execute()) {
            //echo "<p class=\"tituloBranco\">Usuário $usuario removido com exito do sistema.</p>";
            $id = null;
        } else {
            echo "<p class=\"bg-danger\">Erro: Não foi possível executar a declaração sql</p>";
        }
        if ($stmt2->execute()) {
            //echo "<p class=\"tituloBranco\">Todos os dados de login e IP do usuário foram deletados.</p>";
            $usuario = null;
        } else {
            echo "<p class=\"tituloBranco\">Erro: Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        //echo "<p class=\"tituloBranco\">Usuário ainda não tinha logado no sistema, sem database de IP para deletar.</a>";
    }
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
            <h1 class="m-0">Cadastro de Usuários</h1>
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
     


<! -- ================================================  CADASTRO DE USUARIOS ================================================   -->

 <form action="?act=save" method="POST" name="form1" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">


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
                            echo "<div class='inputUploadImagem'>";
                            echo "<img class='tamanho_imagem' src='../../../../assets/images/usuarios/user.jpg' >";
                            echo "</div>";
                            }else{
                              echo "<div class='inputUploadImagem'>";
                              echo "<img class='tamanho_imagem' src='$targetFilePath'>";
                              echo "</div>";
                            }
                            ?>
                            <div class="areaBotoesUpload">
                               <!-- GAMBIARRA PARA TIRAR O TEXTO DO BTN UPLOAD E ALICAR CSS  --->
                              <label  class="login100-form-btn m-b-16" for='selecao-arquivo' autofocus>Selecione uma imagem &#187;</label>
                              <input id='selecao-arquivo' type='file'  name="file" >
                            <input  class="login100-form-btn m-b-16" type="submit" name="submit" value="Upload"></div>
                       </div></div></div>
    </div></div>



  <div class="site-left-col">
  <div class="site-left-col-inner">

          <!-- =====   NOME ======   -->
          <div class=" m-b-16" >
            <div class="control-group  <?php echo !empty($tituloErro) ? 'error ' : ''; ?>">
            <label >NOME</label>
             <div class="controls">
            <input class="input100" type="text" name="nome" value="<?php
                                        echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
                                        ?>" class="form-control"/>
          </div></div></div>


          <!-- =====   SOBRENOME ======   -->
          <div class=" m-b-16" >
            <div class="control-group  <?php echo !empty($tituloErro) ? 'error ' : ''; ?>">
            <label >SOBRENOME</label>
             <div class="controls">
            <input class="input100" type="text" name="sobrenome" value="<?php
                                        echo (isset($sobrenome) && ($sobrenome != null || $sobrenome != "")) ? $sobrenome : '';
                                        ?>" class="form-control"/>
          </div></div></div>

          
          <!-- =====   EMAIL   ======   -->
          <div class=" m-b-16" >
            <div class="control-group  <?php echo !empty($tituloErro) ? 'error ' : ''; ?>">
            <label >EMAIL</label>
             <div class="controls">
            <input class="input100" type="text" name="email" value="<?php
                                        echo (isset($email) && ($email != null || $email != "")) ? $email : '';
                                        ?>" class="form-control"/>
          </div></div></div>


          <!-- =====   SENHA ======   -->
          <div class=" m-b-16" >
            <div class="control-group  <?php echo !empty($tituloErro) ? 'error ' : ''; ?>">
            <label >SENHA</label>
             <div class="controls">
            <input class="input100" type="text" name="senha" value="<?php
                                        echo (isset($senha) && ($senha != null || $senha != "")) ? $senha : '';
                                        ?>" class="form-control" />
          </div></div></div>

  </div></div>








  <div class="site-left-col">
  <div class="site-left-col-inner">
    <!-- =====   NÍVEL DE ACESSO ======   -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($nivelErro) ? 'error ' : ''; ?>">
            <label >NÍVEL DE ACESSO</label>
             <div class="controls">
                <select class="input100" name="nivel" id="nivel">
                    <option class="input100" value=""></option>
                    <option class="input100" value="user">Usuário</option>
                    <option class="input100" value="admin">Administrador</option>
                    <option class="input100" value="representante">Representante</option>
                </select>
          </div></div></div>

          <!-- =====   USUARIO ======   -->
          <div class=" m-b-16" >
            <div class="control-group  <?php echo !empty($tituloErro) ? 'error ' : ''; ?>">
            <label >USUÁRIO</label>
             <div class="controls">
            <input class="input100" type="text" name="usuario" value="<?php
                                        echo (isset($usuario) && ($usuario != null || $usuario != "")) ? $usuario : '';
                                        ?>" class="form-control" />
          </div></div></div>

          <!-- =====   TELEFONE ======   -->
          <div class=" m-b-16" >
            <div class="control-group  <?php echo !empty($tituloErro) ? 'error ' : ''; ?>">
            <label >TELEFONE</label>
             <div class="controls">
            <input class="input100" type="text" name="telefone" value="<?php
                                        echo (isset($telefone) && ($telefone != null || $telefone != "")) ? $telefone : '';
                                        ?>" class="form-control"/>
          </div></div></div>


          <!-- =====   IMAGEM | pega as infos da função de upload e retorna se o status esta True o nome da imagem para por na DB======   -->
        <div class="  m-b-16" >
            <div class="control-group <?php echo !empty($imagemErro) ? 'error ' : ''; ?>">
                <label >IMAGEM</label>
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
           <button type="submit" class="login100-form-btn ">Adicionar</button>
  </div></div>

</form></div>


        <div class="panel panel-default">
            <table class="table table-striped">
                <thead>
                    <tr>
                      <td class="coluna1" scope="col">ID</td>
                        <td class="coluna1" scope="col">NOME</td>
                        <td class="coluna1" scope="col">USUARIO</td>
                        <td class="coluna1" scope="col">SENHA</td>
                        <td class="coluna1" scope="col">CADASTRO</td>
                        <td class="coluna1" scope="col">NIVEL</td>
                        <td class="coluna1" scope="col">BANIR</td>
                    </tr>
                </thead>
                <tbody>


                    <?php
                    try {$stmt = $conexao->prepare("SELECT * FROM usuarios");
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    ?>
                    <tr>
                      <td class="coluna2" data-label="ID:"><?php echo $rs->id; ?></td>
                        <td class="coluna2" data-label="Nome:"><?php echo $rs->nome; ?></td>
                        <td class="coluna2" data-label="Usuário:"><?php echo $rs->usuario; ?></td>
                        <td class="coluna2" data-label="Senha:"><?php echo '*******'; ?></td>
                        <td class="coluna2" data-label="Cadastro:"><?php echo $rs->cadastro; ?></td>
                        <td class="coluna2" data-label="Nivel:"><?php echo $rs->nivel; ?></td>
                        <td  class="coluna2" data-label="Banir:">
                         <a href="?act=del&id=<?php echo $rs->id; ?>&usuario=<?php echo $rs->usuario; ?>" class="botaoIcones" ><i class="fas fa-trash " aria-hidden="true"></i> Banir Usuário</a>
                        </td>
                    </tr>
                    <?php
                        }
                        } else {
                            echo "Erro: Não foi possível recuperar os dados do banco de dados";
                        }
                        } catch (PDOException $erro) {
                            echo "Erro: " . $erro->getMessage();
                        }

                    ?>


                    <!--   ==================================== EXIBE OS REPRESENTANTES CADASTRADOS PARA USAR O SISTEMA - CASO QUEIRA OCULTAR SO DELETAR ABAIXO    --->
                    <?php
                    try {$stmt = $conexao->prepare("SELECT * FROM login_representantes");
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    ?>
                    <tr>
                      <td class="coluna2" data-label="ID:"><?php echo $rs->id; ?></td>
                        <td class="coluna2" data-label="Nome:"><?php echo $rs->nome; ?></td>
                        <td class="coluna2" data-label="Usuário:"><?php echo $rs->usuario; ?></td>
                        <td class="coluna2" data-label="Senha:"><?php echo '*******'; ?></td>
                        <td class="coluna2" data-label="Cadastro:"><?php echo $rs->cadastro; ?></td>
                        <td class="coluna2" data-label="Nivel:"><?php echo $rs->nivel; ?></td>
                        <td  class="coluna2" data-label="Banir:">
                         <a href="?act2=del2&id=<?php echo $rs->id; ?>&usuario=<?php echo $rs->usuario; ?>" class="botaoIcones" ><i class="fas fa-trash " aria-hidden="true"></i> Banir Usuário</a>
                        </td>
                    </tr>
                    <?php
                        }
                        } else {
                            echo "Erro: Não foi possível recuperar os dados do banco de dados";
                        }
                        } catch (PDOException $erro) {
                            echo "Erro: " . $erro->getMessage();
                        }

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
