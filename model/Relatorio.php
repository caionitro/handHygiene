<?php
  class Relatorio extends Connect
  {
    private $relatorio;

    public function getListaIndicaAcao(){
      $db = parent::getInstanceMysql();
      $query = $db->prepare('SELECT   l.local,
                                      s.setor,
                                      c.categoria,
                                      count(ao.fk_acao) as qtdeAcao,
                                      a.descricao,
                                      oi.fk_indicacao,
                                      i.descricao
                              FROM tcc.observacao as o 
                                  INNER JOIN tcc.acao_observacao as ao
                                      ON ao.fk_observacao=o.idObservacao
                                  INNER JOIN tcc.acao as a 
                                      ON a.idAcao=ao.fk_acao
                                  INNER JOIN tcc.indicacao_observacao as oi 
                                      ON oi.fk_observacao=o.idObservacao
                                  INNER JOIN tcc.indicacao as i 
                                      ON i.idIndicacao=oi.fk_indicacao
                                  INNER JOIN tcc.categoria as c
                                      ON c.idCategoria=o.fk_categoria
                                  INNER JOIN tcc.local as l
                                      ON l.idLocal=o.fk_local
                                  INNER JOIN tcc.setor as s
                                      ON s.idSetor=o.fk_setor
                              GROUP BY l.local,s.setor,c.categoria,ao.fk_acao;');
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
                                ON v.idVestimenta=vo.fk_vestimenta;");
      //$query->bindValue(":idUsuario",$idUsuario,PDO::PARAM_INT);
      $query->execute();

      $this->relatorio = $query->fetchAll(PDO::FETCH_ASSOC);

      return $this->relatorio;
    }
  }