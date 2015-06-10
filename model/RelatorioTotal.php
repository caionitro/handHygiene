<?php
  class RelatorioTotal extends Connect
  {
    private $relatorio;
    private $dataInicio;
    private $dataFim;
    private $local;
    private $setor;
    private $categoria;


    public function getAllLocal(){
      $local = new LocalModel();
      return $local->getAllLocals();
    }

    public function getSetorLocal($idLocal){
      $setores = new SetorModel();
      return $setores->getSetorByLocal($idLocal);
    }

    public function getCategoriaBySetor($idSetor){
      $categorias = new CategoriaModel();
      return $categorias->getCategoriaBySetor($idSetor);
    }

    public function getListaIndicaAcao(){
      $db = parent::getInstanceMysql();
      unset($sql);
      if(!empty($this->dataInicio)) $sql .= " AND %s.dataCadastro>='{$this->dataInicio}'";
      if(!empty($this->dataFim)) $sql .= " AND %s.dataCadastro<='{$this->dataFim}'";
      if(!empty($this->local)) $sql .= " AND %s.fk_local='{$this->local}'";
      if(!empty($this->setor)) $sql .= " AND %s.fk_setor='{$this->setor}'";
      if(!empty($this->categoria)) $sql .= " AND %s.fk_categoria='{$this->categoria}'";

      $sqlOb = sprintf($sql,'ob','ob','ob','ob','ob');
      $sql = sprintf($sql,'o','o','o','o','o');

      $query = $db->prepare("SELECT l.local,
                                   s.setor,
                                   c.categoria,
                                   i.descricao,

                              (SELECT count(aob.fk_acao) AS qtde
                               FROM observacao AS ob
                               INNER JOIN acao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                               INNER JOIN acao AS ac ON ac.idAcao=aob.fk_acao
                               INNER JOIN categoria AS ca ON ca.idCategoria=ob.fk_categoria
                               WHERE aob.fk_acao=1
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria
                                 AND 1=1 {$sqlOb}) AS 'alcool',

                              (SELECT count(aob.fk_acao) AS qtde
                               FROM observacao AS ob
                               INNER JOIN acao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                               INNER JOIN acao AS ac ON ac.idAcao=aob.fk_acao
                               INNER JOIN categoria AS ca ON ca.idCategoria=ob.fk_categoria
                               WHERE aob.fk_acao=2
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria
                                 AND 1=1 {$sqlOb}) AS 'aguaSabonete',

                              (SELECT count(aob.fk_acao) AS qtde
                               FROM observacao AS ob
                               INNER JOIN acao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                               INNER JOIN acao AS ac ON ac.idAcao=aob.fk_acao
                               INNER JOIN categoria AS ca ON ca.idCategoria=ob.fk_categoria
                               WHERE aob.fk_acao=3
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria
                                 AND 1=1 {$sqlOb}) AS 'aguaPvpi',

                              (SELECT count(aob.fk_acao) AS qtde
                               FROM observacao AS ob
                               INNER JOIN acao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                               INNER JOIN acao AS ac ON ac.idAcao=aob.fk_acao
                               INNER JOIN categoria AS ca ON ca.idCategoria=ob.fk_categoria
                               WHERE aob.fk_acao=4
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria
                                 AND 1=1 {$sqlOb}) AS 'aguaClorexidina',

                              (SELECT count(aob.fk_acao) AS qtde
                               FROM observacao AS ob
                               INNER JOIN acao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                               INNER JOIN acao AS ac ON ac.idAcao=aob.fk_acao
                               INNER JOIN categoria AS ca ON ca.idCategoria=ob.fk_categoria
                               WHERE aob.fk_acao=5
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria
                                 AND 1=1 {$sqlOb}) AS 'outroProduto',

                              (SELECT count(aob.fk_acao) AS qtde
                               FROM observacao AS ob
                               INNER JOIN acao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                               INNER JOIN acao AS ac ON ac.idAcao=aob.fk_acao
                               INNER JOIN categoria AS ca ON ca.idCategoria=ob.fk_categoria
                               WHERE aob.fk_acao=6
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria
                                 AND 1=1 {$sqlOb}) AS 'naoRealizada'
                            FROM observacao AS o
                            INNER JOIN acao_observacao AS ao ON ao.fk_observacao=o.idObservacao
                            INNER JOIN acao AS a ON a.idAcao=ao.fk_acao
                            INNER JOIN indicacao_observacao AS oi ON oi.fk_observacao=o.idObservacao
                            INNER JOIN indicacao AS i ON i.idIndicacao=oi.fk_indicacao
                            INNER JOIN categoria AS c ON c.idCategoria=o.fk_categoria
                            INNER JOIN local AS l ON l.idLocal=o.fk_local
                            INNER JOIN setor AS s ON s.idSetor=o.fk_setor
                            WHERE 1=1 {$sql}
                            GROUP BY 1,2,3,4,5,6,7,8,9,10");
      $query->execute();

      $this->relatorio['lista'] = $query->fetchAll(PDO::FETCH_ASSOC);
      $this->relatorio['qtde'] = $query->rowCount();

      return $this->relatorio;
    }

    public function getListaGeralAnalitico(){
      $db = parent::getInstanceMysql();
      unset($sql);
      if(!empty($this->dataInicio)) $sql .= " AND o.dataCadastro>='{$this->dataInicio}'";
      if(!empty($this->dataFim)) $sql .= " AND o.dataCadastro<='{$this->dataFim}'";
      if(!empty($this->local)) $sql .= " AND o.fk_local='{$this->local}'";
      if(!empty($this->setor)) $sql .= " AND o.fk_setor='{$this->setor}'";
      if(!empty($this->categoria)) $sql .= " AND o.fk_categoria='{$this->categoria}'";

      $query = $db->prepare("SELECT  DATE_FORMAT(o.dataCadastro,'%d/%m/%y %h:%i %p') as dataCadastro,
                                      s.setor,
                                      l.local,
                                      c.categoria,
                                      IFNULL(a.descricao,'Não realizada') as acao,
                                      IFNULL(i.descricao,'Não realizada') as indicacao,
                                      IFNULL(v.descricao,'Não realizada') as vestimenta,
                                      IFNULL(h.descricao,'Não realizada') as higienizacao
                            FROM observacao as o
                              LEFT JOIN acao_observacao as ao
                                ON ao.fk_observacao=o.idObservacao
                              LEFT JOIN acao as a
                                ON a.idAcao=ao.fk_acao
                              LEFT JOIN indicacao_observacao as oi
                                ON oi.fk_observacao=o.idObservacao
                              LEFT JOIN indicacao as i
                                ON i.idIndicacao=oi.fk_indicacao
                              LEFT JOIN categoria as c
                                ON c.idCategoria=o.fk_categoria
                              LEFT JOIN local as l
                                ON l.idLocal=o.fk_local
                              LEFT JOIN setor as s
                                ON s.idSetor=o.fk_setor
                              LEFT JOIN higienizacao_observacao as ho
                                ON ho.fk_observacao=o.idObservacao
                              LEFT JOIN higienizacao as h
                                ON h.idHigienizacao=ho.fk_higienizacao
                              LEFT JOIN vestimenta_observacao as vo
                                ON vo.fk_observacao=o.idObservacao
                              LEFT JOIN vestimenta as v
                                ON v.idVestimenta=vo.fk_vestimenta
                            WHERE 1=1 {$sql}");
      $query->execute();

      $this->relatorio['lista'] = $query->fetchAll(PDO::FETCH_ASSOC);
      $this->relatorio['qtde'] = $query->rowCount();

      return $this->relatorio;
    }

    public function getListaGeralSintetico(){
      $db = parent::getInstanceMysql();
      unset($sql);
      if(!empty($this->dataInicio)) $sql .= " AND o.dataCadastro>='{$this->dataInicio}'";
      if(!empty($this->dataFim)) $sql .= " AND o.dataCadastro<='{$this->dataFim}'";
      if(!empty($this->local)) $sql .= " AND o.fk_local='{$this->local}'";
      if(!empty($this->setor)) $sql .= " AND o.fk_setor='{$this->setor}'";
      if(!empty($this->categoria)) $sql .= " AND o.fk_categoria='{$this->categoria}'";

      $query = $db->prepare("SELECT s.setor,
                                   l.local,
                                   c.categoria,
                                   count(1) AS qtde
                            FROM observacao AS o
                            INNER JOIN acao_observacao AS ao ON ao.fk_observacao=o.idObservacao
                            INNER JOIN categoria AS c ON c.idCategoria=o.fk_categoria
                            INNER JOIN local AS l ON l.idLocal=o.fk_local
                            INNER JOIN setor AS s ON s.idSetor=o.fk_setor
                            WHERE 1=1 {$sql}
                            GROUP BY 1,2,3");
      $query->execute();

      $this->relatorio['lista'] = $query->fetchAll(PDO::FETCH_ASSOC);
      $this->relatorio['qtde'] = $query->rowCount();

      return $this->relatorio;
    }

    public function getListaIndicaHigienizacao(){
      $db = parent::getInstanceMysql();
      unset($sql);
      if(!empty($this->dataInicio)) $sql .= " AND %s.dataCadastro>='{$this->dataInicio}'";
      if(!empty($this->dataFim)) $sql .= " AND %s.dataCadastro<='{$this->dataFim}'";
      if(!empty($this->local)) $sql .= " AND %s.fk_local='{$this->local}'";
      if(!empty($this->setor)) $sql .= " AND %s.fk_setor='{$this->setor}'";
      if(!empty($this->categoria)) $sql .= " AND %s.fk_categoria='{$this->categoria}'";

      $sqlOb = sprintf($sql,'ob','ob','ob','ob','ob');
      $sql = sprintf($sql,'o','o','o','o','o');

      $query = $db->prepare("SELECT l.local,
                                   s.setor,
                                   c.categoria,
                                   i.descricao,

                                (SELECT count(aob.fk_higienizacao) AS qtde
                                 FROM observacao AS ob
                                 INNER JOIN higienizacao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                                 INNER JOIN higienizacao AS ac ON ac.idHigienizacao=aob.fk_higienizacao
                                 INNER JOIN categoria AS ca ON ca.idCategoria=ob.fk_categoria
                                INNER JOIN acao_observacao as ao ON ao.fk_observacao=ob.idObservacao
                                 WHERE aob.fk_higienizacao=1
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria
                                 AND 1=1) AS 'palmas',

                                (SELECT count(aob.fk_higienizacao) AS qtde
                                 FROM observacao AS ob
                                 INNER JOIN higienizacao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                                 INNER JOIN higienizacao AS ac ON ac.idHigienizacao=aob.fk_higienizacao
                                 INNER JOIN categoria AS ca ON ca.idCategoria=ob.fk_categoria
                              INNER JOIN acao_observacao as ao ON ao.fk_observacao=ob.idObservacao
                                 WHERE aob.fk_higienizacao=2
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria
                                 AND 1=1) AS 'interdigital',

                                (SELECT count(aob.fk_higienizacao) AS qtde
                                 FROM observacao AS ob
                                 INNER JOIN higienizacao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                                 INNER JOIN higienizacao AS ac ON ac.idHigienizacao=aob.fk_higienizacao
                                 INNER JOIN categoria AS ca ON ca.idCategoria=ob.fk_categoria
                              INNER JOIN acao_observacao as ao ON ao.fk_observacao=ob.idObservacao
                                 WHERE aob.fk_higienizacao=3
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria
                                 AND 1=1) AS 'dorso',

                                (SELECT count(aob.fk_higienizacao) AS qtde
                                 FROM observacao AS ob
                                 INNER JOIN higienizacao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                                 INNER JOIN higienizacao AS ac ON ac.idHigienizacao=aob.fk_higienizacao
                                 INNER JOIN categoria AS ca ON ca.idCategoria=ob.fk_categoria
                              INNER JOIN acao_observacao as ao ON ao.fk_observacao=ob.idObservacao
                                 WHERE aob.fk_higienizacao=4
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria
                                 AND 1=1) AS 'polegar',

                                (SELECT count(aob.fk_higienizacao) AS qtde
                                 FROM observacao AS ob
                                 INNER JOIN higienizacao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                                 INNER JOIN higienizacao AS ac ON ac.idHigienizacao=aob.fk_higienizacao
                                 INNER JOIN categoria AS ca ON ca.idCategoria=ob.fk_categoria
                              INNER JOIN acao_observacao as ao ON ao.fk_observacao=ob.idObservacao
                                 WHERE aob.fk_higienizacao=5
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria
                                 AND 1=1) AS 'ponta',

                                (SELECT count(aob.fk_higienizacao) AS qtde
                                 FROM observacao AS ob
                                 INNER JOIN higienizacao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                                 INNER JOIN higienizacao AS ac ON ac.idHigienizacao=aob.fk_higienizacao
                                 INNER JOIN categoria AS ca ON ca.idCategoria=ob.fk_categoria
                              INNER JOIN acao_observacao as ao ON ao.fk_observacao=ob.idObservacao
                                 WHERE aob.fk_higienizacao=6
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria
                                 AND 1=1) AS 'punho'
                              FROM observacao AS o
                              INNER JOIN higienizacao_observacao AS ao ON ao.fk_observacao=o.idObservacao
                              INNER JOIN higienizacao AS a ON a.idHigienizacao=ao.fk_higienizacao
                              INNER JOIN indicacao_observacao AS oi ON oi.fk_observacao=o.idObservacao
                              INNER JOIN indicacao AS i ON i.idIndicacao=oi.fk_indicacao
                              INNER JOIN categoria AS c ON c.idCategoria=o.fk_categoria
                              INNER JOIN local AS l ON l.idLocal=o.fk_local
                              INNER JOIN setor AS s ON s.idSetor=o.fk_setor
                              WHERE 1=1
                              GROUP BY 1,2,3,4,5,6,7,8,9,10");
      $query->execute();

      $this->relatorio['lista'] = $query->fetchAll(PDO::FETCH_ASSOC);
      $this->relatorio['qtde'] = $query->rowCount();

      return $this->relatorio;
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

        return $this;
    }

    /**
     * Gets the value of relatorio.
     *
     * @return mixed
     */
    public function getRelatorio()
    {
        return $this->relatorio;
    }

    /**
     * Sets the value of relatorio.
     *
     * @param mixed $relatorio the relatorio
     *
     * @return self
     */
    public function setRelatorio($relatorio)
    {
        $this->relatorio = $relatorio;

        return $this;
    }

    /**
     * Gets the value of dataInicio.
     *
     * @return mixed
     */
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * Sets the value of dataInicio.
     *
     * @param mixed $dataInicio the data inicio
     *
     * @return self
     */
    public function setDataInicio($dataInicio)
    {
      $this->dataInicio = Lista::dataBd($dataInicio);

      return $this;
    }

    /**
     * Gets the value of dataFim.
     *
     * @return mixed
     */
    public function getDataFim()
    {
        return $this->dataFim;
    }

    /**
     * Sets the value of dataFim.
     *
     * @param mixed $dataFim the data fim
     *
     * @return self
     */
    public function setDataFim($dataFim)
    {
        $this->dataFim = Lista::dataBd($dataFim);

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
}