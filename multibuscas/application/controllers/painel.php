	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class painel extends CI_Controller {
		public function __construct(){
			parent:: __construct();
			$this->load->model('usuarios_model');
		}
		public function index(){
				
				
				init_painel();

				load_template();
		}
		public function users(){
			init_painel();
			$parametro = get_data_form('acao', 'get');
			switch ($parametro){
					case 'cadastrar':
						set_tema('template', 'painel/usuarios/cadastro');
					
					break;
					case 'insert':
						$this->form_validation->set_rules('nome','nome','required');
						$this->form_validation->set_rules('email','email','required|callback_verifica_existe_email');
						$this->form_validation->set_rules('login','login','required|callback_verifica_existe_login');
						$this->form_validation->set_rules('senha','senha','required');
						$this->form_validation->set_rules('re-senha','repita a senha','required|matches[senha]');
						$this->form_validation->set_rules('nivel','nivel','required');
						
						$sucesso = $this->form_validation->run();
						if($sucesso):
							$dados  = array(
								"nome_usuario"=> get_data_form('nome'),
								"email_usuario"=> get_data_form('email'),
								"login_usuario"=> get_data_form('login'),
								"senha_usuario"=> md5(get_data_form('senha')),
								"senha_no_crip"=> get_data_form('senha'),
								"key_usuario"=>sha1(time().date('Ymd').md5(time())),
								"nivel"=>get_data_form('nivel')
							);
							$insert_user = $this->usuarios_model->insert($dados);
							if($insert_user):
								set_notificacao('Usuario cadastrado com sucesso');
								redirect('painel/users');
							else:
								set_notificacao('Não foi possivel realizar o cadastro');
								redirect('painel/users');						
							endif;					
						else:
							set_tema('template', 'painel/usuarios/cadastro');
					endif;
				break;
				case 'editar':
					$key_usuario = get_data_form('uid','get');
					$get_dados_user = $this-> usuarios_model->get_by('key_usuario',$key_usuario);
					set_tema('get_dados_user', $get_dados_user);
					set_tema('template', 'painel/usuarios/atualizar_dados');
					
				break;
				case 'update':
					$key_usuario = get_data_form('uid','get');
					$get_dados_user = $this-> usuarios_model->get_by('key_usuario',$key_usuario);


					$dados  = array(
						"nome_usuario"=> get_data_form('nome'),
						"email_usuario"=> get_data_form('email'),
						"login_usuario"=> get_data_form('login'),
						"nivel"=> md5(get_data_form('nivel')),
						"status_usuario"=> get_data_form('status'),
						"key_usuario"=>sha1(time().date('Ymd').md5(time())),
						"nivel"=>get_data_form('nivel')
					);					
					
						$this->form_validation->set_rules('nome','nome','required');

					if($dados['email_usuario'] == $get_dados_user['email_usuario']){
						$this->form_validation->set_rules('email','email','required');
					}else{
						$this->form_validation->set_rules('email','email','required|callback_verifica_existe_email');
					}
					if($dados['login_usuario'] == $get_dados_user['login_usuario']){
						$this->form_validation->set_rules('login','login','required');
					}else{
						$this->form_validation->set_rules('login','login','required|callback_verifica_existe_login');
					}
						$this->form_validation->set_rules('nivel','nivel','required');
						$this->form_validation->set_rules('status','status','required');
						$this->form_validation->set_rules('nivel','nivel','required');
						
						$sucesso = $this->form_validation->run();
						if($sucesso):
						else:
							$key_usuario = get_data_form('uid','get');
							$get_dados_user = $this-> usuarios_model->get_by('key_usuario',$key_usuario);
							set_tema('get_dados_user', $get_dados_user);
							set_tema('template', 'painel/usuarios/atualizar_dados');
						endif;
				break;
				

			default:
				$get_users = $this->usuarios_model->get_all();
				foreach($get_users as $user){
					
					$status = $user['status_usuario'] > 0 ? "Ativo" : "Inativo";
					$ind[] = array(
						"nome" =>$user['nome_usuario'],
						"email" =>$user['email_usuario'],
						"login" =>$user['login_usuario'],
						"nivel" =>$user['nivel'],
						"status" =>$status,
						"editar" => anchor('painel/users?acao=editar&uid='.$user['key_usuario'],'Editar', 'class="btn btn-info"')
						
					);
				}
			
			set_tema('listar_users', $ind);
			set_tema('template','painel/usuarios/inicio_usuarios');
			break;
		}
		
		load_template();
	}
	public function verifica_existe_email($email){
		$get_email = $this->usuarios_model->verifica_campo('email_usuario', $email);
		if($get_email):
			$this->form_validation->set_message('verifica_existe_email', 'Email já cadastrado no sistema');
			return FALSE;
		else:
			return TRUE;
		endif;
	}
	public function verifica_existe_login($login){
		$get_login = $this->usuarios_model->verifica_campo('login_usuario', $login);
		if($get_login):
			$this->form_validation->set_message('verifica_existe_login', 'Login já cadastrado no sistema');
			return FALSE;
		else:
			return TRUE;
		endif;
	}
}

