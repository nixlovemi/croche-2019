<footer class="font-karla" id="site-footer">
  <div class="content-wrap">
    <div id="footer" class="section group">
      <aside class="col span_8_of_12">
        <h3 class="footer-title">Sobre</h3>
        <div class="footer-title-before"></div>
        <p>
          O Crochê Passo a Passo é um site feito para vocês, amantes do crochê. Nosso principal objetivo é compartilhar gratuitamente receitas e gráficos em várias categorias e também experiências entre todas nós.
        </p>
        <p>
          Qualquer dúvida ou contato, acesse nossa página de contato que teremos o maior prazer em responder =)
        </p>
      </aside>
      <aside class="col span_2_of_12">
        <h3 class="footer-title">Mais Baixadas</h3>
        <div class="footer-title-before"></div>
        <ul class="footer-list">
          <?php
          $arrFooter = getArrPostsMaisLikes(30);
          shuffle($arrFooter);
          for($i=0; $i<4; $i++){
            $itemPost = $arrFooter[$i];
            $urlPost  = $itemPost["link"];
            $titPost  = $itemPost["title"];

            echo "<li>";
            echo "  <a href='$urlPost'>$titPost</a>";
            echo "</li>";
          }
          ?>
        </ul>
      </aside>
      <aside class="col span_2_of_12">
        <h3 class="footer-title">Links Úteis</h3>
        <div class="footer-title-before"></div>
        <ul class="footer-list">
          <li>
            <a href="https://crochepassoapasso.com.br/sessao/ponto-de-croche">Pontos de Crochê</a>
          </li>
          <li>
            <a href="https://crochepassoapasso.com.br/sessao/receitas-de-croche-graficos">Receitas e Gráficos</a>
          </li>
          <li>
            <a href="https://crochepassoapasso.com.br/sessao/artigos">Artigos</a>
          </li>
          <li>
            <a href="https://crochepassoapasso.com.br/sessao/tutorial">Tutoriais</a>
          </li>
          <li>
            <a href="https://crochepassoapasso.com.br/politica-de-privacidade">Política de Privacidade</a>
          </li>
        </ul>
      </aside>
    </div>
  </div>
</footer>

<div class="font-karla" id="footer-bot">
  <div class="content-wrap">
    <div class="section group">
      <div class="col span_12_of_12">
        <p align="center">Política de privacidade / Crochê Passo a Passo © <?=date('Y')?> / Todos os direitos reservados</p>
      </div>
    </div>
  </div>
</div>


<?php
/*
<header><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <nav>
    <ul>
      <li>Your menu</li>
    </ul>
  </nav>
</header>
<section>
  <article>
    <header>
      <h2>Article title</h2>
      <p>Posted on <time datetime="2009-09-04T16:31:24+02:00">September 4th 2009</time> by <a href="#">Writer</a> - <a href="#comments">6 comments</a></p>
    </header>
    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
  </article>
  <article>
    <header>
      <h2>Article title</h2>
      <p>Posted on <time datetime="2009-09-04T16:31:24+02:00">September 4th 2009</time> by <a href="#">Writer</a> - <a href="#comments">6 comments</a></p>
    </header>
    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
  </article>
</section>
<aside>
  <h2>About section</h2>
  <p>Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
</aside>
<footer>
  <p>Copyright 2009 Your name</p>
</footer>
*/
?>

<?php
wp_footer();
?>

<script src="<?php bloginfo('template_url'); ?>/scripts.js"></script>
<script>
  window.onload = function(){
    setTimeout(function(){
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-9051401060868246",
        enable_page_level_ads: true
      });
    }, 500);
  };
</script>
</body>
</html>
