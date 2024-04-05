<?php
session_start();
if(!$_SESSION['nome']) {
  header('Location: ../../index.php');
  exit();
}

$usuario = $_SESSION['nome'];
include('../../../../databases/conexao.php');
require '../../../../databases/database.php';


$tipo_produto = $_GET['tipo_produto'];
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = $pdo->prepare("SELECT * FROM produtos WHERE tipo_produto = '$tipo_produto'");
$sql->execute();
$info = $sql->fetchAll();
foreach($info as $key => $row){

echo '<option class="input100" value="'.$row['id'].'">'.$row['produto'].' | '.$row['tamanho'].' | '.$row['cor'].'</option>';

}
?>