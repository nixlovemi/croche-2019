<?php
if ( ! session_id() ) session_start();
include_once("funcoes.php");

$msgAlert   = "";
$idCurso    = 2116;
$usuId      = $_SESSION["crochemeunegocio_usuId"] ?? null;
$Usuario    = $_SESSION["crochemeunegocio_Usuario"] ?? array();
$usuLogado  = checa_session();
$dtCadastro = $Usuario["cmn_dtcadastro"];

if(!$usuLogado){
  destroi_session();
  ?>
  <script>
    alert('Erro ao confirmar login! Faça o login novamente.');
  </script>
  <?php
  header("Location: ".get_site_url()."/curso-de-croche");
}
?>

<style>
  .embed-container{
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
    max-width: 100%;
    height: auto;
  }
  .embed-container iframe, .embed-container object, .embed-container embed{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }
  #top_toolbar{
    width: 100%;
    padding: 10px 5px;
    background-color: #fffcfa;
    border: dashed 1px #525252;
  }
  .titulo-curso{
    font-size: 21px;
    margin-top: 19px;
  }
  .info-aula{
    display: block;
    width: 100%;
    background-color: #d68662;
    margin-top: -1px;
    color: #fff;
  }
  .info-aula p{
    padding: 0 5px;
  }
  .aula-nao-liberada{
    background-color:#c4c4c4;
    color: #8f8f8f;
    display: block;
    width: 100%;
    padding: 65px;
    font-size: 40px;
    text-align: center;
    line-height: 46px;
  }
  .mb-20{
    margin-bottom: 20px;
  }
  .mb-50{
    margin-bottom: 50px;
  }
</style>

<div id="top_toolbar">
  <?php
  $arrMenu   = [];
  $arrMenu[] = "Bem vindo, " . $Usuario["cmn_nome"];
  $arrMenu[] = '<a target="_blank" class="read-more" href="'.get_site_url().'/contato">Contato</a>';
  $arrMenu[] = '<a class="read-more" href="'.get_site_url().'/curso-croche-multi-negocio/?l=1">Sair</a>';
  
  echo implode(" | ", $arrMenu);
  ?>
</div>
<div class="section group">
  <div class="col span_12_of_12">
    <h2 class="titulo-curso mb-20">Curso Crochê Multi Negócio</h2>
    
    <?php
    $arrLoopCurso = [];
    $camposCurso  = CFS()->get( false, $idCurso );
    $idxModulo    = 1;
    foreach($camposCurso as $modulos){
      foreach($modulos as $infoModulo){
        $titulo = $infoModulo["croche_multi_negocio__modulos_titulo"];
        $dias   = $infoModulo["croche_multi_negocio__modulos_dias"];
          
        $arrLoopCurso[$idxModulo] = array(
          "titulo" => $titulo,
          "dias"   => $dias,
          "aulas"  => array(),
        );
        
        $idxAulas = 1;
        foreach($infoModulo["croche_multi_negocio__aulas"] as $aulas){
          $titulo    = $aulas["croche_multi_negocio__aulas_titulo"];
          $video     = $aulas["croche_multi_negocio__aulas_video"];
          $descricao = $aulas["croche_multi_negocio__aulas_descricao"];
          
          if(isset($arrLoopCurso[$idxModulo]["aulas"][$idxAulas]) && count($arrLoopCurso[$idxModulo]["aulas"][$idxAulas]) >= 3){
            $idxAulas++;
          }
          
          $arrLoopCurso[$idxModulo]["aulas"][$idxAulas][] = array(
            "titulo"    => $titulo,
            "video"     => $video,
            "descricao" => $descricao,
          );
        }
        
        $idxModulo++;
      }
    }
    
    // loop para exibir os dados organizados
    // =====================================
    foreach($arrLoopCurso as $modulo){
      $moduloTit        = $modulo["titulo"];
      $moduloDias       = $modulo["dias"];
      $moduloAulas      = $modulo["aulas"];
      $moduloDtLiberado = date("Y-m-d", strtotime($dtCadastro . " + $moduloDias days"));
      $moduloLiberado   = (date("Y-m-d") >= $moduloDtLiberado);
        
      echo "<div class='mb-50'>";
      echo "  <h3>$moduloTit</h3>";
      if(!$moduloLiberado){
        echo "<div class='section group mb-20'>";
        echo "  <div class='col span_12_of_12'>";
        echo "    <div class='aula-nao-liberada'>";
        echo "      O conteúdo desse módulo será liberado dia " . date("d/m/y", strtotime($moduloDtLiberado));
        echo "    </div>";
        echo "  </div>";
        echo "</div>";
      } else {
        foreach($moduloAulas as $loopAula){
          echo "<div class='section group'>";
          foreach($loopAula as $aula){
            $aulaTit  = $aula["titulo"];
            $aulaVid  = $aula["video"];
            $aulaDesc = $aula["descricao"];
            
            echo "<div class='col span_4_of_12'>";
            echo "  <div class='embed-container'>";
            echo "    <iframe src='$aulaVid' width='640' height='360' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>";
            echo "  </div>";
            echo "  <div class='info-aula'>";
            echo "    <p>$aulaTit</p>";
            echo "  </div>";
            echo "</div>";   
          }
          echo "</div>";
        }
      }
      echo "</div>";
    }
    ?>
  </div>
</div>

<?php
if($msgAlert != ""){
  ?>
  <script>
    setTimeout(function(){
      alert('<?=$msgAlert?>');
    }, 700);
  </script>
  <?php
}
?>