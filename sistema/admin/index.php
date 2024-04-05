<!-- @Guilherme Paluch 2021 --> 

<?php
session_start();

require '../../databases/database.php';

 //--------- DATABASES DO CHAT ------->

//CRIA USUARIOS DO CHAT
$pdo = Database::conectar($dbNome='csc_chat');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = $pdo->prepare("CREATE TABLE  IF NOT EXISTS `user_cpmvj` (
`user_id` mediumint(9) NOT NULL,
`user_first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`user_last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`user_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`user_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`user_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
`user_datetime` datetime NOT NULL,
`user_verification_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
PRIMARY KEY (user_id)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;");
$sql->execute();
$pdo = Database::desconectar();

$pdo = Database::conectar($dbNome='csc_chat');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = $pdo->prepare("ALTER TABLE `user_cpmvj` MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;");
$sql->execute();
$pdo = Database::desconectar();

//CRIA MENSAGENS DO CHAT
$pdo = Database::conectar($dbNome='csc_chat');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = $pdo->prepare("CREATE TABLE  IF NOT EXISTS `chat_message_cpmvj` (
 `chat_message_id` mediumint(9) NOT NULL,
 `chat_message_sender_id` int(11) NOT NULL,
 `chat_message_receiver_id` int(11) NOT NULL,
 `chat_message` text COLLATE utf8_unicode_ci NOT NULL,
 `chat_message_status` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL,
 `chat_message_datetime` int(11) NOT NULL,
PRIMARY KEY (chat_message_id)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;");
$sql->execute();
$pdo = Database::desconectar();


//CRIA REQUISIÇOES DO CHAT
$pdo = Database::conectar($dbNome='csc_chat');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = $pdo->prepare("CREATE TABLE  IF NOT EXISTS `chat_request_cpmvj` (
`chat_request_id` mediumint(9) NOT NULL,
`chat_request_sender_id` int(11) NOT NULL,
`chat_request_receiver_id` int(11) NOT NULL,
`chat_request_status` enum('Send','Accept','Reject') COLLATE utf8_unicode_ci NOT NULL,
`chat_request_datetime` int(11) NOT NULL,
PRIMARY KEY (chat_request_id)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;");
$sql->execute();
$pdo = Database::desconectar();

?>

<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta property="og:site_name" content="Corporate - Smart Control" />
  <meta property="og:title" content="Corporate - Smart Control" />
  <meta property="og:url" content="https://corporatesmartcontrol.com.br/" />
  <meta property="og:description" content="Corporate - Smart Control" />
  <meta property="og:image" content="../../assets/imagens/logo.svg" />
  <link rel="shortcut icon" href="./../../assets/images/icon.png" />
  <script src="https://kit.fontawesome.com/a80232805f.js" crossorigin="anonymous"></script>
  <script src="../../assets/js/funcoesLogin.js"></script>
  <link rel="stylesheet" type="text/css" href="../../assets/css/style_login.css" />
  <title>Corporate - Smart Control</title>
</head>
<body style="background: url(../../assets/images/bg_index_admin.jpg) no-repeat center center fixed; ">
  <div class="login">
    <div class="login-header">
      <a href="../" title="Clique na logotipo para ir para o Painel de Administrador do Sistema.">
        <img class='logo' style="" src="../../assets/images/logo_login.png">
      </a>
    </div>

    <div class="login-form" >
      <div class="container col-xl-10 col-xxl-8 px-4 py-5">
          <div class="row g-lg-5 py-5">
              <div class="col-md-10 mx-auto col-lg-6">
                  <span id="login_error"></span>
                  <form id="login" method="POST" autocomplete="off">
                          <input type="email" class="" id="user_email" placeholder="Email" name="user_email" autocomplete="off" required>
                          <label for="user_email"></label>
                          <input type="password" class="form-control" id="user_password" placeholder="Senha" name="user_password" autocomplete="off" required>
                          <label for="user_password"></label>
                          <input type="text" class="" id="user_token" placeholder="token" name="user_token" autocomplete="off" required>
                          <label for="user_token"></label>
                          <button class="btnlogar" id="login_button" type="submit">Login</button>
                  </form>
              </div>
          </div>
      </div>
    </div></div>

</body>
</html>
<!-- bloqueio do click direito do mouse -->
<script>
  document.oncontextmenu = document.body.oncontextmenu = function() {
    return false;
  }
</script>


<script>

function _(element)
{
    return document.getElementById(element);
}

check_login();

function check_login()
{
    fetch('../../../assets/functions/chat/backend/check_login.php').then(function(response){

        return response.json();

    }).then(function(responseData){

        if(responseData.user_name && responseData.image)
        {
            window.location.href = 'login.php';
        }

    });
}




_('login').onsubmit = function(event){
    event.preventDefault();
}

_('login_button').onclick = function(){

    var form_data = new FormData(_('login'));

    _('login_button').disabled = true;

    _('login_button').innerHTML = 'Aguarde...';

    fetch('../../../assets/functions/chat/backend/login.php', {

        method:"POST",

        body:form_data

    }).then(function(response){

        return response.json();

    }).then(function(responseData){

        _('login_button').disabled = false;

        _('login_button').innerHTML = 'Login';

        if(responseData.error != '')
        {
            var error = '<div class="alert alert-danger"><ul>'+responseData.error+'</ul></div>';
            _('login_error').innerHTML = error;
        }
        else
        {
            
            window.location.href = 'login.php';
        }

        setTimeout(function(){

            _('login_error').innerHTML = '';

        }, 10000);

    });

}

let url = window.location.href;

let params = (new URL(url)).searchParams;

if(params.get('msg'))
{
    let param_val = params.get('msg');
    if(param_val == 'success')
    {
        _('login_error').innerHTML = '<div class="alert alert-success">Your Email Successfully Verified, now you can login</div>';
    }
    else
    {
        _('login_error').innerHTML = '<div class="alert alert-info">Wrong URL</div>';
    }

    setTimeout(function(){
        window.location.href = 'index.php';
    }, 5000);
}




</script>