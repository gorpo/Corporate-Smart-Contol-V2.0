
<!-- ================================================  MENUS DA ESQUERDA ================================================ -->
  <!-- Main Sidebar Container -->
  <aside class="menu_esquerda-link main-sidebar sidebar-dark-primary elevation-4 " id="cor_menu">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link" id="cor_logo">
      <img src="../../../../assets/images/logo.svg" alt="Corporate Smart Control"class="brand-image " style="opacity: .8">
      <span class="brand-text font-weight-light">⠀⠀
    </a>

    <!-- Sidebar que exibe o nome de usuario e foto de quem esta logado-->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <?php
            $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
            $sql = 'SELECT * FROM usuarios ';
            foreach($pdo->query($sql)as $row){
                if($row["usuario"] == $_SESSION['usuario']){
                echo '<img src="../../../../assets/images/usuarios/'.$row['imagem'].'" class="img-circle elevation-2" alt="User Image">';
                echo '</div>';
                echo '<div class="info">';
                echo '<a href="../perfil/edita_perfil.php?id='.$row['id'].'" class="d-block">'.$row['nome'].'</a>';     
            }}
            ?>
        </div>
      </div>



      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

          <li class="nav-item ">
            <a href="../index.php" class="nav-link "><i class="nav-icon fas fa-home"></i><p> Início</p></a>
          </li>

          
          <li class="nav-item "><a href="#" class="nav-link "><i class="nav-icon fas fa-tachometer-alt"></i><p> Dashboard<i class="right fas fa-angle-left"></i></p></a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="../index.php" class="nav-link "><i class="fas fa-users nav-icon"></i><p>Usuários</p></a></li>
              <li class="nav-item"><a href="../dashboard/dashboard_produtos.php" class="nav-link"><i class="fas fa-box nav-icon"></i><p>Produtos</p></a></li>
              <li class="nav-item"><a href="../dashboard/dashboard_tabelas.php" class="nav-link"><i class="fas fa-table nav-icon"></i><p>Tabelas</p></a></li>
              <li class="nav-item"><a href="../dashboard/dashboard_graficos.php" class="nav-link"><i class="fas fa-chart-bar nav-icon"></i><p>Gráficos</p></a></li>
            </ul>
          </li>


          <li class="nav-item ">
            <a href="../informacoes/informacoes.php" class="nav-link "><i class="nav-icon fas fa-info"></i><p> Informações</p></a>
          </li>

         
          <li class="nav-item">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-file-invoice"></i><p>Ordem Serviço<i class="fas fa-angle-left right"></i><span class="badge badge-info right"></p> </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"> <a href="../ordem_servico/index.php" class="nav-link "><i class="nav-icon fas fa-file-invoice"></i><p>Gerar O.S.</p></a></li>
              <li class="nav-item"> <a href="../ordem_servico/consulta_ordem_servico.php" class="nav-link "><i class="nav-icon fas fa-file-invoice"></i><p>Consultar O.S</p></a></li>
            </ul>
          </li>
          

          <li class="nav-item">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-user"></i><p>Usuários<i class="fas fa-angle-left right"></i><span class="badge badge-info right"></p> </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="cadastro_usuarios.php" class="nav-link"><i class="far fa-user nav-icon"></i><p>Cadastro de usuários</p></a> </li>
              <li class="nav-item"><a href="consulta_usuarios.php" class="nav-link"><i class="far fa-user nav-icon"></i><p>Verificar acessos</p></a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Representantes<i class="fas fa-angle-left right"></i><span class="badge badge-info right"></span></p> </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="../representantes/index.php" class="nav-link"><i class="fas fa-users nav-icon"></i><p>Cadastro representantes</p></a> </li>
              <li class="nav-item"><a href="../representantes/pedidos_representantes.php" class="nav-link"><i class="fas fa-users nav-icon"></i><p>Pedidos representantes</p></a></li>
              <li class="nav-item"><a href="../representantes/consulta_representantes.php" class="nav-link"><i class="fas fa-users nav-icon"></i><p>Consulta Representantes</p></a></li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-cube"></i> <p>Produtos<i class="right fas fa-angle-left"></i> </p> </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"> <a href="../produtos/produtos_cadastrados.php" class="nav-link"><i class="fas fa-cube nav-icon"></i><p>Produtos Cadastrados</p></a></li>
              <li class="nav-item"> <a href="../produtos/index.php" class="nav-link"><i class="fas fa-cube nav-icon"></i><p>Produto Único</p></a></li>
              <li class="nav-item"> <a href="../produtos/produto_composto.php" class="nav-link"> <i class="fas fa-cube nav-icon"></i> <p>Produto Composto</p></a></li>
              <li class="nav-item"> <a href="../produtos/produto_composto_idade.php" class="nav-link"> <i class="fas fa-cube nav-icon"></i> <p>Produto Idade</p></a> </li>
              <li class="nav-item">  <a href="../produtos/produto_composto_sapatilha.php" class="nav-link"> <i class="fas fa-cube nav-icon"></i> <p>Produto Sapatilhas</p></a> </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-archive"></i> <p>Relatórios<i class="right fas fa-angle-left"></i> </p> </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"> <a href="../relatorios_produtos/index.php" class="nav-link"><i class="fas fa-archive nav-icon"></i><p>Relatório Produtos</p></a></li>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-laptop-code"></i><p>Desenvolvedor<i class="fas fa-angle-left right"></i><span class="badge badge-info right"></p> </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"> <a href="../desenvolvedor/index.php" class="nav-link "><i class="nav-icon fas fa-database"></i><p>Editor Avançado</p></a></li>
              <li class="nav-item"> <a href="../desenvolvedor/null.php" class="nav-link "><i class="nav-icon fas fa-laptop-code"></i><p>null</p></a></li>
            </ul>
          </li>


          <!-- /.sidebar-menu -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>