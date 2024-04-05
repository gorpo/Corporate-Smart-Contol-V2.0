<!-- @Guilherme Paluch 2021 --><?php
// Inicia a sessão
session_start();
?>


<!DOCTYPE html>
  <head>      
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta property="og:site_name" content="VOPEN"/>
      <meta property="og:title" content="VOPEN"/>
      <meta property="og:url" content="https://vopen.com.br/"/>
      <meta property="og:description" content="VOPEN"/>
      <meta property="og:image" content="../assets/images/logo.svg"/>
      <link rel="shortcut icon" href="../assets/images/icon.png" />
      <script src="https://kit.fontawesome.com/a80232805f.js" crossorigin="anonymous"></script>
      <script src="../assets/js/funcoesLogin.js"></script>
      <link rel="stylesheet" type="text/css" href="../assets/css/style_login.css" />
      <title>VOPEN</title>
    </head>

<body style="background-color: #181818;"> <!-- class="bghome" -->
  <!-- bloqueio do click direito do mouse -->
<script>document.oncontextmenu = document.body.oncontextmenu = function() {return false;}</script>
  <!-- função php que retorna se o usuario teve erro ao logar -->
<div class="login">
  <div class="login-header">
    <br>
    <a href="../index.php"><img class='logo'  style="filter: invert(38%) sepia(88%) saturate(5482%) hue-rotate(209deg) brightness(98%) contrast(112%);"  src="../assets/images/logo.svg"></a>
    <h3 class="tituloAdmin">ÁREA DOS REPRESENTANTES</h3>
  </div>
  <div class="login-form">
     <?php
    if(isset($_SESSION['nao_autenticado'])):
  ?>
    <div class="notification is-danger" style="font-size:20px; color:#3046c2;"><b>Usuário não cadastrado</b></div>
  <?php
    endif;
    unset($_SESSION['nao_autenticado']);
  ?>
  
    <form action="login.php" method="POST" >
    <input type="text" name="usuario" autocomplete="off"  placeholder="Usuário"/><br>
    <input type="password" name="senha" autocomplete="off" placeholder="Senha"/>
    <br>
    <input type="hidden" name="cor" autocomplete="off" placeholder="cor" value="dark" />

    <button type="submit" id="btnhome" type="button" class="btnlogar m-b-16 ">Entrar</button>
  </div></form></div>

  </body>
</html>


 

