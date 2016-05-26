<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {
	
	public function __construct(){
		parent:: __construct();
		$this->load->model("usuarios_model");
	}

	public function index()
	{

		var_dump($this->session->all_userdata());
		set_tema('css', load_css('normalize'),FALSE);
		set_tema('css', load_css('foundation'),FALSE);
		set_tema('template', 'login');
		
		load_template();
	}
	
	public function logar(){
		$dados_logar = array(
			"email"=>get_data_form('email'),
			"senha"=>md5(get_data_form('senha'))
		);
		$logar = $this->usuarios_model->logar($dados_logar);
		if($logar):
			$this->session->set_userdata('usuario_logado', $logar);
			redirect('painel');
		else:
			$this->session->unset_userdata('usuario_logado');
			redirect('login');
		endif;
		
	}
	public function sair(){
		$this->session->unset_userdata('usuario_logado');
		redirect('login');
	}
}
