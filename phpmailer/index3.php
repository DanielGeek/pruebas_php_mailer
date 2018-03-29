<?php
//index.php
require("class/class.phpmailer.php"); 

$message = '';

function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}

if(isset($_POST["submit"]))
{
	$programming_languages = '';
	foreach($_POST["programming_languages"] as $row)
	{
		$programming_languages .= $row . ', ';
	}
	$programming_languages = substr($programming_languages, 0, -2);//omite los 2 caracteres del final de la cadena, la coma y el espacio en este caso (, )
	$path = 'upload/' . $_FILES["resume"]["name"];
	move_uploaded_file($_FILES["resume"]["tmp_name"], $path);
	$message = '
		<h3 align="center">Información del programador</h3>
		<table border="1" width="100%" cellpadding="5" cellspacing="5">
			<tr>
				<td width="30%">Nombre</td>
				<td width="70%">'.$_POST["name"].'</td>
			</tr>
			<tr>
				<td width="30%">Dirección</td>
				<td width="70%">'.$_POST["address"].'</td>
			</tr>
			<tr>
				<td width="30%">Email</td>
				<td width="70%">'.$_POST["email"].'</td>
			</tr>
			<tr>
				<td width="30%">Lenguajes de programación conocidos</td>
				<td width="70%">'.$programming_languages.'</td>
			</tr>
			<tr>
				<td width="30%">Años de experiencia</td>
				<td width="70%">'.$_POST["experience"].'</td>
			</tr>
			<tr>
				<td width="30%">Número de télefono</td>
				<td width="70%">'.$_POST["mobile"].'</td>
			</tr>
			<tr>
				<td width="30%">Información adicional</td>
				<td width="70%">'.$_POST["additional_information"].'</td>
			</tr>
		</table>
	';
	

	$mail = new PHPMailer();  
	 
	$mail->IsSMTP();
	//Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
	// 0 = off (producción)
	// 1 = client messages
	// 2 = client and server messages
	$mail->CharSet = 'UTF-8';
	$mail->SMTPDebug  = 0;
	//Ahora definimos gmail como servidor que aloja nuestro SMTP
	$mail->Host       = 'smtp.gmail.com';
	//El puerto será el 465 ya que usamos encriptación TLS
	//El puerto 587 es soportado por la mayoría de los servidores SMTP y es útil para conexiones no encriptadas (sin TLS)
	$mail->Port       = 465;
	//Definmos la seguridad como TLS
	$mail->SMTPSecure = 'tls';
	//Tenemos que usar gmail autenticados, así que esto a TRUE
	$mail->SMTPAuth   = true;
	//Definimos la cuenta que vamos a usar. Dirección completa de la misma
	$mail->Username   = "correo@gmail.com";
	//Introducimos nuestra contraseña de gmail
	$mail->Password   = "psd";
	//Esta línea es por si queréis enviar copia a alguien (dirección y, opcionalmente, nombre)
	$mail->AddReplyTo('correo@gmail.com', 'Amarok');
	//Definimos el remitente (dirección y, opcionalmente, nombre)
	$mail->SetFrom($_POST["email"], $_POST["name"]);
	//Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
	$mail->AddAddress('correo@gmail.com');
	//Definimos el tema del email
	$mail->Subject = 'Formulario para programadores';
	//Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
	$mail->MsgHTML($message);
	//Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
	$mail->AltBody = $message;
	//Enviamos el correo
	if($mail->Send())								//Send an Email. Return true on success or false on error
	{
		$message = '<div class="alert alert-success">Email enviado correctamente</div>';
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
		<title>Enviar email con archivos adjuntos en php usando phpmailer</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<div class="row">
				<div class="col-md-8" style="margin:0 auto; float:none;">
					<h3 align="center">Enviar email con archivos adjuntos en php usando phpmailer</h3>
					<br />
					<h4 align="center">Registrar programador</h4><br />
					<?php print_r($message); ?>
					<form method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Ingrese Nombre</label>
									<input type="text" name="name" placeholder="Ingrese Nombre" class="form-control" required />
								</div>
								<div class="form-group">
									<label>Ingrese Dirección</label>
									<textarea name="address" placeholder="Ingrese Dirección" class="form-control" required></textarea>
								</div>
								<div class="form-group">
									<label>Ingrese Dirección de email</label>
									<input type="email" name="email" class="form-control" placeholder="Dirección de email" required />
								</div>
								<div class="form-group">
									<label>Seleccione Habilidad(es) de programación</label>
									<select name="programming_languages[]" class="form-control" multiple required style="height:150px;">
										<option value=".NET">.NET</option><option value="Android">Android</option><option value="ASP">ASP</option><option value="Blackberry">Blackberry</option><option value="C">C</option><option value="C++">C++</option><option value="COCOA">COCOA</option><option value="CSS">CSS</option><option value="DHTML">DHTML</option><option value="Drupal">Drupal</option><option value="Flash">Flash</option><option value="HTML">HTML</option><option value="HTML 5">HTML 5</option><option value="IPAD">IPAD</option><option value="IPHONE">IPHONE</option><option value="Java">Java</option><option value="Java Script">Java Script</option><option value="Joomla">Joomla</option><option value="LAMP">LAMP</option><option value="Linux">Linux</option><option value="MAC OS">MAC OS</option><option value="Magento">Magento</option><option value="MySQL">MySQL</option><option value="Oracle">Oracle</option><option value="PayPal">PayPal</option><option value="Perl">Perl</option><option value="PHP">PHP</option><option value="Ruby on Rails">Ruby on Rails</option><option value="Salesforce.com">Salesforce.com</option><option value="SEO">SEO</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Seleccione años de experiencia</label>
									<select name="experience" class="form-control" required>
										<option value="">Seleccione experiencia</option>
										<option value="0-1 año">0-1 año</option>
										<option value="2-3 años">2-3 años</option>
										<option value="4-5 años">4-5 años</option>
										<option value="6-7 años">6-7 años</option>
										<option value="8-9 años">8-9 años</option>
										<option value="10 o más años">10 o más años</option>
									</select>
								</div>
								<div class="form-group">
									<label>Ingrese número de Teléfono</label>
									<input type="text" name="mobile" placeholder="número de Teléfono" class="form-control" pattern="\d*" required />
								</div>
								<div class="form-group">
									<label>Enviar cvc</label>
									<input type="file" name="resume" accept=".doc,.docx, .pdf" required />
								</div>
								<div class="form-group">
									<label>Ingrese Información adicional</label>
									<textarea name="additional_information" placeholder="Información adicional" class="form-control" required rows="8"></textarea>
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
	</body>
</html>





