<div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1" type="button"  data-toggle="modal" data-target="#modal-usuarios"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Usuários Cadastrados</span>
                <span class="info-box-number"><?php
                $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
                $sql = "SELECT * FROM usuarios";
                $contador_usuarios = 0;
                foreach($pdo->query($sql)as $row){
                  $contador_usuarios = $contador_usuarios +1;
              }database::desconectar();
              echo $contador_usuarios;
          ?> </span>
      </div>
  </div></div>






<! -- ================================================  CAIXA DE MODAL POPUP PARA INSERÇÃO DE NOVO USUARIO ================================================   -->
  <div class="modal fade" id="modal-usuarios">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Adicionar Usuário</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" action="index.php" method="post"  autocomplete="off" enctype="multipart/form-data">
            <div class="site-cols-wrapper">

                <!-- =====   IMAGEM | pega as infos da função de upload e retorna se o status esta True o nome da imagem para por na DB======   -->
                <div class="  m-b-16" >
                    <div class="control-group <?php echo !empty($imagemErro) ? 'error ' : ''; ?>">
                        <label >Imagem </label>
                        <div class="controls">
                          <input class="form-control" name="file" type="file" 
                          >
                      </span></div></div></div>
                       <!-- =====   NOME   ======   -->
                        <div class=" m-b-16" >
                          <div class="control-group  <?php echo !empty($tituloErro) ? 'error ' : ''; ?>">
                          <label >NOME EXIBIÇÃO</label>
                           <div class="controls">
                          <input class="form-control" type="text" name="nome" value="<?php
                                                      echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
                                                      ?>" class="form-control"/>
                        </div></div></div>


                        <!-- =====   USUARIO ======   -->
                        <div class=" m-b-16" >
                          <div class="control-group  <?php echo !empty($tituloErro) ? 'error ' : ''; ?>">
                          <label >USUARIO</label>
                           <div class="controls">
                          <input class="form-control" type="text" name="usuario" value="<?php
                                                      echo (isset($usuario) && ($usuario != null || $usuario != "")) ? $usuario : '';
                                                      ?>" class="form-control" />
                        </div></div></div>


                        <!-- =====   SENHA ======   -->
                        <div class=" m-b-16" >
                          <div class="control-group  <?php echo !empty($tituloErro) ? 'error ' : ''; ?>">
                          <label >SENHA</label>
                           <div class="controls">
                          <input class="form-control" type="text" name="senha" value="<?php
                                                      echo (isset($senha) && ($senha != null || $senha != "")) ? $senha : '';
                                                      ?>" class="form-control" />
                        </div></div></div>

                    
                <!-- =====   NÍVEL DE ACESSO ======   -->
                        <div class="  m-b-16" >
                          <div class="control-group  <?php echo !empty($nivelErro) ? 'error ' : ''; ?>">
                          <label >NÍVEL DE ACESSO</label>
                           <div class="controls">
                              <select class="form-control" name="nivel" id="nivel">
                                  <option class="form-control" value=""></option>
                                  <option class="form-control" value="user">Usuário</option>
                                  <option class="form-control" value="admin">Administrador</option>
                                  <option class="form-control" value="representante">Representante</option>
                              </select>
                        </div></div></div>


                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button  type="submit" class="btn btn-primary">Salvar</button>
                    </div>

                    </div>
                    </div>
                    </form>
    </div></div> </div>