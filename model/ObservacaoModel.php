<?php
    class ObservacaoModel extends Connect
    {
      private $id;
      private $localSetor = [];
      private $setorCategoria = [];
      private $indicacao;
      private $acao = [];
      private $higienizacao = [];
      private $vestimenta = [];

      public function __construct(){}

      public function saveObservacao(){
        $db = parent::getInstanceMysql();

        $localSetorObs = $this->getLocalSetorById($this->localSetor);
        $setorCategoriaObs = $this->getSetorCategoriaById($this->setorCategoria);

        $qObservacao = $db->prepare('INSERT INTO observacao (fk_local,fk_setor,fk_categoria,userCadastro) VALUES (:fk_local,:fk_setor,:fk_categoria,:userCadastro)');
        $qObservacao->bindValue(":fk_local",$localSetorObs['idLocal'],PDO::PARAM_INT);
        $qObservacao->bindValue(":fk_setor",$setorCategoriaObs['idSetor'],PDO::PARAM_INT);
        $qObservacao->bindValue(":fk_categoria",$setorCategoriaObs['idCategoria'],PDO::PARAM_INT);
        $qObservacao->bindValue(":userCadastro",$_SESSION['user']['idUsuario'],PDO::PARAM_INT);
        $qObservacao->execute();
        $lastId = $db->lastInsertId();

        if (!empty($this->indicacao)) {
          $qIndicacao = $db->prepare('INSERT INTO indicacao_observacao (fk_observacao,fk_indicacao) VALUES (:fk_observacao,:fk_indicacao)');
          $qIndicacao->bindValue(":fk_observacao",$lastId,PDO::PARAM_INT);
          $qIndicacao->bindValue(":fk_indicacao",$this->getIndicacao(),PDO::PARAM_INT);
          $qIndicacao->execute();
        }

        if (!empty($this->acao)) {
          $qAcao = $db->prepare('INSERT INTO acao_observacao (fk_observacao,fk_acao) VALUES (:fk_observacao,:fk_acao)');
          foreach ($this->acao as $key) {
            $qAcao->bindValue(":fk_observacao",$lastId,PDO::PARAM_INT);
            $qAcao->bindValue(":fk_acao",$key,PDO::PARAM_INT);
            $qAcao->execute();
          }
        }

        if (!empty($this->higienizacao)) {
          $qHigienizacao = $db->prepare('INSERT INTO higienizacao_observacao (fk_observacao,fk_higienizacao) VALUES (:fk_observacao,:fk_higienizacao)');
          foreach ($this->higienizacao as $key) {
            $qHigienizacao->bindValue(":fk_observacao",$lastId,PDO::PARAM_INT);
            $qHigienizacao->bindValue(":fk_higienizacao",$key,PDO::PARAM_INT);
            $qHigienizacao->execute();
          }
        }

        if (!empty($this->vestimenta)) {
          $qVestimenta = $db->prepare('INSERT INTO vestimenta_observacao (fk_observacao,fk_vestimenta) VALUES (:fk_observacao,:fk_vestimenta)');
          foreach ($this->vestimenta as $key) {
            $qVestimenta->bindValue(":fk_observacao",$lastId,PDO::PARAM_INT);
            $qVestimenta->bindValue(":fk_vestimenta",$key,PDO::PARAM_INT);
            $qVestimenta->execute();
          }
        }

        return true;
      }

      public function getLocalSetorById($idLocalSetor){
        $db = parent::getInstanceMysql();
        $q = $db->prepare('SELECT ls.idLocalSetor,
                                 l.idLocal,
                                 l.local,
                                 s.idSetor,
                                 s.setor
                          FROM local_setor AS ls
                          INNER JOIN local AS l ON l.idLocal=ls.fk_local
                          INNER JOIN setor AS s ON s.idSetor=ls.fk_setor
                          WHERE ls.idLocalSetor=:idLocalSetor');
        $q->bindValue(":idLocalSetor",$idLocalSetor,PDO::PARAM_INT);
        $q->execute();
        $this->localSetor = $q->fetch(PDO::FETCH_ASSOC);

        return $this->localSetor;
      }

      public function getSetorCategoriaById($idSetorCategoria){
        $db = parent::getInstanceMysql();
        $q = $db->prepare('SELECT sc.idSetorCategoria,
                                   c.idCategoria,
                                   c.categoria,
                                   s.idSetor,
                                   s.setor
                            FROM setor_categoria AS sc
                            INNER JOIN categoria AS c ON c.idCategoria=sc.fk_categoria
                            INNER JOIN setor AS s ON s.idSetor=sc.fk_setor
                            WHERE sc.idSetorCategoria=:idSetorCategoria');
        $q->bindValue(":idSetorCategoria",$idSetorCategoria,PDO::PARAM_INT);
        $q->execute();
        $this->setorCategoria = $q->fetch(PDO::FETCH_ASSOC);

        return $this->setorCategoria;
      }

      public function getAllCategoriaById($idLocalSetor){
        $db = parent::getInstanceMysql();

        $q1 = $db->prepare('SELECT fk_setor
                            FROM local_setor
                            WHERE idLocalSetor=:idLocalSetor');
        $q1->bindValue(":idLocalSetor",$idLocalSetor,PDO::PARAM_INT);
        $q1->execute();
        $fk = $q1->fetch(PDO::FETCH_ASSOC);

        $q = $db->prepare('SELECT sc.idSetorCategoria,
                                   c.idCategoria,
                                   c.categoria,
                                   s.idSetor,
                                   s.setor
                            FROM setor_categoria AS sc
                            INNER JOIN categoria AS c ON c.idCategoria=sc.fk_categoria
                            INNER JOIN setor AS s ON s.idSetor=sc.fk_setor
                            WHERE fk_setor=:fk_setor');
        $q->bindValue(":fk_setor",$fk['fk_setor'],PDO::PARAM_INT);
        $q->execute();
        $this->setorCategoria = $q->fetchAll(PDO::FETCH_ASSOC);

        return $this->setorCategoria;
      }

      public function getAllLocalSetor(){
        $db = parent::getInstanceMysql();
        $q = $db->prepare('SELECT ls.idLocalSetor,
                                 l.idLocal,
                                 l.local,
                                 s.idSetor,
                                 s.setor
                          FROM local_setor AS ls
                          INNER JOIN local AS l ON l.idLocal=ls.fk_local
                          INNER JOIN setor AS s ON s.idSetor=ls.fk_setor');
        $q->execute();
        $this->localSetor = $q->fetchAll(PDO::FETCH_ASSOC);

        return $this->localSetor;
      }

      public function getAllAcao(){
        $db = parent::getInstanceMysql();
        $q = $db->prepare('SELECT idAcao, descricao FROM acao');
        $q->execute();
        $this->acao = $q->fetchAll(PDO::FETCH_ASSOC);

        return $this->acao;
      }

      public function getAllIndicacao(){
        $db = parent::getInstanceMysql();
        $q = $db->prepare('SELECT idIndicacao, descricao FROM indicacao');
        $q->execute();
        $this->indicacao = $q->fetchAll(PDO::FETCH_ASSOC);

        return $this->indicacao;
      }

      public function getAllHigienizacao(){
        $db = parent::getInstanceMysql();
        $q = $db->prepare('SELECT idHigienizacao, descricao FROM higienizacao');
        $q->execute();
        $this->higienizacao = $q->fetchAll(PDO::FETCH_ASSOC);

        return $this->higienizacao;
      }

      public function getAllVestimenta(){
        $db = parent::getInstanceMysql();
        $q = $db->prepare('SELECT idVestimenta, descricao FROM vestimenta');
        $q->execute();
        $this->vestimenta = $q->fetchAll(PDO::FETCH_ASSOC);

        return $this->vestimenta;
      }


      //public function deleteCategoria($idSetorCategoria){

        // $db = parent::getInstanceMysql();
        // $q = $db->prepare('SELECT fk_categoria FROM setor_categoria WHERE idSetorCategoria=:idSetorCategoria');
        // $q->bindValue(":idSetorCategoria",$idSetorCategoria,PDO::PARAM_INT);
        // $q->execute();

        // return true;
      //}


    /**
     * Gets the value of indicacao.
     *
     * @return mixed
     */
    public function getIndicacao()
    {
        return $this->indicacao;
    }

    /**
     * Sets the value of indicacao.
     *
     * @param mixed $indicacao the indicacao
     *
     * @return self
     */
    public function setIndicacao($indicacao)
    {
        $this->indicacao = $indicacao;
    }

    /**
     * Gets the value of acao.
     *
     * @return mixed
     */
    public function getAcao()
    {
        return $this->acao;
    }

    /**
     * Sets the value of acao.
     *
     * @param mixed $acao the acao
     *
     * @return self
     */
    public function setAcao($acao)
    {
        $this->acao = $acao;
    }

    /**
     * Gets the value of higienizacao.
     *
     * @return mixed
     */
    public function getHigienizacao()
    {
        return $this->higienizacao;
    }

    /**
     * Sets the value of higienizacao.
     *
     * @param mixed $higienizacao the higienizacao
     *
     * @return self
     */
    public function setHigienizacao($higienizacao)
    {
        $this->higienizacao = $higienizacao;
    }

    /**
     * Gets the value of vestimenta.
     *
     * @return mixed
     */
    public function getVestimenta()
    {
        return $this->vestimenta;
    }

    /**
     * Sets the value of vestimenta.
     *
     * @param mixed $vestimenta the vestimenta
     *
     * @return self
     */
    public function setVestimenta($vestimenta)
    {
        $this->vestimenta = $vestimenta;
    }


    /**
     * Gets the value of localSetor.
     *
     * @return mixed
     */
    public function getLocalSetor()
    {
        return $this->localSetor;
    }

    /**
     * Sets the value of localSetor.
     *
     * @param mixed $localSetor the local setor
     *
     * @return self
     */
    public function setLocalSetor($localSetor)
    {
        $this->localSetor = $localSetor;
    }

    /**
     * Gets the value of setorCategoria.
     *
     * @return mixed
     */
    public function getSetorCategoria()
    {
        return $this->setorCategoria;
    }

    /**
     * Sets the value of setorCategoria.
     *
     * @param mixed $setorCategoria the setor categoria
     *
     * @return self
     */
    public function setSetorCategoria($setorCategoria)
    {
        $this->setorCategoria = $setorCategoria;
    }
}