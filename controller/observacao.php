<?php
  require_once '../sessionUp.php';
  require_once '../connect/Connect.php';
  require_once '../autoloadClass.php';

  $action     = (!empty($_REQUEST['action']))     ? $_REQUEST['action']     : '';
  $idLocalSetor  = (!empty($_REQUEST['idLocalSetor']))  ? $_REQUEST['idLocalSetor']  : '';
  $idSetorCategoria  = (!empty($_REQUEST['idSetorCategoria']))  ? $_REQUEST['idSetorCategoria']  : '';
  $campo  = (!empty($_REQUEST['campo']))  ? $_REQUEST['campo']  : '';

  $obs = new ObservacaoModel();
  unset($flashData);

  switch($action){

    case 'obsHandHygiene':
      $localSetorNome = $obs->getLocalSetorById($idLocalSetor);
      $setorCategoria = $obs->getSetorCategoriaById($idSetorCategoria);
      $listaAcao = $obs->getAllAcao();
      $listaIndicacao = $obs->getAllIndicacao();
      $listaHigienizacao = $obs->getAllHigienizacao();
      $listaVestimenta = $obs->getAllVestimenta();
      include_once '../view/obsHandHygiene.php';
      break;

    case 'insert':
      $valores = array();
      parse_str($campo, $valores);
      extract($valores);

      //insere ou atualiza a observacao
      $obs->setLocalSetor((int)$idLocalSetor);
      $obs->setSetorCategoria((int)$idSetorCategoria);
      $obs->setIndicacao((int)$indicacao);
      $obs->setAcao((array)$acao);
      $obs->setHigienizacao((array)$higienizacao);
      $obs->setVestimenta((array)$vestimenta);

      $obs->saveObservacao();
      Session::setFlashData('alert-info', 'Observação cadastrada com sucesso!');
    break;

    case 'obsCategoria':
      $localSetorNome = $obs->getLocalSetorById($idLocalSetor);
      $listCategoriaSetor = $obs->getAllCategoriaById($idLocalSetor);
      $flashData = Session::getFlashData();
      include_once '../view/obsCategoria.php';
    break;

    default:
      //entra no formulário
      $listLocalSetor = $obs->getAllLocalSetor();
      include_once '../view/obsLocalSetor.php';
      break;
  }