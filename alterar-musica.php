<?php
session_start();
ob_start(); //buffer do PHP

if(isset($_GET['id'])){
    include_once "dao/spotifydao.class.php";
    include_once "modelo/musica.class.php";

    $musDAO = new SpotifyDAO();
    $array = $musDAO->filtrarMusica("codigo", $_GET['id']);

    $mus = $array[0];

}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alteração de Musicas</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Alteração de Musicas</h1>

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

        <form name="cadmusica" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtnome" placeholder="Nome da música" class="form-control" value="<?php if(isset($mus)){ echo $mus->nomeMusica; } ?>">
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
            <input type="text" name="txtcantorbanda" placeholder="Nome do cantor/banda" class="form-control" value="<?php if(isset($mus)){ echo $mus->cantorBanda; } ?>">
          </div>
          <div class="row">
            <div class="form-group col-md-1">
              <p>Gênero Musical</p>
            </div>
            <div class="form-group col-md-11">
              <select class="form-control" name="selgenero">
                <option value="Sertanejo"
                    <?php if(isset($mus)){
                          if($mus->genero == "Sertanejo"){ echo 'selected=selected'; }
                        } ?>>Sertanejo</option>
                <option value="Samba">
                      <?php if(isset($mus)){
                            if($mus->genero == "Samba"){ echo 'selected=selected'; }
                          } ?>>Samba</option>
                <option value="Rock">
                      <?php if(isset($mus)){
                          if($mus->genero == "Rock"){ echo 'selected=selected'; }
                        } ?>>Rock</option>
                <option value="Música Eletrônica">
                      <?php if(isset($mus)){
                          if($mus->genero == "Música Eletrônica"){ echo 'selected=selected'; }
                        } ?>>Música Eletrônica</option>
                <option value="Pop">
                      <?php if(isset($mus)){
                          if($mus->genero == "Pop"){ echo 'selected=selected'; }
                        } ?>>Pop</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <input type="text" name="txtalbum" placeholder="Digite o nome do album em que se encontra a música" class="form-control" value="<?php if(isset($mus)){ echo $mus->album; } ?>">
          </div>
          <div class="form-group">
            <input type="submit" name="alterar" value="Alterar" class="btn btn-primary">
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
        if(isset($_POST['alterar'])){
          include_once "modelo/musica.class.php";
          include_once "dao/spotifydao.class.php";
          include_once "util/padronizacao.class.php";
          include_once "util/validacao.class.php";

          $mus = new Musica();
          $mus->idLivro = $_GET['id'];
          $mus->nomeMusica = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['txtnome']));
          $mus->dia = Validacao::validarSeguranca($_POST['numdia']);
          $mus->mes = Validacao::validarSeguranca($_POST['nummes']);
          $mus->ano = Validacao::validarSeguranca($_POST['numano']);
          $mus->dataLancMus = Validacao::validarSeguranca(Padronizacao::ajeitarData($mus->ano,$mus->mes,$mus->dia));
          $mus->cantorBanda = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['txtcantorbanda']));
          $mus->genero = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['selgenero']));
          $mus->album = Validacao::validarSeguranca(Padronizacao::ajeitarText($_POST['txtalbum']));

          $musDAO = new SpotifyDAO();
          $musDAO->alterarMusica($mus);

          $_SESSION['msg'] = "Musica alterada com sucesso!";
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
