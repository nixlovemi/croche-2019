<?php
define( 'SHORTINIT', true );
require( '/home/croche/public_html/wp-load.php' );

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $acao = $_POST["acao"] ?? "";
  
  switch ($acao) {
    case "initClientesCrocheMultiNegocio":
      initClientesCrocheMultiNegocio($_POST);
      break;
    case "telaCadastroAluno":
      telaCadastroAluno($_POST);
      break;
    case "postAddAluno":
      postAddAluno($_POST);
      break;
    case "telaEditaAluno":
      telaEditaAluno($_POST);
      break;
    case "postEditAluno":
      postEditAluno($_POST);
      break;
    default:
      break;
  }
}

function getHtmlBtnAddAluno($holderId)
{
  return "<button type='button' class='button' onclick=\" mvc_post_ajax_var('acao=telaCadastroAluno&holderId=$holderId') \">Adicionar Aluno</button>";
}

function getHtmlFormAluno($holderId, $cmnId='')
{
  $EH_INSERT = true;
  $TAB_TITLE = 'CADASTRAR NOVO ALUNO';
  
  $jsCancelar = "
    var vars = 'acao=initClientesCrocheMultiNegocio&holderId=$holderId';
    mvc_post_ajax_var(vars);
  ";
  $jsSalvar = "
    var formVar = jQuery('#frmAddAluno').find('select, textarea, input').serialize()
    var vars    = 'acao=postAddAluno&holderId=$holderId&' + formVar;
    mvc_post_ajax_var(vars);
  ";
    
  // info do aluno
  $Aluno = [];
  if($cmnId > 0){
    $EH_INSERT = false;
    $TAB_TITLE = 'EDITAR ALUNO';
    $jsSalvar  = "
      var formVar = jQuery('#frmAddAluno').find('select, textarea, input').serialize()
      var vars    = 'acao=postEditAluno&holderId=$holderId&' + formVar;
      mvc_post_ajax_var(vars);
    ";
      
    global $wpdb;
    $sql = "
      SELECT cmn_id, cmn_login, cmn_senha, cmn_nome, cmn_telefone, cmn_dtcadastro, cmn_validade, cmn_ativo
      FROM tb_curso_croche_multi_neg
      WHERE cmn_id = ".esc_sql($cmnId)."
    ";
    $result = $wpdb->get_results($sql, 'ARRAY_A');
    if($wpdb->last_error !== ''){
        
    } else {
      foreach($result as $row){
        $Aluno['cmn_id']         = $row['cmn_id'];
        $Aluno['cmn_login']      = $row['cmn_login'];
        $Aluno['cmn_senha']      = $row['cmn_senha'];
        $Aluno['cmn_nome']       = $row['cmn_nome'];
        $Aluno['cmn_telefone']   = $row['cmn_telefone'];
        $Aluno['cmn_dtcadastro'] = $row['cmn_dtcadastro'];
        $Aluno['cmn_validade']   = $row['cmn_validade'];
        $Aluno['cmn_ativo']      = $row['cmn_ativo'];
      }
    }
  }
  // =============
  $vCmnId         = (isset($Aluno['cmn_id'])) ? $Aluno['cmn_id']: '';
  $vCmnLogin      = (isset($Aluno['cmn_login'])) ? $Aluno['cmn_login']: '';
  $vCmnSenha      = (isset($Aluno['cmn_senha'])) ? $Aluno['cmn_senha']: '';
  $vCmnNome       = (isset($Aluno['cmn_nome'])) ? $Aluno['cmn_nome']: '';
  $vCmnTelefone   = (isset($Aluno['cmn_telefone'])) ? $Aluno['cmn_telefone']: '';
  $vCmnDtCadastro = (isset($Aluno['cmn_dtcadastro'])) ? date('d/m/Y', strtotime($Aluno['cmn_dtcadastro'])): '';
  $vCmnValidade   = (isset($Aluno['cmn_validade'])) ? date('d/m/Y', strtotime($Aluno['cmn_validade'])): '';
  $vCmnAtivo      = (isset($Aluno['cmn_ativo'])) ? $Aluno['cmn_ativo']: '';
  // =============
    
  $html  = "";
  $html .= "<h2 class='nav-tab-wrapper' style='padding-left:0; padding-right:0; '>";
  $html .= "  <a class='nav-tab nav-tab-active' href='javascript:;'>$TAB_TITLE</a>";
  $html .= "</h2>";
  $html .= "<div id='frmAddAluno'>";
  $html .= "  <table class='form-table'>";
  $html .= "    <tbody>";
  if(!$EH_INSERT){
    $html .= "      <tr class='js_sub ao_adv' valign='top'>";
    $html .= "        <th scope='row'>";
    $html .= "          ID:";
    $html .= "        </th>";
    $html .= "        <td>";
    $html .= "          <label>";
    $html .= "            <input type='hidden' name='id' value='$vCmnId' />";
    $html .= "            <input readonly type='text' style='width:100%;' name='txt_id' value='$vCmnId' maxlength='100' />";
    $html .= "            <i>Identificador no banco de dados</i>";
    $html .= "          </label>";
    $html .= "        </td>";
    $html .= "      </tr>";
  }
  $html .= "      <tr class='js_sub ao_adv' valign='top'>";
  $html .= "        <th scope='row'>";
  $html .= "          Login:";
  $html .= "        </th>";
  $html .= "        <td>";
  $html .= "          <label>";
  $html .= "            <input type='text' style='width:100%;' name='login' value='$vCmnLogin' maxlength='100' />";
  $html .= "            <i>Email do aluno</i>";
  $html .= "          </label>";
  $html .= "        </td>";
  $html .= "      </tr>";
  $html .= "      <tr class='js_sub ao_adv' valign='top'>";
  $html .= "        <th scope='row'>";
  $html .= "          Senha:";
  $html .= "        </th>";
  $html .= "        <td>";
  $html .= "          <label>";
  $html .= "            <input type='password' style='width:100%;' name='senha' value='' maxlength='50' />";
  $html .= "            <i>A senha deve conter letras e números, ter pelo menos 8 caracteres e um caracter maiúsculo</i>";
  $html .= "          </label>";
  $html .= "        </td>";
  $html .= "      </tr>";
  $html .= "      <tr class='js_sub ao_adv' valign='top'>";
  $html .= "        <th scope='row'>";
  $html .= "          Nome:";
  $html .= "        </th>";
  $html .= "        <td>";
  $html .= "          <label>";
  $html .= "            <input type='text' style='width:100%;' name='nome' value='$vCmnNome' maxlength='100' />";
  $html .= "            <i>Nome completo do aluno: Ex: João da Silva</i>";
  $html .= "          </label>";
  $html .= "        </td>";
  $html .= "      </tr>";
  $html .= "      <tr class='js_sub ao_adv' valign='top'>";
  $html .= "        <th scope='row'>";
  $html .= "          Telefone:";
  $html .= "        </th>";
  $html .= "        <td>";
  $html .= "          <label>";
  $html .= "            <input type='text' style='width:100%;' name='telefone' value='$vCmnTelefone' maxlength='25' />";
  $html .= "            <i>No formato (DDD) XXXXX-XXXX</i>";
  $html .= "          </label>";
  $html .= "        </td>";
  $html .= "      </tr>";
  if(!$EH_INSERT){
    $html .= "      <tr class='js_sub ao_adv' valign='top'>";
    $html .= "        <th scope='row'>";
    $html .= "          Cadastro:";
    $html .= "        </th>";
    $html .= "        <td>";
    $html .= "          <label>";
    $html .= "            <input readonly type='text' style='width:100%;' name='cadastro' value='$vCmnDtCadastro' maxlength='10' />";
    $html .= "            <i>Data de cadastro do aluno</i>";
    $html .= "          </label>";
    $html .= "        </td>";
    $html .= "      </tr>";
  }
  $html .= "      <tr class='js_sub ao_adv' valign='top'>";
  $html .= "        <th scope='row'>";
  $html .= "          Validade:";
  $html .= "        </th>";
  $html .= "        <td>";
  $html .= "          <label>";
  $html .= "            <input type='text' style='width:100%;' name='validade' value='$vCmnValidade' maxlength='10' />";
  $html .= "            <i>Data limite de acesso ao curso. Formado: DD/MM/YYYY</i>";
  $html .= "          </label>";
  $html .= "        </td>";
  $html .= "      </tr>";
  if(!$EH_INSERT){
    $naoSelected = ($vCmnAtivo == 0) ? 'selected': '';
    $simSelected = ($vCmnAtivo == 1) ? 'selected': '';
    
    $htmlAtivo = "
      <select name='ativo'>
        <option $naoSelected value='0'>Não</option>
        <option $simSelected value='1'>Sim</option>
      </select>
    ";
      
    $html .= "      <tr class='js_sub ao_adv' valign='top'>";
    $html .= "        <th scope='row'>";
    $html .= "          Ativo:";
    $html .= "        </th>";
    $html .= "        <td>";
    $html .= "          <label>";
    $html .= "            $htmlAtivo";
    $html .= "          </label>";
    $html .= "        </td>";
    $html .= "      </tr>";
  }
  $html .= "    </tbody>";
  $html .= "  </table>";
  $html .= "</div>";
  $html .= "<hr />";
  $html .= "<center>";
  $html .= "  <input type='button' class='button-primary cfs_add_field' value='Salvar' onClick=\" $jsSalvar \" />";
  $html .= "  &nbsp;";
  $html .= "  <a class='button' href='javascript:;' onClick=\" $jsCancelar \">";
  $html .= "    Voltar";
  $html .= "  </a>";
  $html .= "</center>";
  
  return $html;
}

function getHtmlListaAluno($holderId)
{
  global $wpdb;
  $html  = "";
  
  $sql = "
    SELECT cmn_id, cmn_login, cmn_nome, cmn_telefone, cmn_dtcadastro, cmn_validade, CASE cmn_ativo WHEN 0 THEN 'Não' ELSE 'Sim' END AS ativo
    FROM tb_curso_croche_multi_neg
    ORDER BY cmn_nome
  ";
  $results    = $wpdb->get_results($sql, 'ARRAY_A');
  $numResults = count($results);
  if($numResults <= 0){
    $html .= '<div class="notice notice-info">';
    $html .= '  <div style="margin:10px 0">';
    $html .= '    Nenhum aluno cadastrado';
    $html .= '  </div>';
    $html .= '</div>';
  } else {
    $html .= "<table id='tabela-cadastro-alunos' class='display data_table' style='width:100%'>";
    $html .= "  <thead>";
    $html .= "    <tr>";
    $html .= "      <th>ID</th>";
    $html .= "      <th>Nome</th>";
    $html .= "      <th>Login</th>";
    $html .= "      <th>Telefone</th>";
    $html .= "      <th>Cadastro</th>";
    $html .= "      <th>Validade</th>";
    $html .= "      <th>Ativo</th>";
    $html .= "      <th>Alterar</th>";
    $html .= "    </tr>";
    $html .= "  </thead>";
    $html .= "  <tbody>";
    foreach($results as $row){
      $vId         = $row["cmn_id"];
      $vLogin      = $row["cmn_login"];
      $vNome       = $row["cmn_nome"];
      $vTelefone   = $row["cmn_telefone"];
      $vDtCadastro = $row["cmn_dtcadastro"];
      $vDtValidade = $row["cmn_validade"];
      $vAtivo      = $row["ativo"];
      
      $vDtCadastro_F = (strlen($vDtCadastro) == 10) ? date('d/m/Y', strtotime($vDtCadastro)): '';
      $vDtValidade_F = (strlen($vDtValidade) == 10) ? date('d/m/Y', strtotime($vDtValidade)): '';
      
      $jsEdit = "
        var vars = 'acao=telaEditaAluno&cmn_id=$vId&holderId=$holderId';
        mvc_post_ajax_var(vars);
      ";
      
      $html .= "  <tr>";
      $html .= "    <td>$vId</td>";
      $html .= "    <td>$vNome</td>";
      $html .= "    <td>$vLogin</td>";
      $html .= "    <td>$vTelefone</td>";
      $html .= "    <td>$vDtCadastro_F</td>";
      $html .= "    <td>$vDtValidade_F</td>";
      $html .= "    <td>$vAtivo</td>";
      $html .= "    <td><a href='javascript:;' onClick=\" $jsEdit \"><span class='dashicons dashicons-text-page'></span></a></td>";
      $html .= "  </tr>";
    }
    $html .= "  </tbody>";
    $html .= "  <tfoot>";
    $html .= "    <tr>";
    $html .= "      <th>ID</th>";
    $html .= "      <th>Nome</th>";
    $html .= "      <th>Login</th>";
    $html .= "      <th>Telefone</th>";
    $html .= "      <th>Cadastro</th>";
    $html .= "      <th>Validade</th>";
    $html .= "      <th>Ativo</th>";
    $html .= "      <th>Alterar</th>";
    $html .= "    </tr>";
    $html .= "  </tfoot>";
    $html .= "</table>";
  }
    
  return $html;
}

function validaSenha($senha)
{
  $uppercase = preg_match('@[A-Z]@', $senha);
  $lowercase = preg_match('@[a-z]@', $senha);
  $number    = preg_match('@[0-9]@', $senha);
  
  if (!$uppercase || !$lowercase || !$number || strlen($senha) < 8) {
    // A senha deve conter letras e números, ter pelo menos 8 caracteres e um caracter maiúsculo!
    return false;
  } else {
    return true;
  }
}

function isValidDate($date, $format = 'Y-m-d H:i:s')
{
  $d = DateTime::createFromFormat($format, $date);
  return $d && $d->format($format) == $date;
}

function acerta_data($dt)
{
  if (!preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/', $dt)){
    return null;
  }
  $temp = explode('/', $dt);
  $dt_F = $temp [2].'-'.$temp [1].'-'.$temp [0];
  
  if(isValidDate($dt_F, 'Y-m-d')){
    return $dt_F;
  } else {
    return null;
  }
}

function initClientesCrocheMultiNegocio($post)
{
  $arrRet                  = [];
  $arrRet["html_selector"] = "";
  $arrRet["html"]          = "";
  
  // variaveis
  $holderId    = $post["holderId"] ?? "";
  $btnAddAluno = getHtmlBtnAddAluno($holderId);
  $htmlLista   = getHtmlListaAluno($holderId);
  // =========

  $html  = "";
  $html .= "<div id='dv-box-croche-multi-negocio' class='postbox'>";
  $html .= "  <button type='button' class='handlediv' aria-expanded='true'>";
  $html .= "    <span class='screen-reader-text'>Alternar painel: Cadastro de Alunos</span>";
  $html .= "    <span onClick=\"closeBox('dv-box-croche-multi-negocio')\" class='toggle-indicator' aria-hidden='true'></span>";
  $html .= "  </button>";
  $html .= "  <h2 class='hndle ui-sortable-handle'><span>Cadastro de Alunos</span></h2>";
  $html .= "  <div class='inside'>";
  $html .= "    <p class='hide-if-no-js' id='novo-aluno'>";
  $html .= "      $btnAddAluno";
  $html .= "    </p>";
  $html .= "    <div>";
  $html .= "      $htmlLista";
  $html .= "    </div>";
  $html .= "  </div>";
  $html .= "</div>";
  
  $arrRet["html_selector"] = "#$holderId";
  $arrRet["html"]          = $html;
  
  echo json_encode($arrRet);
}

function telaCadastroAluno($post)
{
  $arrRet                  = [];
  $arrRet["html_selector"] = "";
  $arrRet["html"]          = "";
  
  // variaveis
  $holderId = $post["holderId"] ?? "";
  $html     = getHtmlFormAluno($holderId);
  // =========

  $arrRet["html_selector"] = "#$holderId .inside";
  $arrRet["html"]          = $html;
  
  echo json_encode($arrRet);
}

function postAddAluno($post)
{
  $arrRet = [];
  $arrRet["msg"]        = '';
  $arrRet["msg_titulo"] = '*';
  $arrRet["msg_tipo"]   = '*';
  $arrRet["callback"]   = '';
  
  // variaveis
  $login    = $post["login"] ?? "";
  $senha    = $post["senha"] ?? "";
  $nome     = $post["nome"] ?? "";
  $telefone = $post["telefone"] ?? "";
  $validade = $post["validade"] ?? "";
  $holderId = $post["holderId"] ?? "";
  
  $validade_F = acerta_data($validade);
  // =========
  
  if( !filter_var($login, FILTER_VALIDATE_EMAIL) ){
    $arrRet["msg"] = 'Informe um email válido!';
  } else if( !validaSenha($senha) ){
    $arrRet["msg"] = 'A senha deve conter letras e números, ter pelo menos 8 caracteres e um caracter maiúsculo!';
  } else if( strlen($nome) < 5 ){
    $arrRet["msg"] = 'Informe um nome válido!';
  } else if( strlen($telefone) < 11 ){
    $arrRet["msg"] = 'Informe um telefone válido!';
  } else if( $validade_F == null ){
    $arrRet["msg"] = 'Informe uma data de validade válida!';
  } else if($validade_F <= date('Y-m-d')) {
    $arrRet["msg"] = 'A data de validade deve ser maior que hoje!';
  } else {
    $login_F    = esc_sql($login);
    $senha_F    = esc_sql(md5($senha));
    $nome_F     = esc_sql($nome);
    $telefone_F = esc_sql($telefone);
    $validade_F = esc_sql($validade_F);
      
    global $wpdb;
    $sql = "
      INSERT INTO tb_curso_croche_multi_neg(cmn_login, cmn_senha, cmn_nome, cmn_telefone, cmn_dtcadastro, cmn_validade, cmn_ativo)
      VALUES ('$login_F', '$senha_F', '$nome_F', '$telefone_F', NOW(), '$validade_F', 1)
    ";
    $wpdb->get_results($sql, 'ARRAY_A');
    if($wpdb->last_error !== ''){
      $arrRet["msg"] = 'Erro ao inserir aluno! Msg: ' . $wpdb->last_error;
    } else {
      $arrRet["msg"]      = 'Aluno inserido com sucesso!';
      //$arrRet["callback"] = "var vars = 'acao=initClientesCrocheMultiNegocio&holderId=$holderId'; mvc_post_ajax_var(vars);";
    }
  }
  
  echo json_encode($arrRet);
}

function telaEditaAluno($post)
{
  $arrRet                  = [];
  $arrRet["html_selector"] = "";
  $arrRet["html"]          = "";
  
  // variaveis
  $holderId = $post["holderId"] ?? "";
  $cmnId    = $post["cmn_id"] ?? "";
  $html     = getHtmlFormAluno($holderId, $cmnId);
  // =========

  $arrRet["html_selector"] = "#$holderId .inside";
  $arrRet["html"]          = $html;
  
  echo json_encode($arrRet);
}

function postEditAluno($post)
{
  $arrRet = [];
  $arrRet["msg"]        = '';
  $arrRet["msg_titulo"] = '*';
  $arrRet["msg_tipo"]   = '*';
  $arrRet["callback"]   = '';
  
  // variaveis
  $id       = $post["id"] ?? "";
  $login    = $post["login"] ?? "";
  $senha    = $post["senha"] ?? "";
  $nome     = $post["nome"] ?? "";
  $telefone = $post["telefone"] ?? "";
  $validade = $post["validade"] ?? "";
  $ativo    = $post["ativo"] ?? "";
  $holderId = $post["holderId"] ?? "";
  
  $validade_F = acerta_data($validade);
  // =========
  
  if(!($id > 0)){
    $arrRet["msg"] = 'Informe um ID válido!';  
  } elseif( !filter_var($login, FILTER_VALIDATE_EMAIL) ){
    $arrRet["msg"] = 'Informe um email válido!';
  } else if( !validaSenha($senha) && strlen($senha) > 0 ){
    $arrRet["msg"] = 'A senha deve conter letras e números, ter pelo menos 8 caracteres e um caracter maiúsculo!';
  } else if( strlen($nome) < 5 ){
    $arrRet["msg"] = 'Informe um nome válido!';
  } else if( strlen($telefone) < 11 ){
    $arrRet["msg"] = 'Informe um telefone válido!';
  } else if( $validade_F == null ){
    $arrRet["msg"] = 'Informe uma data de validade válida!';
  } else if($validade_F <= date('Y-m-d')) {
    $arrRet["msg"] = 'A data de validade deve ser maior que hoje!';
  } else if( $ativo != 0 && $ativo != 1 ){
    $arrRet["msg"] = 'Informe se o aluno está ativo ou não!';  
  } else {
    // formata as variaveis
    $id_F       = esc_sql($id);
    $login_F    = esc_sql($login);
    if(strlen($senha) > 0){
      $senha_F  = "'".esc_sql(md5($senha))."'";
    } else {
      $senha_F  = "cmn_senha";
    }
    $nome_F     = esc_sql($nome);
    $telefone_F = esc_sql($telefone);
    $validade_F = esc_sql($validade_F);
    $ativo_F    = esc_sql($ativo);
    // ====================
      
    global $wpdb;
    $sql = "
      UPDATE tb_curso_croche_multi_neg
      SET  cmn_login    = '$login_F'
          ,cmn_senha    = $senha_F
          ,cmn_nome     = '$nome_F'
          ,cmn_telefone = '$telefone_F'
          ,cmn_validade = '$validade_F'
          ,cmn_ativo    = $ativo_F
      WHERE cmn_id = $id_F
    ";
    $wpdb->get_results($sql, 'ARRAY_A');
    if($wpdb->last_error !== ''){
      $arrRet["msg"] = 'Erro ao editar aluno! Msg: ' . $wpdb->last_error;
    } else {
      $arrRet["msg"]      = 'Aluno editado com sucesso!';
      //$arrRet["callback"] = "var vars = 'acao=initClientesCrocheMultiNegocio&holderId=$holderId'; mvc_post_ajax_var(vars);";
    }
  }
  
  echo json_encode($arrRet);
}