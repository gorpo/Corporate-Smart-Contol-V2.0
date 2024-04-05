<!-- @Gorpo Orko - 2020 -->

<?php


//cria a tabela de customização
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = $pdo->prepare("CREATE TABLE  IF NOT EXISTS `customizar` (
`id` INT NOT NULL,
`dark_mode` varchar(200) NOT NULL,
`fixar_cabecalho` varchar(200) NOT NULL,
`dropdown_legacy` varchar(200) NOT NULL,
`sem_bordas` varchar(200) NOT NULL,
`menu_fechado` varchar(200) NOT NULL,
`menu_flat` varchar(200) NOT NULL,
`menu_legacy` varchar(200) NOT NULL,
`menu_compact` varchar(200) NOT NULL,
`submenu` varchar(200) NOT NULL,
`submenu_esconder` varchar(200) NOT NULL,
`desabilitar_auto_expand` varchar(200) NOT NULL,
`fixa_rodape` varchar(200) NOT NULL,
`texto_corpo` varchar(200) NOT NULL,
`texto_barra_navegacao` varchar(200) NOT NULL,
`texto_logotipo` varchar(200) NOT NULL,
`texto_barra_lateral` varchar(200) NOT NULL,
`texto_rodape` varchar(200) NOT NULL,
`cor_barra_topo` varchar(200) NOT NULL,
`cor_logo` varchar(200) NOT NULL,
PRIMARY KEY (id)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;");
$sql->execute();
$pdo = Database::desconectar();

//cria a tabela com valores vazios
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = $pdo->prepare("INSERT IGNORE `customizar` ( `dark_mode`,`fixar_cabecalho`,`dropdown_legacy`,`sem_bordas`,`menu_fechado`,`menu_flat`,`menu_legacy`,`menu_compact`,`submenu`,`submenu_esconder`,`desabilitar_auto_expand`,`fixa_rodape`,`texto_corpo`,`texto_barra_navegacao`,`texto_logotipo`,`texto_barra_lateral`,`texto_rodape`,`cor_barra_topo`,`cor_logo`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ;");
$sql->execute(array('none','none','none','none','none','none','none','none','none','none','none','none','none','none','none','none','none','none','none'));
$pdo = Database::desconectar();




//dark_mode
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['dark_mode'] == 'dark_mode') {
    echo '<script type="text/javascript">
            var body = document.body;
            body.classList.add("dark-mode");
          </script>';
  }else{

  }
}


//fixar_cabecalho
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['fixar_cabecalho'] == 'fixar_cabecalho') {
    echo '<script type="text/javascript">
            var body = document.body;
            body.classList.add("layout-navbar-fixed");
          </script>';
  }else{

  }
}


//dropdown-legacy 
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['dropdown_legacy'] == 'dropdown_legacy') {
    echo '<script type="text/javascript">
            var dropdown-legacy  = document.getElementsByClassName("main-header");
           dropdown-legacy [0].classList.add("dropdown-legacy");
          </script>';
  }else{

  }
}


//sem_bordas
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['sem_bordas'] == 'sem_bordas') {
    echo '<script type="text/javascript">
            var main_header = document.getElementsByClassName("main-header");
            main_header[0].classList.add("border-bottom-0");
          </script>';
  }else{

  }
}


//menu_fechado
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['menu_fechado'] == 'menu_fechado') {
    echo '<script type="text/javascript">
            var body = document.body;
            body.classList.add("sidebar-collapse");
          </script>';
  }else{

  }
}




//menu_flat
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['menu_flat'] == 'menu_flat') {
    echo '<script type="text/javascript">
            var navsidebar = document.getElementsByClassName("nav-sidebar");
            navsidebar[0].classList.add("nav-flat");
          </script>';
  }else{

  }
}


//menu_legacy
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['menu_legacy'] == 'menu_legacy') {
    echo '<script type="text/javascript">
            var navsidebar1 = document.getElementsByClassName("nav-sidebar");
            navsidebar1[0].classList.add("nav-legacy");
          </script>';
  }else{

  }
}


//menu_compact 
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['menu_compact'] == 'menu_compact') {
    echo '<script type="text/javascript">
            var navsidebar2 = document.getElementsByClassName("nav-sidebar");
            navsidebar2[0].classList.add("nav-compact");
          </script>';
  }else{

  }
}


//submenu
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['submenu'] == 'submenu') {
    echo '<script type="text/javascript">
            var navsidebar3 = document.getElementsByClassName("nav-sidebar");
            navsidebar3[0].classList.add("nav-child-indent");
          </script>';
  }else{

  }
}


//submenu_esconder
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['submenu_esconder'] == 'submenu_esconder') {
    echo '<script type="text/javascript">
            var navsidebar4 = document.getElementsByClassName("nav-sidebar");
            navsidebar4[0].classList.add("nav-collapse-hide-child");
          </script>';
  }else{

  }
}


//desabilitar_auto_expand
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['desabilitar_auto_expand'] == 'desabilitar_auto_expand') {
    echo '<script type="text/javascript">
            var navsidebar5 = document.getElementsByClassName("main-sidebar");
            navsidebar5[0].classList.add("sidebar-no-expand");
          </script>';
  }else{

  }
}


//fixa_rodape
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['fixa_rodape'] == 'fixa_rodape') {
    echo '<script type="text/javascript">
            var body = document.body;
            body.classList.add("layout-footer-fixed");
          </script>';
  }else{

  }
}


//texto_corpo
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['texto_corpo'] == 'texto_corpo') {
    echo '<script type="text/javascript">
            var body = document.body;
            body.classList.add("text-sm");
          </script>';
  }else{

  }
}


//texto_barra_navegacao
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['texto_barra_navegacao'] == 'texto_barra_navegacao') {
    echo '<script type="text/javascript">
            var navsidebar6 = document.getElementsByClassName("main-header");
            navsidebar6[0].classList.add("text-sm");
          </script>';
  }else{

  }
}


//texto_logotipo
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['texto_logotipo'] == 'texto_logotipo') {
    echo '<script type="text/javascript">
            var navsidebar7 = document.getElementsByClassName("brand-link");
            navsidebar7[0].classList.add("text-sm");
          </script>';
  }else{

  }
}


//texto_barra_lateral
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['texto_barra_lateral'] == 'texto_barra_lateral') {
    echo '<script type="text/javascript">
            var navsidebar8 = document.getElementsByClassName("nav-sidebar");
            navsidebar8[0].classList.add("text-sm");
          </script>';
  }else{

  }
}


//texto_rodape
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['texto_rodape'] == 'texto_rodape') {
    echo '<script type="text/javascript">
            var navsidebar9 = document.getElementsByClassName("main-footer");
            navsidebar9[0].classList.add("text-sm");
          </script>';
  }else{

  }
}



//cor_barra_topo
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['cor_barra_topo'] != 'cor_barra_topo_off') {

    echo '<script type="text/javascript">
            document.getElementById("navbar_cor").classList.remove("navbar-white");
            document.getElementById("navbar_cor").classList.add("'.$row['cor_barra_topo'] .'");
          </script>';
  }else{

  }
}


//cor_logo
$pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
$sql = "SELECT * FROM customizar";
foreach($pdo->query($sql)as $row){
  if ($row['cor_logo'] != 'cor_barra_topo_off') {

    echo '<script type="text/javascript">
            //document.getElementById("cor_logo").classList.remove("navbar-white");
            document.getElementById("cor_logo").classList.add("'.$row['cor_logo'] .'");
          </script>';
  }else{

  }
}



?>
