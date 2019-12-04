<?php
/* Template Name: Curso Crochê */
$hideMenu   = true;
$hideFooter = true;
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
        <div class="breadcrumbs">
          <a href="<?=site_url()?>">Home</a> / <span><?php the_title(); ?></span>
        </div>
      </div>
    </div>
    
    <div class="content-wrap">
      <div id="content" class="section group">
        <div class="col span_12_of_12">
          <article class="post-single">
            <?php
            $postId     = get_the_ID();
            $idImgTopo  = get_post_meta( $postId, 'lcc_imagem_topo', true );
            $imgTopo    = wp_get_attachment_image( $idImgTopo, "Large", "", array( "class" => "img-responsive" ) );
            $conteudo   = get_post_meta( $postId, 'lcc_conteudo', true );
            
            echo $imgTopo;
            ?>
            <div style="margin-top: 30px;" class="section group">
              <div class="col span_7_of_12">
                <?php
                echo nl2br($conteudo);
                ?>
              </div>
              <div class="col span_5_of_12">
                <div id="dv-holder-info-curso-croche">
                  <p>Compre o curso e tenha acesso a todas as vídeo-aulas e materiais por apenas</p>
                  <p class="price"><small>12x</small>R$39,90</p>
                  <p><input type="button" value="COMPRAR AGORA!" onclick="alert(0)"></p>
                  <hr />
                  <p class="title">Tire suas dúvidas!</p>
                  <p class="formulario-text">Use o formulário para tirar qualquer dúvida que tiver sobre o nosso curso. Ficaremos felizem em te atender de uma forma mais pessoal.</p>
                  <form method="post" action="./">
                    <input type="hidden" name="action" value="post_contact" />
                    <p>
                      <small>Nome:</small>
                      <br />
                      <input type="text" name="nome" />
                    </p>
                    <p>
                      <small>Email:</small>
                      <br />
                      <input type="text" name="email" />
                    </p>
                    <p>
                      <small>Whatsapp:</small>
                      <br />
                      <input type="text" name="whatsapp" />
                    </p>
                    <p>
                      <small>Mensagem:</small>
                      <br />
                      <textarea name="whatsapp"></textarea>
                    </p>
                    <p>
                      <input class="btn-contato" type="button" value="ENVIAR CONTATO" onclick="alert(0)">
                    </p>
                  </form>
                </div>
              </div>
            </div>
          <article>
        </div>
        <!--
        <div class="sidebar col span_4_of_12">
          <?php #include get_template_directory().'/sidebar.php' ?>
        </div>
        -->
      </div>
    </div>
    <?php
  }
}
?>

<?php get_footer(); ?>