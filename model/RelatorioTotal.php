<?php
  class RelatorioTotal extends Connect
  {
    private $relatorio;
    private $dataInicio;
    private $dataFim;
    private $local;
    private $setor;
    private $categoria;
    private $usuario;


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

    public function getListaCategoriaVestimenta(){
      $db = parent::getInstanceMysql();
      unset($sql);
      if(!empty($this->dataInicio)) $sql .= " AND a.dataCadastro>='{$this->dataInicio}'";
      if(!empty($this->dataFim)) $sql .= " AND a.dataCadastro<='{$this->dataFim}'";
      if(!empty($this->local)) $sql .= " AND a.fk_local='{$this->local}'";
      if(!empty($this->setor)) $sql .= " AND a.fk_setor='{$this->setor}'";
      if(!empty($this->categoria)) $sql .= " AND a.fk_categoria='{$this->categoria}'";

      $query = $db->prepare("SELECT b.local,
                              c.setor,
                              d.categoria,
                              count(case when f.idVestimenta=1 then 1 else null end) as jaleco,
                              count(case when f.idVestimenta=2 then 1 else null end) as mascara,
                              count(case when f.idVestimenta=3 then 1 else null end) as oculos,
                              count(case when f.idVestimenta=4 then 1 else null end) as gorro,
                              count(case when f.idVestimenta=5 then 1 else null end) as luvas,
                              count(case when f.idVestimenta=6 then 1 else null end) as aneisAlianca,
                              count(case when f.idVestimenta=7 then 1 else null end) as relogio,
                              count(case when f.idVestimenta=8 then 1 else null end) as unhas,
                              count(case when f.idVestimenta=9 then 1 else null end) as esmalte,
                              count(case when f.idVestimenta=10 then 1 else null end) as brinco,
                              count(case when f.idVestimenta=11 then 1 else null end) as piercing
                            FROM observacao AS a
                              INNER JOIN local AS b ON a.fk_local=b.idLocal
                              INNER JOIN setor AS c ON c.idSetor=a.fk_setor
                              INNER JOIN categoria AS d ON d.idCategoria=a.fk_categoria
                              INNER JOIN vestimenta_observacao as e ON e.fk_observacao=a.idObservacao
                              INNER JOIN vestimenta as f ON f.idVestimenta=e.fk_vestimenta
                            WHERE 1=1 {$sql}
                            GROUP BY b.local,c.setor,d.categoria
                            ORDER BY b.local,c.setor,d.categoria");
      $query->execute();

      $this->relatorio['lista'] = $query->fetchAll(PDO::FETCH_ASSOC);
      $this->relatorio['qtde'] = $query->rowCount();

      return $this->relatorio;
    }

    public function getListaAcaoHigienizacao(){
      $db = parent::getInstanceMysql();
      unset($sql);
      if(!empty($this->dataInicio)) $sql .= " AND o.dataCadastro>='{$this->dataInicio}'";
      if(!empty($this->dataFim)) $sql .= " AND o.dataCadastro<='{$this->dataFim}'";
      if(!empty($this->local)) $sql .= " AND o.fk_local='{$this->local}'";
      if(!empty($this->setor)) $sql .= " AND o.fk_setor='{$this->setor}'";
      if(!empty($this->categoria)) $sql .= " AND o.fk_categoria='{$this->categoria}'";

      $query = $db->prepare("SELECT b.local,
                                c.setor,
                                d.categoria,
                                f.descricao,
                                count(case when h.idHigienizacao=1 then 1 else null end) as palmas,
                                count(case when h.idHigienizacao=2 then 1 else null end) as interdigital,
                                count(case when h.idHigienizacao=3 then 1 else null end) as dorso,
                                count(case when h.idHigienizacao=4 then 1 else null end) as polegar,
                                count(case when h.idHigienizacao=5 then 1 else null end) as ponta,
                                count(case when h.idHigienizacao=6 then 1 else null end) as punho
                              FROM observacao AS a
                                INNER JOIN local AS b ON a.fk_local=b.idLocal
                                INNER JOIN setor AS c ON c.idSetor=a.fk_setor
                                INNER JOIN categoria AS d ON d.idCategoria=a.fk_categoria
                                INNER JOIN acao_observacao AS e ON e.fk_observacao=a.idObservacao
                                INNER JOIN acao AS f ON f.idAcao=e.fk_acao
                                INNER JOIN higienizacao_observacao AS g ON g.fk_observacao=a.idObservacao
                                INNER JOIN higienizacao AS h ON h.idHigienizacao=g.fk_higienizacao
                              WHERE 1=1 {$sql}
                              GROUP BY b.local,c.setor,d.categoria,f.descricao
                              ORDER BY b.local,c.setor,d.categoria,f.descricao");
      $query->execute();

      $this->relatorio['lista'] = $query->fetchAll(PDO::FETCH_ASSOC);
      $this->relatorio['qtde'] = $query->rowCount();

      return $this->relatorio;
    }

    public function getListaIndicaAcao(){
      $db = parent::getInstanceMysql();
      unset($sql);
      if(!empty($this->dataInicio)) $sql .= " AND o.dataCadastro>='{$this->dataInicio}'";
      if(!empty($this->dataFim)) $sql .= " AND o.dataCadastro<='{$this->dataFim}'";
      if(!empty($this->local)) $sql .= " AND o.fk_local='{$this->local}'";
      if(!empty($this->setor)) $sql .= " AND o.fk_setor='{$this->setor}'";
      if(!empty($this->categoria)) $sql .= " AND o.fk_categoria='{$this->categoria}'";

      $query = $db->prepare("SELECT l.local,
                                   s.setor,
                                   c.categoria,
                                   i.descricao,
                                  count(case when a.idAcao=1 then 1 else null end) as alcool,
                                  count(case when a.idAcao=2 then 1 else null end) as sabonete,
                                  count(case when a.idAcao=3 then 1 else null end) as pvpi,
                                  count(case when a.idAcao=4 then 1 else null end) as clorexidina,
                                  count(case when a.idAcao=5 then 1 else null end) as outro,
                                  count(case when a.idAcao=6 then 1 else null end) as naoRealizada
                              FROM observacao AS o
                              INNER JOIN acao_observacao AS ao ON ao.fk_observacao=o.idObservacao
                              INNER JOIN acao AS a ON a.idAcao=ao.fk_acao
                              INNER JOIN indicacao_observacao AS oi ON oi.fk_observacao=o.idObservacao
                              INNER JOIN indicacao AS i ON i.idIndicacao=oi.fk_indicacao
                              INNER JOIN categoria AS c ON c.idCategoria=o.fk_categoria
                              INNER JOIN local AS l ON l.idLocal=o.fk_local
                              INNER JOIN setor AS s ON s.idSetor=o.fk_setor
                              WHERE 1=1 {$sql}
                              GROUP BY l.local,s.setor,c.categoria,i.descricao
                              ORDER BY l.local,s.setor,c.categoria,i.descricao");
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
      if(!empty($this->usuario)) $sql .= " AND u.idUsuario='{$this->usuario}'";

      $query = $db->prepare("SELECT  DATE_FORMAT(o.dataCadastro,'%d/%m/%y %h:%i %p') as dataCadastro,
                                      s.setor,
                                      l.local,
                                      c.categoria,
                                      IFNULL(a.descricao,'Não realizada') as acao,
                                      IFNULL(i.descricao,'Não realizada') as indicacao,
                                      IFNULL(v.descricao,'Não realizada') as vestimenta,
                                      IFNULL(h.descricao,'Não realizada') as higienizacao,
                                      u.nome as nome
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
                              INNER JOIN usuario as u
                                ON u.idUsuario=o.userCadastro
                            WHERE 1=1 {$sql}");
      $query->execute();

      $this->relatorio['lista'] = $query->fetchAll(PDO::FETCH_ASSOC);
      $this->relatorio['qtde'] = $query->rowCount();

      return $this->relatorio;
    }

    public function getListaGeralAnaliX(){
      $db = parent::getInstanceMysql();
      unset($sql);
      if(!empty($this->dataInicio)) $sql .= " AND o.dataCadastro>='{$this->dataInicio}'";
      if(!empty($this->dataFim)) $sql .= " AND o.dataCadastro<='{$this->dataFim}'";
      if(!empty($this->local)) $sql .= " AND o.fk_local='{$this->local}'";
      if(!empty($this->setor)) $sql .= " AND o.fk_setor='{$this->setor}'";
      if(!empty($this->categoria)) $sql .= " AND o.fk_categoria='{$this->categoria}'";
      if(!empty($this->usuario)) $sql .= " AND u.idUsuario='{$this->usuario}'";

      $query = $db->prepare("SELECT  DATE_FORMAT(o.dataCadastro,'%d/%m/%y %h:%i %p') as dataCadastro,
                                    s.setor,
                                    l.local,
                                    c.categoria,
                                  (select case when fk_indicacao=1  then 'X' else '' end as antPacte from indicacao_observacao where fk_observacao=o.idObservacao and fk_indicacao=1) as antpacte,
                                  (select case when fk_indicacao=2  then 'X' else '' end as antProcAssep from indicacao_observacao where fk_observacao=o.idObservacao and fk_indicacao=2) as antProcAssep,
                                  (select case when fk_indicacao=3  then 'X' else '' end as fluidoCorp from indicacao_observacao where fk_observacao=o.idObservacao and fk_indicacao=3) as fluidoCorp,
                                  (select case when fk_indicacao=4  then 'X' else '' end as apPacte from indicacao_observacao where fk_observacao=o.idObservacao and fk_indicacao=4) as apPacte,
                                  (select case when fk_indicacao=5  then 'X' else '' end as apProxim from indicacao_observacao where fk_observacao=o.idObservacao and fk_indicacao=5) as apProxim,
                                  (select case when fk_acao=1  then 'X' else '' end as friccao from acao_observacao where fk_observacao=o.idObservacao and fk_acao=1) as friccao,
                                  (select case when fk_acao=2  then 'X' else '' end as sabonete from acao_observacao where fk_observacao=o.idObservacao and fk_acao=2) as sabonete,
                                  (select case when fk_acao=3  then 'X' else '' end as pvpi from acao_observacao where fk_observacao=o.idObservacao and fk_acao=3) as pvpi,
                                  (select case when fk_acao=4  then 'X' else '' end as clorexidina from acao_observacao where fk_observacao=o.idObservacao and fk_acao=4) as clorexidina,
                                  (select case when fk_acao=5  then 'X' else '' end as outro from acao_observacao where fk_observacao=o.idObservacao and fk_acao=5) as outro,
                                  (select case when fk_acao=6  then 'X' else '' end as naoRealizada from acao_observacao where fk_observacao=o.idObservacao and fk_acao=6) as naoRealizada,
                                  (select case when fk_higienizacao=1  then 'X' else '' end as palmas from higienizacao_observacao where fk_observacao=o.idObservacao and fk_higienizacao=1) as palmas,
                                  (select case when fk_higienizacao=2  then 'X' else '' end as palmaInterdigital from higienizacao_observacao where fk_observacao=o.idObservacao and fk_higienizacao=2) as palmaInterdigital,
                                  (select case when fk_higienizacao=3  then 'X' else '' end as dedos from higienizacao_observacao where fk_observacao=o.idObservacao and fk_higienizacao=3) as dedos,
                                  (select case when fk_higienizacao=4  then 'X' else '' end as dorso from higienizacao_observacao where fk_observacao=o.idObservacao and fk_higienizacao=4) as dorso,
                                  (select case when fk_higienizacao=5  then 'X' else '' end as polegar from higienizacao_observacao where fk_observacao=o.idObservacao and fk_higienizacao=5) as polegar,
                                  (select case when fk_higienizacao=6  then 'X' else '' end as ponta from higienizacao_observacao where fk_observacao=o.idObservacao and fk_higienizacao=6) as ponta,
                                  (select case when fk_higienizacao=7  then 'X' else '' end as punho from higienizacao_observacao where fk_observacao=o.idObservacao and fk_higienizacao=7) as punho,
                                  (select case when fk_vestimenta=1  then 'X' else '' end as jaleco from vestimenta_observacao where fk_observacao=o.idObservacao and fk_vestimenta=1) as jaleco,
                                  (select case when fk_vestimenta=2  then 'X' else '' end as mascara from vestimenta_observacao where fk_observacao=o.idObservacao and fk_vestimenta=2) as mascara,
                                  (select case when fk_vestimenta=3  then 'X' else '' end as oculos from vestimenta_observacao where fk_observacao=o.idObservacao and fk_vestimenta=3) as oculos,
                                  (select case when fk_vestimenta=4  then 'X' else '' end as gorro from vestimenta_observacao where fk_observacao=o.idObservacao and fk_vestimenta=4) as gorro,
                                  (select case when fk_vestimenta=5  then 'X' else '' end as luvas from vestimenta_observacao where fk_observacao=o.idObservacao and fk_vestimenta=5) as luvas,
                                  (select case when fk_vestimenta=6  then 'X' else '' end as anel from vestimenta_observacao where fk_observacao=o.idObservacao and fk_vestimenta=6) as anel,
                                  (select case when fk_vestimenta=7  then 'X' else '' end as relogio from vestimenta_observacao where fk_observacao=o.idObservacao and fk_vestimenta=7) as relogio,
                                  (select case when fk_vestimenta=8  then 'X' else '' end as unha from vestimenta_observacao where fk_observacao=o.idObservacao and fk_vestimenta=8) as unha,
                                  (select case when fk_vestimenta=9  then 'X' else '' end as esmalte from vestimenta_observacao where fk_observacao=o.idObservacao and fk_vestimenta=9) as esmalte,
                                  (select case when fk_vestimenta=10  then 'X' else '' end as brinco from vestimenta_observacao where fk_observacao=o.idObservacao and fk_vestimenta=10) as brinco,
                                  (select case when fk_vestimenta=11  then 'X' else '' end as piercing from vestimenta_observacao where fk_observacao=o.idObservacao and fk_vestimenta=11) as piercing,
                                    u.nome as nome
                              FROM observacao as o
                                INNER JOIN categoria as c
                                ON c.idCategoria=o.fk_categoria
                                INNER JOIN local as l
                                ON l.idLocal=o.fk_local
                                INNER JOIN setor as s
                                ON s.idSetor=o.fk_setor
                                INNER JOIN usuario as u
                                ON u.idUsuario=o.userCadastro
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
      if(!empty($this->dataInicio)) $sql .= " AND a.dataCadastro>='{$this->dataInicio}'";
      if(!empty($this->dataFim)) $sql .= " AND a.dataCadastro<='{$this->dataFim}'";
      if(!empty($this->local)) $sql .= " AND a.fk_local='{$this->local}'";
      if(!empty($this->setor)) $sql .= " AND a.fk_setor='{$this->setor}'";
      if(!empty($this->categoria)) $sql .= " AND a.fk_categoria='{$this->categoria}'";

      $query = $db->prepare("SELECT b.local,
                              c.setor,
                              d.categoria,
                              f.descricao,
                              count(case when h.idHigienizacao=1 then 1 else null end) as palmas,
                              count(case when h.idHigienizacao=2 then 1 else null end) as palmaInterdigital,
                              count(case when h.idHigienizacao=3 then 1 else null end) as dedos,
                              count(case when h.idHigienizacao=4 then 1 else null end) as dorso,
                              count(case when h.idHigienizacao=5 then 1 else null end) as polegar,
                              count(case when h.idHigienizacao=6 then 1 else null end) as ponta,
                              count(case when h.idHigienizacao=7 then 1 else null end) as punho
                            FROM observacao AS a
                              INNER JOIN local AS b ON a.fk_local=b.idLocal
                              INNER JOIN setor AS c ON c.idSetor=a.fk_setor
                              INNER JOIN categoria AS d ON d.idCategoria=a.fk_categoria
                              INNER JOIN indicacao_observacao AS e ON e.fk_observacao=a.idObservacao
                              INNER JOIN indicacao AS f ON f.idIndicacao=e.fk_indicacao
                              INNER JOIN higienizacao_observacao AS g ON g.fk_observacao=a.idObservacao
                              INNER JOIN higienizacao AS h ON h.idHigienizacao=g.fk_higienizacao
                            WHERE 1=1 {$sql}
                              GROUP BY b.local,c.setor,d.categoria,f.descricao
                              ORDER BY b.local,c.setor,d.categoria,f.descricao;");
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

    /**
     * Gets the value of usuario.
     *
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Sets the value of usuario.
     *
     * @param mixed $usuario the usuario
     *
     * @return self
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }
}