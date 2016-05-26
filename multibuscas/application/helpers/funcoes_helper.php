	<?php

	function load_css($arquivo=null, $media='screen', $import=FALSE, $echo =TRUE)
	{
		$css = '';
		if($import ==TRUE){
			$css = '<link rel="stylesheet" type="text/css" href="'.$arquivo.'" media="'.$media.'" />'."\n";
		}else{
			
			if($arquivo != NULL){
				if(file_exists('./assets/css/'.$arquivo.'.css')){
					$css = base_url('assets/css/'.$arquivo.'.css');
					
				}
				if($echo == TRUE){
					echo '<link rel="stylesheet" type="text/css" href="'.$css.'" media="'.$media.'" />'."\n";
				}else{
					return '<link rel="stylesheet" type="text/css" href="'.$css.'" media="'.$media.'" />'."\n";
				}
			}else{
				echo 'Arquivo não encontrado';
			}
		}
	} // Fim Load css
	function load_js($arquivo=NULL, $echo = TRUE)
	{
		if($arquivo != NULL)
		{
			if(file_exists('./assets/js/'.$arquivo.'.js'))
				{
					$arquivo = base_url('assets/js/'.$arquivo.'.js');
				}
			$js = '<script type="text/javascript" src="'.$arquivo.'"></script>'."\n";
			if($echo):
				echo $js;
			else:
				return $js;
			endif;
		}
	}// Fim load js
	
	define('MGSUCESSO',' success');
	define('MGALERT',' warning');
	define('MGINFO',' info');
	define('MGERROR',' alert ');
	
	function set_mensagem($texto,$tipo,$extras=NULL,$echo=TRUE){
		$mensagem='<div  data-alert class="alert-box'.$tipo.'" '.$extras.'>';
		$mensagem.=$texto;
		$mensagem.='<a href="#" class="close">&times;</a></div>';
		
		if ($echo):
			echo $mensagem;
		else:
			return $mensagem;
		endif;

	}
	function set_notificacao($mensagem=NULL,$tipo='success',$id_notificacao='ok'){
		$ci=& get_instance();
		$ci->load->library('session');
		$ci->session->set_flashdata($id_notificacao, set_mensagem($mensagem, $tipo,NULL,FALSE));
	}
	function get_notificacao($id_notificacao='ok'){
		$ci=& get_instance();
		$ci->load->library('session');
		return $ci->session->flashdata($id_notificacao);
	}
	
	
	function get_data_form($campo,$tipo='post'){
		$ci =& get_instance();
		return $ci->input->$tipo($campo);
	}
	
	function get_tema(){
		$ci =& get_instance();
		$ci->load->library('sistema');
		return $ci->sistema->tema;
	}
	function set_tema($propriedade, $valor,$replace = TRUE){
		$ci =& get_instance();
		$ci->load->library('sistema');
		if($replace):
			$ci->sistema->tema[$propriedade] = $valor;
		else: 
		if(!isset($ci->sistema->tema[$propriedade]))$ci->sistema->tema[$propriedade] ="";
		$ci->sistema->tema[$propriedade].= $valor;
		endif;
	}
	
	function load_template(){
		$ci =&get_instance();
		$ci->load->library('sistema');
		if (isset($ci->sistema->tema['header'])){
			$ci->parser->parse($ci->sistema->tema['header'], get_tema());
		}
		if(isset($ci->sistema->tema['template'])){
			$ci->parser->parse($ci->sistema->tema['template'], get_tema());
		}
		if(isset($ci->sistema->tema['footer'])){
			$ci->parser->parse($ci->sistema->tema['footer'], get_tema());
		}
	}
	function get_valor_sessao($valor=NULL, $nome_session='usuario_logado'){
		$ci =& get_instance();
		$ci->load->library('session');
		$get_session = $ci->session->userdata($nome_session);
		
		if($get_session){
			return $get_session[$valor];
		}else{
			return FALSE;
		}
		
	}
	function init_painel(){
			set_tema('header','painel/header');
			set_tema('footer','painel/footer');
//			set_tema('template','painel/index');

	}