<?php require_once '../template/topo.php'; ?>
<?php require_once '../template/menu.php'; ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<div class="container">
    <h3>Relatório geral analítico em X</h3>
    <div class="row">
      <form class="form-horizontal" method="POST" action="relatorioAnaliX.php">
        <input type="hidden" name="action" value="gerar">
        <div class="form-group">
          <label for="dataInicio" class="col-xs-2 control-label">Data Inicio</label>
          <div class="col-xs-6 input-group date">
            <input type="text" class="form-control" value="<?=$dataInicio?>" name="dataInicio" id="dataInicio" placeholder="Data Inicio"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
          </div>
        </div>
        <div class="form-group">
          <label for="dataFim" class="col-xs-2 control-label">Data Fim</label>
          <div class="col-xs-6 input-group date">
            <input type="text" class="form-control" value="<?=$dataFim?>" id="dataFim" name="dataFim" placeholder="Data Fim"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
          </div>
        </div>
        <div class="form-group">
          <label for="local" class="col-xs-2 control-label">Local</label>
          <div class="col-xs-6 input-group">
            <select name="local" id="local" class="form-control">
              <option value=""></option>
              <?php foreach ($localSelect as $key) { ?>
                  <option value="<?=$key['idLocal']?>"><?=$key['local']?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="setor" class="col-xs-2 control-label">Setor</label>
          <div class="col-xs-6 input-group">
            <select name="setor" id="setor" class="form-control"></select>
          </div>
        </div>
        <div class="form-group">
          <label for="categoria" class="col-xs-2 control-label">Categoria</label>
          <div class="col-xs-6 input-group">
            <select name="categoria" id="categoria" class="form-control"></select>
          </div>
        </div>
        <div class="form-group">
          <label for="usuario" class="col-xs-2 control-label">Usuário</label>
          <div class="col-xs-6 input-group">
            <select name="usuario" id="usuario" class="form-control">
              <option value=""></option>
              <?php foreach ($listaUsuario as $key) { ?>
                  <option value="<?=$key['idUsuario']?>"><?=$key['nome']?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-6 col-xs-2 text-right">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-filter"></span></button>
          </div>
        </div>
      </form>
    </div>
    <hr>
    <!-- <a id="btnImpExcel" href="#"><span class="fa fa-file-excel-o"></span> Excel</a> -->
    <?php if (count($lista['qtde']) > 0) { ?>
    <div class="row">
      <div class="dropdown">
        <button id="dLabel" type="button" class="btn btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <span class="fa fa-cog"></span> Ação
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dLabel">
          <li><a id="btnImpExcel" href="#"><span class="fa fa-file-excel-o"></span> Excel</a></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <?php ob_start(); ?>
      <div style="width:1100px;height:500px;overflow:scroll;">
        <table class="table table-striped table-hover table-bordered" id="tableRelTotal">
          <thead>
            <tr>
              <th>Data</th>
              <th>Setor</th>
              <th>Local</th>
              <th>Categoria</th>
              <th>Ant. pacte</th>
              <th>Ant. proc. assep.</th>
              <th>Ap. fluídos corp.</th>
              <th>Ap. pacte</th>
              <th>Ap. proxim.</th>
              <th>Fricção com álcool</th>
              <th>Água + sabonete</th>
              <th>Água + PVPI</th>
              <th>Água + clorexidina</th>
              <th>Outro produto</th>
              <th>Não realizada</th>
              <th>Palmas (dir.+esq.)</th>
              <th>Palma+Interdigital (dir.+esq.)</th>
              <th>Dedos entrelaçados</th>
              <th>Dorso (dir.+esq.)</th>
              <th>Polegar (dir.+esq.)</th>
              <th>Ponta (dir.+esq.)</th>
              <th>Punho (dir.+esq.)</th>
              <th>Jaleco</th>
              <th>Máscara</th>
              <th>Óculos</th>
              <th>Gorro</th>
              <th>Luvas</th>
              <th>Anéis/Aliança</th>
              <th>Relógio</th>
              <th>Unhas artificiais</th>
              <th>Esmalte</th>
              <th>Brinco</th>
              <th>Piercing</th>
              <th>Usuário</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($lista['lista'] as $key => $value) { ?>
              <tr class="text-center">
                <td><?=$value['dataCadastro']?></td>
                <td><?=$value['setor']?></td>
                <td><?=$value['local']?></td>
                <td><?=$value['categoria']?></td>
                <td><?=$value['antpacte']?></td>
                <td><?=$value['antProcAssep']?></td>
                <td><?=$value['fluidoCorp']?></td>
                <td><?=$value['apPacte']?></td>
                <td><?=$value['apProxim']?></td>
                <td><?=$value['friccao']?></td>
                <td><?=$value['sabonete']?></td>
                <td><?=$value['pvpi']?></td>
                <td><?=$value['clorexidina']?></td>
                <td><?=$value['outro']?></td>
                <td><?=$value['naoRealizada']?></td>
                <td><?=$value['palmas']?></td>
                <td><?=$value['palmaInterdigital']?></td>
                <td><?=$value['dedos']?></td>
                <td><?=$value['dorso']?></td>
                <td><?=$value['polegar']?></td>
                <td><?=$value['ponta']?></td>
                <td><?=$value['punho']?></td>
                <td><?=$value['jaleco']?></td>
                <td><?=$value['mascara']?></td>
                <td><?=$value['oculos']?></td>
                <td><?=$value['gorro']?></td>
                <td><?=$value['luvas']?></td>
                <td><?=$value['anel']?></td>
                <td><?=$value['relogio']?></td>
                <td><?=$value['unha']?></td>
                <td><?=$value['esmalte']?></td>
                <td><?=$value['brinco']?></td>
                <td><?=$value['piercing']?></td>
                <td><?=$value['nome']?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php $htmlExcel = ob_get_contents(); ?>
    </div>
  <?php
    $html = ob_get_contents();
    ob_end_clean();
    echo $html;
  }else{ ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Ops!</strong> Não há registros lançados, refine a sua busca.
    </div>
  <?php } ?>
</div>
</div>
</br>
</br>
<form action="../controller/relatorioExcel.php" method="POST" id="impExcel" target="blank">
  <input type="hidden" name="action" value="excel">
  <input type="hidden" name="html" value="<?php echo str_replace('"', '\'', $htmlExcel);?>">
</form>
<script type="text/javascript">
  $(document).ready(function() {
    $('.input-group.date').datepicker({
      format: "dd/mm/yyyy",
      language: "pt-BR",
      autoclose: true
    });

    $('#btnImpExcel').click(function(event) {
      $('#impExcel').submit();
    });

    $('#local').change(function() {
        var idLocal = $(this).val();
        $.ajax({
            url: '../controller/relatorioAnaliX.php',
            type: 'POST',
            dataType: 'JSON',
            data: {action: 'getAllSetor', idLocal: idLocal},
        }).done(function(r) {
            var option = '<option></option>';
            $.each(r, function(index, val) {
                option += '<option value="'+val.idSetor+'">'+val.setor+'</option>';
            });
            $('#setor').html(option);
            $('#categoria').html('<option></option>');
        }).fail(function() {
            console.log("error");
        });
    });

    $('#setor').change(function() {
        var idSetor = $(this).val();
        $.ajax({
            url: '../controller/relatorioAnaliX.php',
            type: 'POST',
            dataType: 'JSON',
            data: {action: 'getAllCategoria', idSetor: idSetor},
        }).done(function(r) {
            var option = '<option></option>';
            $.each(r, function(index, val) {
              option += '<option value="'+val.idCategoria+'">'+val.categoria+'</option>';
            });
            $('#categoria').html(option);
        }).fail(function() {
            console.log("error");
        });
    });

  });
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<?php require_once '../template/rodape.php'; ?>