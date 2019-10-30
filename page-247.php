<?php
/* Template Name: Croche Download */
?>
<?php get_header(); ?>
<?php
$urlDownload = $_POST["urlDownload"];
$linkPost    = $_POST["linkPost"];
$errorMsg    = "";

$urlReceita  = $urlDownload;
if($urlReceita == ""){
  $errorMsg = "<p>N&atilde;o conseguimos processar o PDF da receita. Tente novamente ou acesse nossa <a href='http://crochepassoapasso.com.br/sessao/receitas-graficos'>p&aacute;gina de receitas</a>.</p>";
} else {
  $urlReceita = bitLyToUrlPdf($urlReceita);

  $arrPost    = getPostIdByUrl($linkPost);
  $postId     = $arrPost["ID"];
  $postTitle  = $arrPost["title"];
  $postTag    = $arrPost["tag"];
  $postTagUrl = $arrPost["tagUrl"];
  
  #echo "<h2>$postTitle</h2>";
  #echo "<center><p>Para visualizar em tela cheia, <a target='_blank' href='$urlReceita'>clique aqui</a></p></center>";
  #echo "<div class='post_content'>";
  #echo "  <div id='dv-propaganda-bottom-post'>";
  #echo "    <img class='propaganda' src='http://crochepassoapasso.com.br/wp-content/uploads/2018/12/loading-3.gif' alt='Loading - Crochê Passo a Passo' />";
  #echo "  </div>";
  #echo "</div>";
  #echo "<div class='resp-container' style='min-height:900px;'>";
  #echo "  <iframe class='resp-iframe' style='width:100%;' src='$urlReceita'></iframe>";
  #echo "</div>";
}

$qtClicks = getBitLyClicks($urlDownload);
if($qtClicks !== false){
  # var_dump($postId);
  # update_post_meta($postId, 'mb_croche_qtde_downloads', $qtClicks);
  # update_post_meta($postId, 'ir_qtd_downloads', $qtClicks);
  # $ret = simple_fields_set_value($postId, 'ir_qtd_downloads', null, null, $qtClicks);
  $ret = update_field('qt_downloads', $qtClicks, $postId);
}
?>

<div id="header-headline">
  <div class="headline-text">
    <h1 class="entry-title font-lora">Download da <?=$postTitle?></h1>
    <div class="breadcrumbs">
      <a href="<?=site_url()?>">Home</a> / <span><a href="<?=$postTagUrl?>"><?=$postTag?></a></span> / <span><?=$postTitle?></span>
    </div>
  </div>
</div>

<div class="content-wrap">
  <div id="content" class="section group">
    <div class="col span_12_of_12">
      <?php
      if($errorMsg != ""){
        echo $errorMsg;
      } else {
        ?>
        <div style='text-align:center; width:100%; margin-bottom:25px;'>
          <input onClick="abreReceitaTelaCheia('<?=$urlReceita?>')" style="font-size:18px;" class="button-croche" type="button" value="Ver Receita em Tela Cheia" />
            &nbsp;
          <input onClick="downloadReceita('<?=$urlDownload?>')" style="font-size:18px;" class="button-croche" type="button" value="Salvar Receita no Computador" />
        </div>
        
        <div class="resp-container">
          <style>
            .resp-container {
              position: relative;
              overflow: hidden;
              padding-top: 56.25%;
              min-height: 1000px;
            }
            .resp-iframe {
              position: absolute;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              border: 0;
            }
          </style>
          <iframe class="resp-iframe" src="<?=$urlReceita?>" gesture="media"  allow="encrypted-media" allowfullscreen></iframe>
        </div>
        <?php
      }
      ?>
    </div>
    <!--
    <div class="sidebar col span_4_of_12">
      <?php #include get_template_directory().'/sidebar.php' ?>
    </div>
    -->
  </div>
</div>

<?php get_footer(); ?>