<?php require_once '../template/topo.php'; ?>
<?php require_once '../template/menu.php'; ?>

<div class="container">
  <div class="row">
    <div id="breadTcc" class="col-sm-6" style="display:inline;">
      <ol class="breadcrumb">
        <li><?=SISTEMA?></li>
      </ol>
    </div>
  </div>
  <div class="row">
    <h3>Onde você irá observar?</h3>
    <?php if(count($listLocalSetor) > 0){ ?>
    <div class="col-sm-6">
      <div class="list-group">
        <?php foreach ($listLocalSetor as $key) { ?>
          <a href="#" class="list-group-item js-lista" data-id="<?=$key['idLocalSetor']?>"><?=$key['local']?> / <?=$key['setor']?> <span class="glyphicon glyphicon-chevron-right"></span></a>
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
</div>
<form action="../controller/observacao.php" method="POST" id="formObsCategoria">
  <input type="hidden" name="action" id="action" value="obsCategoria">
  <input type="hidden" name="idLocalSetor" id="idLocalSetor" value="">
</form>
<script type="text/javascript">
  $(document).ready(function() {
    $('.js-lista').on('click',function(){ 
      var idLocalSetor = $(this).data('id');
      $('#idLocalSetor').val(idLocalSetor);
      $('#formObsCategoria').submit();
    });
  });
</script>

<?php require_once '../template/rodape.php'; ?>