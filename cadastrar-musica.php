<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Cadastro de Música</title>
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
      <h1 class="jumbotron bg-info">Cadastro música</h1>

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

      <form name="cadmusica" method="post" action="">
        <div class="form-group">
          <input type="text" name="txtnome" placeholder="Nome da música" class="form-control">
        </div>
        <div class="row form-group">
          <div class="col-md-1.8">
            <label>Data de Lançamento:</label>
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
          <input type="text" name="txtcantorbanda" placeholder="Nome do cantor/banda" class="form-control">
        </div>
        <div class="row">
          <div class="form-group col-md-1">
            <p>Gênero Musical</p>
          </div>
          <div class="form-group col-md-11">
            <select class="form-control" name="selgenero">
              <option value="Sertanejo">Sertanejo</option>
              <option value="Samba">Samba</option>
              <option value="Rock">Rock</option>
              <option value="Música Eletrônica">Música Eletrônica</option>
              <option value="Pop">Pop</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <input type="text" name="txtalbum" placeholder="Digite o nome do album em que se encontra a música" class="form-control">
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
      if(isset($_POST['cadastrar'])){
        include_once 'util/validacao.class.php';
        $erros = array();
        if(!Validacao::validarNomeMC($_POST['txtnome'])){
          $erros[] = "Nome da música inválida!<br>";
        }else if(!Validacao::validarNomeMC($_POST['txtcantorbanda'])){
          $erros[] = "Nome do cantor/banda inválido!<br>";
        }else if(!Validacao::validarGenero($_POST['selgenero'])){
          $erros[] = "Gênero inválido!<br>";
        }else if(!Validacao::validarAlbum($_POST['txtalbum'])){
          $erros[] = "Album inválido!<br>";
        }

        if(count($erros)==0){
          if(isset($_POST['cadastrar'])){
            include_once "modelo/musica.class.php";
            include_once "dao/spotifydao.class.php";
            include_once "util/padronizacao.class.php";


            $mus = new Musica();
            $mus->nomeMusica = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['txtnome']));
            $mus->dia = Validacao::validarSeguranca($_POST['numdia']);
            $mus->mes = Validacao::validarSeguranca($_POST['nummes']);
            $mus->ano = Validacao::validarSeguranca($_POST['numano']);
            $mus->dataLancMus = Validacao::validarSeguranca(Padronizacao::ajeitarData($mus->ano,$mus->mes,$mus->dia));
            $mus->cantorBanda = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['txtcantorbanda']));
            $mus->genero = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['selgenero']));
            $mus->album = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['txtalbum']));

            $musDAO = new SpotifyDAO();
            $musDAO->cadastrarMusica($mus);

            $_SESSION['msg'] = "Música cadastrada com sucesso!";
            $mus->__destruct();

            //teste
            echo "Música cadastrada com sucesso!";
            echo $mus;
            header("location:cadastrar-musica.php");
          }
        }else{
          $_SESSION['erros'] = serialize($erros);
          $_SESSION['post'] = serialize($_POST);
          header("location:cadastrar-musica.php");
        }
      }
      ?>
    </div>
  </body>
</html>
