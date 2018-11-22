<?php
class Cliente{
  //cadastro do cliente
  private $idCliente;
  private $cpf;
  private $nomeCliente;
  //data nascimento (entrada bd)
  private $dia;
  private $mes;
  private $ano;
  private $dataNasc;
  private $tel;
  private $email;
  private $sexo;
  private $endereco;
  private $tipoPlano;
  private $formaPagamento;

  public function __construct(){}
  public function __destruct(){}

  public function __get($a){return $this->$a;}
  public function __set($a,$v){$this->$a=$v;}
  public function __toString(){
    return nl2br("Nome: $this->nomeCliente
                  Data nascimento: $this->dataNasc
                  Telefone: $this->tel
                  Cpf: $this->cpf
                  Email: $this->email
                  Endereço: $this->endereco
                  Plano: $this->tipoPlano
                  Forma de Pagamento: $this->formaPagamento");
  }
}
