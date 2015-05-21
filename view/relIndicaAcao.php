<?php require_once '../template/topo.php'; ?>
<?php require_once '../template/menu.php'; ?>
<!-- l.local,
    s.setor,
    c.categoria,
    count(ao.fk_acao) as qtdeAcao,
    a.descricao,
    oi.fk_indicacao,
    i.descricao -->
<div class="container">
    <h3>Relatório Indicação x Ação</h3>
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
</div>

</div>

<?php require_once '../template/rodape.php'; ?>