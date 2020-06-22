<?php
/* Template Name: Curso Crochê */
global $hideMenu, $hideFooter;

$hideMenu   = true;
$hideFooter = true;

extract($_POST);
$nome  = $nome ?? "";
$email = $email ?? "";
$whats = $whatsapp ?? "";
$msg   = $mensagem ?? "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $action ?? "";
  if($action == "post_contact"){
    $errorMsg  = "";
    $arrCmpInv = [];
    if(strlen($nome) < 2){
      $arrCmpInv[] = "Nome";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $arrCmpInv[] = "Email";
    }
    if(strlen($whats) < 10){
      $arrCmpInv[] = "Telefone";
    }
    if(strlen($msg) < 2){
      $arrCmpInv[] = "Mensagem";
    }
    
    if(count($arrCmpInv) > 0){
      $errorMsg = "Para enviar o contato, preencha corretamente os campos: " . implode(", ", $arrCmpInv);
    } else {
      $to      = "carla@crochepassoapasso.com.br";
      $subject = "Contato Curso";
      $body    = "Nome: $nome<br />Email: $email<br />Whats: $whats<br /><br /><i>".nl2br($msg)."</i>";
      
      [$retErro, $retMsg] = enviaEmail($to, $subject, $body);
      $errorMsg           = $retMsg;
      if(!$retErro){
        $nome  = "";
        $email = "";
        $whats = "";
        $msg   = "";
      }
    }
  }
}
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
                  <p class="title">Já comprou?<br />Acesse agora as aulas!</p>
                  <p><input type="button" value="ACESSAR AULAS!" onclick="document.location.href='<?php echo site_url(); ?>/curso-croche-multi-negocio'"></p>
                  <hr />
                  <p class="title">Tire suas dúvidas!</p>
                  <p class="formulario-text">Use o formulário para tirar qualquer dúvida que tiver sobre o nosso curso. Ficaremos felizem em te atender de uma forma mais pessoal.</p>
                  <form method="post" action="<?php echo site_url(); ?>/curso-de-croche">
                    <input type="hidden" name="action" value="post_contact" />
                    <p>
                      <small>Nome:</small>
                      <br />
                      <input type="text" name="nome" value="<?=$nome?>" />
                    </p>
                    <p>
                      <small>Email:</small>
                      <br />
                      <input type="text" name="email" value="<?=$email?>" />
                    </p>
                    <p>
                      <small>Whatsapp (DDD+Celular):</small>
                      <br />
                      <input type="text" name="whatsapp" value="<?=$whats?>" />
                    </p>
                    <p>
                      <small>Mensagem:</small>
                      <br />
                      <textarea name="mensagem"><?=$msg?></textarea>
                    </p>
                    <p>
                      <input class="btn-contato" type="button" value="ENVIAR CONTATO" onclick="this.form.submit()" />
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

if($errorMsg != ""){
  ?>
  <script>
    setTimeout(function(){
      alert('<?=$errorMsg?>');    
    }, 750);
  </script>
  <?php
}
?>
<?php get_footer(); ?>