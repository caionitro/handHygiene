<?php require_once '../template/topo.php'; ?>
<?php require_once '../template/menu.php'; ?>

<div class="container">
  <h3>Cadastro de usuário</h3>
  <form class="form-horizontal" id="formUsuario" action="../controller/usuario.php">
    <input type="hidden" id="action" name="action" value="insert">
    <div class="form-group">
      <label for="nome" class="col-xs-2 control-label">ID</label>
      <div class="col-xs-1">
        <input type="text" id="idUsuario" name="idUsuario" class="form-control" readonly>
      </div>
    </div>
    <div class="form-group">
      <label for="nome" class="col-xs-2 control-label">Nome</label>
      <div class="col-xs-6">
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
      </div>
    </div>
    <div class="form-group">
      <label for="email" class="col-xs-2 control-label">E-mail</label>
      <div class="col-xs-6">
        <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
      </div>
    </div>
    <div class="form-group">
      <label for="login" class="col-xs-2 control-label">Login</label>
      <div class="col-xs-6">
        <input type="text" class="form-control" id="login" name="login" placeholder="Login" required>
      </div>
    </div>
    <div class="form-group">
      <label for="senha" class="col-xs-2 control-label">Senha</label>
      <div class="col-xs-6">
        <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-6 col-xs-2 text-right">
        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>
      </div>
      <div class="col-xs-2  text-left">
        <button type="reset" class="btn btn-warning"><span class="fa fa-eraser"></span></button>
      </div>
    </div>
  </form> 
  <hr>
  <h3>Listagem de Usuários</h3>
  <?php if (count($lista) > 0) { ?>
    <table class="table table-striped table-hover" id="tableUsuario">
      <thead>
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>Login</th>
          <th>E-Mail</th>
          <th class="text-center" colspan="2">Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          foreach ($lista as $key => $value) { ?>
          <tr>
            <td><?=$value['idUsuario']?></td>
            <td><?=$value['nome']?></td>
            <td><?=$value['login']?></td>
            <td><?=$value['email']?></td>
            <td class="text-right">
              <button class="btn btn-warning btn-sm right js-edit" data-id="<?=$value['idUsuario']?>"><span class="glyphicon glyphicon-pencil"></span></button>
            </td>
            <td class="text-left">
              <button type="button" class="btn btn-danger btn-sm" data-id="<?=$value['idUsuario']?>" data-nome="<?=$value['nome']?>" data-toggle="modal" data-target="#modalDelete">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php }else{ ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Ops!</strong> Não há registros lançados.
    </div>
  <?php } ?>

 
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Atenção!</h4>
        <input type="hidden" id="idModal" name="idModal">
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
        <button type="button" class="btn btn-danger" id="btnDeletar">Sim</button>
      </div>
    </div>
  </div>
</div>



</div>
<script type="text/javascript">
  $(document).ready(function(){
    // $('#tableUsuario').dataTable({
    //     "language": {
    //         "url": "//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Portuguese-Brasil.json"
    //     },
    //     "dom": '<"top"f>t<"bottom.center"p>'
    // });

    $('.js-edit').click(function() {
      var idUsuario = $(this).data('id');
      $.ajax({
        url: "../controller/usuario.php",
        type: 'POST',
        dataType: 'json',
        data: {action: 'edit', idUsuario: idUsuario},
      })
      .done(function(r) {
        $('#idUsuario').val(r.idUsuario);
        $('#nome').val(r.nome);
        $('#email').val(r.email);
        $('#login').val(r.login);
      })
      .fail(function() {
        console.log("error");
      });
      
    });

    $('#modalDelete').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var nomeUser = button.data('nome');
      var idUser = button.data('id');
      var modal = $(this);
      modal.find('#idModal').val(idUser);
      modal.find('.modal-body').empty().append('Deseja deletar o usuário: #'+idUser+' - '+nomeUser+' ?');
    });

    $('#btnDeletar').on('click',function(){
      var idModal = $('#idModal').val();
      $.ajax({
        method: "POST",
        url: "../controller/usuario.php",
        data: { idUsuario: idModal, action: 'delete' }
      })
      .done(function( msg ) {
        window.location.replace("../controller/usuario.php");
      });
    });

    $('#formUsuario').validate({
      rules: {
        name: "required",
        login: "required",
        senha: "required",
        email: {
          required: true,
          email: true
        }
      }
    });

  });
</script>

<?php require_once '../template/rodape.php'; ?>