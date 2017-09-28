<?php
  class Lista
  {
    //Transforma data do usuário em data para salvar no banco
    public static function dataBd($data){
      $dataF = explode('/', $data);
      return $dataF[2].'-'.$dataF[1].'-'.$dataF[0];
    }
    
    //transforma data do banco para data apresentável para o usuário
    public static function dataUser($data){
      $dataF = explode('-', $data);
      return $dataF[2].'/'.$dataF[1].'/'.$dataF[0];
    }
  }
