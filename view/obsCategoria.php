<?php require_once '../template/topo.php'; ?>
<?php require_once '../template/menu.php'; ?>
<style type="text/css">
  .well{
    min-height: 70px;
  }
</style>
<div class="container">
  <div class="row">
    <div id="breadTcc" class="col-sm-6" style="display:inline;">
      <ol class="breadcrumb">
        <li><?=SISTEMA?></li>
        <li><a href="../controller/observacao.php"><?=$localSetorNome['local']?> / <?=$localSetorNome['setor']?></a></li>
      </ol>
    </div>
  </div>
  <?php
    if(is_array($flashData)) {
      echo "<div class='row'><div class='col-sm-6'>
              <div class='alert {$flashData['alert-class']} alert-dismissible text-center' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                {$flashData['text']}
              </div>
              </div>
            </div>";
    }
  ?>
  <div class="row">
    <h3>Quem você irá observar?</h3>
    <?php if(count($listCategoriaSetor) > 0){ ?>
    <div class="col-sm-6">
      <div class="list-group">
        <?php foreach ($listCategoriaSetor as $key) { ?>
          <a href="#" class="list-group-item js-lista" data-id="<?=$key['idSetorCategoria']?>"><?=$key['categoria']?> <span class="glyphicon glyphicon-chevron-right"></span></a>
        <?php } ?>
      </div>
    </div>
    <?php }else{ ?>
      <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Ops!</strong> Não há registros lançados.
      </div>
    <?php } ?>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <form id="formOutraCat" method="POST">
        <button class="btn btn-primary col-sm-12 btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          Outros
        </button>
        <div class="collapse" id="collapseExample">
          <div class="well">
            <input type="text" class="col-sm-8" id="descricao" name="descricao" placeholder="Descrição">
            <button type="button" class="btn btn-success btn-sm col-sm-2 js-salvar-cat">Salvar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<form action="../controller/observacao.php" method="POST" id="formObsCat">
  <input type="hidden" name="action" id="action" value="obsHandHygiene">
  <input type="hidden" name="idLocalSetor" id="idLocalSetor" value="<?=$localSetorNome['idLocalSetor']?>">
  <input type="hidden" name="idSetorCategoria" id="idSetorCategoria" value="">
</form>
<script type="text/javascript">
  $(document).ready(function() {

    $('.js-salvar-cat').on('click',function() {
      $.ajax({
        url: '../controller/categoria.php',
        type: 'POST',
        dataType: 'json',
        data: {action: 'getSetorLocal',idSetorCategoria: '<?=$localSetorNome["idLocalSetor"]?>',},
      }).done(function(r) {
        console.log(r);
        $.ajax({
          url: '../controller/categoria.php',
          type: 'POST',
          dataType: 'html',
          data: {action: 'insert', categoria: $('#descricao').val(), setor: r.idSetor, local: r.idLocal},
        }).done(function() {
          //console.log("fungo!");
          $('#action').val('obsCategoria');
          $('#formObsCat').submit();
        });
      });
    });


    $('.js-lista').on('click',function(){
      var idSetorCategoria = $(this).data('id');
      $('#idSetorCategoria').val(idSetorCategoria);
      $('#formObsCat').submit();
    });
  });
</script>

<?php require_once '../template/rodape.php'; ?>