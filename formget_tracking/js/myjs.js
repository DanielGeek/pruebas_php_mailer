$(document).ready(function()
{
$('#loading-image').hide();
//-------------------------------------------first ajax call to submit form1 and send email then receieve response HTML-----//
$("form#form1").submit(function()
{
$('#box').slideUp('fast');
$('#loading-image').show();
var d = $("#form1").serialize();
$.ajax({type: 'POST',
url: "tracker.php",
data: d,
dataType: 'html',
success: function(data)
{ $('form#form2').css("display","block");
$('#view').html(data);
$('#loading-image').hide();
$('#track_mail').css("visibility", "visible");
},
error: function() {
alert("oops! something went wrong....");
}
});
return false;
});
//-------------------------------------------first ajax call to submit form1 and send email then receieve response HTML-----//
$("form#form2").submit(function()
{
var d = $("#form2").serialize();
$.ajax({type: 'POST',
url: "tracker.php",
data: d,
dataType: 'html',
success: function(data)
{
$('#readstatus').html(data);
},
error: function() {
alert("oops");
}
});
return false;
});
});