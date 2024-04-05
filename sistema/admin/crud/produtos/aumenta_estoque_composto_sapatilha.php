<?php 
session_start();
require '../../../../databases/database.php';



//codigo que reduz a quantidade de itens do estoque
//pega os dados do form e retorna a pagina repassando a pesquisa(buscar)
if(isset($_GET['id'])){
      $id = $_GET['id'];
      $quantidade = $_GET['quantidade'];
      $usuario = $_SESSION['nome'];
      echo $quantidade;
      $buscar = $_GET['buscar'];
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("UPDATE produtos SET quantidade = quantidade + $quantidade WHERE id = $id");
      $sql->execute();
      database::desconectar();
      //volta para a pagina após executar as funçoes
      header("Location: produto_composto_sapatilha.php?buscar=$buscar");     
} 


?>