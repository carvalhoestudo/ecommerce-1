<?php 

namespace Hcode;
use Rain\Tpl;
class Mailer {
	
	const USERNAME = "carenasml@gmail.com";
	const PASSWORD = "<senha>";
	const NAME_FROM = "Loja Ecommerce";
	private $mail;
	public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
	{
		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/",
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"         => false
	    );
		Tpl::configure( $config );
		$tpl = new Tpl;
		foreach ($data as $key => $value) {
			$tpl->assign($key, $value);
		}
		$html = $tpl->draw($tplName, true);

		$this->mail = new \PHPMailer;

		    //Configurações do servidor

		    $this->mail->setLanguage('pt_br');                   //Define a Linguagem Padrão do e-mail
		    $this->mail->SMTPDebug = 2;                          // Ativar saída de depuração detalhada
		    $this->mail->isSMTP();                               // Definir mailer para usar o SMTP
		    $this->mail->Host       = 'smtp.gmail.com';          // Especifique servidores SMTP principais e de backup
		    $this->mail->SMTPAuth   = true;                      // Ativar autenticação SMTP
		    $this->mail->Username   = Mailer::USERNAME;     	   // Nome de usuário SMTP
		    $this->mail->Password   = Mailer::PASSWORD;          // Senha SMTP
		    $this->mail->SMTPSecure = 'tls';                     // Ativar criptografia TLS, `ssl` também aceita
		    $this->mail->Port       = 587;                       // Porta TCP para conectar
			$this->mail->SMTPOptions = array(
		    'ssl' => [
		        'verify_peer' => true,
		        'verify_depth' => 3,
		        'allow_self_signed' => true,
		        'peer_name' => $this->mail->Host, 				//Mesmo endereço do HOST
		        'cafile' => '/etc/ssl/ca_cert.pem',
		    ],
		);

		    //Remetente
		    $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);

		    //Definir prioridade do email 1 = Alta Prioridade
		    $this->mail->Priority = 1;

		    // Adicionar um destinatário
		    $this->mail->addAddress($toAddress, $toName);

		    //Adicionar um segundo destinário com copia oculta
		    //$this->mail->addBCC('vncarvalhome@hotmail.com');

		    // Conteúdo

		    // Usar "true" se for usar templates no email ou "false" Caso Não utilize
		    $this->mail->isHTML(true);                                  

		    //Assunto(Título do e-mail)
		    $this->mail->Subject = $subject;

		    //converter HTML em um corpo alternativo de texto simples básico
		    $this->mail->msgHTML ($html);

		    //// Converte HTML em um corpo alternativo de texto simples básico
		    //$this->mail->Body    = 'Este é o corpo da mensagem em HTML <b>PHPMailer!</b>';
		    //$this->mail->AltBody = 'Este é o corpo em texto sem formatação para clientes de email não HTML';
	}

	public function send()
	{
		//return $this->mail->send();
	}

	
}

