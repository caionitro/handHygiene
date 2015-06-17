<?php
  require_once '../sessionUp.php';
  require_once '../connect/Connect.php';
  require_once '../autoloadClass.php';

  $action     = (!empty($_REQUEST['action']))     ? $_REQUEST['action']     : '';
  $idLocal     = (!empty($_REQUEST['idLocal']))     ? $_REQUEST['idLocal']     : '';
  $idSetor     = (!empty($_REQUEST['idSetor']))     ? $_REQUEST['idSetor']     : '';
  $dataInicio     = (!empty($_REQUEST['dataInicio']))     ? $_REQUEST['dataInicio']     : '';
  $dataFim     = (!empty($_REQUEST['dataFim']))     ? $_REQUEST['dataFim']     : '';
  $local     = (!empty($_REQUEST['local']))     ? $_REQUEST['local']     : '';
  $setor     = (!empty($_REQUEST['setor']))     ? $_REQUEST['setor']     : '';
  $categoria     = (!empty($_REQUEST['categoria']))     ? $_REQUEST['categoria']     : '';

  $rel = new RelatorioTotal();

  switch($action){
    case 'getAllSetor':
      $setor = $rel->getSetorLocal($idLocal);
      echo json_encode($setor);
      break;

    case 'getAllCategoria':
      $categoria = $rel->getCategoriaBySetor($idSetor);
      echo json_encode($categoria);
      break;

    case 'gerar':
      if ($dataInicio) $rel->setDataInicio($dataInicio);
      if ($dataFim) $rel->setDataFim($dataFim);
      if ($local) $rel->setLocal($local);
      if ($setor) $rel->setSetor($setor);
      if ($categoria) $rel->setCategoria($categoria);

      $lista = $rel->getListaGeralAnalitico();

    default:
      $localSelect = $rel->getAllLocal();
      include_once '../view/relTotalAnalitico.php';
      break;
  }