<?php
require_once 'config/conexaobanco.class.php';
 class UsuarioDAO {

   private $conexao = null;

   public function __construct(){
     $this->conexao = ConexaoBanco::getInstance();
   }

   public function __destruct(){}


   public function verificarUsuario($u){
     try{
       $stat = $this->conexao->prepare(
         "select * from usuario where login = ?
         and senha = ? and tipo = ?");

       $stat->bindValue(1, $u->login);
       $stat->bindValue(2, $u->senha);
       $stat->bindValue(3, $u->tipo);

       $stat->execute();

       $usuario = null;
       $usuario = $stat->fetchObject('Usuario');
       return $usuario;
     }catch(PDOException $e){
       echo "Erro ao buscar usuarios! ".$e;
     }
   }

   public function cadastrarUsuario($user){
     try{
       $stat = $this->conexao->prepare("insert into usuario(idusuario,login,senha,tipo)values(null,?,?,?)");

       $stat->bindValue(1,$user->login);
       $stat->bindValue(2,$user->senha);
       $stat->bindValue(3,$user->tipo);

       $stat->execute();

     }catch(PDOException $e){
       echo "Erro ao cadastrar!".$e;
     }
   }
 }
