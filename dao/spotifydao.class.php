<?php
require_once 'config/conexaobanco.class.php';
class SpotifyDAO{
  private $conexao=null;

  public function __construct(){
    $this->conexao = ConexaoBanco::getInstance();
  }
  public function __destruct(){}

  public function cadastrarCliente($cli){
    try{
      $stat = $this->conexao->prepare("insert into cliente(idcliente,cpf,nomecliente,datanasc,tel,email,sexo,endereco,tipoplano,formapagamento)values(null,?,?,?,?,?,?,?,?,?)");

      $stat->bindValue(1,$cli->cpf);
      $stat->bindValue(2,$cli->nomeCliente);
      $stat->bindValue(3,$cli->dataNasc);
      $stat->bindValue(4,$cli->tel);
      $stat->bindValue(5,$cli->email);
      $stat->bindValue(6,$cli->sexo);
      $stat->bindValue(7,$cli->endereco);
      $stat->bindValue(8,$cli->tipoPlano);
      $stat->bindValue(9,$cli->formaPagamento);

      $stat->execute();

    }catch(PDOException $e){
      echo "Erro ao cadastrar!".$e;
    }
  }

  public function cadastrarMusica($mus){
    try{
      $stat = $this->conexao->prepare('insert into musica(idmusica,nomemusica,datalancmus,cantorbanda,genero,album)values(null,?,?,?,?,?)');

      $stat->bindValue(1,$mus->nomeMusica);
      $stat->bindValue(2,$mus->dataLancMus);
      $stat->bindValue(3,$mus->cantorBanda);
      $stat->bindValue(4,$mus->genero);
      $stat->bindValue(5,$mus->album);

      $stat->execute();

    }catch(PDOException $e){return "Erro ao cadastrar!".$e;}
  }

  public function buscarClientes(){
      try{
        $stat = $this->conexao->query("select * from cliente");
        $array = $stat->fetchAll(PDO::FETCH_CLASS, "Cliente");
        return $array;
      }catch(PDOException $e){
        echo "Erro ao buscar clientes!".$e;
      }
  }

  public function buscarMusicas(){
      try{
        $stat = $this->conexao->query("select * from musica");
        $array = $stat->fetchAll(PDO::FETCH_CLASS, "Musica");
        return $array;
      }catch(PDOException $e){
        echo "Erro ao buscar músicas!".$e;
      }
  }

  public function filtrarCliente($filtro, $pesquisa){
    try{
      $query = "";
      switch($filtro){
        case "codigo": $query = "where idcliente=".$pesquisa;
        break;
        case "cpf": $query="where cpf like '%".$pesquisa."%'";
        break;
        case "nomecliente": $query="where nomecliente like '%".$pesquisa."%'";
        break;
        case "tel": $query="where tel like '%".$pesquisa."%'";
        break;
        case "email": $query="where email like '%".$pesquisa."%'";
        break;
        case "sexo": $query="where sexo like '%".$pesquisa."%'";
        break;
        case "endereco": $query="where endereco like '%".$pesquisa."%'";
        break;
        case "tipoplano": $query="where tipoplano like '%".$pesquisa."%'";
        break;
        case "formapagamento": $query="where formapagamento like '%".$pesquisa."%'";
        break;
      }//fecha switch

      if(empty($pesquisa)){
        $query = "";
      }

      $stat = $this->conexao->query("select * from cliente ".$query);
      $array = $stat->fetchAll(PDO::FETCH_CLASS, "Cliente");
      return $array;
    }catch(PDOException $e){
      echo "Erro ao filtrar clientes!".$e;
    }
  }

  public function filtrarMusica($filtro, $pesquisa){
    try{
      $query = "";
      switch($filtro){
        case "codigo": $query = "where idmusica=".$pesquisa;
        break;
        case "nomemusica": $query="where nomemusica like '%".$pesquisa."%'";
        break;
        case "nomecantorbanda": $query="where cantorbanda like '%".$pesquisa."%'";
        break;
        case "genero": $query="where genero like '%".$pesquisa."%'";
        break;
        case "album": $query="where album like '%".$pesquisa."%'";
        break;
      }//fecha switch

      if(empty($pesquisa)){
        $query = "";
      }

      $stat = $this->conexao->query("select * from musica ".$query);
      $array = $stat->fetchAll(PDO::FETCH_CLASS, "Musica");
      return $array;
    }catch(PDOException $e){
      echo "Erro ao filtrar musicas!".$e;
    }
  }


  public function alterarCliente($cli){
    try{
      $stat = $this->conexao->prepare("update cliente set idcliente=?, cpf=?, nomecliente=?, datanasc=?, tel=? email=? sexo=? endereco=? tipoplano=? formapagamento=? where idcliente=?");
      $stat->bindValue(1,$cli->idcliente);
      $stat->bindValue(2,$cli->cpf);
      $stat->bindValue(3,$cli->nomecliente);
      $stat->bindValue(4,$cli->datanasc);
      $stat->bindValue(5,$cli->tel);
      $stat->bindValue(6,$cli->email);
      $stat->bindValue(7,$cli->sexo);
      $stat->bindValue(8,$cli->endereco);
      $stat->bindValue(9,$cli->tipoplano);
      $stat->bindValue(10,$cli->formapagamento);

      $stat->execute();
    }catch(PDOException $e){
      echo "Erro ao alterar cliente! ".$e;
    }
  }

  public function alterarMusica($mus){
    try{
      $stat = $this->conexao->prepare("update musica set idmusica=?, nomemusica=?, datalancmus=?, cantorbanda=?, genero=? album=? where idcliente=?");
      $stat->bindValue(1,$mus->idmusica);
      $stat->bindValue(2,$mus->nomemusica);
      $stat->bindValue(3,$mus->datalancmus);
      $stat->bindValue(4,$mus->cantorbanda);
      $stat->bindValue(5,$mus->genero);
      $stat->bindValue(6,$mus->album);
      $stat->execute();
    }catch(PDOException $e){
      echo "Erro ao alterar musica! ".$e;
    }
  }

  public function deletarCliente($id){
    try{
      $stat = $this->conexao->prepare("delete from cliente where idCliente=?");
      $stat->bindValue(1, $id);
      $stat->execute();
    }catch(PDOException $e){
      echo "Erro ao deletar cliente!".$e;
    }
  }

  public function deletarMusica($id){
    try{
      $stat = $this->conexao->prepare("delete from musica where idMusica=?");
      $stat->bindValue(1, $id);
      $stat->execute();
    }catch(PDOException $e){
      echo "Erro ao deletar musica!".$e;
    }
  }
}
