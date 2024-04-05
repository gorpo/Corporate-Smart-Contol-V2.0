<?php 
require 'cria_database.php';
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Sistema de automação comercial">
    <meta name="author" content="Corporate Smart Control - Guilherme Paluch">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
	<meta property="og:site_name" content="Corporate Smart Control" /> <!-- website name -->
	<meta property="og:site" content="https://corporatesmartcontrol.com" /> <!-- website link -->

<!-- HTML Meta Tags -->
<title>Corporate Smart Control</title>


<!-- Facebook Meta Tags -->
<meta property="og:url" content="https://corporatesmartcontrol.com/">
<meta property="og:type" content="website">
<meta property="og:title" content="Corporate Smart Control">
<meta property="og:description" content="Sistema de automação empresarial">
<meta property="og:image" content="http://corporatesmartcontrol.com/assets/images/bg_logo.jpg">

<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:domain" content="corporatesmartcontrol.com">
<meta property="twitter:url" content="https://corporatesmartcontrol.com/">
<meta name="twitter:title" content="Corporate Smart Control">
<meta name="twitter:description" content="Sistema de automação empresarial">
<meta name="twitter:image" content="http://corporatesmartcontrol.com/assets/images/bglogo.jpg">

<!-- Styles -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
<link href="assets/css/bootstrap.css" rel="stylesheet">
<link href="assets/css/fontawesome-all.css" rel="stylesheet">
<link href="assets/css/swiper.css" rel="stylesheet">
<link href="assets/css/magnific-popup.css" rel="stylesheet">
<link href="assets/css/styles.css" rel="stylesheet">
	
	<!-- Favicon  -->
    <link rel="icon" href="assets/images/icon.png">

    
</head>
<body data-spy="scroll" data-target=".fixed-top">
 
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark">
        <div class="container">
            
            
            <!-- Image Logo -->
            <a class="navbar-brand logo-image" href="index.php"><img src="assets/images/logo_bco.png" alt=""></a> 

            <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#header">HOME <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#registration">REGISTRO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#details">DETALHES</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">INFORMAÇÕES</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item page-scroll" href="article.php">INSTRUÇÕES DETALHADAS</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item page-scroll" href="terms.php">TERMOS E CONDIÇÕES</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item page-scroll" href="privacy.php">POLITICA DE PRIVACIDADE</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#purchase">COMPRAR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="sistema/admin">ENTRAR <i class="fas fa-lock"></i></a>
                    </li>
                </ul>
                <span class="nav-item social-icons">
                    <span class="fa-stack">
                        <a href="https://www.facebook.com/corporatesmartcontrol">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-facebook-f fa-stack-1x"></i>
                        </a>
                    </span>
                    <span class="fa-stack">
                        <a href="#your-link">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-instagram fa-stack-1x"></i>
                        </a>
                    </span>
                </span>
            </div> <!-- end of navbar-collapse -->
        </div> <!-- end of container -->
    </nav> <!-- end of navbar -->
    <!-- end of navigation -->


    <!-- Header -->
    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <!-- Text Slider -->
                    <div class="slider-container">
                        <div class="swiper-container text-slider">
                            <div class="swiper-wrapper">
                                
                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <div class="row">
                                        <div class="col-lg-6 col-xl-7">
                                            <div class="image-container" >
                                                <img class="img-fluid" src="assets/images/banner_login.jpg" alt="alternative">
                                            </div> <!-- end of image-container -->
                                        </div> <!-- end of col -->
                                        <div class="col-lg-6 col-xl-5">
                                            <div class="text-container">
                                                <h1 class="h1-large">Sistema empresarial</h1>
                                                <p class="p-large">O melhor e mais completo sistema de automação para gerir tudo de sua empresa e seu negócio.</p>
                                                <a class="btn-solid-lg page-scroll" href="#registration">TESTE GRÁTIS</a>
                                                <a class="btn-outline-lg page-scroll" href="#purchase">COMPRAR</a>
                                            </div> <!-- end of text-container -->
                                        </div> <!-- end of col -->
                                    </div> <!-- end of row -->
                                </div> <!-- end of swiper-slide -->
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <div class="row">
                                        <div class="col-lg-6 col-xl-7">
                                            <div class="image-container">
                                                <img class="img-fluid" src="assets/images/banner_inicio.jpg" alt="alternative">
                                            </div> <!-- end of image-container -->
                                        </div> <!-- end of col -->
                                        <div class="col-lg-6 col-xl-5">
                                            <div class="text-container">
                                                <h1 class="h1-large">Sua empresa em um só lugar</h1>
                                                <p class="p-large">Todos os dados de sua empresa em um só lugar, tenha o controle de tudo em suas mãos.</p>
                                                <a class="btn-solid-lg page-scroll" href="#registration">TESTE GRÁTIS</a>
                                                <a class="btn-outline-lg page-scroll" href="#purchase">COMPRAR</a>
                                            </div> <!-- end of text-container -->
                                        </div> <!-- end of col -->
                                    </div> <!-- end of row -->
                                </div> <!-- end of swiper-slide -->
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <div class="row">
                                        <div class="col-lg-6 col-xl-7">
                                            <div class="image-container">
                                                <img class="img-fluid" src="assets/images/banner_produtos.jpg" alt="alternative">
                                            </div> <!-- end of image-container -->
                                        </div> <!-- end of col -->
                                        <div class="col-lg-6 col-xl-5">
                                            <div class="text-container">
                                                <h1 class="h1-large">Controle de produção</h1>
                                                <p class="p-large">Controle sua produção desde a entrada da matéria prima ao produto acabado em estoque.</p>
                                                <a class="btn-solid-lg page-scroll" href="#registration">TESTE GRÁTIS</a>
                                                <a class="btn-outline-lg page-scroll" href="#purchase">COMPRAR</a>
                                            </div> <!-- end of text-container -->
                                        </div> <!-- end of col -->
                                    </div> <!-- end of row -->
                                </div> <!-- end of swiper-slide -->
                                <!-- end of slide -->

                            </div> <!-- end of swiper-wrapper -->
                            
                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <!-- end of add arrows -->

                        </div> <!-- end of swiper-container -->
                    </div> <!-- end of slider-container -->
                    <!-- end of text slider -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->

        </div> <!-- end of container --> 


    </header> <!-- end of header -->
    <!-- end of header -->


    <!-- Registration -->
    <div id="registration" class="form-1 bg-dark-blue">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="text-container">
                        <h2>Registre-se para a avaliação gratuita</h2>
                        <p>Você está a apenas alguns cliques de usar o primeiro aplicativo desktop e mobile dedicado a empreededores. Preencha o formulário para obter o teste de 30 dias.</p>
                        <ul class="list-unstyled li-space-lg">
                            <li class="media">
                                <i class="fas fa-square"></i><div class="media-body"><strong>Cadastro de administradores</strong> 
                                </div>
                            </li>
                            <li class="media">
                                <i class="fas fa-square"></i><div class="media-body"><strong>Cadastro de usuários</strong> 
                                </div>
                            </li>
                            <li class="media">
                                <i class="fas fa-square"></i><div class="media-body"><strong>Cadastro de representantes.</strong> 
                                </div>
                            </li>
                            <li class="media">
                                <i class="fas fa-square"></i><div class="media-body"><strong>Controle de produção</strong> 
                                </div>
                            </li>
                            <li class="media">
                                <i class="fas fa-square"></i><div class="media-body"><strong>Ordens de serviço</strong> 
                                </div>
                            </li>
                            <li class="media">
                                <i class="fas fa-square"></i><div class="media-body"><strong>Controle de matéria prima e estoque</strong> 
                                </div>
                            </li>
                            <li class="media">
                                <i class="fas fa-square"></i><div class="media-body"><strong>Valor total em matéria prima e produtos</strong> 
                                </div>
                            </li>
                        </ul>
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6">

                    <!-- Registration Form -->
                    <form id="registrationForm" onSubmit = "return checkPassword(this)" action="cadastro.php" method="POST" name="form1" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="text" class="form-control-input" id="rname" name="nome" required>
                            <label class="label-control" for="rname">Nome</label>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control-input" id="rsna" name="sobrenome" required>
                            <label class="label-control" for="rsna">Sobrenome</label>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control-input"  id="phone" name="telefone" required>
                            <label class="label-control" type="tel" id="phone"  pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">Telefone</label>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control-input"  id="remail" name="email" required>
                            <label class="label-control" for="remail">Email</label>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control-input" id="password1" name="senha" required>
                            <label class="label-control" for="password1">Senha</label>
                            <button type="button" id="btnToggle" class="toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control-input" id="password2" required>
                            <label class="label-control" for="password2">Repita a Senha</label>
                            <button type="button" id="btnToggle2" class="toggle"><i id="eyeIcon2" class="fa fa-eye"></i></button>
                        </div>

                        <div class="form-group checkbox">
                            <input type="checkbox" id="rterms" value="Agreed-to-Terms" required>Eu concordo com a Política de Privacidade 
                            <a href="privacy.php">Política de Privacidade</a> e <a href="terms.php">Termos e Condições do site</a>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control-submit-button">INSCREVER-SE</button>
                        </div>
                    </form>
                    <!-- end of registration form -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of form-1 -->
    <!-- end of registration -->


    <!-- Features -->
    <div id="features" class="cards-1 bg-dark-blue">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="h2-heading">Recursos do CSC</h2>
                    <p class="p-heading">Temos o melhor a mais completo sistema de gerenciamento<br> de empresas, indústrias, lojas e comercio.</p>
                </div> <!-- end of div -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">
                    
                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <i class="fas fa-rocket" style="color: whitesmoke;"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title" style="color: #0B0433;">Sistema Fluido</h5>
                            <p>Ferramentas de ponta que o ajudarão a esboçar suas ideias em tempo recorde e preparar sua empresa e seus funcionários, unificando todos os setores em todos processos.</p>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <i class="fas fa-tv" style="color: whitesmoke;"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title" style="color: #0B0433;">Facilidade de Acesso</h5>
                            <p>Controle sua empresa via Desktop ou via Mobile em nossa plataforma, fazendo uso de nossos programas e apps faça desde reuniões online a controle de todos processos.</p>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <i class="fas fa-user-tag" style="color: whitesmoke;"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title" style="color: #0B0433;">Unifique Funcionários</h5>
                            <p>Com diferentes níveis de acesso, todos da sua empresa podem ter acesso ao sistema, automatizando seu trabalho de coordenação e protocolando todos os processos</p>
                        </div>
                    </div>
                    <!-- end of card -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of cards-1 -->
    <!-- end of features -->


    <!-- Details 1 -->
    <div id="details" class="basic-1 bg-dark-blue">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <img class="img-fluid" src="assets/images/banner_inicio.jpg" alt="alternative">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6 col-xl-5">
                    <div class="text-container">
                        <h2>Funcionalidades do CSC</h2>
                        <p>O Corporate Smart Control oferece tudo de mais completo para gerir as tarefas dos funcionários de sua empresa</p>
                        <ul class="list-unstyled li-space-lg">
                            <li class="media">
                                <i class="fas fa-square"></i>
                                <div class="media-body"><strong>Sistemas de administrador e funcionários separados</strong>
                                </div>
                            </li>
                            <li class="media">
                                <i class="fas fa-square"></i>
                                <div class="media-body"><strong>Cadastro de funcionários de acordo com a ISO9001</strong> 
                            </div>
                            </li>
                        </ul>
                        <a class="btn-solid-reg popup-with-move-anim" href="#details-lightbox">TESTE GRÁTIS</a>
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of basic-1 -->
    <!-- end of details 1 -->


    <!-- Details Lightbox -->
    <!-- Lightbox -->
	<div id="details-lightbox" class="lightbox-basic zoom-anim-dialog mfp-hide">
        <div class="row">
            <button title="Close (Esc)" type="button" class="mfp-close x-button">×</button>
			<div class="col-lg-8">
                <div class="image-container">
                    <img class="img-fluid" src="assets/images/banner_representantes.jpg" alt="alternative">
                </div> <!-- end of image-container -->
			</div> <!-- end of col -->
			<div class="col-lg-4">
                <h3>Corporate Smart Control</h3>
				<hr>
                <p>O Corporate Smart Control é um sistema completo para empresas. O sistema conta com Dashboard,sistema de compras para representantes, oferece praticidade para todos seus processos internos de acordo com a ISO9001.</p>
                <h4>Teste Grátis</h4>
                <p>Teste funcionalidades como:</p>
                <ul class="list-unstyled li-space-lg">
                    <li class="media">
                        <i class="fas fa-square"></i><div class="media-body">Dashboard</div>
                    </li>
                    <li class="media">
                        <i class="fas fa-square"></i><div class="media-body">Cadastro de usuários</div>
                    </li>
                    <li class="media">
                        <i class="fas fa-square"></i><div class="media-body">Cadastro de Representantes</div>
                    </li>
                    <li class="media">
                        <i class="fas fa-square"></i><div class="media-body">Cadastro de produtos</div>
                    </li>
                    <li class="media">
                        <i class="fas fa-square"></i><div class="media-body">Emita Ordens de Serviço</div>
                    </li>
                </ul>
                <a class="btn-solid-reg mfp-close page-scroll" href="#registration">TESTE GRÁTIS</a> <button class="btn-outline-reg mfp-close as-button" type="button">VOLTAR</button>
			</div> <!-- end of col -->
		</div> <!-- end of row -->
    </div> <!-- end of lightbox-basic -->
    <!-- end of lightbox -->
    <!-- end of details lightbox -->


    <!-- Details 2 -->
    <div class="tabs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5">
                    <div class="tabs-container">
                        <div class="tab-content" id="revoTabsContent">
        
                            <!-- Tab -->
                            <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab-1">
                                <h4>Sistema de Representantes</h4>
                                <p>O sistema conta com uma loja online, onde seu representante pode conferir seus produtos e fazer seu pedido, confira esta e outros recursos disponíveis em nosso sistema.</p>
                                <ul class="list-unstyled li-space-lg">
                                    <li class="media">
                                        <i class="fas fa-square"></i>
                                        <div class="media-body"><strong>Cadastre seus representantes</strong> 
                                        </div>
                                    </li>
                                    <li class="media">
                                        <i class="fas fa-square"></i>
                                        <div class="media-body"><strong>Gerencie todas as compras dos representates</strong> </div>
                                    </li>
                                    <li class="media">
                                        <i class="fas fa-square"></i>
                                        <div class="media-body"><strong>Aplicativo exclusivo para representantes</strong>
                                        </div>
                                    </li>
                                </ul>
                            </div> <!-- end of tab-pane --> 
                            <!-- end of tab -->
                        </div> <!-- end of tab-content -->
                        <!-- end of tabs content -->
                    </div> <!-- end of tabs-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <img class="img-fluid" src="assets/images/banner_representantes.jpg" alt="alternative">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of tabs -->
    <!-- end of details 2 -->


    <!-- Testimonials -->
    <div class="slider-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Card Slider -->
                    <div class="slider-container">
                        <div class="swiper-container card-slider">
                            <div class="swiper-wrapper">
                                
                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <div class="card">
                                        <img class="card-image" src="assets/images/testimonial-4.jpg" alt="alternative">
                                        <div class="card-body">
                                            <p class="testimonial-text">Hoje compro de diversas empresas desta plataforma através de suas lojas virtuais e os preços são os melhores do mercado.</p>
                                            <p class="testimonial-author">Jhon Smith - Representante Comercial</p>
                                        </div>
                                    </div>
                                </div> <!-- end of swiper-slide -->
                                <!-- end of slide -->
        
                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <div class="card">
                                        <img class="card-image" src="assets/images/testimonial-2.jpg" alt="alternative">
                                        <div class="card-body">
                                            <p class="testimonial-text">O CSC mudou a forma que trabalhamos, hoje dependemos dele para tudo no gerenciamento de nossa empresa.</p>
                                            <p class="testimonial-author">Jader Marciel - Empresário</p>
                                        </div>
                                    </div>        
                                </div> <!-- end of swiper-slide -->
                                <!-- end of slide -->
        
                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <div class="card">
                                        <img class="card-image" src="assets/images/testimonial-3.jpg" alt="alternative">
                                        <div class="card-body">
                                            <p class="testimonial-text">Este sistema ajudou muito com nossa ISO9001, sem ele não teria sido possivel obter a Certificação ISO9001.</p>
                                            <p class="testimonial-author">Joana Singer - Coordenadora</p>
                                        </div>
                                    </div>        
                                </div> <!-- end of swiper-slide -->
                                <!-- end of slide -->
        
                               
        
                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <div class="card">
                                        <img class="card-image" src="assets/images/testimonial-5.jpg" alt="alternative">
                                        <div class="card-body">
                                            <p class="testimonial-text">Uso o sistema de RH do CSC e ele é incrivel, atendeu todos requisitos para automatizar meu trabalho e armazenar documentos.</p>
                                            <p class="testimonial-author">Luana Benckel - Recursos Humanos</p>
                                        </div>
                                    </div>        
                                </div> <!-- end of swiper-slide -->
                                <!-- end of slide -->
        
                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <div class="card">
                                        <img class="card-image" src="assets/images/testimonial-6.jpg" alt="alternative">
                                        <div class="card-body">
                                            <p class="testimonial-text">Hoje o financeiro da empresa não trabalha mais sem ele, automatizou todos meus processos, tenho relatórios perfeitos!</p>
                                            <p class="testimonial-author">Anne Willians - Gerente Financeiro</p>
                                        </div>
                                    </div>        
                                </div> <!-- end of swiper-slide -->
                                <!-- end of slide -->
                            
                            </div> <!-- end of swiper-wrapper -->
        
                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <!-- end of add arrows -->
        
                        </div> <!-- end of swiper-container -->
                    </div> <!-- end of slider-container -->
                    <!-- end of card slider -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of slider-1 -->
    <!-- end of testimonials -->


    <!-- Purchase -->
    <div id="purchase" class="basic-3 bg-dark-blue">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="h2-heading">Obtenha agora o CSC</h2>
                    <p class="p-heading p-large">Gerencie sua empresa e venda seus produtos para representantes na mesma plataforma. Nunca foi tão facil gerenciar sua empresa.</p>
                    <a class="btn-solid-lg" href="#your-link">COMPRAR</a> <a class="btn-outline-lg page-scroll" href="#registration">TESTAR</a>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of basic-3 -->
    <!-- end of purchase -->


    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-col first">
                        <h6>Sobre o CSC</h6>
                        <p class="p-small">O Corporate Smart Control é o sistema mais completo para empresas, indústrias e comercios, nosso sistema conta com Dashboard intuitiva e um sistema de compras para seus representantes além de oferecer a praticidade de controlar todos seus processos internos de acordo com a ISO9001.</p>
                    </div> <!-- end of footer-col -->
                    <div class="footer-col second">
                        <h6>Links</h6>
                        <ul class="list-unstyled li-space-lg p-small">
                            <li><a class="page-scroll" href="#header">Home</a>
                            <li><a href="terms.php">Termos e condições</a></li>
                            <li><a href="privacy.php">Política de Privacidade</a></li>
                        </ul>
                    </div> <!-- end of footer-col -->
                    <div class="footer-col third">
                        <span class="fa-stack">
                            <a href="https://www.facebook.com/corporatesmartcontrol">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-facebook-f fa-stack-1x"></i>
                            </a>
                        </span>
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-instagram fa-stack-1x"></i>
                            </a>
                        </span>
                        <p class="p-small">Precisando de ajuda? <a href="mailto:suporte@corporatesmartcontrol.com"><strong>suporte@corporatesmartcontrol.com</strong></a></p>
                    </div> <!-- end of footer-col -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of footer -->  
    <!-- end of footer -->


<?php 
//se o email ja foi cadastrado ele retorna um alert
if (isset($_GET['cadastrado'])) {
$cadastrado = $_GET['cadastrado'];
echo '<script type="text/javascript">
            alert("Email já cadastrado.");
            </script>';
}

//se o email foi cadastrado com sucesso ele retorna um alert
if (isset($_GET['enviado'])) {
echo '<script type="text/javascript">
            alert("Foi enviado um email com link do sistema para ser acessado com seu login e senha, caso precise redefinir sua senha será neste sistema que será redefinido.");
            </script>';
}
?>



    <!-- Copyright -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="p-small">Copyright © <a href="#your-link">Corporate Smart Control</a></p>
                </div> <!-- end of col -->
            </div> <!-- enf of row -->
        </div> <!-- end of container -->
    </div> <!-- end of copyright --> 
    <!-- end of copyright -->
    
    	
    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script> <!-- jQuery for Bootstrap's JavaScript plugins -->
    <script src="assets/js/bootstrap.min.js"></script> <!-- Bootstrap framework -->
    <script src="assets/js/jquery.easing.min.js"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
    <script src="assets/js/swiper.min.js"></script> <!-- Swiper for image and text sliders -->
    <script src="assets/js/jquery.magnific-popup.js"></script> <!-- Magnific Popup for lightboxes -->
    <script src="assets/js/scripts.js"></script> <!-- Custom scripts -->
    
    <script type="text/javascript">
    //Botao mostrar senha 001-------------->    
    let passwordInput1 = document.getElementById('password1'),
    toggle1 = document.getElementById('btnToggle'),
    icon1 =  document.getElementById('eyeIcon');
    function togglePassword1() {
      if (passwordInput1.type === 'password') {
        passwordInput1.type = 'text';
        icon1.classList.add("fa-eye-slash");
        //toggle.innerHTML = 'hide';
      } else {
        passwordInput1.type = 'password';
        icon1.classList.remove("fa-eye-slash");
        //toggle.innerHTML = 'show';
      }
    }
    function checkInput1() {
      //if (passwordInput1.value === '') {
      //toggle1.style.display = 'none';
      //toggle1.innerHTML = 'show';
      //  passwordInput1.type = 'password';
      //} else {
      //  toggle1.style.display = 'block';
      //}
    }
    toggle1.addEventListener('click', togglePassword1, false);
    passwordInput1.addEventListener('keyup', checkInput1, false);

    //Botao mostrar senha 002-------------->    
    let passwordInput2 = document.getElementById('password2'),
    toggle2 = document.getElementById('btnToggle2'),
    icon2 =  document.getElementById('eyeIcon2');
    function togglePassword2() {
      if (passwordInput2.type === 'password') {
        passwordInput2.type = 'text';
        icon2.classList.add("fa-eye-slash");
        //toggle.innerHTML = 'hide';
      } else {
        passwordInput2.type = 'password';
        icon2.classList.remove("fa-eye-slash");
        //toggle.innerHTML = 'show';
      }
    }
    function checkInput2() {
      //if (passwordInput2.value === '') {
      //toggle2.style.display = 'none';
      //toggle2.innerHTML = 'show';
      //  passwordInput2.type = 'password';
      //} else {
      //  toggle2.style.display = 'block';
      //}
    }
    toggle2.addEventListener('click', togglePassword2, false);
    passwordInput2.addEventListener('keyup', checkInput2, false);



    //Valida se as senhas sao iguais
    function checkPassword(form) {
        password1 = form.password1.value;
        password2 = form.password2.value;
        // If password not entered
        if (password1 == '')
            alert ("Insira a senha.");
        // If confirm password not entered
        else if (password2 == '')
            alert ("Confirme a senha.");
        // If Not same return False.    
        else if (password1 != password2) {
            alert ("\nSenhas não coincidem, tente novamente...")
            return false;
        }
        // If same return True.
        else{
            //alert ("\nCadastro de teste concluído com sucesso, verifique sua caixa de email.")
            return true;
        }
    }

    


    </script>
</body>
</html>