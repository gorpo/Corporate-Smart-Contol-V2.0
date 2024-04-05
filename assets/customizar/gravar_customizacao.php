<!-- @Gorpo Orko - 2020 -->

<?php

session_start();
require '../../database.php';
$customizar = $_GET['customizar'];

if(!$_SESSION['nome']) {
  header('Location: ../../index.php');
  exit();
}


//seta o darkmode
if($customizar =='dark_mode'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['dark_mode'] != 'dark_mode'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `dark_mode`) VALUES (?) ON DUPLICATE KEY UPDATE dark_mode= 'dark_mode';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `dark_mode`) VALUES (?) ON DUPLICATE KEY UPDATE dark_mode= 'dark_mode_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//seta o fixar_cabecalho
if($customizar =='fixar_cabecalho'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['fixar_cabecalho'] != 'fixar_cabecalho'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `fixar_cabecalho`) VALUES (?) ON DUPLICATE KEY UPDATE fixar_cabecalho= 'fixar_cabecalho';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `fixar_cabecalho`) VALUES (?) ON DUPLICATE KEY UPDATE fixar_cabecalho= 'fixar_cabecalho_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//dropdown-legacy
if($customizar =='dropdown_legacy'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['dropdown_legacy'] != 'dropdown_legacy'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `dropdown_legacy`) VALUES (?) ON DUPLICATE KEY UPDATE dropdown_legacy= 'dropdown_legacy';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `dropdown_legacy`) VALUES (?) ON DUPLICATE KEY UPDATE dropdown_legacy= 'dropdown_legacy_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//sem_bordas
if($customizar =='sem_bordas'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['sem_bordas'] != 'sem_bordas'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `sem_bordas`) VALUES (?) ON DUPLICATE KEY UPDATE sem_bordas= 'sem_bordas';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `sem_bordas`) VALUES (?) ON DUPLICATE KEY UPDATE sem_bordas= 'sem_bordas_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//menu_fechado
if($customizar =='menu_fechado'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['menu_fechado'] != 'menu_fechado'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `menu_fechado`) VALUES (?) ON DUPLICATE KEY UPDATE menu_fechado= 'menu_fechado';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `menu_fechado`) VALUES (?) ON DUPLICATE KEY UPDATE menu_fechado= 'menu_fechado_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}




//menu_flat
if($customizar =='menu_flat'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['menu_flat'] != 'menu_flat'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `menu_flat`) VALUES (?) ON DUPLICATE KEY UPDATE menu_flat= 'menu_flat';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `menu_flat`) VALUES (?) ON DUPLICATE KEY UPDATE menu_flat= 'menu_flat_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//menu_legacy
if($customizar =='menu_legacy'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['menu_legacy'] != 'menu_legacy'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `menu_legacy`) VALUES (?) ON DUPLICATE KEY UPDATE menu_legacy= 'menu_legacy';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `menu_legacy`) VALUES (?) ON DUPLICATE KEY UPDATE menu_legacy= 'menu_legacy_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//menu_compact
if($customizar =='menu_compact'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['menu_compact'] != 'menu_compact'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `menu_compact`) VALUES (?) ON DUPLICATE KEY UPDATE menu_compact= 'menu_compact';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `menu_compact`) VALUES (?) ON DUPLICATE KEY UPDATE menu_compact= 'menu_compact_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//submenu
if($customizar =='submenu'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['submenu'] != 'submenu'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `submenu`) VALUES (?) ON DUPLICATE KEY UPDATE submenu= 'submenu';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `submenu`) VALUES (?) ON DUPLICATE KEY UPDATE submenu= 'submenu_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}




//submenu_esconder
if($customizar =='submenu_esconder'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['submenu_esconder'] != 'submenu_esconder'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `submenu_esconder`) VALUES (?) ON DUPLICATE KEY UPDATE submenu_esconder= 'submenu_esconder';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `submenu_esconder`) VALUES (?) ON DUPLICATE KEY UPDATE submenu_esconder= 'submenu_esconder_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//desabilitar_auto_expand
if($customizar =='desabilitar_auto_expand'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['desabilitar_auto_expand'] != 'desabilitar_auto_expand'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `desabilitar_auto_expand`) VALUES (?) ON DUPLICATE KEY UPDATE desabilitar_auto_expand= 'desabilitar_auto_expand';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `desabilitar_auto_expand`) VALUES (?) ON DUPLICATE KEY UPDATE desabilitar_auto_expand= 'desabilitar_auto_expand_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//fixa_rodape
if($customizar =='fixa_rodape'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['fixa_rodape'] != 'fixa_rodape'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `fixa_rodape`) VALUES (?) ON DUPLICATE KEY UPDATE fixa_rodape= 'fixa_rodape';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `fixa_rodape`) VALUES (?) ON DUPLICATE KEY UPDATE fixa_rodape= 'fixa_rodape_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}

//texto_corpo
if($customizar =='texto_corpo'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['texto_corpo'] != 'texto_corpo'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `texto_corpo`) VALUES (?) ON DUPLICATE KEY UPDATE texto_corpo= 'texto_corpo';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `texto_corpo`) VALUES (?) ON DUPLICATE KEY UPDATE texto_corpo= 'texto_corpo_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//texto_barra_navegacao
if($customizar =='texto_barra_navegacao'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['texto_barra_navegacao'] != 'texto_barra_navegacao'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `texto_barra_navegacao`) VALUES (?) ON DUPLICATE KEY UPDATE texto_barra_navegacao= 'texto_barra_navegacao';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `texto_barra_navegacao`) VALUES (?) ON DUPLICATE KEY UPDATE texto_barra_navegacao= 'texto_barra_navegacao_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//texto_logotipo
if($customizar =='texto_logotipo'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['texto_logotipo'] != 'texto_logotipo'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `texto_logotipo`) VALUES (?) ON DUPLICATE KEY UPDATE texto_logotipo= 'texto_logotipo';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `texto_logotipo`) VALUES (?) ON DUPLICATE KEY UPDATE texto_logotipo= 'texto_logotipo_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//texto_barra_lateral
if($customizar =='texto_barra_lateral'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['texto_barra_lateral'] != 'texto_barra_lateral'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `texto_barra_lateral`) VALUES (?) ON DUPLICATE KEY UPDATE texto_barra_lateral= 'texto_barra_lateral';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `texto_barra_lateral`) VALUES (?) ON DUPLICATE KEY UPDATE texto_barra_lateral= 'texto_barra_lateral_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//texto_rodape
if($customizar =='texto_rodape'){
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['texto_rodape'] != 'texto_rodape'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `texto_rodape`) VALUES (?) ON DUPLICATE KEY UPDATE texto_rodape= 'texto_rodape';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `texto_rodape`) VALUES (?) ON DUPLICATE KEY UPDATE texto_rodape= 'texto_rodape_off';");
      $sql->execute(array($customizar));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}



//cor_barra_topo
if($customizar =='cor_barra_topo'){
  $cor = $_GET['cor'];
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['cor_barra_topo'] != 'cor_barra_topo'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `cor_barra_topo`) VALUES (?) ON DUPLICATE KEY UPDATE cor_barra_topo= '$cor';");
      $sql->execute(array($cor));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `cor_barra_topo`) VALUES (?) ON DUPLICATE KEY UPDATE cor_barra_topo= 'cor_barra_topo_off';");
      $sql->execute(array($cor));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}


//cor_logo
if($customizar =='cor_logo'){
  $cor1 = $_GET['cor_logo'];
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['cor_logo'] != 'cor_logo_off'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `cor_logo`) VALUES (?) ON DUPLICATE KEY UPDATE cor_logo= '$cor1';");
      $sql->execute(array($cor1));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `cor_logo`) VALUES (?) ON DUPLICATE KEY UPDATE cor_logo= 'cor_logo_off';");
      $sql->execute(array($cor1));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}

//cor_menu_esquerda
if($customizar =='cor_menu_esquerda'){
  $cor1 = $_GET['cor_menu_esquerda'];
  $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
  $sql = 'SELECT * FROM customizar';
  foreach($pdo->query($sql)as $row){
      if($row['cor_menu_esquerda'] != 'cor_menu_esquerda_off'){
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `cor_menu_esquerda`) VALUES (?) ON DUPLICATE KEY UPDATE cor_menu_esquerda= '$cor1';");
      $sql->execute(array($cor1));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }else{
      $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = $pdo->prepare("INSERT  `customizar` ( `cor_menu_esquerda`) VALUES (?) ON DUPLICATE KEY UPDATE cor_menu_esquerda= 'cor_menu_esquerda_off';");
      $sql->execute(array($cor1));
      $pdo = Database::desconectar();
      header('Location: '.$_GET['old_url']);
    }
  }
}

?>

