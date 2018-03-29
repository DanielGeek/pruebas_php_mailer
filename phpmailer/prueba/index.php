<!DOCTYPE html>
<html>
<head>
    <title>Enviar correo HTML+CSS+Imagen+Adjunto desde Localhost</title>
</head>
<body>
    <form method="POST" action="enviacor.php" enctype="multipart/form-data">
        <label>Destinatarios</label><br>
        <input type="text" style="width: 500px;" name="txtDestin" value="pruebaamarok@gmail.com, daniel30081990@gmail.com"><br>
        <label>Asunto</label><br>
        <input type="text" style="width: 500px;" name="txtAsunto" value = "Probando mensaje HTML"><br>
        <label>Mensaje HTML</label><br>
        <textarea name="txtMensa" style="width: 500px; height: 150px;"></textarea><br>
        <label>Imagen en el mensaje</label><br>
        <input type="file" name="txtImagen" accept="image/x-png,image/gif,image/jpeg"><br>
        <label>Archivo adjunto</label><br>
        <input type="file" name="txtAdjun" accept=".zip"><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>