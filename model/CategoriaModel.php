<?php
    class CategoriaModel extends Connect
    {
      private $id;
      private $categoria;
      private $setor;
      private $local;
      private $setores = [];
      private $categorias = [];
      private $locais = [];

      public function __construct(){}

      public function saveCategoria(){
        $db = parent::getInstanceMysql();

        if(!$this->id){
          $query = $db->prepare('INSERT INTO categoria (categoria) values (:categoria)');
          $query->bindValue(":categoria",$this->getCategoria(),PDO::PARAM_STR);
          $query->execute();
          $last = $db->lastInsertId();  

          $query2 = $db->prepare('INSERT INTO setor_categoria (fk_setor,fk_local,fk_categoria) VALUES (:fk_setor,:fk_local,:fk_categoria)');
          $query2->bindValue(":fk_categoria",$last,PDO::PARAM_INT);
          $query2->bindValue(":fk_local",$this->getLocal(),PDO::PARAM_INT);
          $query2->bindValue(":fk_setor",$this->getSetor(),PDO::PARAM_INT);
          $query2->execute();

        }else{
          $q = $db->prepare('SELECT fk_categoria FROM setor_categoria WHERE idSetorCategoria=:idSetorCategoria');
          $q->bindValue(":idSetorCategoria",$this->getId(),PDO::PARAM_INT);
          $q->execute();
          $idSet = $q->fetch(PDO::FETCH_ASSOC);

          $query = $db->prepare('UPDATE categoria 
                                SET categoria=:categoria, dataCadastro=now()
                                WHERE idCategoria=:idCategoria');
          $query->bindValue(":idCategoria",$idSet['fk_categoria'],PDO::PARAM_INT);
          $query->bindValue(":categoria",$this->getCategoria(),PDO::PARAM_STR);
          $query->execute();

          $q2 = $db->prepare('UPDATE setor_categoria
                                SET fk_setor=:idSetor, fk_local=:idLocal, fk_categoria=:fk_categoria
                                WHERE idSetorCategoria=:idSetorCategoria');
          $q2->bindValue(":idSetorCategoria",$this->getId(),PDO::PARAM_INT);
          $q2->bindValue(":idSetor",$this->getSetor(),PDO::PARAM_INT);
          $q2->bindValue(":idLocal",$this->getLocal(),PDO::PARAM_INT);
          $q2->bindValue(":fk_categoria",$idSet['fk_categoria'],PDO::PARAM_INT);
          $q2->execute();

        }
        return true;
      }

      public function deleteCategoria($idSetorCategoria){

        $db = parent::getInstanceMysql();
        $q = $db->prepare('SELECT fk_categoria FROM setor_categoria WHERE idSetorCategoria=:idSetorCategoria');
        $q->bindValue(":idSetorCategoria",$idSetorCategoria,PDO::PARAM_INT);
        $q->execute();
        $idSet = $q->fetch(PDO::FETCH_ASSOC);

        $query = $db->prepare('DELETE FROM setor_categoria WHERE idSetorCategoria=:idSetorCategoria');
        $query->bindValue(":idSetorCategoria",$idSetorCategoria,PDO::PARAM_INT);
        $query->execute();

        //depois verificar o delete cascade
        $query2 = $db->prepare('DELETE FROM categoria WHERE idCategoria=:idCategoria');
        $query2->bindValue(":idCategoria",$idSet['fk_categoria'],PDO::PARAM_INT);
        $query2->execute();

        return true;
      }

      // public function getAllSetors(){
      //   $this->setores = new SetorModel();
      //   return $this->setores->getAllSetors();
      // }

      public function getSetorLocal($idSetor){
        $this->setores = new SetorModel();
        return $this->setores->getSetorByLocal($idSetor);
      }

      public function getSetorLocalById($idSetorLocal){
        $this->setores = new SetorModel();
        return $this->setores->getSetorById($idSetorLocal);
      }


      public function getAllLocals(){
        $this->locais = new LocalModel();
        return $this->locais->getAllLocals();
      }

      public function getAllCategorias(){
        $db = parent::getInstanceMysql();
        $query = $db->prepare('SELECT sc.idSetorCategoria,
                                  c.idCategoria, 
                                  c.categoria, 
                                  s.idSetor, 
                                  s.setor,
                                  l.idLocal,
                                  l.local 
                                FROM setor_categoria as sc
                                  INNER JOIN categoria as c
                                    ON c.idCategoria=sc.fk_categoria
                                  INNER JOIN setor as s
                                    ON s.idSetor=sc.fk_setor
                                  INNER JOIN local as l
                                    ON l.idLocal=sc.fk_local');
        $query->execute();
        $this->categorias = $query->fetchAll();

        return $this->categorias;
      }

      public function getCategoriaBySetor($idSetor){
        $db = parent::getInstanceMysql();
        $query = $db->prepare('SELECT sc.idSetorCategoria,
                                  c.idCategoria, 
                                  c.categoria, 
                                  s.idSetor, 
                                  s.setor,
                                  l.idLocal,
                                  l.local 
                                FROM setor_categoria as sc
                                  INNER JOIN categoria as c
                                    ON c.idCategoria=sc.fk_categoria
                                  INNER JOIN setor as s
                                    ON s.idSetor=sc.fk_setor
                                  INNER JOIN local as l
                                    ON l.idLocal=sc.fk_local
                                WHERE sc.fk_setor=:idSetor');
        $query->bindValue(":idSetor",$idSetor,PDO::PARAM_INT);
        $query->execute();
        $this->categorias = $query->fetchAll(PDO::FETCH_ASSOC);

        return $this->categorias;
      }

      public function getCategoriaById($idSetorCategoria){
        
        $db = parent::getInstanceMysql();
        $query = $db->prepare('SELECT sc.idSetorCategoria,
                                  c.idCategoria, 
                                  c.categoria, 
                                  s.idSetor, 
                                  s.setor,
                                  l.idLocal,
                                  l.local 
                                FROM setor_categoria as sc
                                  INNER JOIN categoria as c
                                    ON c.idCategoria=sc.fk_categoria
                                  INNER JOIN setor as s
                                    ON s.idSetor=sc.fk_setor
                                  INNER JOIN local as l
                                    ON l.idLocal=sc.fk_local
                                WHERE sc.idSetorCategoria=:idSetorCategoria');
        $query->bindValue(":idSetorCategoria",$idSetorCategoria,PDO::PARAM_INT);
        $query->execute();
        $this->categorias = $query->fetch();

        return $this->categorias;
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
    }

    /**
     * Gets the value of categoria.
     *
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Sets the value of categoria.
     *
     * @param mixed $categoria the categoria
     *
     * @return self
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
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
    }
}