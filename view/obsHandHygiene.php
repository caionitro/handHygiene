<?php require_once '../template/topo.php'; ?>
<?php require_once '../template/menu.php'; ?>

<div class="container">
  <div class="row">
    <div id="breadTcc" class="col-sm-6">
      <ol class="breadcrumb">
        <li><?=SISTEMA?></li>
        <li><a href="../controller/observacao.php"><?=$localSetorNome['local']?> / <?=$localSetorNome['setor']?></a></li>
        <li><a href="javascript:void(0);" id="aCategoria"><?=$setorCategoria['categoria']?></a></li>
      </ol>
    </div>
  </div>
  <form method="POST" action="../controller/observacao.php" id="formObs">
    <input type="hidden" name="action" value="insert">
    <input type="hidden" name="idLocalSetor" value="<?=$localSetorNome['idLocalSetor']?>">
    <input type="hidden" name="idSetorCategoria" value="<?=$setorCategoria['idSetorCategoria']?>">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">Box</div>
        <div class="panel-body">
          <div class="form-group row">
            <div class="col-sm-12">
              <input type="text" class="form-control" id="box" name="box" placeholder="Box" required>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">Indicação</div>
        <div class="panel-body">

          <div class="form-group row">
            <?php foreach ($listaIndicacao as $key) { ?>
              <div class="col-sm-2">
                <div class="radio">
                  <label><input type="radio" name="indicacao" value="<?=$key['idIndicacao']?>"><?=$key['descricao']?></label>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Ação</h3>
        </div>
        <div class="panel-body">
          <div class="row col-sm-12">
            <?php foreach ($listaAcao as $key) { ?>
              <div class="col-sm-2">
                <div class="checkbox">
                  <label><input type="checkbox" name="acao[]" value="<?=$key['idAcao']?>"><?=$key['descricao']?></label>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Técnica de higienização</h3>
        </div>
        <div class="panel-body">
          <?php
            $higiCount = 0;
          ?>
          <div class="row col-sm-12">
            <?php
              foreach ($listaHigienizacao as $key) {
                $higiCol = ($higiCount>=5) ? 1 : 2;
            ?>
              <div class="col-sm-<?=$higiCol?>">
                <div class="checkbox">
                  <label><input type="checkbox" name="higienizacao[]" value="<?=$key['idHigienizacao']?>"><?=$key['descricao']?></label>
                </div>
              </div>
            <?php
            $higiCount++;
            } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">EPIs e Adornos</h3>
        </div>
        <div class="panel-body">
          <div class="row col-sm-12">
            <?php foreach ($listaVestimenta as $key) { ?>
              <div class="col-sm-1">
                <div class="checkbox">
                  <label><input type="checkbox" name="vestimenta[]" value="<?=$key['idVestimenta']?>"><?=$key['descricao']?></label>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row text-center">
      <button type="submit" class="btn btn-success col-sm-12">Salvar</button>
    </div>

  </form>
  </br>
  </br>
</div>
<form action="../controller/observacao.php" method="POST" id="formBackCategoria">
  <input type="hidden" name="action" id="action" value="obsCategoria">
  <input type="hidden" name="idLocalSetor" value="<?=$localSetorNome['idLocalSetor']?>">
  <input type="hidden" name="idSetorCategoria" value="<?=$setorCategoria['idSetorCategoria']?>">
</form>
<script type="text/javascript">
  $(document).ready(function() {
    $('#formObs').submit(function(event) {
      event.preventDefault();
      var campos = $('#formObs').serialize();
      $.ajax({
        url: '../controller/observacao.php',
        type: 'POST',
        dataType: 'html',
        data: {action: 'insert', campo: campos},
      })
      .done(function(r) {
        //console.log(r);
        $('#formBackCategoria').submit();
      });
    });

    $('#aCategoria').on('click',function(){
      $('#formBackCategoria').submit();
    });

  });
</script>

<?php require_once '../template/rodape.php'; ?>