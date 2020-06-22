<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  extract($_POST);
  
  $login    = $login ?? "";
  $senha    = $senha ?? "";
  $msgAlert = "";
  
  if(strlen($login) < 2 || strlen($senha) < 2){
    $msgAlert = "Preencha o usuário e a senha corretamente!";
  } else {
    global $wpdb;
    
    $escpLogin = esc_sql($login);
    $escpSenha = esc_sql($senha);
    
    $sql = "
      SELECT cmn_id, cmn_login, cmn_senha, cmn_nome, cmn_telefone, cmn_dtcadastro, cmn_validade, cmn_ativo
      FROM tb_curso_croche_multi_neg
      WHERE cmn_login = '$escpLogin'
      AND cmn_senha = '".md5($escpSenha)."'
    ";
    $results    = $wpdb->get_results($sql, 'ARRAY_A');
    $numResults = count($results);
    
    if($numResults <= 0){
      $msgAlert = "Usuário ou senha inválidos!";
    } else {
      $row      = $results[0];
      $validade = $row["cmn_validade"];
      $ativo    = $row["cmn_ativo"];
      
      if($ativo != 1){
        $msgAlert = "Esse usuário está inativo! Entre em contato conosco, por favor.";
      } else if(date("Y-m-d") > $validade){
        $msgAlert = "A validade desse usuário expirou! Entre em contato conosco, por favor.";
      } else {
        $_SESSION["crochemeunegocio_Usuario"] = $row;
        $_SESSION["crochemeunegocio_usuId"]   = $row["cmn_id"];
      
        header("Location: ".get_site_url()."/curso-croche-multi-negocio");   
      }
    }
  }
}
?>

<div class="section group">
  <div class="col span_3_of_12"></div>
  <div class="col span_6_of_12">
    <style>
      /* talvez depois integrar no CSS principal (igual aside) */
      div.login-curso-croche{
        background-color: #f8efea;
        position: relative;
        padding: 40px;
        border: solid 1px #ebebeb;
        text-align: center;
        margin-bottom: 0 !important;
      }
      div.login-curso-croche .title{
        font-size: 20px;
        margin-bottom: 20px;
      }
      div.login-curso-croche .inpt{
        transition: border-color .2s ease-in-out;
        width: 100% !important;
        padding: 9px !important;
        border-color: #ebebeb;
        background-color: #fff;
        color: #7b726f;
        max-width: 100%;
        border-width: 1px;
        border-style: solid;
      }
      div.login-curso-croche input[type="button"]{
        transition: all .3s ease-in-out;
        color: #fff;
        border-color: #d68662;
        background-color: #d68662;
        cursor: pointer;
        white-space: nowrap;
        text-align: center;
        border-width: 1px;
        border-style: solid;
        padding: 8px 25px;
      }
      div.login-curso-croche form.login{
        margin-bottom: 35px;
      }
    </style>
    <div class="login-curso-croche">
      <h3 class="title font-karla">
        Login do
        <br />
        Curso de Crochê Multi Negócio
      </h3>
      <div class="entry-content">
        <form class="login" method="post" action="<?php echo site_url(); ?>/curso-croche-multi-negocio">
          <input type="hidden" name="action" value="acessar_curso" />
          <input class="inpt" type="text" value="" name="login" id="login" placeholder="Nome de Usuário" />
          <div class="dv-br"></div>
          <input class="inpt" type="password" value="" name="senha" id="senha" placeholder="Senha" />
          <div class="dv-br"></div>
          <input type="button" value="Acessar Curso" onclick="this.form.submit()">
        </form>
        <hr />
        Ainda não comprou o curso?
        <br />
        <a class="read-more" href="<?php echo site_url(); ?>/curso-de-croche">Conheça mais sobre ele aqui!</a>
      </div>
    </aside>
  </div>
  <div class="col span_3_of_12"></div>
</div>

<?php
if($msgAlert != ""){
  ?>
  <script>
    setTimeout(function(){
      alert('<?=$msgAlert?>');
    }, 700);
  </script>
  <?php
}
?>