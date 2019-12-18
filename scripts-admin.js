//var HOME_URL = "/home/croche/public_html/wp-content/themes/croche2019/";
var HOME_URL = "https://crochepassoapasso.com.br/wp-content/themes/croche2019/includes_croche_meu_negocio/";

jQuery( document ).ready(function() {
  var postId = jQuery('#post #post_ID').val();
  var boxCustomFields = jQuery('#cfs_input_2122');
  
  if(postId == 2116 && boxCustomFields.length > 0){
    initClientesCrocheMultiNegocio();
  }
});

function closeBox(idBox){
  jQuery('#'+idBox+' .inside').toggle();
  var styleFechado = jQuery('#'+idBox+' .inside').css('display');
      
  if(styleFechado == 'block'){
    //aberto
    jQuery('#'+idBox+' .handlediv').attr('aria-expanded', false);
    jQuery('#'+idBox+'').removeClass('closed');
  } else {
    //fechado
    jQuery('#'+idBox+' .handlediv').attr('aria-expanded', true);
    jQuery('#'+idBox+'').addClass('closed');
  }
}

function initJquery()
{
  jQuery('.data_table').DataTable();
}

function mostraNotificacao(titulo, msg, tipo)
{
  alert(msg);
}

function process_mvc_ret(data)
{
  if(typeof data.callback !== 'undefined'){
    if(data.callback !== ""){
      setTimeout(data.callback, 350);
    }
  }

  if(typeof data.msg !== 'undefined' && typeof data.msg_titulo !== 'undefined' && typeof data.msg_tipo !== 'undefined'){
    if(data.msg !== "" && data.msg_titulo !== "" && data.msg_tipo !== ""){
      mostraNotificacao(data.msg_titulo, data.msg, data.msg_tipo);
    }
  }

  if(typeof data.html_selector !== 'undefined'){
    var append = false;
    if(data.html_append !== 'undefined'){
      append = data.html_append;
    }

    if(data.html_selector !== ""){
      var vHtml = "";
      if(typeof data.html !== "undefined"){
        vHtml = data.html;
      }
      
      if(append){
        jQuery(data.html_selector).append(vHtml);
      } else {
        jQuery(data.html_selector).html(vHtml);
      }
    }
  }
}

function mvc_post_ajax_var(vars)
{
  jQuery.ajax({
    url     : HOME_URL + 'json_admin_clientes.php',
    data    : vars,
    type    : 'POST',
    dataType: 'json',
    error: function () {
      mostraNotificacao('Aviso!', 'Erro ao carregar página.', 'danger');
    },
    beforeSend: function () {
      
    },
    success: function (data) {
      process_mvc_ret(data);
      setTimeout(function(){
        initJquery();
      }, 500);
    }
  });
}

function initClientesCrocheMultiNegocio()
{
  // cria a holder inicial
  var holderId = 'holderClientesCrocheMultiNegocio';
  jQuery('#cfs_input_2122').after('<div id="'+holderId+'"></div>');
    
  var vars = 'acao=initClientesCrocheMultiNegocio&holderId='+holderId;
  mvc_post_ajax_var(vars);
}