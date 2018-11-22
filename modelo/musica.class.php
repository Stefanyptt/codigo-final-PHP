<?php
class Musica{

  //cadastro das músicas
  private $idMusica;
  private $nomeMusica;
  private $dia;
  private $mes;
  private $ano;
  private $dataLancMus;
  private $cantorBanda;
  private $genero;
  private $album;

  public function __construct(){}
  public function __destruct(){}

  public function __get($a){return $this->$a;}
  public function __set($a,$v){$this->$a=$v;}

  public function __toString(){
    return nl2br("Música: $this->musica
                  Data de lançamento: $this->dataLancMus
                  Compositor: $this->cantorbanda
                  Gênero: $this->genero
                  Albúm: $this->album");
  }
}
