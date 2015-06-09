<?php
  class Lista
  {
    public static function dataBd($data){
      $dataF = explode('/', $data);
      return $dataF[2].'-'.$dataF[1].'-'.$dataF[0];
    }
    public static function dataUser($data){
      $dataF = explode('-', $data);
      return $dataF[2].'/'.$dataF[1].'/'.$dataF[0];
    }
  }