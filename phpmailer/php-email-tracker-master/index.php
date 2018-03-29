<?php
//index.php

require("../class/class.phpmailer.php"); 
require("../class/class.smtp.php"); 


$message = '';
$name = '';
$correo = '';
$imagen = '<img src="tracker.php?image=tracking.gif" alt="">';
$img = 'http://amarokdatacenter.cl/phpmailer/php-email-tracker-master/tracker.php?image=banner.jpg';
// $img = '<img src="http://amarokdatacenter.cl/phpmailer/php-email-tracker-master/images/banner.jpg" alt="">';
function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}



if(isset($_POST["submit"]))
{
    $name = $_POST["name"];
    $correo = $_POST["email"];
    $message .= '
    <html>
		<h3 align="center">Información</h3>
		<table border="1" width="100%" cellpadding="5" cellspacing="5">
			<tr>
				<td width="30%">Nombre</td>
				<td width="70%">'.$name.'</td>
			</tr>
			<tr>
				<td width="30%">Email</td>
				<td width="70%">'.$correo.'</td>
            </tr>
            <tr>
				<td width="30%">img</td>
				<td width="70%">'.$img.'</td>
            </tr>
        </table>
    </html>
	';
	

	$mail = new PHPMailer;
	// $mail->IsSMTP();								//Sets Mailer to send message using SMTP
                                                    //Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
                                                    // 0 = off (producción)
                                                    // 1 = client messages
                                                    // 2 = client and server messages
	$mail->CharSet = 'UTF-8';
	$mail->SMTPDebug  = 1;
	$mail->Host = 'smtp.gmail.com';					//Sets the SMTP hosts of your Email hosting, this for Godaddy
	                                                //El puerto será el 465 ya que usamos encriptación TLS
	                                                //El puerto 587 es soportado por la mayoría de los servidores SMTP y es útil para conexiones no encriptadas (sin TLS)
	$mail->Port = '465';							//Sets the default SMTP server port
	                                                //Definmos la seguridad como TLS
	$mail->SMTPSecure = 'tls';
	$mail->Username = 'correoquerecibe@gmail.com';		//Sets SMTP username
	$mail->Password = 'password';					//Sets SMTP password
	$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables

	$mail->From = $correo;					        //Sets the From email address for the message
	$mail->FromName = $name;				        //Sets the From name of the message
	$mail->AddAddress('pruebaamarok@gmail.com', 'mail tracking');		//Adds a "To" address
	                                                //Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
	// $mail->MsgHTML($message);
	$html = file_get_contents('http://amarokdatacenter.cl/phpmailer/php-email-tracker-master/email.html');
	$mail->msgHTML($html);                                                 //Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
	// $mail->AltBody = $message;
	$mail->AltBody = $html;
	$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
	$mail->IsHTML(true);							//Sets message type to HTML
	// $mail->AddAttachment($img);					//Adds an attachment from a path on the filesystem
	$mail->Subject = 'Prueba tracking correos';		//Sets the Subject of the message
	// $mail->Body = $message;							//An HTML or plain text message body
	$mail->Body = $html;
	if($mail->Send())								//Send an Email. Return true on success or false on error
	{
		$message = '<div class="alert alert-success">Email enviado correctamente</div>';
		// unlink($path);
	}
	else
	{
		$message = '<div class="alert alert-danger">Error al intentar enviar el email '.$mail->ErrorInfo.'</div>';
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Enviar email en php usando phpmailer</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-12" style="margin:0 auto; float:none;">
					<h3 align="center">Enviar email usando phpmailer</h3>
					<br />
					<h4 align="center">Registrar </h4><br />
					<?php print_r($message); ?>
					<form method="post">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Ingrese Nombre</label>
									<input type="text" name="name" placeholder="Ingrese Nombre" class="form-control" required />
								</div>
								
								<div class="form-group">
									<label>Ingrese Dirección de email</label>
									<input type="email" name="email" class="form-control" placeholder="Dirección de email" required />
								</div>
							</div>
							</div>
						</div>
						<div class="form-group" align="center">
							<input type="submit" name="submit" value="Submit" class="btn btn-info" />
						</div>
					</form>
				</div>
			</div>
        </div>
        <!-- <img src="tracker.php?image=tracking.gif" alt=""> -->
	</body>
</html>





