<?php
class Padronizacao{
  public function ajeitarData($a,$m,$d){
    $array = array($a,$m,$d);
    return implode("-",$array);
  }

  public function ajeitarText($v){
    return ucwords(strtolower($v));
  }
}
