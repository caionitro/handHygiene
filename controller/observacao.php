<?php
  require_once '../sessionUp.php';
  require_once '../connect/Connect.php';
  require_once '../model/UsuarioModel.php';
  require_once '../model/LocalModel.php';
  require_once '../model/SetorModel.php';
  require_once '../model/CategoriaModel.php';
  require_once '../model/ObservacaoModel.php';

  $action     = (!empty($_REQUEST['action']))     ? $_REQUEST['action']     : '';
  $idLocalSetor  = (!empty($_REQUEST['idLocalSetor']))  ? $_REQUEST['idLocalSetor']  : '';
  $idSetorCategoria  = (!empty($_REQUEST['idSetorCategoria']))  ? $_REQUEST['idSetorCategoria']  : '';
  $campo  = (!empty($_REQUEST['campo']))  ? $_REQUEST['campo']  : '';

  $obs = new ObservacaoModel();

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
      //echo '<pre>'.print_r($campo,1).'</pre>';
      parse_str($campo, $valores);
      extract($valores);
      // echo '<pre>'.print_r($valores,1).'</pre>';
      //insere ou atualiza a observacao
      $obs->setLocalSetor((int)$idLocalSetor);
      $obs->setSetorCategoria((int)$idSetorCategoria);
      $obs->setIndicacao((int)$indicacao);
      $obs->setAcao((array)$acao);
      $obs->setHigienizacao((array)$higienizacao);
      $obs->setVestimenta((array)$vestimenta);
      // echo '<pre>'.print_r($obs,1).'</pre>';
      // exit;
      $obs->saveObservacao();
    break;

    case 'obsCategoria':
      $localSetorNome = $obs->getLocalSetorById($idLocalSetor);
      $listCategoriaSetor = $obs->getAllCategoriaById($idLocalSetor);
      include_once '../view/obsCategoria.php';
    break;

    default:
      //entra no formulário
      $listLocalSetor = $obs->getAllLocalSetor();
      include_once '../view/obsLocalSetor.php';
      break;
  }