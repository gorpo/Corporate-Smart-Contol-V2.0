
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
    $produtoErro = null;
    $imagemErro = null;
    $referenciaErro = null;
    $corErro = null;
    $tamanhoErro = null;
    $codigo_barraErro = null;
    $valorErro = null;
    $loteErro = null;
    $quantidadeErro = null;
    $data_atualErro = null;

    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;

        if (!empty($_POST['produto'])) {
            $produto = $_POST['produto'];
        } else {
            $produtoErro = 'Por favor digite o seu produto!';
            $validacao = False;
        }

        if (!empty($_POST['tipo_produto'])) {
            $tipo_produto = $_POST['tipo_produto'];
        } else {
            $tipo_produtoErro = 'Por favor selecione o tipo do produto!';
            $validacao = False;
        }

        if (!empty($_POST['genero'])) {
            $genero = $_POST['genero'];
        } else {
            $generoErro = 'Por favor selecione o genero!';
            $validacao = False;
        }


        if (!empty($_POST['imagem'])) {
            $imagem = $_POST['imagem'];
            $tamanho = 'Unico';
        } else {
            $imagemErro = 'Por favor envie uma imagem!';
            $validacao = False;
        }


       
        if (!empty($_POST['referencia'])) {
            $referencia = $_POST['referencia'];
        } else {
            $referenciaErro = 'Por favor digite a referencia SKU!';
            $validacao = False;
        }

        if (!empty($_POST['cor'])) {
            $cor = $_POST['cor'];
        } else {
            $corErro = 'Por favor digite a cor!';
            $validacao = False;
        }

       

       if (!empty($_POST['codigo_barra'])) {
            $codigo_barra = $_POST['codigo_barra'];
        } else {
            $codigo_barraErro = 'Por favor digite o codigo de barra EAN13!';
            $validacao = False;
        }

        if (!empty($_POST['valor'])) {
            $valor = $_POST['valor'];
        } else {
            $valorErro = 'Por favor digite o valor!';
            $validacao = False;
        }

        if (!empty($_POST['lote'])) {
            $lote = $_POST['lote'];
        } else {
            $loteErro = 'Por favor digite o lote!';
            $validacao = False;
        }

        if (!empty($_POST['quantidade'])) {
            $quantidade = $_POST['quantidade'];
        } else {
            $quantidadeErro = 'Por favor digite a quantidade!';
            $validacao = False;
        }
    }

//Inserindo no database:
     if ($validacao) {
        $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO  produtos  (produto,tipo_produto, genero, imagem, referencia, cor, tamanho, codigo_barra, valor, lote, quantidade, data) VALUES(?,?,?,?,?,?,?,?,?,?,?,NOW())";
        $q = $pdo->prepare($sql);
        $q->execute(array($produto, $tipo_produto, $genero, $imagem, $referencia, $cor, $tamanho, $codigo_barra, $valor,$lote, $quantidade));
        database::desconectar();
        header("Location: produtos_cadastrados.php");
    }
}


//================== FUNÇÃO UPLOAD DE IMAGEM | REDIMENSIONAMENTO | MARCA DAGUA  ===================================
$targetDir = "../../../../assets/images/produtos/"; 
$watermarkImagePath = '../assets/images/watermark.png'; 
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
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM produtos where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    database::desconectar();
    header("Location: produtos_cadastrados.php");
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
        <a href="" class="nav-link">Produtos Cadastrados</a>
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
            <h1 class="m-0">Produtos Cadastrados </h1>
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
     







<! -- ================================================  CADASTRO DE PRODUTOS ================================================   -->
<form class="form-horizontal" action="produtos_cadastrados.php"  autocomplete="off" enctype="multipart/form-data">
<div class="row" style="margin-bottom: 30px;">


          <!-- =====   tipo de produto ======   -->
          <div class="col" >
            <div class="control-group  <?php echo !empty($valorErro) ? 'error ' : ''; ?>">
             <div class="controls">
                <select class="input100" name="produtos_cadastrados" id="produtos_cadastrados" > <!-- onchange="submit();"> -->
                    <option class="input100" value="">Selecione o Tipo de Produto</option>
                    <?php  
                      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                      $sql = 'SELECT * FROM produtos ORDER BY tipo_produto ASC';
                      $array_tipo_produto = array();
                      foreach($pdo->query($sql)as $row){
                        if (in_array($row['tipo_produto'], $array_tipo_produto) ) {
                            
                        }else{
                            $array_tipo_produto[] = $row['tipo_produto'];
                             }
                      }
                      foreach ($array_tipo_produto as $key => $value) {
                          echo '<option class="input100" value="'.$value.'">'.ucwords( str_replace("_"," ",$value) ).'</option>';
                      }
                    ?>
                </select>
            </span>
          </div></div></div>



          <!-- =====   genero produto ======   -->
          <div class="col" >
            <div class="control-group  <?php echo !empty($valorErro) ? 'error ' : ''; ?>">
             <div class="controls">
                <select class="input100" name="genero_cadastrado" id="genero_cadastrado" > <!-- onchange="submit();"> -->
                    <option class="input100" value="">Selecione o Gênero</option>
                    <?php  
                      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                      $sql = 'SELECT * FROM produtos ORDER BY genero ASC';
                      $array_genero = array();
                      foreach($pdo->query($sql)as $row){
                        if (in_array($row['genero'], $array_genero) ) {
                            
                        }else{
                            $array_genero[] = $row['genero'];
                             }
                      }
                      foreach ($array_genero as $key => $value) {
                          echo '<option class="input100" value="'.$value.'">'.ucwords($value).'</option>';
                      }
                    ?>
                </select>
            </span>
          </div></div></div>


          <!-- =====   cor produto ======   -->
          <div class="col" >
            <div class="control-group  <?php echo !empty($valorErro) ? 'error ' : ''; ?>">
             <div class="controls">
                <select class="input100" name="cor_cadastrado" id="cor_cadastrado" > <!-- onchange="submit();"> -->
                    <option class="input100" value="">Selecione a Cor</option>
                    <?php  
                      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                      $sql = 'SELECT * FROM produtos ORDER BY cor ASC';
                      $array_cor = array();
                      foreach($pdo->query($sql)as $row){
                        if (in_array($row['cor'], $array_cor) ) {
                            
                        }else{
                            $array_cor[] = $row['cor'];
                             }
                      }
                      foreach ($array_cor as $key => $value) {
                          echo '<option class="input100" value="'.$value.'">'.ucwords($value).'</option>';
                      }
                    ?>
                </select>
            </span>
          </div></div></div>


          <!-- =====   tamanho produto ======   -->
          <div class="col" >
            <div class="control-group  <?php echo !empty($valorErro) ? 'error ' : ''; ?>">
             <div class="controls">
                <select class="input100" name="tamanho_cadastrado" id="tamanho_cadastrado" > <!-- onchange="submit();"> -->
                    <option class="input100" value="">Selecione o Tamanho</option>
                    <?php  
                      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                      $sql = 'SELECT * FROM produtos ORDER BY tamanho ASC';
                      $array_tamanho = array();
                      foreach($pdo->query($sql)as $row){
                        if (in_array($row['tamanho'], $array_tamanho) ) {
                            
                        }else{
                            $array_tamanho[] = $row['tamanho'];
                             }
                      }
                      foreach ($array_tamanho as $key => $value) {
                          echo '<option class="input100" value="'.$value.'">'.ucwords($value).'</option>';
                      }
                    ?>
                </select>
            </span>
          </div></div></div>


          <div class="col">
              <input class="botaoIcones" type="submit" value="Enviar">
          </div>



</div>
</form>













<!-- ============================== TABELA DE PRODUTOS ==============================   -->
<tbody>
<?php
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$info = null;

  if(isset($_GET['buscar'])){
      $buscar = $_GET['buscar'];
      //se for numerico pega os dados do leitor de codigo, se nao for numerico pesquisa por nome do produto
      if (is_numeric($buscar)){
      $sql = $pdo->prepare("SELECT * FROM produtos WHERE  codigo_barra LIKE '%$buscar%' ");
  }else{
    $sql = $pdo->prepare("SELECT * FROM produtos WHERE  produto LIKE '%$buscar%' ");
  }
      $sql->execute();
      $info = $sql->fetchAll();
  }
  if (is_array($info) || is_object($info))
{
    //sistema de pesquisa ------------------------------------------------------------------------------>
    foreach ($info as $key => $row) {
      echo '<table> <tr> <td class="preto">';
      echo '<img  class="caixa_imagem"  src="../../../../assets/images/produtos/'.$row['imagem'].'"/> </td></a>';
      echo '<td class="preto"> <p class="textoTabela">'.mb_strimwidth($row['produto'], 0 , 22, '...').'</p> ';
      echo '<p class="textoTabela">Referência SKU: '.$row['referencia'].'</p> ';
      echo '<p class="textoTabela">Cor: '.$row['cor'].'</p> ';
      echo '<p class="textoTabela">Tamanho: '.$row['tamanho'].'</p>';
      echo '<p class="textoTabela">Gênero: '.$row['genero'].'</p> ';
      echo '<p class="textoTabela">Tipo: '.$row['tipo_produto'].'</p> </td>';
      echo '<td class="preto"> <p class="textoTabela">Código EAN: '.$row['codigo_barra'].'</p> ';
      echo '<p class="textoTabela">Valor: '.$row['valor'].'</p> ';
      echo '<p class="textoTabela">Lote: '.$row['lote'].'</p> ';
      echo '<p class="textoTabela">Data: '.$row['data'].'</p> ';
      echo '<p class="textoTabela">Quantidade: '.$row['quantidade'].'</p> ';
      echo '<td  data-label="" class="preto">';

      echo '<form  action="aumenta_estoque_produtos_cadastrados.php"  >';
      echo '<input class="input100quantidademenor" type="number" id="quantidade" name="quantidade" min="-1000" max="999">';//envia a quantidade para reduzir do estoque
      echo '<input type="hidden" id="id" name="id" value="'.$row['id'].'">'; //envia a id - OBS: o input esta escondido(hidden)
      echo '<input type="hidden" id="buscar" name="buscar" value="'.$row['codigo_barra'].'">'; //envia o codigo de barra que quando retorna volta exibir o mesmo produto
      echo ' ';
      echo '<input class="botaoIcones" type="submit" value="Enviar">';
      echo ' ';
      echo '<br> ';
      echo '<a class="botaoIcones" title="Editar" href="update_produtos_cadastrados.php?id='.$row['id'].'"><i class="fas fa-pencil-square-o" aria-hidden="true" ></i></a>';
      echo ' ';
      echo '<a href=""  class="botaoIcones" title="Deletar" onclick="exclusao('.$row['id'].')" name="excluir" id="excluir" value="<?='.$row['id'].'?>" "><i class="fas fa-trash" aria-hidden="true"></i></a>';
      echo '</form>';
      echo '</td>';
      echo '</td> </tr> </table>  <br>';
  }   
}







elseif(isset($_GET['produtos_cadastrados'])){
    $produtos_cadastrados = $_GET['produtos_cadastrados'];
    $genero_cadastrado = $_GET['genero_cadastrado'];
    $cor_cadastrado = $_GET['cor_cadastrado'];
    $tamanho_cadastrado = $_GET['tamanho_cadastrado'];


   



    if ($produtos_cadastrados  != '' &&  $genero_cadastrado == '' &&  $cor_cadastrado == ''  && $tamanho_cadastrado == '' ) {
        $sql = $pdo->prepare("SELECT * FROM produtos WHERE  tipo_produto = '$produtos_cadastrados'");
        $sql->execute();
        $info = $sql->fetchAll();
        echo '<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pesquisa Selecionada: Produto</h3>
              </div>
              <div class="card-body">';
    }




    elseif ( $produtos_cadastrados  != '' &&  $genero_cadastrado != '' &&  $cor_cadastrado == ''  && $tamanho_cadastrado == '' ) {
        $sql = $pdo->prepare("SELECT * FROM produtos WHERE  tipo_produto = '$produtos_cadastrados' and genero = '$genero_cadastrado' ");
        $sql->execute();
        $info = $sql->fetchAll();
        echo '<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pesquisa Selecionada: Produto e Gênero</h3>
              </div>
              <div class="card-body">';
    }


   
    elseif ($produtos_cadastrados  != '' && $genero_cadastrado != '' &&  $cor_cadastrado != ''  && $tamanho_cadastrado == '' ) {
        $sql = $pdo->prepare("SELECT * FROM produtos WHERE  tipo_produto = '$produtos_cadastrados' and genero = '$genero_cadastrado'  and cor = '$cor_cadastrado'");
        $sql->execute();
        $info = $sql->fetchAll();
        echo '<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pesquisa Selecionada: Produto, Gênero e Cor</h3>
              </div>
              <div class="card-body">';
    }


    elseif ($produtos_cadastrados  != '' && $genero_cadastrado != '' &&  $cor_cadastrado != ''  && $tamanho_cadastrado != '' ) {
        $sql = $pdo->prepare("SELECT * FROM produtos WHERE  tipo_produto = '$produtos_cadastrados' and genero = '$genero_cadastrado'  and cor = '$cor_cadastrado' and tamanho = '$tamanho_cadastrado'  ");
        $sql->execute();
        $info = $sql->fetchAll();
        echo '<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pesquisa Selecionada: Produto, Gênero, Cor e Tamanho</h3>
              </div>
              <div class="card-body">';
    }

    //----------------------------------------------------------------------------------------------

    elseif ($produtos_cadastrados  != '' && $genero_cadastrado == '' &&  $cor_cadastrado != ''  && $tamanho_cadastrado == '' ) {
        $sql = $pdo->prepare("SELECT * FROM produtos WHERE  tipo_produto = '$produtos_cadastrados'  and cor = '$cor_cadastrado'  ");
        $sql->execute();
        $info = $sql->fetchAll();
        echo '<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pesquisa Selecionada: Produto e Cor</h3>
              </div>
              <div class="card-body">';
    }


    elseif ($produtos_cadastrados  != '' && $genero_cadastrado == '' &&  $cor_cadastrado == ''  && $tamanho_cadastrado != '' ) {
        $sql = $pdo->prepare("SELECT * FROM produtos WHERE  tipo_produto = '$produtos_cadastrados' and tamanho = '$tamanho_cadastrado'  ");
        $sql->execute();
        $info = $sql->fetchAll();
        echo '<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pesquisa Selecionada: Produto e Tamanho</h3>
              </div>
              <div class="card-body">';
    }


    elseif ($produtos_cadastrados  == '' && $genero_cadastrado != '' &&  $cor_cadastrado != ''  && $tamanho_cadastrado == '' ) {
        $sql = $pdo->prepare("SELECT * FROM produtos WHERE  genero = '$genero_cadastrado'  and cor = '$cor_cadastrado'   ");
        $sql->execute();
        $info = $sql->fetchAll();
        echo '<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pesquisa Selecionada: Gênero e Cor</h3>
              </div>
              <div class="card-body">';
    }

    elseif ($produtos_cadastrados  == '' && $genero_cadastrado != '' &&  $cor_cadastrado == ''  && $tamanho_cadastrado != '' ) {
        $sql = $pdo->prepare("SELECT * FROM produtos WHERE   genero = '$genero_cadastrado' and tamanho = '$tamanho_cadastrado'  ");
        $sql->execute();
        $info = $sql->fetchAll();
        echo '<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pesquisa Selecionada: Gênero e Tamanho</h3>
              </div>
              <div class="card-body">';
    }


    elseif ($produtos_cadastrados  == '' && $genero_cadastrado == '' &&  $cor_cadastrado != ''  && $tamanho_cadastrado != '' ) {
        $sql = $pdo->prepare("SELECT * FROM produtos WHERE  cor = '$cor_cadastrado' and tamanho = '$tamanho_cadastrado'  ");
        $sql->execute();
        $info = $sql->fetchAll();
        echo '<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pesquisa Selecionada: Tamanho e Cor</h3>
              </div>
              <div class="card-body">';
    }

    //-----------------------------------------------------------------

    elseif ($produtos_cadastrados  == '' && $genero_cadastrado != '' &&  $cor_cadastrado == ''  && $tamanho_cadastrado == '' ) {
        $sql = $pdo->prepare("SELECT * FROM produtos WHERE  genero = '$genero_cadastrado' ");
        $sql->execute();
        $info = $sql->fetchAll();
        echo '<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pesquisa Selecionada: Gênero</h3>
              </div>
              <div class="card-body">';
    }

    elseif ($produtos_cadastrados  == '' && $genero_cadastrado == '' &&  $cor_cadastrado != ''  && $tamanho_cadastrado == '' ) {
        $sql = $pdo->prepare("SELECT * FROM produtos WHERE  cor = '$cor_cadastrado'  ");
        $sql->execute();
        $info = $sql->fetchAll();
        echo '<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pesquisa Selecionada: Cor</h3>
              </div>
              <div class="card-body">';
    }

    elseif ($produtos_cadastrados  == '' && $genero_cadastrado == '' &&  $cor_cadastrado == ''  && $tamanho_cadastrado != '' ) {
        $sql = $pdo->prepare("SELECT * FROM produtos WHERE  tamanho = '$tamanho_cadastrado'  ");
        $sql->execute();
        $info = $sql->fetchAll();
        echo '<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pesquisa Selecionada: Tamanho</h3>
              </div>
              <div class="card-body">';
    }

//-------------------------------------------------------------------------------------------------------------------------------------------------
    


    foreach ($info as $key => $row){
        echo '<table> <tr> <td class="preto">';
      echo '<img  class="caixa_imagem"  src="../../../../assets/images/produtos/'.$row['imagem'].'"/> </td></a>';
      echo '<td class="preto"> <p class="textoTabela">'.mb_strimwidth($row['produto'], 0 , 22, '...').'</p> ';
      echo '<p class="textoTabela">Referência SKU: '.$row['referencia'].'</p> ';
      echo '<p class="textoTabela">Cor: '.$row['cor'].'</p> ';
      echo '<p class="textoTabela">Tamanho: '.$row['tamanho'].'</p> ';
      echo '<p class="textoTabela">Gênero: '.$row['genero'].'</p> ';
      echo '<p class="textoTabela">Tipo: '.$row['tipo_produto'].'</p> </td>';
      echo '<td class="preto"> <p class="textoTabela">Código EAN: '.$row['codigo_barra'].'</p> ';
      echo '<p class="textoTabela">Valor: '.$row['valor'].'</p> ';
      echo '<p class="textoTabela">Lote: '.$row['lote'].'</p> ';
      echo '<p class="textoTabela">Data: '.$row['data'].'</p> ';
      echo '<p class="textoTabela">Quantidade: '.$row['quantidade'].'</p> ';
      echo '<td  data-label="" class="preto">';

      echo '<form  action="aumenta_estoque_produtos_cadastrados.php"  >';
      echo '<input class="input100quantidademenor" type="number" id="quantidade" name="quantidade" min="-9991" max="999">';//envia a quantidade para reduzir do estoque
      echo '<input type="hidden" id="id" name="id" value="'.$row['id'].'">'; //envia a id - OBS: o input esta escondido(hidden)
      echo '<input type="hidden" id="buscar" name="buscar" value="'.$row['codigo_barra'].'">'; //envia o codigo de barra que quando retorna volta exibir o mesmo produto
      echo ' ';
      echo '<input class="botaoIcones" type="submit" value="Enviar">';
      echo ' ';
      echo '<br> ';
      echo '<a class="botaoIcones" title="Editar" href="update_produtos_cadastrados.php?id='.$row['id'].'"><i class="fas fa-pencil-square-o" aria-hidden="true" ></i></a>';
      echo ' ';
      echo '<a href=""  class="botaoIcones" title="Deletar" onclick="exclusao('.$row['id'].')" name="excluir" id="excluir" value="<?='.$row['id'].'?>" "><i class="fas fa-trash" aria-hidden="true"></i></a>';
      echo '</form>';
      echo '</td>';
      echo '</td> </tr> </table>  <br>';

    }
}else{
  //sistema do CRUD ------------------------------------------------------------------------------>
  echo '<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Todos os Produtos </h3>
              </div>
              <div class="card-body">';  
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM produtos ORDER BY produto ASC';
  foreach($pdo->query($sql)as $row)
  {
      echo '<table> <tr> <td class="preto">';
      echo '<img  class="caixa_imagem"  src="../../../../assets/images/produtos/'.$row['imagem'].'"/> </td></a>';
      echo '<td class="preto"> <p class="textoTabela">'.mb_strimwidth($row['produto'], 0 , 22, '...').'</p> ';
      echo '<p class="textoTabela">Referência SKU: '.$row['referencia'].'</p> ';
      echo '<p class="textoTabela">Cor: '.$row['cor'].'</p> ';
      echo '<p class="textoTabela">Tamanho: '.$row['tamanho'].'</p> ';
      echo '<p class="textoTabela">Gênero: '.$row['genero'].'</p> ';
      echo '<p class="textoTabela">Tipo: '.$row['tipo_produto'].'</p> </td>';
      echo '<td class="preto"> <p class="textoTabela">Código EAN: '.$row['codigo_barra'].'</p> ';
      echo '<p class="textoTabela">Valor: '.$row['valor'].'</p> ';
      echo '<p class="textoTabela">Lote: '.$row['lote'].'</p> ';
      echo '<p class="textoTabela">Data: '.$row['data'].'</p> ';
      echo '<p class="textoTabela">Quantidade: '.$row['quantidade'].'</p> ';
      echo '<td  data-label="" class="preto">';

      echo '<form  action="aumenta_estoque_produtos_cadastrados.php"  >';
      echo '<input class="input100quantidademenor" type="number" id="quantidade" name="quantidade" min="-9999" max="999">';//envia a quantidade para reduzir do estoque
      echo '<input type="hidden" id="id" name="id" value="'.$row['id'].'">'; //envia a id - OBS: o input esta escondido(hidden)
      echo '<input type="hidden" id="buscar" name="buscar" value="'.$row['codigo_barra'].'">'; //envia o codigo de barra que quando retorna volta exibir o mesmo produto
      echo ' ';
      echo '<input class="botaoIcones" type="submit" value="Enviar">';
      echo ' ';
      echo '<br> ';
      echo '<a class="botaoIcones" title="Editar" href="update_produtos_cadastrados.php?id='.$row['id'].'"><i class="fas fa-pencil-square-o" aria-hidden="true" ></i></a>';
      echo ' ';
      echo '<a href=""  class="botaoIcones" title="Deletar" onclick="exclusao('.$row['id'].')" name="excluir" id="excluir" value="<?='.$row['id'].'?>" "><i class="fas fa-trash" aria-hidden="true"></i></a>';
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
function exclusao($id) {
    var msg = confirm("Atenção: Deseja Excluir esse Registro?");
    if (msg){
        alert("Arquivo excluído com sucesso!");
        window.location.href=("produtos_cadastrados.php?id="+$id);
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
</body>
</html>
<?php 
include_once('chat.php');
?>
