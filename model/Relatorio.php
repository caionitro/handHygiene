<?php
  class Relatorio extends Connect
  {
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
  }