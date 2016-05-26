<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Login - Painel</title>
	{css}
	</head>
<style>
	.mae{position: relative; min-height:100%;}
	#rodape{position: absolute; bottom: 0;}
	#rodape{background-color: #CCC; width:100%; height:30px; margin-top: 2em; position:absolute; bottom:0;}
	#copyriht {font-family: Vedana, Geneva, sans-serif; font-size: 15px; color:#999999; margin-top:5px}
</style>
<body>
	<div class="mae">
		<div class="topo">
			<div class="row">
				<div class="madium-12 columns">
					Topo
				</div>
			</div>
		</div>
		<div class="row">
			<div class="medium-5 columns small-centered">
				<fieldset>
					<legend>
					Identifique-se
					</legend>
					<?php
						echo form_open('login/logar');
						
						
							echo form_label('Email', 'login');
							echo form_input('email', set_value('login'), 'id="login"');
							echo form_label('Senha', 'senha');
							echo form_password('senha', NULL, 'id="senha"');
							
							echo form_submit('entrar','Login','class="button success tiny right radius"');
						echo form_close();
					?>
				</fieldset>
			</div>
		</div>
		<div id="rodape">
			<div class="row">
				<div class="medium-12 columns">
					<div id="copyright">
						<center> &copy; Todos os Direitos Reservavos para multibuscas.com</center>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
