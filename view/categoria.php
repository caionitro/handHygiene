<?php require_once '../template/topo.php'; ?>
<?php require_once '../template/menu.php'; ?>

<div class="container">
  <?php
    if(is_array($flashData)) {
      echo "<div class='alert {$flashData['alert-class']} alert-dismissible text-center' role='alert'>
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
              {$flashData['text']}
            </div>";
    }
  ?>
    <h3>Cadastro de categoria</h3>
    <form class="form-horizontal" id="formCategoria" action="categoria.php" method="POST">
        <input type="hidden" id="action" name="action" value="insert">
        <div class="form-group">
          <label for="nome" class="col-xs-2 control-label">ID</label>
          <div class="col-xs-1">
            <input type="text" id="idSetorCategoria" name="idSetorCategoria" class="form-control" readonly>
          </div>
        </div>
        <div class="form-group">
            <label for="local" class="col-xs-2 control-label">Local</label>
            <div class="col-xs-6">
              <select name="local" id="local" class="form-control" required>
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
              <select name="setor" id="setor" class="form-control" required>
                <option></option>
              </select>
            </div>
      </div>
      <div class="form-group">
        <label for="categoria" class="col-xs-2 control-label">Categoria</label>
        <div class="col-xs-6">
          <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Categoria" required>
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
    <h3>Listagem de Categoria</h3>
     <?php if (count($lista) > 0) { ?>
    <table class="table table-striped table-hover" id="tableCategoria">
      <thead>
        <tr>
          <th>#</th>
          <th>Local</th>
          <th>Setor</th>
          <th>Categoria</th>
          <th class="text-center" colspan="2">Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($lista as $key => $value) { ?>
          <tr>
            <td><?=$value['idSetorCategoria']?></td>
            <td><?=$value['local']?></td>
            <td><?=$value['setor']?></td>
            <td><?=$value['categoria']?></td>
            <td class="text-right">
              <button class="btn btn-warning btn-sm right js-edit" data-id="<?=$value['idSetorCategoria']?>"><span class="glyphicon glyphicon-pencil"></span></button>
            </td>
            <td class="text-left">
              <button type="button" class="btn btn-danger btn-sm" data-id="<?=$value['idSetorCategoria']?>" data-categoria="<?=$value['categoria']?>" data-toggle="modal" data-target="#modalDelete">
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

</div>

<script type="text/javascript">
  $(document).ready(function(){
    // $('#tableUsuario').dataTable({
    //     "language": {
    //         "url": "//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Portuguese-Brasil.json"
    //     },
    //     "dom": '<"top"f>t<"bottom.center"p>'
    // });
    
    $('#local').change(function() {
        var local = $(this).val();
        $.ajax({
            url: '../controller/categoria.php',
            type: 'POST',
            dataType: 'JSON',
            data: {action: 'getSetorSelect', local: local},
        })
        .done(function(r) {
            var option = '<option></option>';
            $.each(r, function(index, val) {
                option += '<option value="'+val.idSetor+'">'+val.setor+'</option>';
            });
            $('#setor').html(option);
        })
        .fail(function() {
            console.log("error");
        });
        
    });

    $('.js-edit').click(function() {
      var idSetorCategoria = $(this).data('id');
      $("#local option").each(function() { $(this).removeAttr("selected"); });

      $.ajax({
        url: "../controller/categoria.php",
        type: 'POST',
        dataType: 'json',
        data: {action: 'edit', idSetorCategoria: idSetorCategoria},
      })
      .done(function(r) {
        console.log(r);
        $('#idSetorCategoria').val(r.idSetorCategoria);
        $('#local option[value="'+r.idLocal+'"]').attr('selected', 'selected');
        $('#setor').html('<option value="'+r.idSetor+'" selected>'+r.setor+'</option>');
        $('#categoria').val(r.categoria);
      })
      .fail(function() {
        console.log("error");
      });
      
    });

    $('#modalDelete').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var categoria = button.data('categoria');
      var idSetorCategoria = button.data('id');
      var modal = $(this);
      modal.find('#idModal').val(idSetorCategoria);
      modal.find('.modal-body').empty().append('Deseja deletar a categoria: #'+idSetorCategoria+' - '+categoria+' ?');
    });

    $('#btnDeletar').on('click',function(){
      var idModal = $('#idModal').val();
      $.ajax({
        method: "POST",
        url: "../controller/categoria.php",
        data: { idSetorCategoria: idModal, action: 'delete' }   
      })
      .done(function( msg ) {
        //console.log(msg);
        window.location.replace("../controller/categoria.php");
      });
    });

    $('#formCategoria').validate({
      rules: {
        local: "required",
        setor: "required",
        categoria: "required"
      }
    });

  });
</script>

<?php require_once '../template/rodape.php'; ?>