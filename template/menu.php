<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="../view/home.php"><?=SISTEMA?></a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href='../controller/observacao.php'>Observações</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Cadastros <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="../controller/setor.php">Setor</a></li>
            <li><a href="../controller/categoria.php">Categoria</a></li>
            <li class="divider"></li>
            <li><a href="../controller/usuario.php">Usuário</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Relatórios <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="../controller/relatorioCatVestimenta.php">Categoria x EPis</a></li>
            <li><a href="../controller/relatorioAcaoHigienizacao.php">Ação x Higienização</a></li>
            <li><a href="../controller/relatorioIndicaAcao.php">Indicação x Ação</a></li>
            <li><a href="../controller/relatorioIndicaHigienizacao.php">Indicação x Higienização</a></li>
            <li class="divider"></li>
            <li><a href="../controller/relatorioAnalitico.php">Geral Analítico</a></li>
            <li><a href="../controller/relatorioSintetico.php">Geral Sintético</a></li>
            <li class="divider"></li>
            <li><a href="../controller/relatorioAnaliX.php">Geral Analítico em X</a></li>
          </ul>
        </li>
      </ul>
      <?php if (isset($_SESSION['user'])):?>
      <ul class="nav  navbar-nav navbar-right">
        <li><a href='../logout.php'>Logout</a></li>
      </ul>
    <?php endif; ?>
    </div>
  </div>
</nav>