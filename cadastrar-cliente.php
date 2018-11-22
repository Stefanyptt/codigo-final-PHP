<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro</title>
  <meta charset="utf-8">
  <link rel="icon" href="favicon/spotifyfavicon.jpg" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Cadastro</h1>

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

        <?php
        if(isset($_SESSION['erros'])){
         $erros = unserialize($_SESSION['erros']);
         foreach($erros as $e){
           echo "<br>".$e;
         }
         unset($_SESSION['erros']);
        }
        ?>

        <?php
        if(isset($_SESSION['post'])){
          $dados = unserialize($_SESSION['post']);
          unset($_SESSION['post']);
        }
       ?>


        <form name="cadcliente" method="post" action="">
          <div class="form-group">
            <input type="text" name="login" placeholder="Login" class="form-control">
          </div>
          <div class="form-group">
            <input type="password" name="senha" placeholder="Senha" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="txtnome" placeholder="Nome" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="txttel" placeholder="Telefone" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="txtcpf" placeholder="CPF" class="form-control">
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
              <input type="number" name="numdia" placeholder="Dia" class="form-control">
            </div>
            <div class="col-md-2">
              <input type="number" name="nummes" placeholder="Mês" class="form-control">
            </div>
            <div class="col-md-2">
              <input type="number" name="numano" placeholder="Ano" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <input type="email" name="email" placeholder="Email" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="txtendereco" placeholder="Endereço" class="form-control">
          </div>
          <div class="form-group">
            <select name="selplano" class="form-control">
              <option value="Premium">Premium</option>
              <option value="Premium Family">Premium Family</option>
              <option value="Premium Estudante">Premium estudante</option>
            </select>
          </div>
          <div class="form-group">
            <select name="selpagamento" class="form-control">
              <option value="Boleto Bancário">Boleto bancário</option>
              <option value="Cartão Crédito">Cartão crédito</option>
              <option value="Cartão Débito">Cartão débito</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
          </div>
        </form>
        <?php
        if(isset($_SESSION['msg'])){
          echo $_SESSION['msg'];
          unset($_SESSION['msg']);
        }
        ?>

        <?php
        include_once "util/validacao.class.php";
        if(isset($_POST['cadastrar'])){
          $erros = array();
          if(!Validacao::validarNome($_POST['txtnome'])){
            $erros[] = "Nome inválido!<br>";
          }else if(!Validacao::validarEndereco($_POST['txtendereco'])){
            $erros[] = "Endereço inválido!<br>";
          }else if(!Validacao::validarTel($_POST['txttel'])){
            $erros[] = "Telefone inválido!<br>";
          }else if(!Validacao::validarCPF($_POST['txtcpf'])){
            $erros[] = "CPF inválido!<br>";
          }else if(!Validacao::validarSexo($_POST['rdsexo'])){
            $erros[] = "Sexo inválido!<br>";
          }else if(!Validacao::validarPlano($_POST['selplano'])){
            $erros[] = "Plano inválido!<br>";
          }else if(!Validacao::validarPagamento($_POST['selpagamento'])){
            $erros[] = "Tipo pagamento inválido!<br>";
          }
          if(count($erros)==0){

            include_once "modelo/cliente.class.php";
            include_once "dao/spotifydao.class.php";
            include_once "util/padronizacao.class.php";
            include_once "modelo/usuario.class.php";
            include_once "dao/usuariodao.class.php";
            include_once "util/seguranca.class.php";

            $cli = new Cliente();
            $user = new Usuario();
            $cli->nomeCliente = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['txtnome']));
            $cli->endereco = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['txtendereco']));
            $cli->tel = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['txttel']));
            $cli->cpf = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['txtcpf']));
            $cli->sexo = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['rdsexo']));
            $cli->dia = $_POST['numdia'];
            $cli->mes = $_POST['nummes'];
            $cli->ano = $_POST['numano'];
            $cli->dataNasc = Validacao::validarSeguranca(Padronizacao::ajeitarData($cli->ano,$cli->mes,$cli->dia));
            $cli->email = $_POST['email'];
            $cli->tipoPlano = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['selplano']));
            $cli->formaPagamento = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['selpagamento']));
            $user->login = Validacao::validarSeguranca($_POST['login']);
            $user->senha = Validacao::validarSeguranca(Seguranca::criptografar($_POST['senha']));
            $user->tipo = "cliente";

            $cliDAO = new SpotifyDAO();
            $cliDAO->cadastrarCliente($cli);

            $userDAO = new UsuarioDAO();
            $userDAO->cadastrarUsuario($user);

            $_SESSION['msg'] = "Cliente cadastrado com sucesso!";
            $cli->__destruct();
            header("location:cadastrar-cliente.php");
          }else{
            $_SESSION['erros'] = serialize($erros);
            $_SESSION['post'] = serialize($_POST);
            header("location:cadastrar-cliente.php");
          }
        }
        ?>
      </div>
  </body>
</html>
