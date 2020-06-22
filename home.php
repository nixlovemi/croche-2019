<div id="header-headline">
  <div class="headline-text">
    <h1 class="entry-title font-lora">Crochê Passo a Passo - Receitas gratuitas de crochê</h1>
  </div>
</div>

<div class="content-wrap">
  <div id="content" class="section group">
    <div class="col span_8_of_12">
      <?php
      $arrTagsLoop   = [];
      $arrTagsLoop[] = array(
        "id"   => null,
        "name" => "Novidades!",
        "url"  => "javascript:;",
        "tipo" => "novidades",
      );
      $arrTagsLoop[] = array(
        "id"   => "16",
        "name" => "Tapetes",
        "url"  => "http://crochepassoapasso.com.br/categoria-receitas-graficos/tapetes",
        "tipo" => "mais_downloads",
      );
      $arrTagsLoop[] = array(
        "id"   => "14",
        "name" => "Jogo de Banheiro",
        "url"  => "http://crochepassoapasso.com.br/categoria-receitas-graficos/jogo-de-banheiro",
        "tipo" => "mais_downloads",
      );
      $arrTagsLoop[] = array(
        "id"   => "8",
        "name" => "Caminho de Mesa",
        "url"  => "http://crochepassoapasso.com.br/categoria-receitas-graficos/caminho-de-mesa",
        "tipo" => "mais_downloads",
      );
      
      $marginTop = 0;
      foreach($arrTagsLoop as $tagLoop){
        $vTagId   = $tagLoop["id"];
        $vTagName = $tagLoop["name"];
        $vTagUrl  = $tagLoop["url"];
        $vTipo    = $tagLoop["tipo"];
        
        if($vTipo == "mais_downloads"){
          $arrRet = getArrPostsMaisLikes(4, $vTagId);
        } else {
          $arrRet = getRecentPosts(4);
        }
        $arrRetLoop = array_chunk($arrRet, 2);
          
        echo "<div class='section-title font-lora' style='margin-top:".$marginTop."px;'>";
        echo "  <p class='heading'><a href='$vTagUrl'>$vTagName</a></p>";
        echo "</div>";
        echo "<div class='section group'>";
        for($i=0; $i<=1; $i++){
          echo "<div style='margin-top: 0;' class='col span_6_of_12'>";
          $ii = 1;
          foreach($arrRetLoop[$i] as $arrLoopHome){
            $marginTop = ($ii <= 1) ? 0: 10;
            $arrParam = array(
              "vTitulo"     => $arrLoopHome["title"],
              "vUrlPost"    => $arrLoopHome["link"],
              "vImagemTopo" => $arrLoopHome["img"],
              "vConteudo"   => $arrLoopHome["excerpt"],
              "vAutor"      => $arrLoopHome["author"],
              "vDataPost"   => $arrLoopHome["date"],
              "vEhHome"     => true,
              "vTagUrl"     => $arrLoopHome["tagUrl"],
              "vTagNome"    => $arrLoopHome["tag"],
              "vCatUrl"     => $arrLoopHome["catUrl"],
              "vCatNome"    => $arrLoopHome["cat"],
              "vQtComent"   => $arrLoopHome["totComment"],
            );
            echo gera_post($arrParam, $marginTop);
            $ii++;
          }
          echo "</div>";
        }
        echo "</div>";
        $marginTop = 20;
      }
      ?>
    </div>
    <div class="sidebar col span_4_of_12">
      <?php include get_template_directory().'/sidebar.php' ?>
    </div>
  </div>
</div>