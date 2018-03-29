<?php
    function SubirArchivo ($sfArchivo){
        $dir_subida = 'subidas/';
        $fichero_subido = $dir_subida . basename($_FILES[$sfArchivo]['name']);
        if (move_uploaded_file($_FILES[$sfArchivo]['tmp_name'], $fichero_subido)) {
            return $fichero_subido;
        } else {
            return "";
        }
    }

    set_time_limit(0);
    ignore_user_abort(true);
    /*RECOGER VALORES ENVIADOS DESDE INDEX.PHP*/
    $sDestino = $_POST['txtDestin'];
    $sAsunto = $_POST['txtAsunto'];
    $sMensaje = $_POST['txtMensa'];
    $sImagen = SubirArchivo('txtImagen');
    $sAdjunto = SubirArchivo('txtAdjun');

    date_default_timezone_set('Etc/UTC');
    require("../class/class.phpmailer.php"); 
    require("../class/class.smtp.php"); 
    
    /*CONFIGURACIÓN DE CLASE*/
        $mail = new PHPMailer;
        $mail->isSMTP(); //Indicar que se usará SMTP
        $mail->CharSet = 'UTF-8';//permitir envío de caracteres especiales (tildes y ñ)
    /*CONFIGURACIÓN DE DEBUG (DEPURACIÓN)*/
        $mail->SMTPDebug = 0; //Mensajes de debug; 0 = no mostrar (en producción), 1 = de cliente, 2 = de cliente y servidor
        $mail->Debugoutput = 'html'; //Mostrar mensajes (resultados) de depuración(debug) en html
    /*CONFIGURACIÓN DE PROVEEDOR DE CORREO QUE USARÁ EL EMISOR(GMAIL)*/
        $mail->Host = 'smtp.gmail.com'; //Nombre de host
        // $mail->Host = gethostbyname('smtp.gmail.com'); // Si su red no soporta SMTP sobre IPv6
        $mail->Port = 587; //Puerto SMTP, 587 para autenticado TLS
        $mail->SMTPSecure = 'tls'; //Sistema de encriptación - ssl (obsoleto) o tls
        $mail->SMTPAuth = true;//Usar autenticación SMTP
        $mail->SMTPOptions = array(
            'ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true)
        );//opciones para "saltarse" comprobación de certificados (hace posible del envío desde localhost)
    //CONFIGURACIÓN DEL EMISOR
        $mail->Username = "pruebaamarok@gmail.com";
        $mail->Password = "amarok123";
        $mail->setFrom('no-reply@amarokdatacenter.cl', 'Luis');

    //CONFIGURACIÓN DEL MENSAJE, EL CUERPO DEL MENSAJE SERA UNA PLANTILLA HTML QUE INCLUYE IMAGEN Y CSS
        $mail->Subject = $sAsunto; //asunto del mensaje
        //incrustar imagen para cuerpo de mensaje(no confundir con Adjuntar)
            $mail->AddEmbeddedImage($sImagen, 'imagen'); //ruta de archivo de imagen
        //cargar archivo css para cuerpo de mensaje
            $rcss = "plantilla/estilo.css";//ruta de archivo css
            $fcss = fopen ($rcss, "r");//abrir archivo css
            $scss = fread ($fcss, filesize ($rcss));//leer contenido de css
            fclose ($fcss);//cerrar archivo css
        //Cargar archivo html   
            $shtml = file_get_contents('plantilla/email.html');
        //reemplazar sección de plantilla html con el css cargado y mensaje creado
            $incss  = str_replace('<style id="estilo"></style>',"<style>$scss</style>",$shtml);
            $cuerpo = str_replace('<p id="mensaje"></p>',$sMensaje,$incss);
        $mail->Body = $cuerpo; //cuerpo del mensaje
        $mail->AltBody = '---';//Mensaje de sólo texto si el receptor no acepta HTML

    //CONFIGURACIÓN DE ARCHIVOS ADJUNTOS 
        $mail->addAttachment($sAdjunto);

    //CONFIGURACIÓN DE RECEPTORES
        $aDestino = explode(",",$sDestino);
        foreach ( $aDestino as $i => $sDest){
            $mail->addAddress(trim($sDest), "Destinatario ".$i+1);
        }
    //ENVIAR MENSAJE
    if (!$mail->send()) {
        echo "Error al enviar: " . $mail->ErrorInfo;
    } else {
        echo "Mensaje enviado correctamente";
        //eliminar archivos temporales de carpeta subidas
        unlink($sImagen);
        unlink($sAdjunto);
    }
?>