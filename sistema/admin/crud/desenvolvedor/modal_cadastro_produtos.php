<?php 




//--------------------ADICIONAR PRODUTOS-------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produtoErro = null;
    $imagemErro = null;
    $referenciaErro = null;
    $corErro = null;
    //$tamanhoErro = null;
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


        if (!empty($_FILES['file']['name'])) {
            $imagem = $_FILES['file']['name'];
 //================== FUNÇÃO UPLOAD DE IMAGEM | REDIMENSIONAMENTO | MARCA DAGUA  ===================================
            $targetDir = "../../../../assets/images/produtos/"; 
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


//-----------------------------------------------------------
} else {
    $imagemErro = 'Por favor envie uma imagem!';
    $validacao = False;
}
//--------------------------------------------------------------------------------------------------

if (!empty($_POST['tamanho'])) {
    $tamanho = $_POST['tamanho'];
} else {
    $imagemErro = 'Por favor envie tamanho!';
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
    header("Location: index.php");
}
}
?>

<! -- ================================================  CAIXA DE MODAL POPUP PARA INSERÇÃO DE NOVO PRODUTO ================================================   -->
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Adicionar Produto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
      <! -- ================================================  CADASTRO DE PRODUTOS ================================================   -->
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



    <!-- =====   produto ======   style="margin-bottom: 20px;"-->
    <div class="  m-b-16" >
    <div class="control-group  <?php echo !empty($produtoErro) ? 'error ' : ''; ?>">
    <label>Produto</label>
    <div class="controls">
        <input class="form-control" type="text" name="produto" type="text" placeholder="<?php if (!empty($produtoErro)): echo $produtoErro; endif;?>"value="">
    </div></div></div>

    <!-- =====   tipo de produto ======   -->
    <div class="  m-b-16" >
        <div class="control-group  <?php echo !empty($valorErro) ? 'error ' : ''; ?>">
            <label >Tipo</label>
            <div class="controls">
                <!-- <input class="form-control" type="text" name="valor" type="text" placeholder="<?php if (!empty($valorErro)): echo $valorErro; endif;?>"value=""> -->
                <select class="form-control" name="tipo_produto" id="tipo_produto">
                    <option class="form-control" value=""></option>
                    <option class="form-control" value="camisa_fpu">Camisa FPU50+</option>
                    <option class="form-control" value="camisa_repelente">Camisa Repelente</option>
                    <option class="form-control" value="camisa_termica">Camisa Térmica</option>
                    <option class="form-control" value="camisa_ciclismo">Camisa Ciclismo</option>
                    <option class="form-control" value="lycra">Lycra</option>
                    <option class="form-control" value="neolycra">Neolycra</option>
                    <option class="form-control" value="bermuda">Bermuda</option>
                    <option class="form-control" value="calca">Calça</option>
                    <option class="form-control" value="jaqueta">Jaqueta</option>
                    <option class="form-control" value="float_adulto">Float Adulto</option>
                    <option class="form-control" value="colete_adulto_homologado">Colete Adulto Homologado</option>
                    <option class="form-control" value="colete_adulto_eaf">Colete Adulto EAF</option>
                    <option class="form-control" value="colete_adulto_kite">Colete Adulto Kitesurf</option>
                    <option class="form-control" value="sapatilha">Sapatilha</option>
                    <option class="form-control" value="float_kids">Float Kids</option>
                    <option class="form-control" value="colete_kids">Colete Kids</option>
                    <option class="form-control" value="colete_kids_homologado">Colete Kids Homologado</option>
                </select>

            </span>
        </div></div></div>

        <!-- =====   genero ======   -->
        <div class="  m-b-16" >
            <div class="control-group  <?php echo !empty($valorErro) ? 'error ' : ''; ?>">
                <label >Gênero</label>
                <div class="controls">
                    <select class="form-control" name="genero" id="genero">
                        <option class="form-control" value=""></option>
                        <option class="form-control" value="unisex">Unisex</option>
                        <option class="form-control" value="masculino">Masculino</option>
                        <option class="form-control" value="feminino">Feminino</option>
                        <option class="form-control" value="infantil">Infantil</option>
                    </select>

                </span>
            </div></div></div>


            <!-- =====   cor ======   -->
            <div class="  m-b-16" >
                <div class="control-group  <?php echo !empty($corErro) ? 'error ' : ''; ?>">
                    <label >Cor</label>
                    <div class="controls">
                        <input class="form-control" type="text" name="cor" type="text" placeholder="<?php if (!empty($corErro)): echo $corErro; endif;?>"value="">

                    </span>
                </div></div></div>


                <!-- =====   genero ======   -->
                <div class="  m-b-16" >
                    <div class="control-group  <?php echo !empty($tamanhoErro) ? 'error ' : ''; ?>">
                        <label >Tamanho</label>
                        <div class="controls">
                            <select class="form-control" name="tamanho" id="tamanho">
                                <option class="form-control" value=""></option>
                                <option class="form-control" value="unico">Unico</option>
                                <option class="form-control" value="pp">PP</option>
                                <option class="form-control" value="p">P</option>
                                <option class="form-control" value="m">M</option>
                                <option class="form-control" value="g">G</option>
                                <option class="form-control" value="gg">GG</option>
                                <option class="form-control" value="eg">EG</option><option class="form-control" value="17_18">17_18</option>
                                <option class="form-control" value="2 Anos">2 Anos</option>
                                <option class="form-control" value="4 Anos">4 Anos</option>
                                <option class="form-control" value="6 Anos">6 Anos</option>
                                <option class="form-control" value="8 Anos">8 Anos</option>
                                <option class="form-control" value="17_18">17_18</option>
                                <option class="form-control" value="19_20">19_20</option>
                                <option class="form-control" value="21_22">21_22</option>
                                <option class="form-control" value="23_24">23_24</option>
                                <option class="form-control" value="25_26">25_26</option>
                                <option class="form-control" value="27_28">27_28</option>
                                <option class="form-control" value="29_30">29_30</option>
                                <option class="form-control" value="31_32">31_32</option>
                                <option class="form-control" value="33_34">33_34</option>
                                <option class="form-control" value="35_36">35_36</option>
                            </select>

                        </span>
                    </div></div></div>
                    <!-- =====   quantidade ======   -->
                    <div class="  m-b-16" >
                        <div class="control-group  <?php echo !empty($quantidadeErro) ? 'error ' : ''; ?>">
                            <label >Quantidade</label>
                            <div class="controls">
                                <input class="form-control" type="text" name="quantidade" type="text" placeholder="<?php if (!empty($quantidadeErro)): echo $quantidadeErro; endif;?>"value="">
                        </div></div></div>
                        <!-- =====   referencia ======   -->
                        <div class="  m-b-16" >
                            <div class="control-group  <?php echo !empty($referenciaErro) ? 'error ' : ''; ?>">
                                <label >Referência SKU</label>
                                <div class="controls">
                                    <input class="form-control" type="text" name="referencia" type="text" placeholder="<?php if (!empty($referenciaErro)): echo $referenciaErro; endif;?>"value="">
                            </div></div></div>
                            <!-- =====   codigo_barra ======   -->
                            <div class="  m-b-16" >
                                <div class="control-group  <?php echo !empty($codigo_barraErro) ? 'error ' : ''; ?>">
                                    <label >Código Barra EAN13</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="codigo_barra" type="text" placeholder="<?php if (!empty($codigo_barraErro)): echo $codigo_barraErro; endif;?>"value="">
                                </div></div></div>
                                <!-- =====   lote ======   -->
                                <div class="  m-b-16" >
                                    <div class="control-group  <?php echo !empty($loteErro) ? 'error ' : ''; ?>">
                                        <label >Lote</label>
                                        <div class="controls">
                                            <input class="form-control" type="text" name="lote" type="text" placeholder="<?php if (!empty($loteErro)): echo $loteErro; endif;?>"value="">
                                        </span>
                                    </div></div></div>
                                    <!-- =====   valor ======   -->
                                    <div class="  m-b-16" >
                                        <div class="control-group  <?php echo !empty($valorErro) ? 'error ' : ''; ?>">
                                            <label >Valor</label>
                                            <div class="controls">
                                                <input class="form-control" type="text" name="valor" type="text" placeholder="<?php if (!empty($valorErro)): echo $valorErro; endif;?>"value="">
                                            </span>
                                        </div></div></div>
                                        <div class="modal-footer justify-content-between">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                              <button  type="submit" class="btn btn-primary">Salvar</button>
                                          </div>
                                    </div>
                                    </div>
                                </form>
                            </div></div> </div>