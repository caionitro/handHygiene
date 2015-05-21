<?php
    class SetorModel extends Connect
    {
      private $id;
      private $setor;
      private $local;
      private $locais = [];
      private $setores = [];

      public function __construct(){}

      public function saveSetor(){
        $db = parent::getInstanceMysql();

        if(!$this->id){
          $query = $db->prepare('INSERT INTO setor (setor) values (:setor)');
          $query->bindValue(":setor",$this->getSetor(),PDO::PARAM_STR);
          $query->execute();
          $last = $db->lastInsertId();  

          $query2 = $db->prepare('INSERT INTO local_setor (fk_setor,fk_local) VALUES (:fk_setor,:fk_local)');
          $query2->bindValue(":fk_setor",$last,PDO::PARAM_INT);
          $query2->bindValue(":fk_local",$this->getLocal(),PDO::PARAM_INT);
          $query2->execute();

        }else{
          $q = $db->prepare('SELECT fk_setor FROM local_setor WHERE idLocalSetor=:idLocalSetor');
          $q->bindValue(":idLocalSetor",$this->getId(),PDO::PARAM_INT);
          $q->execute();
          $idSet = $q->fetch(PDO::FETCH_ASSOC);

          $query = $db->prepare('UPDATE setor 
                                SET setor=:setor, dataCadastro=now()
                                WHERE idSetor=:idSetor');
          $query->bindValue(":idSetor",$idSet['fk_setor'],PDO::PARAM_INT);
          $query->bindValue(":setor",$this->getSetor(),PDO::PARAM_STR);
          $query->execute();

          $q2 = $db->prepare('UPDATE local_setor
                                SET fk_setor=:idSetor, fk_local=:idLocal
                                WHERE idLocalSetor=:idLocalSetor');
          $q2->bindValue(":idLocalSetor",$this->getId(),PDO::PARAM_INT);
          $q2->bindValue(":idSetor",$idSet['fk_setor'],PDO::PARAM_INT);
          $q2->bindValue(":idLocal",$this->getLocal(),PDO::PARAM_INT);
          $q2->execute();

        }
        return true;
      }

      public function deleteSetor($idLocalSetor){

        $db = parent::getInstanceMysql();
        $q = $db->prepare('SELECT fk_setor FROM local_setor WHERE idLocalSetor=:idLocalSetor');
        $q->bindValue(":idLocalSetor",$idLocalSetor,PDO::PARAM_INT);
        $q->execute();
        $idSet = $q->fetch(PDO::FETCH_ASSOC);

        $query = $db->prepare('DELETE FROM local_setor WHERE idLocalSetor=:idLocalSetor');
        $query->bindValue(":idLocalSetor",$idLocalSetor,PDO::PARAM_INT);
        $query->execute();

        //depois verificar o delete cascade
        $query2 = $db->prepare('DELETE FROM setor WHERE idSetor=:idSetor');
        $query2->bindValue(":idSetor",$idSet['fk_setor'],PDO::PARAM_INT);
        $query2->execute();

        return true;
      }

      public function getAllSetors(){

        $db = parent::getInstanceMysql();
        $query = $db->prepare('SELECT s.idSetor,
                                       s.setor,
                                       s.dataCadastro AS dataCadastroSetor,
                                       l.idLocal,
                                       l.local,
                                       l.dataCadastro AS dataCadastroLocal,
                                       ls.idLocalSetor
                                FROM local_setor AS ls
                                INNER JOIN setor AS s ON s.idSetor=ls.fk_setor
                                INNER JOIN local AS l ON l.idLocal=ls.fk_local
                                ORDER BY l.local, s.setor');
        $query->execute();
        $this->setores = $query->fetchAll();

        return $this->setores;
      }

      public function getAllLocals(){
        $this->locais = new LocalModel();
          
        return $this->locais->getAllLocals();
      }

      public function getSetorById($idLocalSetor){
        
        $db = parent::getInstanceMysql();
        $query = $db->prepare('SELECT s.idSetor,
                                       s.setor,
                                       s.dataCadastro AS dataCadastroSetor,
                                       l.idLocal,
                                       l.local,
                                       l.dataCadastro AS dataCadastroLocal,
                                       ls.idLocalSetor
                                FROM local_setor AS ls
                                INNER JOIN setor AS s ON s.idSetor=ls.fk_setor
                                INNER JOIN local AS l ON l.idLocal=ls.fk_local
                                WHERE ls.idLocalSetor = :idLocalSetor');
        $query->bindValue(":idLocalSetor",$idLocalSetor,PDO::PARAM_INT);
        $query->execute();
        $this->setores = $query->fetch();

        return $this->setores;
      }

      public function getSetorByLocal($idLocal){
        
        $db = parent::getInstanceMysql();
        $query = $db->prepare('SELECT s.idSetor,
                                       s.setor,
                                       s.dataCadastro AS dataCadastroSetor
                                FROM local_setor AS ls
                                INNER JOIN setor AS s ON s.idSetor=ls.fk_setor
                                INNER JOIN local AS l ON l.idLocal=ls.fk_local
                                WHERE ls.fk_local = :idLocal');
        $query->bindValue(":idLocal",$idLocal,PDO::PARAM_INT);
        $query->execute();
        $this->setores = $query->fetchAll();

        return $this->setores;
      }




    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of setor.
     *
     * @return mixed
     */
    public function getSetor()
    {
        return $this->setor;
    }

    /**
     * Sets the value of setor.
     *
     * @param mixed $setor the setor
     *
     * @return self
     */
    public function setSetor($setor)
    {
        $this->setor = $setor;

        return $this;
    }

    /**
     * Gets the value of local.
     *
     * @return mixed
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Sets the value of local.
     *
     * @param mixed $local the local
     *
     * @return self
     */
    public function setLocal($local)
    {
        $this->local = $local;

        return $this;
    }
}