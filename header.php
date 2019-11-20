<?php
// https://handmade-shop.cmsmasters.net/masonry-blog/
// https://handmade-shop.cmsmasters.net/standard-blog/
// https://www.iconfinder.com/iconsets/logotypes
// include_once("functions.php");
?>

<!DOCTYPE HTML>
<html lang="pt-BR">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-35484921-1"></script>
  <script>
    var lazySizes;

    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-35484921-1');
  </script>


  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title(''); ?></title>

  <?php if ( is_singular() ): ?>
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <?php endif; ?>
  <meta name="msvalidate.01" content="F13C1611955C5236DF125DB370881693">
  <meta name="p:domain_verify" content="a04d687673100772f80a7be403c8e892">

  <link type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/style.css" rel="stylesheet" />
  <link rel="icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />

  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js">
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <?php wp_head(); ?>
</head>
<body class="font-hind">
  <div id="dv-holder-mobile-baixa-app">
    <p align='center'>
      <a href="#top_baixe_app" class="click_top_baixe_app">Baixe nosso aplicativo!</a>
    </p>
  </div>
  <header>
    <div id="header-content" class="section group">
    	<div class="col span_12_of_12">
        <div class="logo_wrap">
          <a href="<?php echo site_url(); ?>" title="Crochê Passo a Passo" class="logo">
            <img class="img-responsive" src="<?php bloginfo('template_url'); ?>/images/logo.jpg" alt="Crochê Passo a Passo" />
          </a>
        </div>
    	</div>
    </div>
    <div id="menu-content" class="section group">
      <div class="col span_2_of_12">
        <ul class="ul-topo" id="social-top">
          <li>
            <a href="https://www.facebook.com/CrochePassoAPasso">
              <img src="<?php bloginfo('template_url'); ?>/images/logo-topo-face.png" />
            </a>
          </li>
          <li>
            <a href="https://www.instagram.com/crochepassoapasso/">
              <img src="<?php bloginfo('template_url'); ?>/images/logo-topo-insta.png" />
            </a>
          </li>
        </ul>
      </div>
      <div class="col span_8_of_12">
        <ul class="ul-topo" id="menu-top">
          <?php #class="selected" ?>
          <li>
            <a href="<?php echo site_url(); ?>">Home</a>
          </li>
          <li>
            <a href="<?php echo site_url(); ?>/sessao/ponto-de-croche">Ponto de Crochê</a>
          </li>
          <li>
            <a href="<?php echo site_url(); ?>/sessao/receitas-de-croche-graficos">Receitas e Gráficos</a>
          </li>
          <li>
            <a href="<?php echo site_url(); ?>/sessao/artigos">Artigos</a>
          </li>
          <li>
            <a href="<?php echo site_url(); ?>/sessao/tutorial">Tutorial</a>
          </li>
          <li>
            <a href="<?php echo site_url(); ?>/contato">Contato</a>
          </li>
        </ul>
      </div>
      <div class="col span_2_of_12">
        <ul class="ul-topo" id="search-top">
          <li>
            <a href="#side_search_form" class="click_form_top">
              <img src="<?php bloginfo('template_url'); ?>/images/search.png" />
            </a>
          </li>
        </ul>
      </div>
    </div>
    <?php
    /*
    <div class="content-wrap">
      <div class="section group">
        <div class="col span_12_of_12" style="margin-bottom:0;">
          <div class="google-ads google-ads-728">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- Crochê 2019 Header -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-9051401060868246"
                 data-ad-slot="2071766431"
                 data-ad-format="auto"
                 data-full-width-responsive="true">
            </ins>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
          </div>
        </div>
      </div>
    </div>
    */
    ?>
  </header>
