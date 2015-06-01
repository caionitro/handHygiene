<?php
  class Relatorio extends Connect
  {
    private $relatorio;

    public function getAllLocal(){
      $local = new LocalModel();
      return $local->getAllLocals();
    }

    public function getSetorLocal($idSetor){
      $setores = new SetorModel();
      return $setores->getSetorByLocal($idSetor);
    }

    public function getListaIndicaAcao(){
      $db = parent::getInstanceMysql();
      $query = $db->prepare("SELECT l.local,
                                   s.setor,
                                   c.categoria,
                                   i.descricao,

                              (SELECT count(aob.fk_acao) AS qtde
                               FROM tcc.observacao AS ob
                               INNER JOIN tcc.acao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                               INNER JOIN tcc.acao AS ac ON ac.idAcao=aob.fk_acao
                               INNER JOIN tcc.categoria AS ca ON ca.idCategoria=ob.fk_categoria
                               WHERE aob.fk_acao=1
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria) AS 'Fricção com álcool',

                              (SELECT count(aob.fk_acao) AS qtde
                               FROM tcc.observacao AS ob
                               INNER JOIN tcc.acao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                               INNER JOIN tcc.acao AS ac ON ac.idAcao=aob.fk_acao
                               INNER JOIN tcc.categoria AS ca ON ca.idCategoria=ob.fk_categoria
                               WHERE aob.fk_acao=2
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria) AS 'Água + sabonete',

                              (SELECT count(aob.fk_acao) AS qtde
                               FROM tcc.observacao AS ob
                               INNER JOIN tcc.acao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                               INNER JOIN tcc.acao AS ac ON ac.idAcao=aob.fk_acao
                               INNER JOIN tcc.categoria AS ca ON ca.idCategoria=ob.fk_categoria
                               WHERE aob.fk_acao=3
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria) AS 'Água + PVPI',

                              (SELECT count(aob.fk_acao) AS qtde
                               FROM tcc.observacao AS ob
                               INNER JOIN tcc.acao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                               INNER JOIN tcc.acao AS ac ON ac.idAcao=aob.fk_acao
                               INNER JOIN tcc.categoria AS ca ON ca.idCategoria=ob.fk_categoria
                               WHERE aob.fk_acao=4
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria) AS 'Água + clorexidina',

                              (SELECT count(aob.fk_acao) AS qtde
                               FROM tcc.observacao AS ob
                               INNER JOIN tcc.acao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                               INNER JOIN tcc.acao AS ac ON ac.idAcao=aob.fk_acao
                               INNER JOIN tcc.categoria AS ca ON ca.idCategoria=ob.fk_categoria
                               WHERE aob.fk_acao=5
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria) AS 'Outro produto',

                              (SELECT count(aob.fk_acao) AS qtde
                               FROM tcc.observacao AS ob
                               INNER JOIN tcc.acao_observacao AS aob ON aob.fk_observacao=ob.idObservacao
                               INNER JOIN tcc.acao AS ac ON ac.idAcao=aob.fk_acao
                               INNER JOIN tcc.categoria AS ca ON ca.idCategoria=ob.fk_categoria
                               WHERE aob.fk_acao=6
                                 AND ob.fk_setor=o.fk_setor
                                 AND ob.fk_local=o.fk_local
                                 AND ob.fk_categoria=o.fk_categoria) AS 'Não realizada'
                            FROM tcc.observacao AS o
                            INNER JOIN tcc.acao_observacao AS ao ON ao.fk_observacao=o.idObservacao
                            INNER JOIN tcc.acao AS a ON a.idAcao=ao.fk_acao
                            INNER JOIN tcc.indicacao_observacao AS oi ON oi.fk_observacao=o.idObservacao
                            INNER JOIN tcc.indicacao AS i ON i.idIndicacao=oi.fk_indicacao
                            INNER JOIN tcc.categoria AS c ON c.idCategoria=o.fk_categoria
                            INNER JOIN tcc.local AS l ON l.idLocal=o.fk_local
                            INNER JOIN tcc.setor AS s ON s.idSetor=o.fk_setor
                            GROUP BY 1,2,3,4,5,6,7,8,9,10");
      //$query->bindValue(":idUsuario",$idUsuario,PDO::PARAM_INT);
      $query->execute();

      return true;
    }

    public function getListaGeral(){
      $db = parent::getInstanceMysql();
      $query = $db->prepare("SELECT  DATE_FORMAT(o.dataCadastro,'%d/%m/%y %h:%i %p') as dataCadastro,
                                      s.setor,
                                      l.local,
                                      c.categoria,
                                      IFNULL(a.descricao,'Não realizada') as acao,
                                      IFNULL(i.descricao,'Não realizada') as indicacao,
                                      IFNULL(v.descricao,'Não realizada') as vestimenta,
                                      IFNULL(h.descricao,'Não realizada') as higienizacao
                            FROM tcc.observacao as o
                              LEFT JOIN tcc.acao_observacao as ao
                                ON ao.fk_observacao=o.idObservacao
                              LEFT JOIN tcc.acao as a
                                ON a.idAcao=ao.fk_acao
                              LEFT JOIN tcc.indicacao_observacao as oi
                                ON oi.fk_observacao=o.idObservacao
                              LEFT JOIN tcc.indicacao as i
                                ON i.idIndicacao=oi.fk_indicacao
                              LEFT JOIN tcc.categoria as c
                                ON c.idCategoria=o.fk_categoria
                              LEFT JOIN tcc.local as l
                                ON l.idLocal=o.fk_local
                              LEFT JOIN tcc.setor as s
                                ON s.idSetor=o.fk_setor
                              LEFT JOIN tcc.higienizacao_observacao as ho
                                ON ho.fk_observacao=o.idObservacao
                              LEFT JOIN tcc.higienizacao as h
                                ON h.idHigienizacao=ho.fk_higienizacao
                              LEFT JOIN tcc.vestimenta_observacao as vo
                                ON vo.fk_observacao=o.idObservacao
                              LEFT JOIN tcc.vestimenta as v
                                ON v.idVestimenta=vo.fk_vestimenta");
      //$query->bindValue(":idUsuario",$idUsuario,PDO::PARAM_INT);
      $query->execute();

      $this->relatorio = $query->fetchAll(PDO::FETCH_ASSOC);

      return $this->relatorio;
    }
  }