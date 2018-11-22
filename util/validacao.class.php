<?php
class Validacao{

  public static function validarNome($v){
    $exp = "/^[A-Za-záÁéÉíÍóÓúÚãÃçÇâÂüÜöÖñÑ ]{2,60}$/";
    return preg_match($exp,$v);
  }

  public static function validarTel($v){
    $exp = "/^[0-9-() ]{5,20}$/";
    return preg_match($exp,$v);
  }

  public static function validarEndereco($v){
    $exp = "/^[A-Za-záÁéÉíÍóÓúÚãÃçÇâÂüÜöÖñÑ 0-9]{5,100}$/";
    return preg_match($exp,$v);
  }

  public static function validarCPF($v){
    $exp = "/^[0-9-.]{5,15}$/";
    return preg_match($exp,$v);
  }

  public static function validarSexo($v){
    $exp = "/^(Masculino|Feminino)$/";
    return preg_match($exp,$v);
  }

  public static function validarPlano($v){
    $exp = "/^(Premium|Premium Family|Premium Estudante)$/";
    return preg_match($exp,$v);
  }

  public static function validarPagamento($v){
    $exp = "/^(Boleto Bancário|Cartão Crédito|Cartão Débito)$/";
    return preg_match($exp,$v);
  }

  public static function validarNomeMC($v){
    $exp = "/^[A-Za-záÁéÉíÍóÓúÚãÃçÇâÂüÜöÖñÑ ]{2,50}$/";
    return preg_match($exp,$v);
  }

  public static function validarGenero($v){
    $exp = "/^(Sertanejo|Samba|Rock|Música Eletrônica|Pop)$/";
    return preg_match($exp,$v);
  }

  public static function validarAlbum($v){
    $exp = "/^[A-Za-záÁéÉíÍóÓúÚãÃçÇâÂüÜöÖñÑ ]{2,75}$/";
    return preg_match($exp,$v);
  }

  public static function validarSeguranca($v){
    return htmlspecialchars(htmlentities(addslashes(trim($v))));
  }
}
