<div class="content-wrap">
  <div id="content" class="section group">
    <div class="col span_8_of_12">
      <?php 
        if ( have_posts() ) {
	      while ( have_posts() ) {
		    the_post();
		    $arrayPostInfo = getArrayPostInfo($post);
		    
		    // mesmo esquema que tem no functions.php
            $image_post  = wp_get_attachment_image_src(get_post_thumbnail_id($arrayPostInfo["ID"]), 'full');
            $link_post   = $arrayPostInfo["link"];
            $title_post  = $arrayPostInfo["title"];
            $data_post   = $arrayPostInfo["date"];
            $author      = $arrayPostInfo["author"];
            $totComment  = $arrayPostInfo["totComment"];
            $urlDownload = $arrayPostInfo["urlDownload"];
            
            $tag_id   = $arrayPostInfo["tag_id"];
            $tag_post = $arrayPostInfo["tag"];
            $tag_url  = $arrayPostInfo["tagUrl"];
            
            $cat_id   = $arrayPostInfo["cat_id"];
            $cat_post = $arrayPostInfo["cat"];
            $cat_url  = $arrayPostInfo["catUrl"];
            
            $nomeCaixinha = $tag_post;
            $linkCaixinha = $tag_url;
            if($nomeCaixinha == "" || $linkCaixinha == ""){
              $nomeCaixinha = $cat_post;
              $linkCaixinha = $cat_url;
            }
            ?>
            
            <article class="post-single">
              <span class="post-category">
                <a href="<?=$linkCaixinha?>" rel="category tag">
                  <?=$nomeCaixinha?>
                </a>
              </span>
              <header>
                <h1 class="post-title font-lora"><?=$title_post?></h1>
              </header>
              <span class="post-author">por <?=$author?> em <?=$data_post?></span>
              <div class="post-qt-comment">
                <a class='link-comment' href='javascript:;'>
                  <img src='<?php echo get_bloginfo('template_url') ?>/images/comment.png' />
                  <span><?=$totComment?></span>
                </a>
              </div>
              <?php
              if($image_post[0] != ""){
                ?>
                <figure class="post-image">
                  <img src="<?=$image_post[0]?>" alt="<?=$title_post?>" />
                </figure>
                <?php
              }
              ?>
              <div class="post-content font-hind">
                <?php the_content() ?>
              </div>
            </article>
    
            <aside class="post-share">
              <div class="post-share-holder">
                <a target='_blank' class="font-karla" href="https://www.facebook.com/sharer/sharer.php?display=popup&amp;u=<?=urlencode($link_post)?>">Facebook</a>
                <a target='_blank' class="font-karla" href="https://twitter.com/intent/tweet?text=<?=urlencode('Veja o post ' . $title_post)?>&amp;url=<?=urlencode($link_post)?>">Twitter</a>
                <a target='_blank' class="font-karla" href="https://pinterest.com/pin/create/button/?url=<?=urlencode($link_post)?>%2F&amp;media=<?=urlencode($image_post[0])?>&amp;description=<?=urlencode($title_post)?>">Pinterest</a>
              </div>
            </aside>
            <aside class="mais-posts">
              <h3 class="titulo font-lora">Mais posts</h3>
              <div class="section group">
                <?php
                $arrLoop = getArrPostsMaisLikes(30, $tag_id, array('170', '160'));
                shuffle($arrLoop);
                
                for($i=0; $i<3; $i++){
                  $postItem = $arrLoop[$i];
                  $vLink    = $postItem["link"];
                  $vUrlImg  = $postItem["img"];
                  $vTitle   = $postItem["title"];
                  ?>
                  <div class="col span_4_of_12">
                    <div class="mais-posts-item">
                      <figure>
                        <a href="<?=$vLink?>">
                          <img class="img-responsive" src="<?=$vUrlImg?>" alt="<?=$vTitle?>" />
                        </a>
                      </figure>
                      <h6 class="mais-posts-titulo font-karla">
                        <a href="<?=$vLink?>"><?=$vTitle?></a>
                      </h6>
                    </div>
                  </div>
                  <?php
                }
                ?>
              </div>
            </aside>
            <div class="post-respostas">
              <?php
              if ( comments_open() || '0' != get_comments_number() )
                comments_template();
              ?>
            </div>
            
            <?php
	      } // end while
        } // end if
      ?>
    </div>
    <div class="sidebar col span_4_of_12">
      <?php include get_template_directory().'/sidebar.php' ?>
    </div>
  </div>
</div>