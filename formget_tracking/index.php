<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Email Open Tracking Using PHP</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/myjs.js" type="text/javascript"></script>
<link href="css/style.css" rel="stylesheet" type="text/css"/>

</head>
<body>
<div id="main">
<h1>Email Open Tracking Using PHP</h1>
<div id="login">
<h2>Send Email</h2>
<hr/>
<form id="form1" method="post">
<div id="box">
<input type="email" placeholder="To : Email Id " name="mailto" required/>
<input type="text" placeholder="Subject : " name="subject" required/>
<textarea rows="2" cols="50" placeholder="Mensaje : Este es un mensaje de prueba para saber cuando el correo es leido...." name="message" readonly ></textarea>
<input type="submit" value="Send" name="send" />
</div>
</form>

<div id="loading-image"><img src="https://media.giphy.com/media/xTk9ZvMnbIiIew7IpW/giphy.gif" alt="Sending....."/></div>

<form id="form2" method="post">
<div id="view"></div><br><br>
<div id="readstatus"></div>
<input type="submit" value="Track Status" id="track_mail" name="track"/>
</form>
</div>
</div>
</body>
</html>