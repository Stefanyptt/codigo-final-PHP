<?php
session_start();
ob_start(); //buffer do PHP

if(isset($_GET['id'])){
    include_once "dao/spotifydao.class.php";
    include_once "modelo/cliente.class.php";

    $cliDAO = new SpotifyDAO();
    $array = $cliDAO->filtrarCliente("codigo", $_GET['id']);

    $cli = $array[0];

}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alteração de Clientes</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Alteração de Clientes</h1>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Spotify</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="cadastrar-cliente.php">Inscreva-se <span class="sr-only"></span></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="cadastrar-musica.php">Cadastrar Músicas <span class="sr-only">(current)</span></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="cadastrar-cliente.php">Cadastrar Clientes <span class="sr-only">(current)</span></a>
              </li>

              <?php
              if(isset($_SESSION['privateUser'])){
                include_once "modelo/usuario.class.php";
                $u = unserialize($_SESSION['privateUser']);
                if($u->tipo == "adm"){
              ?>
                <li class="nav-item">
                  <a class="nav-link" href="consulta-cliente.php">Consulta de Clientes <span class="sr-only">(current)</span></a>
                </li>
              <?php
                }
              }
              ?>

              <?php
              if(isset($_SESSION['privateUser'])){
                include_once "modelo/usuario.class.php";
                $u = unserialize($_SESSION['privateUser']);
                if($u->tipo == "adm"){
              ?>
                <li class="nav-item">
                  <a class="nav-link" href="consulta-musica.php">Consulta de Músicas <span class="sr-only">(current)</span></a>
                </li>
              <?php
                }
              }
              ?>

            </ul>
          </div>
        </nav>

      <form name="cadcliente" method="post" action="">
        <div class="form-group">
          <input type="text" name="txtnome" placeholder="Nome" class="form-control" value="<?php if(isset($cli)){ echo $cli->nomeCliente; } ?>">
        </div>
        <div class="form-group">
          <input type="text" name="txttel" placeholder="Telefone" class="form-control" value="<?php if(isset($cli)){ echo $cli->tel; } ?>">
        </div>
        <div class="form-group">
          <input type="text" name="txtcpf" placeholder="CPF" class="form-control" value="<?php if(isset($cli)){ echo $cli->cpf; } ?>">
        </div>
        <div class="form-group">
          <label><input type="radio" value="Masculino" name="rdsexo"> Masculino</label>
          <label><input type="radio" value="Feminino" name="rdsexo"> Feminino</label>
        </div>
        <div class="row form-group">
          <div class="col-md-1.8">
            <label>Data Nasc:</label>
          </div>
          <div class="col-md-2">
            <input type="number" name="numdia" placeholder="Dia" class="form-control" value="<?php if(isset($cli)){ echo $cli->dia; } ?>">
          </div>
          <div class="col-md-2">
            <input type="number" name="nummes" placeholder="Mês" class="form-control" value="<?php if(isset($cli)){ echo $cli->mes; } ?>">
          </div>
          <div class="col-md-2">
            <input type="number" name="numano" placeholder="Ano" class="form-control" value="<?php if(isset($cli)){ echo $cli->ano; } ?>">
          </div>
        </div>
        <div class="form-group">
          <input type="email" name="email" placeholder="Email" class="form-control" value="<?php if(isset($cli)){ echo $cli->email; } ?>">
        </div>
        <div class="form-group">
          <input type="text" name="txtendereco" placeholder="Endereço" class="form-control" value="<?php if(isset($cli)){ echo $cli->endereco; } ?>">
        </div>
        <div class="form-group">
          <select name="selplano" class="form-control">
            <option value="Premium"
                    <?php if(isset($cli)){
                            if($cli->tipoPlano == "Premium"){ echo 'selected=selected'; }
                          } ?>>Premium</option>
            <option value="Premium Family"
                    <?php if(isset($cli)){
                            if($cli->tipoPlano == "Premium Family"){ echo 'selected=selected'; }
                          } ?>>Premium Family</option>
            <option value="Premium Estudante"
                    <?php if(isset($cli)){
                            if($cli->tipoPlano == "Premium Estudante"){ echo 'selected=selected'; }
                          } ?>>Premium Estudante<</option>
          </select>
        </div>
        <div class="form-group">
          <select name="selpagamento" class="form-control">
            <option value="Boleto Bancário"
                    <?php if(isset($cli)){
                            if($cli->formaPagamento == "Boleto Bancário"){ echo 'selected=selected'; }
                          } ?>>Boleto Bancário</option>
            <option value="Cartão Crédito"
                    <?php if(isset($cli)){
                            if($cli->formaPagamento == "Cartão Crédito"){ echo 'selected=selected'; }
                          } ?>>Cartão Crédito</option>
            <option value="Cartão Débito"
                    <?php if(isset($cli)){
                            if($cli->formaPagamento == "Cartão Débito"){ echo 'selected=selected'; }
                          } ?>>Cartão Débito</option>
          </select>
        </div>
        <div class="form-group">
          <input type="submit" name="alterar" value="Alterar" class="btn btn-primary">
          <input type="reset" name="limpar" value="Limpar" class="btn btn-danger">
        </div>
      </form>

      <?php
      if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
      }
      ?>

      <?php
      if(isset($_POST['alterar'])){
        include_once "modelo/cliente.class.php";
        include_once "dao/spotifydao.class.php";
        include_once "util/padronizacao.class.php";
        include_once "util/validacao.class.php";


        $mus = new Cliente();
        $mus->idCliente = $_GET['id'];
        $mus->cpf = Validacao::validarSeguranca($_POST['txtcpf']);
        $mus->nomeCliente = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['txtnome']));
        $mus->tel = Validacao::validarSeguranca($_POST['txttel']);
        $mus->dia = Validacao::validarSeguranca($_POST['numdia']);
        $mus->mes = Validacao::validarSeguranca($_POST['nummes']);
        $mus->ano = Validacao::validarSeguranca($_POST['numano']);
        $mus->dataNasc = Validacao::validarSeguranca(Padronizacao::ajeitarData($mus->ano,$mus->mes,$mus->dia));

        $musDAO = new SpotifyDAO();
        $musDAO->alterarCliente($mus);

        $_SESSION['msg'] = "Cliente alterada com sucesso!";
        $mus->__destruct();

        //depois de testado
        // echo "Livro cadastrado com sucesso!";
        // echo $liv;
        header("location:consulta-musica.php");
      }
      ?>
    </div>
</body>
</html>
