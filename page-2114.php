<?php
/* Template Name: Curso Crochê Multi Negocio */
if ( ! session_id() ) session_start();
global $hideMenu, $hideFooter, $templateUrl;

$templateUrl = "/home/croche/public_html/wp-content/themes/croche2019/";
include_once("$templateUrl/includes_croche_meu_negocio/funcoes.php");

// logout
if(isset($_GET["l"]) && $_GET["l"] == "1"){
  destroi_session();
}
// ======

$hideMenu    = true;
$hideFooter  = true;
$usuId       = $_SESSION["crochemeunegocio_usuId"] ?? null;
$Usuario     = $_SESSION["crochemeunegocio_Usuario"] ?? array();
$usuLogado   = ($usuId > 0);
?>
<?php get_header(); ?>

<?php 
if ( have_posts() ) {
  while ( have_posts() ) {
    the_post();
    ?>
    <div id="header-headline">
      <div class="headline-text">
        <h1 class="entry-title font-lora"><?php the_title(); ?></h1>
      </div>
    </div>
    
    <div class="content-wrap holder-curso-croche">
      <div id="content" class="section group">
        <div class="col span_12_of_12">
          <article class="post-single content-post">
            <div class="footer-meta">
              <style>
                div.holder-curso-croche .read-more{
                  float: none !important;
                }
              </style>
              <?php
              if(!$usuLogado){
                include("$templateUrl/includes_croche_meu_negocio/login.php");
              } else {
                include("$templateUrl/includes_croche_meu_negocio/homepage.php");
              }
              ?>
            </div>
          <article>
        </div>
      </div>
    </div>
    <?php
  }
}
?>
<?php get_footer(); ?>