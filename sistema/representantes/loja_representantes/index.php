<?php
session_start();
if(!$_SESSION['nome']) {
  header('Location: index.php');
  exit();
}
//inclui o arquivo de conexao com banco de dados
include('../../databases/conexao.php');
require '../../databases/database.php';

$usuario = $_SESSION['nome'];
$representante =  $_SESSION['nome'];


if(isset($_GET['quantidade'])){

$filtro = $_GET['filtro']  ;
$idprod =  $_GET['id']; 
$produto =  $_GET['produto'];    
$tipo_produto =  $_GET['tipo_produto'];
$genero =  $_GET['genero'];
$imagem =  $_GET['imagem'];
$referencia =  $_GET['referencia'];
$cor =  $_GET['cor'];
$tamanho =  $_GET['tamanho'];
$codigo_barra =  $_GET['codigo_barra'];
$valor =  $_GET['valor'];
$lote =  $_GET['lote'];
$quantidade =  $_GET['quantidade'];  
$representante = $_GET['representante']; 



//seta os itens com fetchall
$pdo = Database::conectar();
$sth = $pdo->prepare("SELECT * FROM produtos WHERE id= '$idprod'");
$sth->execute();
$items = $sth->fetchAll(\PDO::FETCH_ASSOC);
//print_r($items);


//seta o contador como zero para os indices do array()
$idproduto =  0;
foreach ($items as $key => $value) {        
              if($value['id'] == $idprod){
                 //faz a validaçao passando o indice 
                 if (isset($items[$idproduto])) {
      //verifica se algum produto ja foi inserido no array, caso nao ele usa o valor zero para o indice e vai para o else para inserir o primeiro produto
      //caso primeiro produto tenha ja sido inserido ele  executa o if somando a quantidade de arrays + 1 para passar o novo indice para gravação na $_SESSION           
      if(isset($_SESSION['carrinho'][$idproduto])){
        //soma a quantidade de arrays + 1 para definir a proxima gravação no array
        $idproduto = count($_SESSION['carrinho']) +1;
        $_SESSION['carrinho'][$idproduto] = array( 'id'=>$idprod, 'produto'=>$produto,  'tipo_produto'=>$tipo_produto, 'genero'=>$genero, 'imagem'=>$imagem, 'referencia'=>$referencia, 'cor'=>$cor, 'tamanho'=>$tamanho, 'codigo_barra'=>$codigo_barra, 'valor'=>$valor, 'lote'=>$lote, 'quantidade'=>$quantidade);
      }else{
        $_SESSION['carrinho'][$idproduto] = array( 'id'=>$idprod, 'produto'=>$produto,  'tipo_produto'=>$tipo_produto, 'genero'=>$genero, 'imagem'=>$imagem, 'referencia'=>$referencia, 'cor'=>$cor, 'tamanho'=>$tamanho, 'codigo_barra'=>$codigo_barra, 'valor'=>$valor, 'lote'=>$lote, 'quantidade'=>$quantidade);
      }
      //echo '<script>alert("o item foi adicionado ao carrinho");</script>';
    }else{
      die('voce nao pode adicionar algo q nao existe');
                }
}
echo '<div id="snackbar">Produto adicionado no carrinho..</div> 

<script language="javascript" type="text/javascript">
    function f_mostra() {
  // Get the snackbar DIV
  var x = document.getElementById("snackbar");
  // Add the "show" class to DIV
  x.className = "show";
  // After 3 seconds, remove the show class from DIV
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
  window.location.href = "index.php?representante='.$representante.'&filtro='.$filtro.'" +"#rolar_aqui";
    }
</script>

<script language="javascript" type="text/javascript">
    f_mostra();
</script>';
}


//------CRIA A TABELA DA COMPRA
  $nome_db = date('Y_m_d_H');        
  $pdo = Database::conectar();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "CREATE TABLE IF NOT EXISTS `carrinho_representante_$representante` (
    `id` mediumint(9) NOT NULL AUTO_INCREMENT,
    `produto` varchar(200) NOT NULL,
    `tipo_produto` varchar(200) NOT NULL,
    `genero` varchar(200) NOT NULL,
    `imagem` varchar(329) NOT NULL,
    `referencia` varchar(999) NOT NULL,
    `cor` varchar(329) NOT NULL,
    `tamanho` varchar(999) NOT NULL,
    `codigo_barra` varchar(999) NOT NULL,
    `valor` varchar(999) NOT NULL,
    `lote` varchar(999) NOT NULL,
    `quantidade` varchar(999) NOT NULL,
    `pago` varchar(999) NOT NULL,
    `data` datetime NOT NULL,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
  $q = $pdo->prepare($sql);
  $q->execute();
database::desconectar();

}

//--------------------pega os valores gravados no array $_SESSION para gravar no banco de dados
if (isset($_GET['sair'])) {
  $produto_array = array();
  $tipo_produto_array = array();
  $genero_array = array();
  $imagem_array = array();
  $referencia_array = array();
  $cor_array = array();
  $tamanho_array = array();
  $codigo_barra_array = array();
  $valor_array = array();
  $lote_array = array();
  $quantidade_array = array();

  if(isset($_SESSION['carrinho'])){
     foreach ($_SESSION['carrinho'] as $key => $value) {
       $produto_array[] = $_SESSION['carrinho'][$key]['produto'];
       $tipo_produto_array[] = $_SESSION['carrinho'][$key]['tipo_produto'];
       $genero_array[] = $_SESSION['carrinho'][$key]['genero'];
       $imagem_array[] = $_SESSION['carrinho'][$key]['imagem'];
       $referencia_array[] = $_SESSION['carrinho'][$key]['referencia'];
       $cor_array[] = $_SESSION['carrinho'][$key]['cor'];
       $tamanho_array[] = $_SESSION['carrinho'][$key]['tamanho'];
       $codigo_barra_array[] = $_SESSION['carrinho'][$key]['codigo_barra'];

       $valor_array[] = str_replace(",",".",$_SESSION['carrinho'][$key]['valor']);

       $lote_array[] = $_SESSION['carrinho'][$key]['lote'];
       $quantidade_array[] = $_SESSION['carrinho'][$key]['quantidade'];

     }
   }
//------INSERE OS DADOS DO PEDIDO DO REPRESETANTE NA TABELA CRIADA
$pdo = Database::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT INTO carrinho_representante_$representante  (produto,tipo_produto, genero, imagem, referencia, cor, tamanho, codigo_barra, valor, lote, quantidade, pago, data) VALUES(?,?,?,?,?,?,?,?,?,?,?,'nao',NOW())";
$q = $pdo->prepare($sql);
$q->execute(array(implode(",",$produto_array), implode(",",$tipo_produto_array), implode(",",$genero_array), implode(",",$imagem_array), implode(",",$referencia_array), implode(",",$cor_array), implode(",",$tamanho_array), implode(",",$codigo_barra_array), implode(",",$valor_array),implode(",",$lote_array), implode(",",$quantidade_array)));
database::desconectar();
header('Location: envia_email.php');
}


//------REMOVE ITENS USANDO O INDICE DA $_SESSION['carrinho']
if(isset($_GET['remove_item'])){
  $indice = $_GET['remove_item'];
  unset($_SESSION['carrinho'][$indice]);
  //cart-drawer-btn
 echo '
<script language="javascript" type="text/javascript">
window.setTimeout(function () {
    document.querySelector("#btn1").click()
}, 200);


</script>
';
}
 

?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta property="og:site_name" content="VOPEN"/>
  <meta property="og:title" content="VOPEN"/>
  <meta property="og:url" content="https://vopen.com.br/"/>
  <meta property="og:description" content="Sistema de administração VOPEN"/>
  <meta property="og:image" content="../../assets/images/logo.svg"/>
  <link rel="shortcut icon" href="../../assets/images/icon.png" />
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a80232805f.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>VOPEN | Loja Representantes</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <!-- CSS DO CARRINHO -->
    <link rel="stylesheet" href="assets/css/carrinho.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">


</head>
  <body>
    <!-- Header ============================================  MENUS =================================================-->
    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="#"><img class="" src="../../assets/images/logo.svg" height="30" ></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>


        <?php  
            if(isset($_GET['filtro'])){
              echo '<script>
                    $(document).ready(function(){
                      $("#'.$_GET['filtro'].'").click(function(){
                        // alert("button clicked");
                        });
                        // set time out 2 sec
                      setTimeout(function(){
                        $("#'.$_GET['filtro'].'").trigger("click");
                        }, 0);
                        });
                    </script>';
            }
            ?>

            
          <div class="collapse navbar-collapse filters" id="navbarResponsive">
            <ul class="navbar-nav ">
              <li class="nav-item" data-filter="*">
                <a class="nav-link" href="#rolar_aqui">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li> 

                <div class="dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Náutica</a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="margin-top: -4px;">
                  <a class="dropdown-item" href="#rolar_aqui" ><li data-filter=".bermuda">Bermuda</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".calca">Calça</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".jaqueta">Jaqueta</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".lycra">Lycra</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".neolycra">Neolycra</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".colete_adulto_homologado">Colete Adulto Homologado</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".colete_adulto_eaf">Colete Adulto EAF</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".colete_adulto_kite">Colete Adulto Kite</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".float_adulto">Float Adulto</li></a>
                </div></div>

              

                <div class="dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Camisetas</a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="margin-top: -4px;">
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".fpu">FPU50+</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".repelente">Repelente</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".termica">Térmica</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".ciclismo">Ciclismo</li></a>
                </div></div>

                <div class="dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Infantil</a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="margin-top: -4px;">
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".float_kids">Float Kids</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".colete_kids_homologado">Colete Kids Homologado</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".colete_kids">Colete Kids</li></a>
                  <a class="dropdown-item" href="#rolar_aqui"><li data-filter=".sapatilha">Sapatilha</li></a>
                </div></div>

                <a class="nav-link" href="logout.php">Logout</a>
  

                <?php 
              if(isset($_SESSION['carrinho'])){
                echo '<a class="nav-link cart-drawer-btn" href="#" style="margin-left: 100px;" id="btn1"><i class="fas fa-shopping-cart"></i>Carrinho | Produtos:'.count($_SESSION['carrinho']).'</a>';
                //echo '<li class="nav-item cart-drawer-btn nav-link" style="margin-left: 100px;" id="btn1"> <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i>Carrinho | Produtos:'.count($_SESSION['carrinho']).'</a></li> ';
              }else{
                echo '<a class="nav-link cart-drawer-btn" href="#" style="margin-left: 100px;" id="btn1"><i class="fas fa-shopping-cart"></i>Carrinho</a>';
              }
              ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>

                  <?php //EXIBE O CARRINHO NO CANTO DIREITO DA TELA ACOMPANHANDO ROLAGEM ----------------------------------------------------------------
                  if(isset($_SESSION['carrinho'])){

                  echo '<a class="nav-link cart-drawer-btn" href="#" style="position: fixed;  bottom: 0px; font-size:12pt; color: black; right: 0px;z-index:99;" id="btn1"><i class="fas fa-shopping-cart"></i>Carrinho | Produtos:'.count($_SESSION['carrinho']).'<span id="php_code"> </span></a>';
                  }else{
                  echo '<a class="nav-link cart-drawer-btn" href="#" style="margin-left: 100px;" id="btn1"><i class="fas fa-shopping-cart"></i>Carrinho</a>';
                  }
                  ?>



  <div class="cart-drawer cart-drawer-right" id="teste"> 
  <h1 style="color: white;">Carrinho de compras</h1>
  <div class="shopping-cart">
      <h1>⠀⠀⠀⠀</h1>
<div class="column-labels">
  <label class="product-image" style="color: white;">Imagem</label>
  <label class="product-details" style="color: white;">Produto</label>
  <label class="product-price" style="color: white;">Preço</label>
  <label class="product-quantity" style="color: white;">Quantidade</label>
  <label class="product-removal" style="color: white;">Remover</label>
  <label class="product-line-price" style="color: white;">Total</label>
</div>


  <?php 
  if(isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])){

          $total = array();
          
         foreach ($_SESSION['carrinho'] as $key => $value) {
           //echo $_SESSION['carrinho'][$key]['produto'];
           $preco = str_replace (",", ".", $_SESSION['carrinho'][$key]['valor']);
           $quantidade = (int)$_SESSION['carrinho'][$key]['quantidade'];
           $total[] = $preco * $quantidade;
           $total_unitario = $preco * $quantidade;

           echo '     
            <div class="product">
              <div class="product-image">
                <img src="../../assets/images/produtos/'.$_SESSION['carrinho'][$key]['imagem'].'">
              </div>
              <div class="product-details">
                <div class="product-description">'.$_SESSION['carrinho'][$key]['produto'].'</div>
                <p class="product-description">Tamanho:'.$_SESSION['carrinho'][$key]['tamanho'].'</p>
                <p class="product-description">Cor:'.$_SESSION['carrinho'][$key]['cor'].'</p>
                <p class="product-description">Referência: '.$_SESSION['carrinho'][$key]['referencia'].'</p>
              </div>
              <div class="product-price">'.$_SESSION['carrinho'][$key]['valor'].'</div>
              <div class="product-quantity">
                <input disabled type="text" value="'.$_SESSION['carrinho'][$key]['quantidade'].'"  style="min-width: 65px;">
              </div>

              <div class="product-removal">
                <button class="remove-product"><a href="?remove_item='.$key.'" style="color: inherit;">Remover</a></button>
              </div>

              <div class="product-line-price" style="color: white;">'.number_format($total_unitario, 2, '.', '').'</div>
            </div>
            ';
         }

         //calcula a porcentagem mais o valor final do carrinho
         $porcento = number_format(array_sum ( $total), 2, '.', '')/100*5;
         $total_final = number_format(array_sum ( $total), 2, '.', '')/100*5 + number_format(array_sum ( $total), 2, '.', '');
         echo '
         <div class="totals">
  <div class="totals-item">
    <label>Subtotal</label>
    <div class="totals-value" id="cart-subtotal" style="color: white;">'.number_format(array_sum ( $total), 2, '.', '').'</div>
  </div>
  <div class="totals-item">
    <label>Tax (5%)</label>
    <div class="totals-value" id="cart-tax" style="color: white;">'.number_format($porcento, 2, '.', '').'</div>
  </div>
  <div class="totals-item">
    <label>Total</label>
    <div class="totals-value" id="cart-shipping" style="color: white;">'.number_format($total_final, 2, '.', '').'</div>
  </div>
  
</div><button class="checkout"><a href="?confirma" style="color: inherit;">Checkout</a></button></div>
  <div class="cart-drawer-close-btn" style="color: white">Fechar X</div>
</div>';

       }else{//CASO NAO TENHA SIDO CRIADA UMA SESSAO PARA O CARRINHO
             //É APENAS EXIBIDO UM HTML SEM NADA COM UM BOTAO VERMELHO 
        echo '
        <div class="totals">
  <div class="totals-item">
    <label>Subtotal</label>
    <div class="totals-value" id="cart-subtotal" style="color: white;">00.00</div>
  </div>
  <div class="totals-item">
    <label>Tax (5%)</label>
    <div class="totals-value" id="cart-tax" style="color: white;">00.00</div>
  </div>
  <div class="totals-item">
    <label>Transporte</label>
    <div class="totals-value" id="cart-shipping" style="color: white;">00.00</div>
  </div>
  <div class="totals-item totals-item-total">
    <label>Total</label>
    <div class="totals-value" id="cart-total" style="color: white;">00.00</div>
  </div>
</div>
  <button class="checkout_vazio">Carrinho Vazio</button>
</div>
  <div class="cart-drawer-close-btn" style="color: white">
  fechar X
  </div>
</div>';
       }



//===============BANNER DE POP UP FINALIZANDO A COMPRA ---------->>
if(isset($_GET['confirma'])){
  echo '<div class="fundo">
  <div class="pop-up open">
  <div class="content">
    <div class="container">
      <div class="title">
        <h1>Obrigado pela compra</h1>
      </div>
      <div class="subscribe">
        <h1><b>Recebemos seu pedido.<br>Assim que confirmarmos seu pagamento enviaremos imediatamente seu pedido!<br>Um email com seu pedido foi enviado.</b>.</h1>
       </div>
          <button class="checkout_sair"><a href="?sair" style="color: inherit;">Clique aqui para sair</a></button>
      </div> </div>
    </div>
  </div>
</div></div>';
//desabilita o scroll
echo "<script>window.onscroll = function () { window.scrollTo(0, 0); };</script>";
}
  ?>




    <!-- ================================= BANNER ================================= -->
     <img class="img-fluid" src="assets/images/products-heading.jpg" alt=""> 
  

    <!-- ================================= PÁGINA ================================= -->
    <div class="products">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="filters">
              <ul >
                  <li id="todos" data-filter="*">Todos Produtos</li>
                  <li id="fpu" data-filter=".fpu">FPU50+</li>
                  <li id="repelente" data-filter=".repelente">Repelente</li>
                  <li id="termica" data-filter=".termica">Térmica</li>
                  <li id="ciclismo" data-filter=".ciclismo">Ciclismo</li>
                  <li id="bermuda" data-filter=".bermuda">Bermuda</li>
                  <li id="calca" data-filter=".calca">Calça</li>
                  <li id="jaqueta" data-filter=".jaqueta">Jaqueta</li>
                  <li id="lycra" data-filter=".lycra">Lycra</li>
                  <li id="neolycra" data-filter=".neolycra">Neolycra</li>
                  <li id="float_adulto" data-filter=".float_adulto">Float Adulto</li>
                  <li id="colete_adulto_homologado" data-filter=".colete_adulto_homologado">Colete Adulto Homologado</li>
                  <li id="colete_adulto_eaf" data-filter=".colete_adulto_eaf">Colete Adulto EAF</li>
                  <li id="colete_adulto_kite" data-filter=".colete_adulto_kite">Colete Adulto Kite</li>
                  <li id="float_kids" data-filter=".float_kids" >Float Kids</li>
                  <li id="colete_kids_homologado" data-filter=".colete_kids_homologado">Colete Kids Homologado</li>
                  <li id="colete_kids" data-filter=".colete_kids">Colete Kids</li>
                  <li id="sapatilha" data-filter=".sapatilha">Sapatilha</li>
              </ul>
            </div>
          </div>




            
 







  
  










          <div id="rolar_aqui"></div>
          <div class="col-md-12">
            <div class="filters-content">
                <div class="row grid">

                      <!-- ===============================  CAMISETA FPU50+ =========================================-->
              <div class="tab-pane all fpu" id="camiseta_fpu" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'camisa_fpu'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="fpu">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->

              <!-- ===============================  CAMISETA REPELENTE =========================================-->
              <div class="tab-pane all repelente" id="camiseta_repelente" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'camisa_repelente'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="repelente">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->

              <!-- ===============================  CAMISETA TERMICA =========================================-->
              <div class="tab-pane all termica" id="camiseta_termica" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'camisa_termica'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="termica">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->

              <!-- ===============================  CAMISETA CICLISMO =========================================-->
              <div class="tab-pane all ciclismo" id="camiseta_ciclismo" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'camisa_ciclismo'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="ciclismo">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->

              <!-- ===============================  Bermuda =========================================-->
              <div class="tab-pane all bermuda" id="bermuda" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'bermuda'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="bermuda">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->

              <!-- ===============================  CALÇA =========================================-->
              <div class="tab-pane all calca" id="calca" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'calca'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="calca">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->

              <!-- ===============================  JAQUETA =========================================-->
              <div class="tab-pane all jaqueta" id="jaqueta" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'jaqueta'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="jaqueta">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->

              <!-- ===============================  Lycra =========================================-->
              <div class="tab-pane all lycra" id="lycra" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'lycra'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="lycra">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->

              <!-- ===============================  NEOLYCRA =========================================-->
              <div class="tab-pane all neolycra" id="neolycra" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'neolycra'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="neolycra">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->


              <!-- ===============================  FLOAT ADULTO =========================================-->
              <div class="tab-pane all float_adulto" id="float_adulto" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'float_adulto'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="float_adulto">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->


              <!-- ===============================  COLETE ADULTO HOMOLOGADO =========================================-->
              <div class="tab-pane all colete_adulto_homologado" id="colete_adulto_homologado" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_adulto_homologado'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="colete_adulto_homologado">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->


              <!-- ===============================  COLETE ADULTO EAF =========================================-->
              <div class="tab-pane all colete_adulto_eaf" id="colete_adulto_eaf" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_adulto_eaf'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="colete_adulto_eaf">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->

              <!-- ===============================  COLETE ADULTO KITE =========================================-->
              <div class="tab-pane all colete_adulto_kite" id="colete_adulto_kite" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_adulto_kite'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="colete_adulto_kite">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->






                  
                <!-- ===============================  FLOAT KIDS =========================================-->
              <div class="tab-pane all float_kids" id="float_kids" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'float_kids'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="float_kids">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->




                <!-- ===============================  COLETE KIDS HOMOLOGADO =========================================-->
              <div class="tab-pane all colete_kids_homologado" id="colete_kids_homologado" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_kids_homologado'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="colete_kids_homologado">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->

                <!-- ===============================  COLETE KIDS  =========================================-->
              <div class="tab-pane all colete_kids" id="colete_kids" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'colete_kids'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="colete_kids">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->


              <!-- ===============================  SAPATILHA =========================================-->
              <div class="tab-pane all sapatilha" id="sapatilha" style="margin-left: 100px;">
            <div class="post">
                <div class="row">
                  <?php  
                  
                    $pdo = Database::conectar();
                    $sql = "SELECT * FROM produtos WHERE tipo_produto = 'sapatilha'";
                    foreach($pdo->query($sql)as $row){
                    echo '
                      <div class="col-sm-4" style="margin-bottom: 100px;">
                      <img src="../../assets/images/produtos/'.$row['imagem'].'"  class="img-fluid">
                      <div >
                      <b>Produto: </b>'.$row['produto'].'<br>
                      <b>Referência: </b>'.$row['referencia'].'<br>
                      <b>Cor: </b>'.$row['cor'].'<br>
                      <b>Tamanho: </b>'.$row['tamanho'].'<br>
                      <b>Valor: </b>'.$row['valor'].'<br>
                      <b>Quantidade: </b>
                      </div>
                      <form action="" >
                      <input class="input100quantidade" style="width: 30%; height: 25px;" type="number" id="quantidade" name="quantidade" min="1" max="999" value="1">
                      <input type="hidden" id="representante" name="representante" value="'.$representante.'">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <input type="hidden" id="produto" name="produto" value="'.$row['produto'].'">
                      <input type="hidden" id="tipo_produto" name="tipo_produto" value="'.$row['tipo_produto'].'">
                      <input type="hidden" id="genero" name="genero" value="'.$row['genero'].'">
                      <input type="hidden" id="imagem" name="imagem" value="'.$row['imagem'].'">
                      <input type="hidden" id="referencia" name="referencia" value="'.$row['referencia'].'">
                      <input type="hidden" id="cor" name="cor" value="'.$row['cor'].'">
                      <input type="hidden" id="tamanho" name="tamanho" value="'.$row['tamanho'].'">
                      <input type="hidden" id="codigo_barra" name="codigo_barra" value="'.$row['codigo_barra'].'">
                      <input type="hidden" id="valor" name="valor" value="'.$row['valor'].'">
                      <input type="hidden" id="lote" name="lote" value="'.$row['lote'].'">
                      <input type="hidden" name="filtro" value="sapatilha">
                      <button type="submit" class="botaoenviarquantiade">Adicionar</button>
                      <div class="ribbon-wrapper ribbon-xl">
                    </div></form>
                  </div>';
                    };
                     Database::desconectar();
                  ?>
              </div></div></div><!-- =============== Post =========================  -->




                </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="inner-content">
              <p>Copyright &copy; 2021 VOPEN</p>
            </div>
          </div>
        </div>
      </div>
    </footer>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/isotope.js"></script>
    <script src="assets/js/accordions.js"></script>

     <!-- carrinho-->
    <script src="assets/js/carrinho.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script  src="./script.js"></script>


    <script language = "text/Javascript"> 
      cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
      function clearField(t){                   //declaring the array outside of the
      if(! cleared[t.id]){                      // function makes it static and global
          cleared[t.id] = 1;  // you could use true and false, but that's more typing
          t.value='';         // with more chance of typos
          t.style.color='#fff';
          }
      }
    </script>


<script type="text/javascript">
  //CARRINHO DE COMPRAS COM SLIDER
  $(document).ready(function() {
  $drawerRight = $('.cart-drawer-right');
  $cart_list = $('.cart-drawer-btn, .cart-drawer-close-btn');
    
  $cart_list.click(function() {
    $(this).toggleClass('active');
    $('body').toggleClass('cart-drawer-pushtoleft');
    $drawerRight.toggleClass('cart-drawer-open');
  });
});
</script>







  </body>

</html>
  