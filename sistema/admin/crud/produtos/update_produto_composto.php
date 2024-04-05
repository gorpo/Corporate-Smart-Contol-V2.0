<!-- @Guilherme Paluch 2021 -->



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

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: produto_composto.php");
}

if (!empty($_POST) && ($_POST["submit"] != 'upload_imagem')) {

    $produtoErro = null;
    $tipo_produtoErro = null;
    $generoErro = null;
    $imagemErro = null;
    $referenciaErro = null;
    $corErro = null;
    $tamanhoErro = null;
    $codigo_barraErro = null;
    $valorErro = null;
    $loteErro = null;
    $quantidadeErro = null;

    $produto = $_POST['produto'];
    $tipo_produto = $_POST['tipo_produto'];
    $imagem = $_POST['imagem'];
    $referencia = $_POST['referencia'];
    $cor = $_POST['cor'];
    $tamanho = $_POST['tamanho'];
    $genero = $_POST['genero'];
    $codigo_barra = $_POST['codigo_barra'];
    $valor = $_POST['valor'];
    $lote = $_POST['lote'];
    $quantidade = $_POST['quantidade'];
    $cadastro =  date_create()->format('Y-m-d H:i:s');

    //Validação
    $validacao = true;
    if (empty($produto)) {
        $produtoErro = 'Por favor digite o produto!';
        $validacao = false;
    }

    if (empty($tipo_produto)) {
        $tipo_produtoErro = 'Por favor selecione o tipo doproduto!';
        $validacao = false;
    }

    if (empty($imagem)) {
        $imagemErro = 'Por favor digite o nome da imagem!';
        $validacao = false;
    }

    if (empty($referencia)) {
        $referenciaErro = 'Por favor digite o referencia!';
        $validacao = false;
    }

    if (empty($cor)) {
        $corErro = 'Por favor digite a cor!';
        $validacao = false;
    }

    if (empty($tamanho)) {
        $tamanhoErro = 'Por favor insira o tamanho!';
        $validacao = false;
    }


    if (empty($codigo_barra)) {
        $codigo_barraErro = 'Por favor insira o codigo_barra!';
        $validacao = false;
    }

    if (empty($valor)) {
        $valorErro = 'Por favor insira o valor!';
        $validacao = false;
    }

    if (empty($lote)) {
        $loteErro = 'Por favor insira o lote!';
        $validacao = false;
    }

    if (empty($quantidade)) {
        $quantidadeErro = 'Por favor insira o quantidade!';
        $validacao = false;
    }


    
    // update data somente desta forma pode ser passado ao PDO o NOW() para dar update no mysql(data) - ATENÇÃO, o data=now nao usa os =:
    if ($validacao) {
        $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE produtos set produto=:produto,tipo_produto=:tipo_produto, genero=:genero, imagem=:imagem, referencia=:referencia, cor=:cor, tamanho=:tamanho, codigo_barra=:codigo_barra, valor=:valor, lote=:lote, quantidade=:quantidade, data=now() WHERE id=:id";
        
        $q = $pdo->prepare($sql);
        
        $q->bindParam(':produto', $produto);
        $q->bindParam(':tipo_produto', $tipo_produto);
        $q->bindParam(':genero', $genero);
        $q->bindParam(':imagem', $imagem);
        $q->bindParam(':referencia', $referencia);
        $q->bindParam(':cor', $cor);
        $q->bindParam(':tamanho', $tamanho);
        $q->bindParam(':codigo_barra', $codigo_barra);
        $q->bindParam(':valor', $valor);
        $q->bindParam(':lote', $lote);
        $q->bindParam(':quantidade', $quantidade);
        $q->bindParam(':id', $id);
        $q->execute();
        database::desconectar();
        header("Location: produto_composto.php");
    }


} else {
    $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM produtos  where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $produto = $data['produto'];
    $imagem = $data['imagem'];
    $referencia = $data['referencia'];
    $cor = $data['cor'];
    $lote = $data['lote'];
    $tipo_produto = $data['tipo_produto'];
    $genero = $data['genero'];
    $tamanho = $data['tamanho'];
    $codigo_barra = $data['codigo_barra'];
    $valor = $data['valor'];
    $quantidade = $data['quantidade'];
    $data_atual = $data['data'];
    database::desconectar();
}

//---------------------------------------------------------------------------------------------------------------------
//================== FUNÇÃO UPLOAD DE IMAGEM | REDIMENSIONAMENTO | MARCA DAGUA TCXS ===================================
//--------------------------------------------------->>>
// CAMINHO PARA SALVAR A IMAGEM | CAMINHO DA MARCA DAGUA
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
            <h1 class="m-0">Atualizar Produto Tamanho Composto </h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
     


<! -- ================================================  CADASTRO DE PRODUTOS ================================================   -->

        <h3 class="tituloRed">[AVISO]<br>Atualizar: <?php echo $data['produto']; ?><br>Data Cadastro: <?php echo $data['data']; ?> </h3>
    <form class="form-horizontal" action="update_produto_composto.php?id=<?php echo $id ?>"  method="post"  autocomplete="off" enctype="multipart/form-data">



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
                            echo "<img class='tamanho_imagemUnico' src='../../../../assets/images/produtos/".$imagem."' >";
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
            <!-- =====   produto ======   style="margin-bottom: 20px;"-->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($produtoErro) ? 'error ' : ''; ?>">
            <label>Produto</label>
             <div class="controls">
            <input class="input100" type="text" name="produto" type="text" placeholder="<?php if (!empty($produtoErro)): echo $produtoErro; endif;?>" value="<?php echo !empty($produto) ? $produto : ''; ?>">
           
            </span>
          </div></div></div>

          <!-- =====   tipo de produto ======   -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($valorErro) ? 'error ' : ''; ?>">
            <label >Tipo</label>
             <div class="controls">
            <!-- <input class="input100" type="text" name="valor" type="text" placeholder="<?php if (!empty($valorErro)): echo $valorErro; endif;?>"value=""> -->
                <select class="input100" name="tipo_produto" id="tipo_produto" value="">
                    <option class="input100" value="<?php echo !empty($tipo_produto) ? $tipo_produto : ''; ?>"><?php echo !empty($tipo_produto) ? ucwords(str_replace("_"," ","$tipo_produto")) : ''; ?></option>
                    <option class="input100" value="camisa_fpu">Camisa FPU50+</option>
                    <option class="input100" value="camisa_repelente">Camisa Repelente</option>
                    <option class="input100" value="camisa_termica">Camisa Térmica</option>
                    <option class="input100" value="camisa_ciclismo">Camisa Ciclismo</option>
                    <option class="input100" value="lycra">Lycra</option>
                    <option class="input100" value="neolycra">Neolycra</option>
                    <option class="input100" value="bermuda">Bermuda</option>
                    <option class="input100" value="calca">Calça</option>
                    <option class="input100" value="jaqueta">Jaqueta</option>
                    <option class="input100" value="sapatilha">Sapatilha</option>
                    <option class="input100" value="float_adulto">Float Adulto</option>
                    <option class="input100" value="float_kids">Float Kids</option>
                    <option class="input100" value="colete_adulto">Colete Adulto</option>
                    <option class="input100" value="colete_kids">Colete Kids</option>
                </select>
           
            </span>
          </div></div></div>

          <!-- =====   genero ======   -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($valorErro) ? 'error ' : ''; ?>">
            <label >Gênero</label>
             <div class="controls">
                <select class="input100" name="genero" id="genero">
                    <option class="input100" value="<?php echo !empty($genero) ? $genero : ''; ?>">  <?php echo !empty($genero) ? ucwords(str_replace("_"," ","$genero")) : ''; ?></option>
                    <option class="input100" value="unisex">Unisex</option>
                    <option class="input100" value="masculino">Masculino</option>
                    <option class="input100" value="feminino">Feminino</option>
                    <option class="input100" value="infantil">Infantil</option>
                </select>
           
            </span>
          </div></div></div>


          <!-- =====   cor ======   -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($corErro) ? 'error ' : ''; ?>">
            <label >Cor</label>
             <div class="controls">
            <input class="input100" type="text" name="cor" type="text" placeholder="<?php if (!empty($corErro)): echo $corErro; endif;?>" value="<?php echo !empty($cor) ? $cor : ''; ?>">
           
            </span>
          </div></div></div>

          

          <!-- =====   quantidade ======   -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($quantidadeErro) ? 'error ' : ''; ?>">
            <label >Quantidade</label>
             <div class="controls">

            <input class="input100" type="text" name="quantidade" type="text" placeholder="<?php if (!empty($quantidadeErro)): echo $quantidadeErro; endif;?>" value="<?php 
            echo $quantidade ; ?>">
          </div></div></div>

          <!-- =====   tamanho ======   -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($tamanhoErro) ? 'error ' : ''; ?>">
            <label >Tamanho</label>
             <div class="controls">
                <select class="input100" name="tamanho" id="tamanho">
                    <option class="input100" value="<?php echo !empty($tamanho) ? $tamanho : ''; ?>">  <?php echo !empty($tamanho) ? ucwords(str_replace("_"," ","$tamanho")) : ''; ?></option>
                    <option class="input100" value="PP">PP</option>
                    <option class="input100" value="P">P</option>
                    <option class="input100" value="M">M</option>
                    <option class="input100" value="G">G</option>
                    <option class="input100" value="GG">GG</option>
                    <option class="input100" value="EG">EG</option>
                </select>
           
            </span>
          </div></div></div>


    </div>
    </div>


    <div class="site-center-col">
    <div class="site-center-col-inner">
            <!-- =====   referencia ======   -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($referenciaErro) ? 'error ' : ''; ?>">
            <label >Referência SKU</label>
             <div class="controls">
            <input class="input100" type="text" name="referencia" type="text" placeholder="<?php if (!empty($referenciaErro)): echo $referenciaErro; endif;?>" value="<?php echo !empty($referencia) ? $referencia : ''; ?>">
           
            </span>
          </div></div></div>

          <!-- =====   codigo_barra ======   -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($codigo_barraErro) ? 'error ' : ''; ?>">
            <label >Código Barra EAN13</label>
             <div class="controls">
                <input class="input100" type="text" name="codigo_barra" type="text" placeholder="<?php if (!empty($codigo_barraErro)): echo $codigo_barraErro; endif;?>" value="<?php echo !empty($codigo_barra) ? $codigo_barra : ''; ?>">
           
           
            </span>
          </div></div></div>

          <!-- =====   lote ======   -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($loteErro) ? 'error ' : ''; ?>">
            <label >Lote</label>
             <div class="controls">
            <input class="input100" type="text" name="lote" type="text" placeholder="<?php if (!empty($loteErro)): echo $loteErro; endif;?>" value="<?php echo !empty($lote) ? $lote : ''; ?>">
          </div></div></div>

          <!-- =====   valor ======   -->
          <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($valorErro) ? 'error ' : ''; ?>">
            <label >Valor</label>
             <div class="controls">
            <input class="input100" type="text" name="valor" type="text" placeholder="<?php if (!empty($valorErro)): echo $valorErro; endif;?>" value="<?php echo !empty($valor) ? $valor : ''; ?>">
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
    <button type="submit" class="botaoAdicionar m-b-16">Atualizar</button>
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
