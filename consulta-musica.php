<?php
session_start();
ob_start();

include_once "dao/spotifydao.class.php";
include_once "modelo/musica.class.php";

$musDAO = new SpotifyDAO();
$array = $musDAO->buscarMusicas();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Consulta de Músicas</title>
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
        <h1 class="jumbotron bg-info">Consulta de Música</h1>

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
                <option value="nomemusica">Nome da Música</option>
                <option value="nomecantorbanda">Nome do Cantor</option>
                <option value="genero">Gênero</option>
                <option value="album">Album</option>
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
                <th>Nome Música</th>
                <th>Data Lançamento</th>
                <th>Cantor/Banda</th>
                <th>Gênero</th>
                <th>Album</th>
              </tr>
            </thead>

            <tfoot>
              <tr>
                <th>Alterar</th>
                <th>Excluir</th>
                <th>Código</th>
                <th>Nome Música</th>
                <th>Data Lançamento</th>
                <th>Cantor/Banda</th>
                <th>Gênero</th>
                <th>Album</th>
              </tr>
            </tfoot>

            <tbody>
              <?php
                  foreach($array as $mus){
                    echo "<tr>";
                    echo "<td><a href='alterar-musica.php?id=$mus->idMusica 'class='btn btn-warning'>Alterar</a></td>";
                    echo "<td><a href='consulta-musica.php?id=$mus->idMusica 'class='btn btn-danger'>Excluir</a></td>";
                    echo "<td>$mus->idMusica</td>";
                    echo "<td>$mus->nomeMusica</td>";
                    echo "<td>$mus->dataLancMus</td>";
                    echo "<td>$mus->cantorBanda</td>";
                    echo "<td>$mus->genero</td>";
                    echo "<td>$mus->album</td>";
                    echo "</tr>";
                  }
                ?>
            </tbody>
          </table>
        </div>
        </div>

      <?php
      if(isset($_GET['id'])){
        $musDAO = new SpotifyDAO();
        $musDAO->deletarMusica($_GET['id']);
        header("location:consulta-cliente.php");
      }
      ?>


      </div>
  </body>
</html>
