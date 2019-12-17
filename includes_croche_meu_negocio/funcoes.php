<?php
function destroi_session()
{
  if ( ! session_id() ) session_start();
    
  $_SESSION["crochemeunegocio_usuId"]   = null;
  $_SESSION["crochemeunegocio_Usuario"] = array();
  session_destroy();
}

function checa_session()
{
  if ( ! session_id() ) session_start();
  
  $usuId      = $_SESSION["crochemeunegocio_usuId"] ?? null;
  $Usuario    = $_SESSION["crochemeunegocio_Usuario"] ?? array();
  $usuLogado  = ($usuId > 0) && isset($Usuario["cmn_id"]);
  
  return $usuLogado;
}