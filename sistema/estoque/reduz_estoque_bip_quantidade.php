<?php 
session_start();
require '../../databases/database.php';



//codigo que reduz a quantidade de itens do estoque
//pega os dados do form e retorna a pagina repassando a pesquisa(buscar)
if(isset($_GET['id'])){
      $id = $_GET['id'];
      $quantidade = $_GET['quantidade'];
      $usuario = $_SESSION['nome'];
      $buscar = $_GET['buscar'];
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("UPDATE produtos SET quantidade = quantidade - $quantidade WHERE id = $id");
      $sql->execute();
      database::desconectar();
      
      //cria uma tabela para armazenar as retiradas totais
      //$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']); 
      //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //$sql = $pdo->prepare("CREATE TABLE IF NOT EXISTS retiradas_totais (produto VARCHAR(300),tipo_produto VARCHAR(300), cor VARCHAR(300), tamanho VARCHAR(300),quantidade VARCHAR(300),data_atual datetime");
      //$sql->execute();
      //database::desconectar();


      //grava os dados doque o usuario retirou do estoque
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $usuario = mb_convert_case($_GET['usuario'], MB_CASE_LOWER, "UTF-8");
      $produto = $_GET['produto'];
      $tipo_produto = $_GET['tipo_produto'];
      $genero = $_GET['genero'];
      $imagem = $_GET['imagem'];
      $referencia = $_GET['referencia'];
      $cor = $_GET['cor'];
      $tamanho = $_GET['tamanho'];
      $codigo_barra = $_GET['buscar'];
      $lote = $_GET['lote'];
      $quantidade = $_GET['quantidade'];
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $sql = $pdo->prepare("INSERT INTO retiradas_$usuario (usuario, produto, tipo_produto, genero, imagem, referencia, cor, tamanho, codigo_barra, lote, quantidade, data_atual) VALUES (?,?,?,?,?,?,?,?,?,?,?,NOW())");
      $sql->execute(array($usuario, $produto, $tipo_produto, $genero, $imagem, $referencia, $cor, $tamanho, $codigo_barra,$lote, $quantidade));
      database::desconectar();

      //volta para a pagina após executar as funçoes
      header("Location: bip_quantidade.php?buscar=$buscar");     
} 


?>