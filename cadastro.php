
<!-- @Gorpo Orko - 2020 -->

<?php

require 'databases/database.php';


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = filter_input(INPUT_POST, 'nome');
    $sobrenome = filter_input(INPUT_POST, 'sobrenome');
    $telefone = filter_input(INPUT_POST, 'telefone');
    $email = filter_input(INPUT_POST, 'email');
    $senha = filter_input(INPUT_POST, 'senha');

    //CRIA A TABELA DE USUARIOS NAO EXISTA
    $pdo = Database::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $pdo->prepare("CREATE TABLE  IF NOT EXISTS `usuarios` (
    `id` mediumint(9) NOT NULL AUTO_INCREMENT,
    `nome` varchar(200) NOT NULL,
    `sobrenome` varchar(200) NOT NULL,
    `usuario` varchar(200) NOT NULL,
    `telefone` varchar(200) NOT NULL,
    `email` varchar(329) NOT NULL,
    `email_cliente` varchar(329) NOT NULL,
    `senha` varchar(999) NOT NULL,
    `nivel` varchar(999) NOT NULL,
    `prazo` varchar(999) NOT NULL,
    `imagem` varchar(999) NOT NULL,
    `cadastro` datetime NOT NULL,
    `token` varchar(999) NOT NULL,
    PRIMARY KEY (id)
    )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;");
    $sql->execute();
    $pdo = Database::desconectar();

    $pdo = Database::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $pdo->prepare("ALTER TABLE `usuarios` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;");
    $sql->execute();
    $pdo = Database::desconectar();


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

$pdo = Database::conectar($dbNome='csc_chat');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = $pdo->prepare("ALTER TABLE `chat_message_cpmvj` MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;");
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

$pdo = Database::conectar($dbNome='csc_chat');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = $pdo->prepare("ALTER TABLE `chat_request_cpmvj` MODIFY `chat_request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;");
$sql->execute();
$pdo = Database::desconectar();

    try {
        $pdo = Database::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $pdo->prepare("INSERT INTO `usuarios` (`id`,`nome`,`sobrenome`, `usuario`, `telefone`, `email`,`email_cliente`, `senha`, `nivel`, `prazo`,`imagem`, `cadastro`,`token`) VALUES 
        ('0','none','none','none','none','none','none','none','none','none','none','none','none');");
    } catch (Exception $e) {
        $nada = 'nada';
    }


    //VERIFICA SE O EMAIL JÁ ESTA CADASTRADO
    $pdo = Database::conectar();
    $sql = $pdo->prepare("SELECT * FROM `usuarios`");
    $sql->execute();
    $info = $sql->fetchAll();
    foreach($info as $key => $row){
        $email_cadastrado = $row['email'];
        if($email_cadastrado == $email){
            //header('Location: index.php?cadastrado=True');
            $sql->execute();
            $pdo = Database::desconectar();
            $existe = '1';
        }else{
            $existe = '0';
        }
    }

    }
    if($existe != '1'){        
    //INSERE O USUARIO NA TABELA DE USUARIOS DO SISTEMA COMO ADMIN
    $token = md5(microtime(true).mt_Rand());    
    $pdo = Database::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $pdo->prepare("INSERT INTO `usuarios` (`nome`,`sobrenome`, `usuario`, `telefone`, `email`,`email_cliente`, `senha`, `nivel`, `prazo`,`imagem`, `cadastro`,`token`) VALUES 
    (?,?,?,?,?,?,?,'admin','trial','user.jpg', now(),?);");
    $sql->execute(array($nome,$sobrenome, str_replace(' ', '', $nome), $telefone, $email,$email, $senha, $token));
    }
    $pdo = Database::desconectar();
  
    //insere o usuario no banco de dados do chat
    $pdo = Database::conectar($dbNome='csc_chat');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $pdo->prepare("INSERT INTO `user_cpmvj` ( `user_first_name`, `user_last_name`, `user_email`, `user_password`, `user_image`, `user_status`,`user_datetime`, `user_verification_code`) VALUES 
    (?,?,?,?,?,?,now(),?);");
    $sql->execute(array( $nome, $sobrenome, $email, $senha, 'user.jpg', 'Offline',  bin2hex(random_bytes(16))));
    $pdo = Database::desconectar();


    if($existe == '1'){
        header('Location: index.php?cadastrado=True');
    }


//ENVIA UM EMAIL PARA O USUARIO INFORMANDO O CADASTRO
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'assets/functions/PHPMailer/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                                                     //Enable verbose debug output
    $mail->isSMTP();                                                                 //Send using SMTP
    $mail->Host       = 'smtp.hostinger.com';           //smtp.hostinger.com                      //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                                    //Enable SMTP authentication
    $mail->Username   = 'contato@corporatesmartcontrol.com';                                         //SMTP username
    $mail->Password   = 'CRCdaimonae@1';                                                    //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                            //Enable implicit TLS encryption
    $mail->Port       = 465;                                                       //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('contato@corporatesmartcontrol.com', 'Corporate Smart Control');
    $mail->addAddress($email);     //Add a recipient
    $mail->addAddress($email);               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('shark.png', 'shark.png');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Confirmação de cadastro - Teste 30 dias.';

    $espacos = '&zwnj; &zwnj; &zwnj; &zwnj; &zwnj; &zwnj; &zwnj; &zwnj;&zwnj; &zwnj; &zwnj; &zwnj; &zwnj; &zwnj; &zwnj; &zwnj;';
    
    $mail->Body    = '
    <!DOCTYPE html><html> <head> <title>Corporate Smart Control</title> <link rel="shortcut icon" href="images/icon.png"> <meta name="googlebot" content="noindex"/> <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"/> <meta content="width=device-width, initial-scale=1.0" name="viewport"> </head> <body marginheight=0 marginwidth=0 topmargin=0 leftmargin=0 style="height: 100% !important; margin: 0; padding: 0; width: 100% !important;min-width: 100%;"> <table width="100%" cellspacing="0" cellpadding="0" border="0" name="bmeMainBody" style="background-color: rgb(87, 36, 142);" bgcolor="#57248e"> <tbody> <tr> <td width="100%" valign="top" align="center"> <table cellspacing="0" cellpadding="0" border="0" name="bmeMainColumnParentTable" style="border-collapse: separate; border-spacing: 0px;" width="100%"> <tbody> <tr> <td name="bmeMainColumnParent" style="border: 0px none transparent; border-radius: 0px; border-collapse: separate; border-spacing: 0px; overflow: visible;"> <table name="bmeMainColumn" class="bmeMainColumn" style="max-width: 100%; border-radius: 0px; border-collapse: separate; border-spacing: 0px; overflow: visible;" cellspacing="0" cellpadding="0" border="0" align="center" width="100%"> <tbody> <tr> <td width="100%" class="blk_container bmeHolder" name="bmePreHeader" valign="top" align="center" style="color: rgb(102, 102, 102); border: 0px none transparent;" bgcolor=""></td></tr><tr> <td width="100%" class="bmeHolder" valign="top" align="center" name="bmeMainContentParent" style="border: 0px none transparent; border-radius: 0px; border-collapse: separate; border-spacing: 0px; overflow: hidden;"> <table name="bmeMainContent" style="border-radius: 0px; border-collapse: separate; border-spacing: 0px; border: 0px none transparent; overflow: visible;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center"> <tbody> <tr> <td width="100%" class="blk_container bmeHolder" name="bmeHeader" valign="top" align="center" style="color: rgb(56, 56, 56); border: 0px none transparent; background-color: rgb(87, 36, 142);" bgcolor="#57248e"> <div id="dv_11" class="blk_wrapper"> <table width="600" cellspacing="0" cellpadding="0" border="0" class="blk" name="blk_image"> <tbody> <tr> <td> <table width="100%" cellspacing="0" cellpadding="0" border="0"> <tbody> <tr> <td align="left" class="bmeImage" style="border-collapse: collapse; padding: 20px;"> <img src="https://corporatesmartcontrol.com/assets/images/logo_bco.png" width="255" style="max-width: 255px; display: block; width: 255px;" alt="" border="0" imgid="imgkp8dl9f5HXrf"> </td></tr></tbody> </table> </td></tr></tbody> </table> </div><div id="dv_8" class="blk_wrapper"> <table width="600" cellspacing="0" cellpadding="0" border="0" class="blk" name="blk_image"></table> </div><div id="dv_19" class="blk_wrapper"> <table width="600" cellspacing="0" cellpadding="0" border="0" class="blk" name="blk_text"> <tbody> <tr> <td> <table cellpadding="0" cellspacing="0" border="0" width="100%" class="bmeContainerRow"> <tbody> <tr> <td class="tdPart" valign="top" align="center"> <table cellspacing="0" cellpadding="0" border="0" width="600" name="tblText" style="float:left; background-color: #48187b;" align="left" class="tblText"> <tbody> <tr> <td valign="top" align="left" name="tblCell" style="padding: 10px 20px; font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: 400; color: #ffffff; text-align: left;" class="tblCell"> <div style="line-height: 150%; text-align: center;"> <strong>Bem vindo '.$nome.'</strong> <br> <span style="font-size: 14px; font-family: , Helvetica, Arial, sans-serif; color: #ffffff; line-height: 150%;">Seu cadastro para avaliação do CSC - Corporate Smart Control foi concluído, você terá 30 dias para testar nosso produto, manteremos um backup de seus dados por mais 30 dias caso queira adquirir nosso produto e ter a facilidade de usar tudo que for cadastrado. Salve seu token com segurança, ele é o token que identifica sua empresa e garante sua segurança e de seus funcionários. Ao cadastrar um novo funcionário forneça este token a ele para validar seu acesso ao sistema. Apenas usuários com Token conseguem entrar no sistema! <b>Agora basta logar em nosso sistema e aproveitar os recursos.</b><br><br></span> <h1>TOKEN:</h1> <h2>'.$token.'</h2> <br><br><button class="button-36" role="button"> <a href="https://sistema.corporatesmartcontrol.com/"> ACESSAR O SISTEMA </button> <br><br><style type="text/css"> /* CSS */ a, a:hover, a:focus, a:active{text-decoration: none; color: inherit;}.button-36{background-color: #603efa; border-radius: 8px; border-style: none; box-sizing: border-box; color: #FFFFFF; cursor: pointer; flex-shrink: 0; font-family: "Inter UI", "SF Pro Display", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif; font-size: 16px; font-weight: 500; height: 4rem; padding: 0 1.6rem; text-align: center; transition: all .5s; user-select: none; -webkit-user-select: none; touch-action: manipulation;}.button-36:hover{background-color: #603efa; transition-duration: .1s;}@media (min-width: 968px){.button-36{padding: 0 2.6rem;}}</style> </div></td></tr></tbody> </table> </td></tr></tbody> </table> </td></tr></tbody> </table> </div><br><br><div id="dv_1" class="blk_wrapper"> <table width="600" cellspacing="0" cellpadding="0" border="0" class="blk" name="blk_imagecaption" style=""> <tbody> <tr> <td> <table cellspacing="0" cellpadding="0" class="bmeCaptionContainer" width="100%" style="padding-left:20px; padding-right:20px; padding-top:10px; padding-bottom:10px;border-collapse:separate;"> <tbody> <tr> <td class="bmeImageContainerRow" valign="top" gutter="10"> <table width="100%" cellpadding="0" cellspacing="0" border="0"> <tbody> <tr> <td class="tdPart" valign="top"> <table cellspacing="0" cellpadding="0" border="0" class="bmeImageContainer" width="560" align="left" style="float:left;"> <tbody> <tr> <td valign="top" name="tdContainer"> <table cellspacing="0" cellpadding="0" border="0" class="bmeImageTable" dimension="30%" imgid="1" style="float: right;" align="right" width="177" height="264"> <tbody> <tr> <td name="bmeImgHolder" width="187" align="center" valign="top" class="bmeMblCenter" height="264"> <img src="https://corporatesmartcontrol.com/assets/images/celular.png" class="mobile-img-large" width="177" style="max-width: 360px; display: block;" imgid="imgkp8dl9f5HXrf" border="0"> </td></tr></tbody> </table> <table cellspacing="0" cellpadding="0" border="0" class="bmeCaptionTable" style="float:left;" align="left" width="363"> <tbody> <tr> <td name="tblCell" valign="top" align="left" style="font-family: Arial,Helvetica,sans-serif; font-size: 14px; font-weight: normal; color: #383838; text-align: left;" class="bmeMblCenter tblCell"> <div style="line-height: 150%;"> <span style="font-size: 30px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; line-height: 150%;"> <strong>SIGA CONECTADO COM NOSSO APLICATIVO</strong> </span> <br><br><span style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; line-height: 150%;">Temos o melhor a mais completo sistema de gerenciamentode empresas, indústrias, lojas e comercio.Sistema Fluido com ferramentas de ponta que o ajudarão a esboçar suas ideias em tempo recorde e preparar sua empresa e seus funcionários, unificando todos os setores em todos processos. Controle sua empresa via Desktop ou via Mobile em nossa plataforma, fazendo uso de nossos programas e apps faça desde reuniões online a controle de todos processos. Com diferentes níveis de acesso, todos da sua empresa podem ter acesso ao sistema, automatizando seu trabalho de coordenação e protocolando todos os processos </div></td></tr></tbody> </table> </td></tr></tbody> </table> </td></tr></tbody> </table> </td></tr></tbody> </table> </td></tr></tbody> </table> </div><div id="dv_27" class="blk_wrapper"> <table cellspacing="0" cellpadding="0" border="0" name="blk_divider" width="600" class="blk"> <tbody> <tr> <td style="padding: 20px;" class="tblCellMain"> <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-top-width: 0px; border-top-style: none; min-width: 1px;" class="tblLine"> <tbody> <tr> <td> <span></span> </td></tr></tbody> </table> </td></tr></tbody> </table> </div><div id="dv_28" class="blk_wrapper"> <table width="600" cellspacing="0" cellpadding="0" border="0" class="blk" name="blk_text"> <tbody> <tr> <td> <table cellpadding="0" cellspacing="0" border="0" width="100%" class="bmeContainerRow"> <tbody> <tr> <td class="tdPart" valign="top" align="center"> <table cellspacing="0" cellpadding="0" border="0" width="300" name="tblText" style="float: left; " align="left" class="tblText"> <tbody> <tr> <td valign="top" align="left" name="tblCell" style="padding: 20px; font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: 400; color: rgb(56, 56, 56); text-align: left;" class="bmeMblCenter tblCell"> <div style="line-height: 150%; text-align: right;"> <img style="max-width: 135px;" src="https://benchmarkemail.com/images/templates_n/new_editor/Templates/DeviceApp/AppleDownload.png" alt="" border="0" imgid="imgxC9O7CZQvsvw" width="135"> </div></td></tr></tbody> </table> </td><td class="tdPart" valign="top" align="center"> <table cellspacing="0" cellpadding="0" border="0" name="tblGtr" style="float:right;" width="0" align="right" class="tblGtr"> <tbody> <tr> <td></td></tr></tbody> </table> </td><td class="tdPart" valign="top" align="center"> <table cellspacing="0" cellpadding="0" border="0" name="tblText" style="float:right;" align="right" width="300" class="tblText"> <tbody> <tr> <td name="tblCell" valign="top" style="padding: 20px; font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: 400; color: rgb(56, 56, 56); text-align: left;" align="left" class="bmeMblCenter tblCell"> <div style="line-height: 150%; font-size: 14px;"> <img style="max-width: 114px;" src="https://benchmarkemail.com/images/templates_n/new_editor/Templates/DeviceApp/GooglePlayDownload.png" alt="" border="0" imgid="imgiUewkUu5619a" width="114"> </div></td></tr></tbody> </table> </td></tr></tbody> </table> </td></tr></tbody> </table> </div><div id="dv_22" class="blk_wrapper"> <table cellspacing="0" cellpadding="0" border="0" name="blk_divider" width="600" class="blk"> <tbody> <tr> <td style="padding: 20px;" class="tblCellMain"> <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-top-width: 0px; border-top-style: none; min-width: 1px;" class="tblLine"> <tbody> <tr> <td> <span></span> </td></tr></tbody> </table> </td></tr></tbody> </table> </div><tr> <td width="100%" class="blk_container bmeHolder" name="bmeFooter" valign="top" align="center" style="color: rgb(102, 102, 102); border: 0px none transparent; background-color: #48187b;" bgcolor="#881c50"> <div id="dv_10" class="blk_wrapper"> <table width="600" cellspacing="0" cellpadding="0" border="0" class="blk" name="blk_footer" style=""> <tbody> <tr> <td name="tblCell" class="tblCell" style="padding:20px;" valign="top" align="left"> <table cellpadding="0" cellspacing="0" border="0" width="100%"> <tbody> <tr> <td name="bmeBadgeText" style="text-align:left; word-break: break-word;" align="left"> <span id="spnFooterText" style="font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 11px; line-height: 140%; color: whitesmoke;">Esta mensagem foi enviada automaticamente por contato@corporatesmartcontrol.com </span> <br><br><span style="font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 11px; line-height: 140%; color: whitesmoke;"> <span href=http://benchmarkemail.benchurl.com/c/su?e=8E4B52&c=91CEA&t=1&l=7889F345&email=hL2iimIGZvj2QooSzVze1t7P%2FZjRPRKrj2c0%2B7DqUhU%3D&relid=> <img src="https://www.benchmarkemail.com/images/verified.png" alt="Unsubscribe from all mailings" title="Unsubscribe from all mailings" border="0"> </span> <a class=bmefootertext target=_new href="http://benchmarkemail.benchurl.com/c/su?e=8E4B52&c=91CEA&t=1&l=7889F345&email=hL2iimIGZvj2QooSzVze1t7P%2FZjRPRKrj2c0%2B7DqUhU%3D&relid=" style="color: whitesmoke;;text-decoration:underline;">Unsubscribe</a> | <a class=bmefootertext target=_new href="http://benchmarkemail.benchurl.com/c/s?e=8E4B52&c=91CEA&t=1&l=7889F345&email=hL2iimIGZvj2QooSzVze1t7P%2FZjRPRKrj2c0%2B7DqUhU%3D&relid=" style="color:inherit;text-decoration:underline;">Manage Subscription</a> | <a class=bmefootertext target=_new href="http://benchmarkemail.benchurl.com/Abuse?e=8E4B52&c=91CEA&t=1&l=7889F345&email=hL2iimIGZvj2QooSzVze1t7P%2FZjRPRKrj2c0%2B7DqUhU%3D&relid=" style="color: whitesmoke;text-decoration:underline;">Report Abuse</a> <br></span> </td></tr></tbody> </table> </td></tr></tbody> </table> </div></td></tr></tbody> </table> </td></tr></tbody> </table> </td></tr></tbody> </table> </body></html>
';

//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
$mail->send();
//echo 'Message has been sent';
//echo("<script>location.href = 'fecha_carrinho.php?representante=$representante&nome_db=$nome_db';</script>");
//session_destroy();
} catch (Exception $e) {
    echo "Seu pedido foi computado mas tivemos um erro ao enviar o email, informe a nossa equipe pelo email criacao@vopen.com.br o codigo de erro: {$mail->ErrorInfo}";
}



//RETORNA A PAGINA
if($existe != '1'){
header('Location: index.php?enviado=email');
}
?>