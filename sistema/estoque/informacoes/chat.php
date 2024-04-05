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
  <meta property="og:image" content="assets/images/logo.svg"/>
    <title>Corporate Smart Contol Chat </title>
    <!-- Bootstrap core CSS -->
    <link href="../../../assets/functions/chat/vendor/twbs/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link href="../../../assets/functions/chat/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js" rel="stylesheet">

</head>
<body>



    <div class="container-fluid" id="minhaDiv" >

        <!-- <div style="width: 300px; max-height: 800px; z-index: 1; position:absolute; float: right; margin-bottom: 0; position: absolute; right: 0px; bottom: 0px; overflow:auto; background-color: #F7F7F7;"> -->

            <div style="width: 300px; max-height: 800px; z-index: 1; position:absolute;  right: 0px; margin-bottom: 30px; bottom: 0px; overflow:auto; background-color: #F7F7F7;">
    <div id="chat_msg_area1" class="pt-2 pb-2" style="height: 30vh;">
 
    <div class="card-header">
        <div class="row">
            <div class="col" id="chat_user_data1" style="margin-bottom: 7px;">
                <span  id="login_user_image"></span><button type="button" class="btn btn-danger btn-sm float-end" id="close_chat1" onclick="Mudarestado('minhaDiv')">X</button>
            </div>
        </div>
        <div id="notification_area" class=""></div>
        <div class="pt-4 pb-4 h-50 overflow-auto">
        <input type="text" name="search_people" id="search_people" class="form-control" placeholder="Procure usuário" autocomplete="off" />
        <div id="search_people_area" class="mt-3"></div>
    </div>
    Conecte-se
    <div  id="connected_people_area"></div>
    
               
<button hidden class="btn btn-secondary btn-sm" id="setting_button">Setting</button>
<button hidden class="btn btn-primary btn-sm" id="logout_button">Logout</button>

</div></div></div></div></div></div></div><div id="chat_area"></div></div></div></div></div>
 

</body>
</html>
<script type="text/javascript">
    document.getElementById("chat_area").style.cssText="overflow:invisible;"; 
</script>


<!-- abre e fecha o chat -->
<style type="text/css">
    fab{
  position: fixed;
  bottom:10px;
  right:10px;
}
.fab button{
  cursor: pointer;
  width: 35px;
  height: 35px;
  border-radius: 30px;
  background-color: #cb60b3;
  border: none;
  box-shadow: 0 1px 5px rgba(0,0,0,.4);
  font-size: 20px;
  color: white;
    
  -webkit-transition: .2s ease-out;
  -moz-transition: .2s ease-out;
  transition: .2s ease-out;
}
.fab button.main{
  position: absolute;
  width: 40px;
  height: 40px;
  border-radius: 30px;
  background-color: #5b19b7;
  right: 0px;
  bottom: 10px;
  z-index: 20;
}
</style>
<!-- abre e fecha o chat -->
<div class="fab"  ontouchstart="">
  <button class="main" id="btn_chat" onclick="Mudarestado('minhaDiv')">💬</button>
</div>


<script>
    //abre e fecha o chat
    function Mudarestado(el) {
        var display = document.getElementById(el).style.display;
        if(display == "none")
            document.getElementById(el).style.display = 'block';
        else
            document.getElementById(el).style.display = 'none';
    }

    //remover este inicio de função para o chat ja começar aberto
    Mudarestado('minhaDiv');

function $(selector)
{
  return document.querySelector(selector);
}

check_login();

reset_chat_area();

var interval;

function check_login()
{
    fetch('../../../assets/functions/chat/backend/check_login.php').then(function(response){

        return response.json();

    }).then(function(responseData){

        if(responseData.user_name && responseData.image)
        {
           
            _('login_user_image').innerHTML = '<img src="../../../assets/functions/chat/'+responseData.image+'" class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"/>' +'<strong class="text-gray-dark">' + responseData.user_name + '</strong>';

            load_chat_request();
        }
        else
        {

            window.location.href = 'indexes.php';
        }
    });
}

$('#logout_button').onclick = function(){
    var form_data = new FormData();

    form_data.append('action', 'logout');

    fetch('../../../assets/functions/chat/backend/logout.php', {

        method:"POST",

        body:form_data

    }).then(function(response){

        return response.json();

    }).then(function(responseData){

        window.location.href = 'index.html';

    });
}

$('#search_people').onkeyup = function(){
    var query = _('search_people').value;

    if(query.length > 2)
    {
        var form_data = new FormData();

        form_data.append('query', query);

        fetch('../../../assets/functions/chat/backend/search_user.php', {

            method:"POST",

            body:form_data

        }).then(function(response){

            return response.json();

        }).then(function(responseData){

            var html = '<div class="d-flex text-muted pt-3">';
            if(responseData.length > 0)
            {                
                for(var i = 0; i < responseData.length; i++)
                {
                    html += '<img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src="../../../../assets/images/usuarios/'+responseData[i].ui+'" />';
                    html += '<div class="pb-4 mb-0 small lh-sm border-bottom w-100">';
                    html += '<div class="d-flex justify-content-between">';
                    html += '<strong class="text-gray-dark">'+responseData[i].un+'</strong>';
                    html += '<button type="button" name="chat_connect" class="btn btn-primary btn-sm chat_connect" id="'+responseData[i].uc+'">Conectar</button>'
                    html += '</div>';
                    html += '</div>';
                }
            }
            else
            {
                html += '<strong class="text-gray-dark">Não encontramos usuário com este nome.</strong>';
            }
            html += '</div>';

            _('search_people_area').innerHTML = html;

            if(responseData.length > 0)
            {
                $('.chat_connect').onclick = function(){

                    let uc = this.getAttribute('id');

                    send_request(uc);
                };
            }
        });
    }
};

function send_request(uc)
{
    $('#'+uc+'').disabled = true;

    var form_data = new FormData();

    form_data.append('uc', uc);

    form_data.append('action', 'send_request');

    fetch('../../../assets/functions/chat/backend/chat_request.php', {

        method:"POST",

        body:form_data

    }).then(function(response){

        return response.json();

    }).then(function(responseData){

        $('#'+uc+'').disabled = true;

        $('#'+uc+'').classList.add('btn-success');

        $('#'+uc+'').classList.remove('btn-primary');

        $('#'+uc+'').innerHTML = 'Request Send';

    });
}

load_chat_request();

function load_chat_request()
{
    var form_data = new FormData();

    form_data.append('action', 'load_request');

    fetch('../../../assets/functions/chat/backend/chat_request.php', {

        method:"POST",

        body:form_data

    }).then(function(response){

        return response.json();

    }).then(function(responseData){

        var html = '<div class="d-flex text-muted pt-3">';
        if(responseData.length > 0)
        {
            for(var i = 0; i < responseData.length; i++)
            {
                html += '<img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src="../../../../assets/images/usuarios/'+responseData[i].ui+'" />';
                html += '<div class="pb-4 mb-0 small lh-sm border-bottom w-100">';
                html += '<div class="d-flex justify-content-between">';
                html += '<strong class="text-gray-dark">'+responseData[i].un+'</strong>';
                html += '<button type="button" name="accept_request" class="btn btn-primary btn-sm accept_request" id="'+responseData[i].rc+'">Aceitar</button>';
                html += '</div>';
                html += '</div>';
            }
        }
        else
        {   //por texto Sem solicitações de contato abaixo
            html += '<strong class="text-gray-dark"></strong>';
        }
        $('#notification_area').innerHTML = html;

        load_chat_connected_people();

        if(responseData.length > 0)
        {


            $('.accept_request').onclick = function(){

                let rc = this.getAttribute('id');

                accept_request(rc);

            };
        }

    });
}

function accept_request(rc)
{
    $('#'+rc+'').disabled = true;

    var form_data = new FormData();

    form_data.append('rc', rc);

    form_data.append('action', 'accept_request');

    fetch('../../../assets/functions/chat/backend/chat_request.php', {

        method:"POST",

        body:form_data

    }).then(function(response){

        return response.json();

    }).then(function(responseData){

        $('#'+rc+'').classList.add('btn-success');

        $('#'+rc+'').classList.remove('btn-primary');

        $('#'+rc+'').innerHTML = 'Accepted';

        load_chat_connected_people();

    });
}

load_chat_connected_people();

function load_chat_connected_people()
{
    var form_data = new FormData();

    form_data.append('action', 'load_connected_people');

    fetch('../../../assets/functions/chat/backend/chat_request.php', {

        method:"POST",

        body:form_data

    }).then(function(response){

        return response.json();

    }).then(function(responseData){

        var html = '';
        if(responseData.length > 0)
        {
            //pega o nome das pessoas e grava em um array que vai via cookies
            const array_nomes = [];
            const array_botoes = [];
            for(var i = 0; i < responseData.length; i++)
            {
                html += '<div class="d-flex text-muted pt-3">';
                html += '<img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src="../../../../assets/images/usuarios/'+responseData[i].ui+'" />';
                html += '<div class="pb-4 mb-0 small lh-sm border-top w-100">';
                html += '<div class="d-flex justify-content-between">';
                html += '<strong class="text-gray-dark">'+responseData[i].un+'</strong>';
                html += '<button type="button" name="start_request" class="btn btn-warning btn-sm start_request" id="'+responseData[i].uc+'">Entrar</button>';
                html += '</div>';
                html += '</div></div>';
            }
        }
        else
        {
            html += '<strong class="text-gray-dark">Não encontramos usuários</strong>';
        }
        $('#connected_people_area').innerHTML = html;

        if(responseData.length > 0)
        {
            var elements = document.getElementsByClassName("start_request");

            //console.log(elements);
            for(var i = 0; i < elements.length; i++)
            {


                elements[i].onclick = function(){

                    let uc = this.getAttribute('id');

                    start_chat(uc);

                };
            }
        }
    });
}

function reset_chat_area()
{
    //var html = '<div class="row vh-100 align-items-center justify-content-center text-muted fw-bold">Selecione um usuário para iniciar o chat.</div>';
    //$('#chat_area').innerHTML = html;
    clearInterval(interval);
}

function start_chat(uc)
{
    reset_chat_area();
    Mudarestado('btn_chat');
    var html = '<div style="width: 350px; height: auto; z-index: 1; position:absolute; float: right; margin-bottom: 20px; position: absolute; right: 0px; bottom: 0;">';
    html += '<div id="chat_msg_area" class="pt-2 pb-2" style="height: 58vh;">';
    html += '<div class="card h-100">';
    html += '<div class="card-header"><div class="row"><div class="col" id="chat_user_data"></div><div class="col"><button type="button" class="btn btn-danger btn-sm float-end" id="close_chat">Fechar</button></div></div></div>';
    html += '<div class="card-body overflow-auto" id="chat_conversion"></div>';
    html += '<input name="type_chat_message" id="type_chat_message" class="form-control" placeholder="Mensagem..." aria-label="Escreva sua mensagem..." aria-describedby="button-addon2"></input>';
    html += '<input type="hidden" name="hidden_receiver_id" id="hidden_receiver_id" value="'+uc+'" /><input type="hidden" id="hidden_last_chat_datetime" />';
    html += '<button hidden class="btn btn-success" type="button" id="button-addon2">Enviar</button>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    $('#chat_area').innerHTML = html;
    fetch_chat_data(uc);


    //meu codigo----- que envia as mensagens com enter
    document.getElementById('type_chat_message')
    .addEventListener('keyup', function(event) {
        if (event.code === 'Enter')
        {
        var form_data = new FormData();

        form_data.append('action', 'send_chat');
        form_data.append('receiver_user_id', $('#hidden_receiver_id').value);
        form_data.append('msg', $('#type_chat_message').value);

        fetch('../../../assets/functions/chat/backend/chat_request.php', {
            method:"POST",
            body:form_data
        }).then(function(response){

            return response.json();

        }).then(function(responseData){
            $('#button-addon2').disabled = false;
            if(responseData.error != '')
            {
                alert(responseData.error);
            }
            else
            {
                $('#type_chat_message').value = '';
                //$('#chat_conversion').innerHTML += responseData.lc;
                //scroll_top();
            }

        });

        }
    });



    $('#close_chat').onclick = function(){
        $('#chat_area').innerHTML = '';
        reset_chat_area();
        Mudarestado('btn_chat');
    };

    $('#close_chat1').onclick = function(){
        //$('#chat_area1').innerHTML = '';
        //reset_chat_area1();
        Mudarestado('minhaDiv');
    };

    $('#button-addon2').onclick = function(){

        $('#button-addon2').disabled = true;

        var form_data = new FormData();

        form_data.append('action', 'send_chat');

        form_data.append('receiver_user_id', $('#hidden_receiver_id').value);

        form_data.append('msg', $('#type_chat_message').value);

        fetch('../../../assets/functions/chat/backend/chat_request.php', {

            method:"POST",

            body:form_data

        }).then(function(response){

            return response.json();

        }).then(function(responseData){

            $('#button-addon2').disabled = false;

            if(responseData.error != '')
            {
                alert(responseData.error);
            }
            else
            {
                $('#type_chat_message').value = '';

                //$('#chat_conversion').innerHTML += responseData.lc;

                //scroll_top();
            }

        });
    };

    interval = setInterval(function(){

        fetch_chat_data(uc, $('#hidden_last_chat_datetime').value);

    }, 1000);
}

function fetch_chat_data(receiver_user_id, last_chat_datetime)
{
    var form_data = new FormData();

    form_data.append('action', 'load_chat');

    form_data.append('receiver_user_id', receiver_user_id);

    form_data.append('last_chat_datetime', last_chat_datetime);

    fetch('../../../assets/functions/chat/backend/chat_request.php', {

        method:"POST",

        body:form_data, 

        cache:"no-cache"

    }).then(function(response){

        return response.json();

    }).then(function(responseData){

        if(responseData.receiver_image && responseData.receiver_name)
        {
            $('#chat_user_data').innerHTML = '<div class="d-flex text-muted"><img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src="../../../../assets/images/usuarios/'+responseData.receiver_image+'" /><div class="mb-0 small lh-sm w-100 align-middle"><div class="d-flex justify-content-between"><strong class="text-gray-dark">'+responseData.receiver_name+'</strong></div></div></div>';

        }

        var chat_html = '';

        if(responseData.cm)
        {
            for(var i = 0; i < responseData.cm.length; i++)
            {
                if(responseData.cm[i].action == 'Send')
                {
                    chat_html += '<div class="card text-white bg-info mb-3 w-75 float-end">';
                    chat_html += '<div class="card-footer "><img src="../../../../assets/images/usuarios/'+responseData.sender_image+'" width="25" class="rounded-circle me-2" /><b>'+responseData.sender_name+'</b><br><div style="text-align: left">'+responseData.cm[i].msg+'</div></div>';
                    chat_html += '</div>';
                }
                else
                {
                    chat_html += '<div class="card text-white bg-dark mb-3 w-75">';
                    chat_html += '<div class="card-footer "><img src="../../../../assets/images/usuarios/'+responseData.receiver_image+'" width="25" class="rounded-circle me-2" /><b>'+responseData.receiver_name+'</b><br><div style="text-align: left">'+responseData.cm[i].msg+'</div></div>';

                    chat_html += '</div>';
                }
                
            }

            $('#hidden_last_chat_datetime').value = responseData.last_chat_datetime;

            if(last_chat_datetime == '')
            {
                $('#chat_conversion').innerHTML = chat_html;
            }
            else
            {
                $('#chat_conversion').innerHTML += chat_html;
            }

            scroll_top();
        }
        

    });
}



function scroll_top()
{
    $('#chat_conversion').scrollTop = $('#chat_conversion').scrollHeight;
}

function setting_page()
{
    var user_data = '';
    fetch('../../../assets/functions/chat/backend/fetch_user_data.php').then(function(response){

        return response.json();

    }).then(function(responseData){

        var html = '<div class="row vh-100 align-items-center justify-content-center"><div class="col col-sm-8 align-self-center"><span id="register_error"></span>';
        html += '<form class="p-4 p-md-5 border rounded-3 bg-light" id="setting" method="POST" enctype="multipart/form-data" autocomplete="off"><button type="button" class="btn-close float-end" id="close_setting_page" aria-label="Fechar"></button>';
        html += '<h1 class="display-6 fw-bold mb-4 text-center">Setting</h1>';
        html += '<div class="row">';
        html += '<div class="col-md-6">';
        html += '<div class="form-floating mb-3">';
        html += '<input type="text" class="form-control" id="user_first_name" placeholder="Nome" name="user_first_name" required autocomplete="off" value="'+responseData.ufn+'">';
        html += '<label for="user_first_name">Nome</label>';
        html += '</div>';
        html += '</div>';
        html += '<div class="col-md-6">';
        html += '<div class="form-floating mb-3">';
        html += '<input type="text" class="form-control" id="user_last_name" placeholder="Sobrenome" name="user_last_name" required autocomplete="off" value="'+responseData.uln+'">';
        html += '<label for="user_last_name">Sobrenome</label>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="form-floating mb-3">';
        html += '<input type="email" class="form-control" id="user_email" placeholder="name@example.com" name="user_email" autocomplete="off" required value="'+responseData.ue+'">';
        html += '<label for="user_email">Email</label>';
        html += '</div>';
        html += '<div class="form-floating mb-3">';
        html += '<input type="password" class="form-control" id="user_password" placeholder="Senha" name="user_password" autocomplete="off" required value="'+responseData.up+'">';
        html += '<label for="user_password">Senha</label>';
        html += '</div>';
        html += '<div class="mb-3">';
        html += '<input type="file" name="user_image" id="user_image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required><input type="hidden" name="hidden_user_image" id="hidden_user_image" value="'+responseData.ui+'" /><br />';
        html += '<img src="../../../../assets/images/usuarios/'+responseData.ui+'" id="user_uploaded_image" class="img-fluid rounded mt-2 mb-1" />';
        html += '</div>';
        html += '<button class="w-100 btn btn-lg btn-primary" id="save_button" type="submit">Enviar</button>';
        html += '</form></div></div>';

        $('#chat_area').innerHTML = html;

        $('#close_setting_page').onclick = function(){
            reset_chat_area();
        }

        $('#save_button').onclick = function(){

            var form_data = new FormData($('#setting'));

            $('#save_button').disabled = true;

            $('#save_button').innerHTML = 'Aguarde...';

            fetch('../../../assets/functions/chat/backend/setting.php', {

                method:"POST",

                body:form_data

            }).then(function(response){

                return response.json();

            }).then(function(responseData){

                $('#save_button').disabled = false;

                $('#save_button').innerHTML = 'Save';

                if(responseData.error != '')
                {
                    var error = '<div class="alert alert-danger"><ul>'+responseData.error+'</ul></div>';
                    $('#register_error').innerHTML = error;
                }
                else
                {
                    $('#register_error').innerHTML = '<div class="alert alert-success">' + responseData.success + '</div>';

                    $('#user_image').value = '';

                    check_login();

                    $('#user_uploaded_image').src = 'images/'+responseData.ui+'';

                    $('#hidden_user_image').value = responseData.ui;

                }

                setTimeout(function(){

                    _('register_error').innerHTML = '';

                }, 10000);

            });
        }
        
    });

    
}

$('#setting_button').onclick = function(){

    reset_chat_area();

    setting_page();
};



function _(element)
{
    return document.getElementById(element);
}





</script>

