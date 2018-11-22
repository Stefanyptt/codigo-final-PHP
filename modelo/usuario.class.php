<?php
class Usuario {

  private $idUsuario;
  private $login;
  private $senha;
  private $tipo;

  public function __construct(){}
  public function __destruct(){}

  public function __get($a){return $this->$a;}
  public function __set($a, $v){$this->$a = $v;}

  public function __toString(){
    return nl2br("login: $this->login senha: $this->senha tipo: $this->tipo");
  }//fecha toString

  /*
  senha: Aula123456PHP
  insert into usuario(idusuario,login,senha,tipo)
  values(1,"thiago","1f591a4c440e29f36bc86358a832dcd1", "adm")
  */
}//fecha classe
