<?php
if( is_category() ){
  #$vName = single_cat_title('', false);
  $vName = wp_title( '-', false, '' );
  $vName = str_replace(' | Crochê Passo a Passo', '', $vName);
  $vCat  = "";
} else if (is_tag()){
  #$vName = single_tag_title('', false);
  $vName = wp_title( '-', false, '' );
  $vName = str_replace(' | Crochê Passo a Passo', '', $vName);
  $vCat  = "<a href='".get_site_url()."/receitas-de-croche-graficos'>Receitas e Gráficos</a> /";
} else if (is_search()){
  $vName = 'Pesquisa por: "<i>'.get_search_query().'</i>"';
  $vCat  = "";
}
?>

<div id="header-headline">
  <div class="headline-text">
    <h1 class="entry-title font-lora"><?=$vName?></h1>
    <div class="breadcrumbs">
      <a href="<?=site_url()?>">Home</a> / <span><?=$vCat?></span> <span><?=$vName?></span>
    </div>
  </div>
</div>

<div class="content-wrap">
  <div id="content" class="section group">
    <div class="col span_8_of_12">
      <section>
        <?php
        if ( have_posts() ) : while ( have_posts() ) : the_post();
          $arrayPostInfo = getArrayPostInfo($post);
          
          $arrParam = array(
            "vTitulo"     => $arrayPostInfo["title"],
            "vUrlPost"    => $arrayPostInfo["link"],
            "vImagemTopo" => $arrayPostInfo["img"],
            "vConteudo"   => $arrayPostInfo["excerpt"],
            "vAutor"      => $arrayPostInfo["author"],
            "vDataPost"   => $arrayPostInfo["date"],
            "vEhHome"     => false,
            "vTagUrl"     => $arrayPostInfo["tagUrl"],
            "vTagNome"    => $arrayPostInfo["tag"],
            "vCatUrl"     => $arrayPostInfo["catUrl"],
            "vCatNome"    => $arrayPostInfo["cat"],
            "vQtComent"   => $arrayPostInfo["totComment"],
          );
          echo gera_post($arrParam);
        endwhile; endif;
        ?>
      </section>
      <div style="margin-top: 30px;">
        <?php wp_pagenavi(); ?>
      </div>
    </div>
    <div class="sidebar col span_4_of_12">
      <?php include get_template_directory().'/sidebar.php' ?>
    </div>
  </div>
</div>