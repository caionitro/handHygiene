<?php
    class LocalModel extends Connect
    {
      private $local = [];

      public function __construct(){}

      // public function saveSetor(){
      //   if(!$this->id){
      //     $db = parent::getInstanceMysql();
      //     $query = $db->prepare('insert into tcc.usuario (nome, email, login, senha) values (:nome, :email, :login, :senha)');
      //     $query->bindValue(":nome",$this->getNome(),PDO::PARAM_STR);
      //     $query->bindValue(":email",$this->getEmail(),PDO::PARAM_STR);
      //     $query->bindValue(":login",$this->getLogin(),PDO::PARAM_STR);
      //     $query->bindValue(":senha",$this->getSenha(),PDO::PARAM_STR);
      //     $query->execute();

      //   }else{
      //     $db = parent::getInstanceMysql();
      //     $query = $db->prepare('update tcc.usuario 
      //                           set nome=:nome, email=:email, login=:login, senha=:senha 
      //                           where idUsuario=:idUsuario');
      //     $query->bindValue(":idUsuario",$this->getId(),PDO::PARAM_INT);
      //     $query->bindValue(":nome",$this->getNome(),PDO::PARAM_STR);
      //     $query->bindValue(":email",$this->getEmail(),PDO::PARAM_STR);
      //     $query->bindValue(":login",$this->getLogin(),PDO::PARAM_STR);
      //     $query->bindValue(":senha",$this->getSenha(),PDO::PARAM_STR);
      //     $query->execute();

      //   }
      //   return true;
      // }

      // public function deleteSetor($idLocal){

      //   $db = parent::getInstanceMysql();
      //   $query = $db->prepare('delete from tcc.usuario where idUsuario=:idUsuario');
      //   $query->bindValue(":idUsuario",$idUsuario,PDO::PARAM_INT);
      //   $query->execute();

      //   return true;
      // }

      public function getAllLocals(){

        $db = parent::getInstanceMysql();
        $query = $db->prepare('SELECT idLocal, local, dataCadastro FROM local');
        $query->execute();
        $this->local = $query->fetchAll();

        return $this->local;
      }

      // public function getSetor($idLocal){
        
      //   $db = parent::getInstanceMysql();
      //   $query = $db->prepare('SELECT idUsuario, nome, email, login, dataCadastro, ativo 
      //                           FROM tcc.usuario
      //                           WHERE idUsuario = :idUsuario');
      //   $query->bindValue(":idUsuario",$idUsuario,PDO::PARAM_INT);
      //   $query->execute();
      //   $this->users = $query->fetch();

      //   return $this->users;
      // }


}