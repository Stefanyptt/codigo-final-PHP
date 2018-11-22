<?php
session_start();
ob_start();

include_once "dao/spotifydao.class.php";
include_once "modelo/cliente.class.php";

$cliDAO = new SpotifyDAO();
$array = $cliDAO->buscarClientes();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Consulta de Cliente</title>
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
        <h1 class="jumbotron bg-info">Consulta de Cliente</h1>

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

        <form name="pesquisa" method="post" action="">
          <div class="row">
            <div class="form-group col-md-6">
              <input type="text" name="txtfiltro"
              class="form-control" placeholder="Digite sua pesquisa">
            </div>

            <div class="form-group col-md-6">
              <select name="selfiltro" class="form-control">
                <option value="todos">Todos</option>
                <option value="codigo">Código</option>
                <option value="cpf">CPF</option>
                <option value="nomecliente">Nome</option>
                <option value="tel">Telefone</option>
                <option value="email">Email</option>
                <option value="sexo">Sexo</option>
                <option value="endereco">Endereço</option>
                <option value="tipoplano">Tipo de plano</option>
                <option value="formapagamento">Forma de Pagamento</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <input type="submit" name="filtrar" value="Filtrar"
                   class="btn btn-primary btn-block">
          </div>
        </form>
        <?php
        if(isset($_POST['filtrar'])){
          $pesquisa = $_POST['txtfiltro'];
          $filtro = $_POST['selfiltro'];
          $cliDAO = new SpotifyDAO();
          $array = $cliDAO->filtrarCliente($filtro, $pesquisa);
          if(count($array) == 0){
            echo "<h2>Sua pesquisa não retornou nenhum livro!</h2>";
            return;
          }
        }
        ?>

        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover table-condensed">
            <thead>
              <tr>
                <th>Alterar</th>
                <th>Excluir</th>
                <th>Código</th>
                <th>CPF</th>
                <th>Nome</th>
                <th>Data Nascimento</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Sexo</th>
                <th>Endereço</th>
                <th>Plano</th>
                <th>Forma de Pagamento</th>
              </tr>
            </thead>

            <tfoot>
              <tr>
                <th>Alterar</th>
                <th>Excluir</th>
                <th>Código</th>
                <th>CPF</th>
                <th>Nome</th>
                <th>Data Nascimento</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Sexo</th>
                <th>Endereço</th>
                <th>Plano</th>
                <th>Forma de Pagamento</th>
              </tr>
            </tfoot>

            <tbody>
              <?php
                  foreach($array as $cli){
                    echo "<tr>";
                    echo "<td><a href='alterar-cliente.php?id=$cli->idCliente 'class='btn btn-warning'>Alterar</a></td>";
                    echo "<td><a href='consulta-cliente.php?id=$cli->idCliente 'class='btn btn-danger'>Excluir</a></td>";
                    echo "<td>$cli->idCliente</td>";
                    echo "<td>$cli->cpf</td>";
                    echo "<td>$cli->nomeCliente</td>";
                    echo "<td>$cli->dataNasc</td>";
                    echo "<td>$cli->tel</td>";
                    echo "<td>$cli->email</td>";
                    echo "<td>$cli->sexo</td>";
                    echo "<td>$cli->endereco</td>";
                    echo "<td>$cli->tipoPlano</td>";
                    echo "<td>$cli->formaPagamento</td>";
                    echo "</tr>";
                  }
                ?>
            </tbody>
          </table>
        </div>
        </div>
        <?php
        if(isset($_GET['id'])){
        $cliDAO = new SpotifyDAO();
        $cliDAO->deletarCliente($_GET['id']);
        header("location:consulta-cliente.php");
        }
        ?>


      </div>
  </body>
</html>
