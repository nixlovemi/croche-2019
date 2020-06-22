<?php
// set default timezone
date_default_timezone_set('America/Sao_Paulo');
add_theme_support( 'post-thumbnails' );

// add_image_size('nix-croche-thumb-88-88', 88, 88, true);
// add_image_size('nix-croche-category-550', 550, 550, true);
add_image_size('nix-single-mais-posts', 170, 160, true);
add_image_size('nix-side-recentes', 70, 70, true);

/**
 * Use * for origin
 */
add_action( 'rest_api_init', function() {
	remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
	add_filter( 'rest_pre_serve_request', function( $value ) {
		header( 'Access-Control-Allow-Origin: *' );
		header( 'Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method' );
		header( 'Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE' );
		header( 'Access-Control-Allow-Credentials: true' );

		return $value;
	});
}, 15 );

function bitLyToUrlPdf($vUrlReceita)
{
  $arrHeader  = curlHeaders($vUrlReceita);
  $urlReceita = "";
  foreach($arrHeader as $headerInfo){
    $ehLocation = strpos($headerInfo, "Location: ") !== false;
    if($ehLocation){
      $urlReceita = str_replace("Location: ", "", $headerInfo);
      break;
    } else {
        $ehLocation = strpos($headerInfo, "location: ") !== false;
        if($ehLocation){
            $urlReceita = str_replace("location: ", "", $headerInfo);
            break;
        }
    }
  }
  
  $urlReceita = str_replace("?dl=1", "?raw=1", $urlReceita);
  return $urlReceita;
}

// esquema pra adicionar variavel no REST
add_action( 'rest_api_init', 'add_custom_fields' );
function add_custom_fields() {
  register_rest_field(
    'post', 
    'custom_fields', //New Field Name in JSON RESPONSEs
    array(
      'get_callback'    => 'get_custom_fields', // custom function name 
      'update_callback' => null,
      'schema'          => null,
    )
  );
}
function get_custom_fields( $object, $field_name, $request ) {
  $post_id   = $object['id'];
  $bitly_url = get_post_meta( $post_id, 'url_download', true );
  $url_pdf   = bitLyToUrlPdf($bitly_url);
  
  return array(
    "url_bitly" => $bitly_url,
    "url_pdf"   => $url_pdf,
  );
}

add_action('rest_api_init', function () {
  register_rest_route( 'crocherest/v1', 'url-bitly/(?P<post_id>\d+)',array(
    'methods'  => 'GET',
    'callback' => 'get_url_bitly_by_post'
  ));
  register_rest_route('crocherest/v1', '/send-contacts', array (
    'methods'             => 'GET',
    'callback'            => 'send_contact',
    'permission_callback' => function (WP_REST_Request $request) {
      return true;
    }
  ));
});
function get_url_bitly_by_post($request) {
  $post_id = $request['post_id'];
  $bitly_url = get_post_meta( $post_id, 'url_download', true );
  $url_pdf   = bitLyToUrlPdf($bitly_url);
  
  $response = new WP_REST_Response(array(
    "url_bitly" => $bitly_url,
    "url_pdf"   => $url_pdf,
  ));
  
  $response->set_status(200);
  return $response;
}
function send_contact($request) {
  $parameters = $request->get_query_params();
  $vNome      = trim($parameters["nome"]);
  $vEmail     = trim($parameters["email"]);
  $vMsg       = trim($parameters["msg"]);
  
  $retErro    =  false;
  $retMsg     = "";
  
  if($vNome == ''){
    $retErro    =  true;
    $retMsg     = "Informe o nome!";
  } else if( !filter_var($vEmail, FILTER_VALIDATE_EMAIL) ){
    $retErro    =  true;
    $retMsg     = "Informe o email!";
  } else if ($vMsg == ''){
    $retErro    =  true;
    $retMsg     = "Informe a mensagem!";
  } else {
    $to      = 'carla@crochepassoapasso.com.br';
    $subject = 'Contato APP';
    $body    = "Nome: $vNome<br />Email: $vEmail<br /><br /><i>".nl2br($vMsg)."</i>";
    
    [$retErro, $retMsg] = enviaEmail($to, $subject, $body);
  }
  
  $response = new WP_REST_Response(array(
    "erro" => $retErro,
    "msg"  => $retMsg,
  ));
  
  $response->set_status(200);
  return $response;
}
// ======================================

add_action( 'transition_post_status', 'manda_push_notification', 10, 3 );
function manda_push_notification( $new_status, $old_status, $post )
{
    if ( 'publish' !== $new_status or 'publish' === $old_status )
        return;

    if ( 'post' !== $post->post_type )
        return; // restrict the filter to a specific post type

    // do something awesome
    $arrPost = getArrayPostInfo($post);
 
    $topic        = "/topics/crocheapp";
    $notification = [
      "title"                      => "Novo post!",
      "body"                       => "Olá. Veja nosso novo post no app: " . $arrPost["title"],
      "sound"                      => "default",
      "icon"                       => "fcm_push_icon",
      "delivery_receipt_requested" => true,
      "badge"                      => 0, # bolinha vermelha no icone do app
    ];
    $result = sendPushNotificationsTopic($topic, $notification, $arrPost["ID"]);
}

function sendPushNotificationsTopic($topic, $notification=array(), $postID='')
{
    $apiKey = "AIzaSyBN1KJYtTaQE5uapHHGcntbdAQDOpgAjgs";
    $fields = [
        "to"           => $topic,
        "notification" => $notification,
        "data"         => array(
          "post_id" => $postID
        ),
        "options"      => array(
          "priority" => "high"
        )
    ];
    $headers = [
        "Authorization: key=$apiKey",
        "Content-Type: application/json",
    ];
    $url = "https://fcm.googleapis.com/fcm/send";
    $ch     = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

add_filter('get_avatar', 'site_get_avatar', 10, 5);
function site_get_avatar($avatar, $id_or_email, $size, $default, $alt)
{
  #$comment_author_id = $id_or_email->user_id;
  #$comment_author_email = $id_or_email->comment_author_email;

  #$user_profile_img_id = get_the_author_meta( 'user_profile_img', $comment_author_id );
  #$user_profile_img =  wp_get_attachment_url($user_profile_img_id);

  #$my_avatar = "<img src='".$user_profile_img."' alt='".$alt."' height='".$size."' width='".$size."' />";
  #return $my_avatar;
  
  $xpath  = new DOMXPath(@DOMDocument::loadHTML($avatar));
  $src    = $xpath->evaluate("string(//img/@src)");
  $newSrc = str_replace('s=32', 's=64', $src);
  return "<img class='avatar-img' src='$newSrc' />";
}

add_filter( 'get_comment_date', 'custom_comment_date', 10, 3);
function custom_comment_date( $date, $d, $comment )
{
  return date('d/m/y', strtotime($comment->comment_date));
}

function acerta_nome_mes($aux)
{
  switch(strtolower($aux)){
    case 'jan':
	  $aux = 'Jan';
	  break;
	case 'feb':
	  $aux = 'Fev';
	  break;
	case 'mar':
	  $aux = 'Mar';
	  break;
	case 'apr':
	  $aux = 'Abr';
	  break;
	case 'may':
	  $aux = 'Mai';
	  break;
	case 'june':
	  $aux = 'Jun';
	  break;
	case 'july':
	  $aux = 'Jul';
	  break;
	case 'aug':
	  $aux = 'Ago';
	  break;
	case 'sep':
	  $aux = 'Set';
	  break;
	case 'oct':
	  $aux = 'Out';
	  break;
	case 'nov':
	  $aux = 'Nov';
	  break;
	case 'dec':
	  $aux = 'Dez';
	  break;
	}

	return $aux;
}

function gera_post($arrParams, $marginTop=0)
{
  $vTitulo     = $arrParams["vTitulo"] ?? "";
  $vUrlPost    = $arrParams["vUrlPost"] ?? "javascript:;";
  $vImagemTopo = $arrParams["vImagemTopo"] ?? "";
  $vConteudo   = $arrParams["vConteudo"] ?? "";
  $vAutor      = $arrParams["vAutor"] ?? "";
  $vDataPost   = $arrParams["vDataPost"] ?? "";
  $vEhHome     = (isset($arrParams["vEhHome"]) && $arrParams["vEhHome"] == true) ? " post-home ": "";
  $vTagUrl     = $arrParams["vTagUrl"] ?? "";
  $vTagNome    = $arrParams["vTagNome"] ?? "";
  $vCatUrl     = $arrParams["vCatUrl"] ?? "";
  $vCatNome    = $arrParams["vCatNome"] ?? "";
  $vQtComent   = $arrParams["vQtComent"] ?? 0;
  
  $nomeCaixinha = $vTagNome;
  $linkCaixinha = $vTagUrl;
  if($nomeCaixinha == "" || $linkCaixinha == ""){
    $nomeCaixinha = $vCatNome;
    $linkCaixinha = $vCatUrl;
    if($nomeCaixinha == "" || $linkCaixinha == ""){
      $linkCaixinha = "javascript:;";
    }
  }

  $html  = "";
  $html .= "<article class='$vEhHome content-post' style='margin-top:".$marginTop."px'>";
  $html .= "  <div class='image-top'>";
  $html .= "    <span class='tag'>";
  $html .= "      <a href='$linkCaixinha'>$nomeCaixinha</a>";
  $html .= "    </span>";
  $html .= "    <a href='$vUrlPost'><img class='img-responsive' src='$vImagemTopo' alt='$vTitulo - Crochê Passo a Passo' /></a>";
  $html .= "  </div>";
  $html .= "  <div class='post-meta'>";
  $html .= "    por $vAutor em $vDataPost";
  $html .= "  </div>";
  $html .= '  <header class="entry-header"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
  $html .= "    <h2 class='entry-title font-lora'>";
  $html .= "      <a href='$vUrlPost'>$vTitulo</a>";
  $html .= "    </h2>";
  $html .= "  </header>";
  $html .= "  <div class='entry-content'>";
  $html .= "    $vConteudo";
  $html .= "  </div>";
  $html .= "  <footer class='footer-meta'>";
  $html .= "    <a class='read-more' href='$vUrlPost'>Veja mais</a>";
  $html .= "    <div class='entry-comments'>";
  $html .= "      <span class='post-comments'>";
  $html .= "        <a class='link-comment' href='$vUrlPost' title='Comente &amp; $vTitulo'>";
  $html .= "          <img src='".get_bloginfo('template_url')."/images/comment.png' />";
  $html .= "          <span>$vQtComent</span>";
  $html .= "        </a>";
  $html .= "      </span>";
  $html .= "    </div>";
  $html .= "  </footer>";
  $html .= "</article>";

  return $html;
}

function getArrayPostInfo($wpPost, $thumbSize=array('450', 450))
{
  // $image_post = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
  // $image_post = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'nix-croche-thumb-88-88' );
  $postId      = $wpPost->ID;
  $image_post  = wp_get_attachment_image_src(get_post_thumbnail_id($postId), $thumbSize);
  $link_post   = get_permalink($wpPost);
  $title_post  = get_the_title($wpPost);
  $excerpt     = get_the_excerpt($wpPost);
  $mes_post    = acerta_nome_mes(get_the_date("M", $wpPost));
  $dia_post    = get_the_date("d", $wpPost);
  $author      = get_author_name($wpPost);
  $totComment  = get_comments_number($wpPost);
  $urlDownload = get_field('url_download', $postId);
  $qtdDownload = get_field('qt_downloads', $postId);

  $tag_id   = "";
  $tag_post = "";
  $tag_url  = "";
  $posttags = get_the_tags($wpPost);
  if ($posttags) {
    foreach ($posttags as $tag) {
      $tag_id   = $tag->term_id;
      $tag_post = $tag->name;
      $tag_url  = 'https://crochepassoapasso.com.br/categoria-receitas-graficos/' . $tag->slug;
    }
  }
  
  $cat_id   = "";
  $cat_post = "";
  $cat_url  = "";
  $postcats = get_the_category($wpPost);
  if ($postcats) {
    foreach ($postcats as $cat) {
      $cat_id   = $cat->term_id;
      $cat_post = $cat->name;
      $cat_url  = 'https://crochepassoapasso.com.br/sessao/' . $cat->slug;
    }
  }

  return array(
    'ID'          => $postId,
    'img'         => $image_post[0],
    'link'        => $link_post,
    'title'       => $title_post,
    'excerpt'     => $excerpt,
    'tag_id'      => $tag_id,
    'tag'         => $tag_post,
    'tagUrl'      => $tag_url,
    'cat_id'      => $cat_id,
    'cat'         => $cat_post,
    'catUrl'      => $cat_url,
    'date'        => $dia_post . "/" . ucfirst($mes_post),
    'author'      => $author,
    'totComment'  => $totComment,
    'urlDownload' => $urlDownload,
    'qtdDownload' => $qtdDownload,
  );
}

function getArrPostsMaisLikes($qt_posts = 6, $tag_id = '', $thumbSize=array('450', '450'))
{
  $args = array(
    'orderby' => 'meta_value_num',
    //'meta_key' => 'mb_croche_qtde_likes',
    'meta_key' => 'mb_croche_qtde_downloads',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $qt_posts,
    'caller_get_posts' => 1,
	'category' => 3
  );

  if (is_numeric($tag_id)) {
    $args['tag_id'] = $tag_id;
  }

  $my_query = null;
  $my_query = new WP_Query($args);
  $posts    = $my_query->posts;

  $arrResp = array();
  foreach($posts as $post) {
    $my_query->the_post();
    $arrPostInfo = getArrayPostInfo($post, $thumbSize);
    $arrResp[]   = $arrPostInfo;
  }

  /*$arrResp = array();
  if ($my_query->have_posts()) {
    $i = 1;
    while ($my_query->have_posts()):
      $my_query->the_post();
      $arrPostInfo = getArrayPostInfo($post, $thumbSize);
      $arrResp[]   = $arrPostInfo;
    endwhile;
  }*/
  wp_reset_query(); // Restore global post data stomped by the_post().
  return $arrResp;
}

function fncGetFacebookLike($url)
{
	// jSON URL which should be requested
	$json_url = "https://graph.facebook.com/?id=$url";
	#$username = ‘your_username’;  // authentication
	#$password = ‘your_password’;  // authentication

	// jSON String for request
	#$json_string = ‘[your json string here]’;

	// Initializing curl
	$ch = curl_init( $json_url );

	// Configuring curl options
	$options = array(
	CURLOPT_RETURNTRANSFER => true,
	#CURLOPT_USERPWD => $username . “:” . $password,  // authentication
	CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
	#CURLOPT_POSTFIELDS => $json_string
	);

	// Setting curl options
	curl_setopt_array( $ch, $options );

	// Getting results
	$result  = curl_exec($ch); // Getting jSON result string
	$arrJson = json_decode($result, 1);

	#echo "<pre>";
	#print_r($arrJson);
	#echo "</pre>";

	$qtLike  = isset($arrJson["share"]["share_count"]) ? $arrJson["share"]["share_count"]: -5;
	return $qtLike;

  /*include_once 'share-countt.class.php';

	$obj = new shareCount(urlencode($url)); //Use your website or URL
  #echo $obj->get_tweets(); //to get tweets
  return $obj->get_fb(); //to get facebook total count (likes+shares+comments)
  #echo $obj->get_linkedin(); //to get linkedin shares
  #echo $obj->get_plusones(); //to get google plusones
  #echo $obj->get_delicious(); //to get delicious bookmarks  count
  #echo $obj->get_stumble(); //to get Stumbleupon views
  #echo $obj->get_pinterest(); //to get pinterest pins*/
}

function get_shorten_url($url)
{
	$headers     = get_headers($url, 1);
	$retLocation = $headers['Location'];
	if(is_array($retLocation)){
	    $vUrlRet = "";
	    foreach($retLocation as $url){
	        $ehUrlValida = filter_var($url, FILTER_VALIDATE_URL);
	        if($ehUrlValida){
	            $vUrlRet = $url;
	            break;
	        }
	    }
	} else {
	    $vUrlRet = $retLocation;
	}
	
	return $vUrlRet;
}

/*function getPostIdByUrlReceita($urlReceita)
{
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => 1,
    'post_status' => 'publish',
    'meta_query' => array(
      'key' => 'mb_croche_url_pdf_receita',
      'value' => $urlReceita,
    ),
  );
  $my_query = new WP_Query( $args );
  $arrResp = array();
  if ($my_query->have_posts()) {
    $i = 1;
    while ($my_query->have_posts()):
      $my_query->the_post();
      $arrResp["postID"]    = get_the_ID();
      $arrResp["postTitle"] = get_the_title();
    endwhile;
  }
  wp_reset_query(); // Restore global post data stomped by the_post().
  return $arrResp;
}*/

function getPostIdByUrl($url)
{
  $postId   = url_to_postid($url);
  $ret      = get_post($postId);
  $postInfo = getArrayPostInfo($ret);
  return $postInfo;
}

function curlHeaders($url)
{
  // URL to fetch
  // $url = "https://beamtic.com/";

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, 1);

  $response = curl_exec($ch);

  // Retudn headers seperatly from the Response Body
  $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  $headers = substr($response, 0, $header_size);
  $body = substr($response, $header_size);

  curl_close($ch);

  $headers = explode("\r\n", $headers); // The seperator used in the Response Header is CRLF (Aka. \r\n)
  $headers = array_filter($headers);

  return $headers;
}

function getBitLyClicks($url)
{
  $token = "1392f5b009e9288e330c3c906f9159ef4c6e54a9";
  $url   = "https://api-ssl.bitly.com/v3/link/clicks?access_token=$token&link=$url";
  $ch    = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
  $jsonContent = curl_exec($ch);
  curl_close($ch);

  if($jsonContent != ""){
    $arrJson     = json_decode($jsonContent, 1);
    $totalClicks = $arrJson["data"]["link_clicks"] ?? 0;

    return $totalClicks;
  } else {
    return false;
  }
}

function getArrTags()
{
  $arrTag = [];
  $tags   = get_tags( array(
    # 'taxonomy'   => 'category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'orderby'    => 'name',
    'parent'     => 0,
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
  ) );
  
  foreach ( $tags as $tag ){
    $tag_ID   = (int) $tag->term_id;
    $tag_name = $tag->name;
    $tag_url  = esc_url( get_tag_link( $tag->term_id ) );
    
    $arrTag[] = array(
      "ID"   => $tag_ID,
      "name" => $tag_name,
      "url"  => $tag_url
    );
  }
  
  return $arrTag;
}

function getRecentPosts($numPosts=5, $category=3, $thumbSize=array('450', '450'))
{
  $arrRet = [];
  $recent_posts = wp_get_recent_posts(
    array(
      "numberposts" => $numPosts,
      "category"    => $category,
      "orderby"     => "post_date",
      "order"       => "DESC",
      "post_type"   => "post",
      "post_status" => "publish",
    )
  );
  foreach( $recent_posts as $recent ){
    $post        = get_post($recent["ID"]);
    $arrPostInfo = getArrayPostInfo($post, $thumbSize);
    $arrRet[]    = $arrPostInfo;
  }
  
  wp_reset_query(); // Restore global post data stomped by the_post().
  return $arrRet;
}

function enviaEmail($para, $titulo, $mensagem)
{
  $to      = $para;
  $subject = $titulo;
  $body    = $mensagem;
  $headers = array('Content-Type: text/html; charset=UTF-8');
     
  $ret     = wp_mail( $to, $subject, $body, $headers );   
  if($ret){
    $retErro =  false;
    $retMsg  = "Contato enviado com sucesso!";
  } else {
    $retErro =  true;
    $retMsg  = "Erro ao enviar contato! Tente novamente mais tarde!";
  }
  
  return [$retErro, $retMsg];
}
/* pra add JS do croche multi negocio */
function admin_js_croche_multi_negocio($hook) {
  // Only add to the edit.php admin page.
  // See WP docs.
  /*if ('edit.php' !== $hook) {
      return;
  }*/
  wp_enqueue_script('my_custom_script', 'https://crochepassoapasso.com.br/wp-content/themes/croche2019/scripts-admin.js');
  wp_enqueue_script('my_custom_script2', 'https://crochepassoapasso.com.br/wp-content/themes/croche2019/includes_croche_meu_negocio/data-tables/datatables.min.js');
  wp_enqueue_style('style-name', 'https://crochepassoapasso.com.br/wp-content/themes/croche2019/includes_croche_meu_negocio/data-tables/datatables.min.css');
}
add_action('admin_enqueue_scripts', 'admin_js_croche_multi_negocio');
/* ================================== */