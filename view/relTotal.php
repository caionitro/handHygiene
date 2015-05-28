<?php require_once '../template/topo.php'; ?>
<?php require_once '../template/menu.php'; ?>

<div class="container">
    <h3>Relatório Geral</h3>
    
    <?php if (count($lista) > 0) { ?>
    <table class="table table-striped table-hover" id="tableRelTotal">
      <thead>
        <tr>
          <th>Data</th>
          <th>Local</th>
          <th>Setor</th>
          <th>Categoria</th>
          <th>Ação</th>
          <th>Indicação</th>
          <th>Vestimenta</th>
          <th>Higienização</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($lista as $key => $value) { ?>
          <tr>
            <td><?=$value['dataCadastro']?></td>
            <td><?=$value['local']?></td>
            <td><?=$value['setor']?></td>
            <td><?=$value['categoria']?></td>
            <td><?=$value['acao']?></td>
            <td><?=$value['indicacao']?></td>
            <td><?=$value['vestimenta']?></td>
            <td><?=$value['higienizacao']?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php }else{ ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Ops!</strong> Não há registros lançados, refine a sua busca.
    </div>
  <?php } ?>
</div>

</div>

<?php require_once '../template/rodape.php'; ?>