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

        <h1>Spotify - sistema para gerenciamento de músicas.</h1>

        <?php
        if(isset($_SESSION['msg'])){
          echo "<h2>".$_SESSION['msg']."</h2>";
          unset($_SESSION['msg']);
        }
        ?>

        <?php
        if(isset($_SESSION['privateUser'])){
          include_once "modelo/usuario.class.php";
          $u = unserialize($_SESSION['privateUser']);
          echo "<h2>Olá {$u->login}, seja bem vindo!</h2>";
        ?>

        <form name="deslogar" method="post" action="">
          <div class="form-group">
            <input type="submit" name="deslogar" value="Sair" class="btn btn-primary">
          </div>
        </form>

        <?php
        if(isset($_POST['deslogar'])){
          unset($_SESSION['privateUser']);
          header("location:index.php");
        }
        ?>

        <?php

        }else{
        ?>
        <form name="login" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtlogin" placeholder="Login" class="form-control">
          </div>
          <div class="form-group">
            <input type="password" name="txtsenha" placeholder="Digite sua senha" class="form-control">
          </div>
          <div class="form-group">
            <select name="seltipo" class="form-control">
              <option value="adm">Adm</option>
              <option value="cliente">Cliente</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="entrar" value="Entrar" class="btn btn-primary">
          </div>
        </form>
        <?php
        }
        ?>

        <?php
        if(isset($_POST['entrar'])){
          include 'modelo/usuario.class.php';
          include 'dao/usuariodao.class.php';
          include 'util/seguranca.class.php';

          $u = new Usuario();
          $u->login = $_POST['txtlogin'];
          $u->senha = Seguranca::criptografar($_POST['txtsenha']);
          $u->tipo = $_POST['seltipo'];

          //echo $u;

          $uDAO = new UsuarioDAO();
          $usuario = $uDAO->verificarUsuario($u);

          if($usuario == null){
            echo "<h2>Usuário/senha/tipo inválido(s)!</h2>";
          }else{
            //echo "<h2>logado</h2>";
            $_SESSION['privateUser'] = serialize($usuario);
            header("location:index.php");
          }
        }
        ?>
      </div>
  </body>
</html>
