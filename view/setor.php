<?php require_once '../template/topo.php'; ?>
<?php require_once '../template/menu.php'; ?>

<div class="container">
  <h3>Cadastro de setor</h3>
  <form class="form-horizontal" id="formSetor" action="../controller/setor.php">
    <input type="hidden" id="action" name="action" value="insert">
    <div class="form-group">
      <label for="nome" class="col-xs-2 control-label">ID</label>
      <div class="col-xs-1">
        <input type="text" id="idLocalSetor" name="idLocalSetor" class="form-control" readonly>
      </div>
    </div>
    <div class="form-group">
      <label for="local" class="col-xs-2 control-label">Local</label>
      <div class="col-xs-6">
        <select name="local" class="form-control" id="local" required>
          <option></option>
          <?php foreach ($local as $key => $value) { ?>
            <option value="<?=$value['idLocal']?>"><?=$value['local']?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="setor" class="col-xs-2 control-label">Setor</label>
        <div class="col-xs-6">
          <input type="text" class="form-control" id="setor" name="setor" placeholder="Setor" required>
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
  <h3>Listagem de Setores</h3>
   <?php if (count($lista) > 0) { ?>
    <table class="table table-striped table-hover" id="tableLocal">
      <thead>
        <tr>
          <th>#</th>
          <th>Local</th>
          <th>Setor</th>
          <th class="text-center" colspan="2">Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($lista as $key => $value) { ?>
          <tr>
            <td><?=$value['idLocalSetor']?></td>
            <td><?=$value['local']?></td>
            <td><?=$value['setor']?></td>
            <td class="text-right">
              <button class="btn btn-warning btn-sm right js-edit" data-id="<?=$value['idLocalSetor']?>"><span class="glyphicon glyphicon-pencil"></span></button>
            </td>
            <td class="text-left">
              <button type="button" class="btn btn-danger btn-sm" data-id="<?=$value['idLocalSetor']?>" data-setor="<?=$value['setor']?>" data-toggle="modal" data-target="#modalDelete">
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
      var idLocalSetor = $(this).data('id');
      $("#local option").each(function() { $(this).removeAttr("selected"); });

      $.ajax({
        url: "../controller/setor.php",
        type: 'POST',
        dataType: 'json',
        data: {action: 'edit', idLocalSetor: idLocalSetor},
      })
      .done(function(r) {
        $('#idLocalSetor').val(r.idLocalSetor);
        $('#local option[value="'+r.idLocal+'"]').attr('selected', 'selected');
        $('#setor').val(r.setor);
      })
      .fail(function() {
        console.log("error");
      });
      
    });

    $('#modalDelete').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var setor = button.data('setor');
      var idLocalSetor = button.data('id');
      var modal = $(this);
      modal.find('#idModal').val(idLocalSetor);
      modal.find('.modal-body').empty().append('Deseja deletar o setor: #'+idLocalSetor+' - '+setor+' ?');
    });

    $('#btnDeletar').on('click',function(){
      var idModal = $('#idModal').val();
      $.ajax({
        method: "POST",
        url: "../controller/setor.php",
        data: { idLocalSetor: idModal, action: 'delete' }
      })
      .done(function( msg ) {
        //console.log(msg);
        window.location.replace("../controller/setor.php");
      });
    });

    $('#formSetor').validate({
      rules: {
        local: "required",
        setor: "required"
      }
    });

  });
</script>

<?php require_once '../template/rodape.php'; ?>