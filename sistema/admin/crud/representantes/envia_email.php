<?php
session_start();

require '../../../../databases/database.php';
$representante = $_GET['representante'] ;



//PEGA OS DADOS NA DATABASE
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = 'SELECT * FROM representantes ';
foreach($pdo->query($sql)as $row){
    if(mb_convert_case($row['representante'],MB_CASE_LOWER,mb_detect_encoding($row['representante'])) == $representante){
    $imagem = $row['imagem'];
    $nome_fantasia = $row['nome_fantasia'];
    $endereco = $row['endereco'];
    $cidade = $row['cidade'];
    $estado = $row['estado'];
    $telefone = $row['telefone'];
    $email = $row['email'];
}}
database::desconectar();


//PEGA OS DADOS PARA POR NO TOPO DA TABELA
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$q = $pdo->prepare("DESCRIBE carrinho_representante_$representante");
$q->execute();
$table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
$teste = implode('|', $table_fields);
//echo $teste;
database::desconectar();


//pega o id e a data para por no topo do email
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM carrinho_representante_$representante ORDER BY id DESC limit 1";
foreach($pdo->query($sql)as $row){
    $id = $row['id'];
    $data = $row['data'];
}
database::desconectar();







//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.vopen.com.br ';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'criacao@vopen.com.br';                     //SMTP username
    $mail->Password   = 'Criacao2016!';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('criacao@vopen.com.br', 'VOPEN');
    $mail->addAddress('guilherme-paluch@hotmail.com');     //Add a recipient
    $mail->addAddress($email);               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('shark.png', 'shark.png');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Pedido VOPEN - Representante '.ucfirst($representante).'';

    $espacos = '&zwnj; &zwnj; &zwnj; &zwnj; &zwnj; &zwnj; &zwnj; &zwnj;&zwnj; &zwnj; &zwnj; &zwnj; &zwnj; &zwnj; &zwnj; &zwnj;';
    
    $mail->Body    = '
    <style>
    table {
    border-collapse: collapse;
    width: 100%;
    }

    th, td {
    border: 1px solid #ddd;
    text-align: left;
    padding: 8px;
    color:black
    }

    tr:nth-child(even){background-color: #e1dddd}

    th {
    background-color: #17a2b8;
    color: white;
    }
    </style>

   
    <section class="content">
    <div class="container-fluid">
    <div class="row">
    <div class="col-12">
    <!-- Main content -->
    <div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
    <div class="col-12">
    <h4>
    <div class="image">
    <b>Pedido ID:</b>'.$id.'<br>
    <b>Feito em:</b> '.date('d/m/Y',  strtotime(str_replace('_', '-',mb_strimwidth(date($data),0,-3)))).'<br>
    <b>Pagamento:</b>Pendente<br>
    <small class="float-right"></small>
    </h4></div></div>
        <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
        <address>
        <strong>Representante '.ucfirst($representante).'</strong></div>
        <strong>'.$nome_fantasia.'</strong><br>
        '.$endereco.'<br>
        '.$cidade.', '.$estado.'<br>
        Telefone: '.$telefone.'<br>
        Email: '.$email.'
    </address>
    </div><br>

    <div class="card">
    <div class="card-header">
    <h3 class="card-title">Detalhes da compra</h3>
    </div>
    <div class="card-body">
    <table>
    <thead>
    <tr>
        <th style="border:1px solid black; width:130px; padding:0 0 0 5px;">  '.$table_fields[1].'</th>
        <th style="border:1px solid black; width:130px; padding:0 0 0 5px;">  '.$table_fields[5].'</th>
        <th style="border:1px solid black; width:130px; padding:0 0 0 5px;">  '.$table_fields[6].'</th>
        <th style="border:1px solid black; width:130px; padding:0 0 0 5px;">  '.$table_fields[7].'</th>
        <th style="border:1px solid black; width:130px; padding:0 0 0 5px;">  '.mb_strimwidth($table_fields[11],0,5).'</th>
        <th style="border:1px solid black; width:130px; padding:0 0 0 5px;">  '.$table_fields[9].'</th>
    </tr>
    </th>
    </table> 
    ';



$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM carrinho_representante_$representante ORDER BY id DESC limit 1";
foreach($pdo->query($sql)as $row){
      $array_id = explode(',', $row['id']);
      $array_produto = explode(',', $row['produto']);
      $array_tipo_produto = explode(',', $row['tipo_produto']);
      $array_genero = explode(',', $row['genero']);
      $array_referencia = explode(',', $row['referencia']);
      $array_cor = explode(',', $row['cor']);
      $array_tamanho = explode(',',$row['tamanho']);
      $array_codigo_barra = explode(',', $row['codigo_barra']);
      $array_valor = explode(',',$row['valor']);
      $array_lote = explode(',', $row['lote']);
      $array_quantidade = explode(',', $row['quantidade']);
      $array_pago = explode(',', $row['pago']);
      $array_data = explode(',', $row['data']);


    foreach ($array_produto as $key => $value_produto ) {
        $produto =  $value_produto;
        $referencia =  $array_referencia[$key];
        $cor =  $array_cor[$key];
        $tamanho =  $array_tamanho[$key];
        $valor =  $array_valor[$key];
        $quantidade =  $array_quantidade[$key];
        $mail->Body    .= '  
    <table>
        <tbody>
            <tr >
                <td style="border:1px solid black; width:130px; padding:0 0 0 5px;" nowrap="nowrap">  '.$produto.'</td>
                <td style="border:1px solid black; width:130px; padding:0 0 0 5px;" nowrap="nowrap">  '.$referencia.'</td>
                <td style="border:1px solid black; width:130px; padding:0 0 0 5px;" nowrap="nowrap">  '.$cor.'</td>
                <td style="border:1px solid black; width:130px; padding:0 0 0 5px;" nowrap="nowrap">  '.$tamanho.'</td>
                <td style="border:1px solid black; width:130px; padding:0 0 0 5px;" nowrap="nowrap">  '.$quantidade.'</td>
                <td style="border:1px solid black; width:130px; padding:0 0 0 5px;" nowrap="nowrap">  '. $valor.'</td>
            </tr>
    </tbody></table> </div>
';
    }
}
database::desconectar();







$soma_total = 0;
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM carrinho_representante_$representante ORDER BY id DESC limit 1";
foreach($pdo->query($sql)as $row){
    $valor = $row['valor'];
    $quantidade = $row['quantidade'];

    $array_valor = explode(',',$valor);
    $array_quantidade = explode(',', $quantidade);

     foreach ($array_produto as $key => $value_produto ) {
        $valor =  $array_valor[$key];
        $quantidade =  $array_quantidade[$key];  

        $soma_total = $soma_total + $valor * $quantidade;
    }
}



    $mail->Body    .= '<p class="lead"><b>Valor Total:</b></p>
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%; color: black;">Subtotal:</th>
              <td style="color: black;"> R$'.number_format((float)$soma_total, 2, '.', '').'</td>
            </tr>
            <tr>
              <th style="color: black;">Tax (10%)</th>
              <td style="color: black;"> R$'.number_format((float)$soma_total/100*10, 2, '.', '').'</td>
            </tr>
            <tr>
              <th style="color: black;">Total: R$</th>
              <td style="color: black;"> R$'.number_format((float)$soma_total/100*10+$soma_total, 2, '.', '') .'</td>
            </tr>
          </table></div></div>

          <br><br>
          Este é um email enviado após a compra em nosso sistema de representantes, não responda este email, ele é apenas para conferência do pedido.<br>

          <div class="col-sm-4 invoice-col">
    <address>
        <hr style="border: 1px solid #e1dddd;">
        <strong>VOPEN</strong>  - Rodovia SC-434, 11440 Sala 2 | Garopaba, Santa Catarina | Telefone: (48) 99145.4300    | Email: comercial@vopen.com.br
    </address>
    </div><br>';



//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    //echo 'Message has been sent';
    //echo("<script>location.href = 'fecha_carrinho.php?representante=$representante&nome_db=$nome_db';</script>");
    //session_destroy();
    header('Location: fecha_carrinho.php?representante='.$representante.'');
} catch (Exception $e) {
    echo "Seu pedido foi computado mas tivemos um erro ao enviar o email, informe a nossa equipe pelo email criacao@vopen.com.br o codigo de erro: {$mail->ErrorInfo}";
}




?>


