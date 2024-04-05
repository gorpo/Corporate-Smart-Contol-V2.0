
<!-- ================================================  MENUS DA ESQUERDA ================================================ -->
  <!-- Main Sidebar Container -->
  <aside class="menu_esquerda-link main-sidebar sidebar-dark-primary elevation-4 " id="cor_menu">
    <!-- Brand Logo -->
    <a href="../index.php" class="brand-link">
      <img src="../../../assets/images/logo.svg" alt="Corporate Smart Control" class="brand-image " style="opacity: .8">
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
                if($row["nome"] == $_SESSION['nome']){
                echo '<img src="../../../assets/images/usuarios/'.$row['imagem'].'" class="img-circle elevation-2" alt="User Image">';
                echo '</div>';
                echo '<div class="info">';
                echo '<a href="" class="d-block">'.$row['nome'].'</a>';      
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


          <li class="nav-item ">
            <a href="#" class="nav-link "><i class="nav-icon fas fa-tachometer-alt"></i><p> Dashboard<i class="right fas fa-angle-left"></i></p></a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="../dashboard_usuarios.php" class="nav-link "><i class="fas fa-users nav-icon"></i><p>Usuários</p></a></li>
              <li class="nav-item"><a href="../dashboard_produtos.php" class="nav-link"><i class="fas fa-box nav-icon"></i><p>Produtos</p></a></li>
              <li class="nav-item"><a href="../dashboard_tabelas.php" class="nav-link"><i class="fas fa-table nav-icon"></i><p>Tabelas</p></a></li>
              <li class="nav-item"><a href="../dashboard_graficos.php" class="nav-link"><i class="fas fa-chart-bar nav-icon"></i><p>Gráficos</p></a></li>
            </ul>
          </li>

          <li class="nav-item ">
            <a href="informacoes.php" class="nav-link "><i class="nav-icon fas fa-info"></i><p> Informações</p></a>
          </li>


          <li class="nav-item ">
            <a href="#" class="nav-link "><i class="nav-icon fas fa-barcode"></i><p>Bipar Produtos<i class="right fas fa-angle-left"></i></p></a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="../bip_unico.php" class="nav-link "><i class="nav-icon fas fa-barcode"></i><p>Automático</p></a></li>
              <li class="nav-item"><a href="../bip_quantidade.php" class="nav-link "><i class="nav-icon fas fa-barcode"></i><p>Inserir Quantidade</p></a></li>
            <li class="nav-item"><a href="../pesquisa_sku.php" class="nav-link "><i class="nav-icon fas fa-barcode"></i><p>Inserir SKU</p></a></li>
            </ul>
          </li>


          <!-- /.sidebar-menu -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>