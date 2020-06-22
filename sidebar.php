<aside id="top_baixe_app">
  <h3 class="title font-karla">Baixe nosso aplicativo</h3>
  <figure class="img-wrap text-widget">
    <a target="_blank" href="https://apple.co/2N0W41L">
      <img src="https://crochepassoapasso.com.br/wp-content/uploads/2019/10/app-store-logo.jpg" class="img-responsive" alt="" />
    </a>
    <a target="_blank" href="http://bit.ly/2MZUCwH">
      <img src="https://crochepassoapasso.com.br/wp-content/uploads/2019/10/google-play-logo.jpg" class="img-responsive" alt="" />
    </a>
  </figure>
</aside>

<!--
<aside id="top_baixe_app">
  <h3 class="title font-karla">APROVEITE</h3>
  <figure class="img-wrap text-widget">
    <a target="_blank" href="http://bit.ly/2QWuHrU">
      <img src="https://crochepassoapasso.com.br/wp-content/uploads/2019/11/lacosparapet14.jpg" class="img-responsive" alt="" />
    </a>
  </figure>
</aside>
-->

<aside>
  <h3 class="title font-karla">Sobre mim</h3>
  <figure class="img-wrap">
    <a href="javascript:;">
      <img src="<?php bloginfo('template_url'); ?>/images/perfil-carla.jpg" class="img-responsive" alt="" />
    </a>
  </figure>
  <h3 class="entry-title font-lora">
    <a href="javascript:;">Carla</a>
  </h3>
  <div class="entry-content">
    Me chamo Carla, sou de S&atilde;o Paulo e amo artesanato e animais. Amo todos os tipos de artesanato e fiz o blog para compartilhar essa linda arte do croch&ecirc; com voc&ecirc;s =)
  </div>
</aside>

<?php
/*
<aside class="google-ads">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <!-- Crochê 2019 Side -->
  <ins class="adsbygoogle"
    style="display:block"
    data-ad-client="ca-pub-9051401060868246"
    data-ad-slot="2590641187"
    data-ad-format="auto"
    data-full-width-responsive="true"></ins>
  <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</aside>
*/
?>

<aside class="color">
  <h3 class="title font-karla">Inscreva-se e n&atilde;o perca nenhuma novidade!</h3>
  <div class="entry-content">
    <form action="https://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('https://feedburner.google.com/fb/a/mailverify?uri=CrochePassoAPasso', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
      <input name="email" type="text" title="Seu Email" placeholder="Seu Email" value="" />
      <input type="hidden" value="CrochePassoAPasso" name="uri"/><input type="hidden" name="loc" value="en_US"/>
      <div class="dv-br"></div>
      <input type="button" value="Cadastrar" onClick="this.form.submit()" />
    </form>
  </div>
</aside>

<aside class="color" id="side_search_form">
  <h3 class="title font-karla">Pesquise pelo site!</h3>
  <div class="entry-content">
    <form role="search" method="get" id="searchform" action="https://crochepassoapasso.com.br/" >
      <input type="text" value="" name="s" id="s" placeholder="Pesquisar ..." />
      <div class="dv-br"></div>
      <input type="button" value="Pesquisar" onClick="this.form.submit()" />
    </form>
  </div>
</aside>

<aside>
  <h3 class="title font-karla">Categorias</h3>
  <div class="entry-content">
    <ul class="font-karla">
      <?php
      $arrTag = getArrTags();
      foreach($arrTag as $tag){
        $tagName = $tag["name"];
        $tagUrl  = $tag["url"];
        
        echo "<li>";
        echo "  <a href='$tagUrl'>";
        echo "    $tagName";
        echo "  </a>";
        echo "</li>";
      }
      ?>
    </ul>
  </div>
</aside>

<aside>
  <h3 class="title font-karla">Facebook</h3>
  <figure class="img-wrap text-widget">
    <a target="_blank" href="https://www.facebook.com/CrochePassoAPasso/">
      <img src="<?php bloginfo('template_url'); ?>/images/follow-facebook.png" class="img-responsive" alt="" />
    </a>
  </figure>
</aside>

<aside>
  <h3 class="title font-karla">Instagram</h3>
  <figure class="img-wrap text-widget">
    <a target="_blank" href="https://www.instagram.com/crochepassoapasso/">
      <img src="<?php bloginfo('template_url'); ?>/images/follow-insta.png" class="img-responsive" alt="" />
    </a>
  </figure>
</aside>

<aside>
  <h3 class="title font-karla">Posts Recentes</h3>
  <ul class="side-post-list font-karla">
    <?php
    $postRecentes = getRecentPosts(5, 3, array('70', '70'));
    foreach($postRecentes as $post){
      $postUrl   = $post["link"];
      $postImg   = $post["img"];
      $postTitle = $post["title"];
      $postDate  = $post["date"];
      ?>
      <li>
        <div class="post-image">
          <a href="<?=$postUrl?>">
            <img class="img-responsive" src="<?=$postImg?>" alt="<?=$postTitle?>" />
          </a>
        </div>
        <div class="post-title">
          <a href="<?=$postUrl?>" title="<?=$postTitle?>">
            <?=$postTitle?>
          </a>
        </div>
        <abbr class="post-published" title="<?=$postDate?>"><?=$postDate?></abbr>
      </li>
      <?php
    }
    ?>
  </ul>
</aside>
