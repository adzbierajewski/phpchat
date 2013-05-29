<?php require_once('load.php'); ?>
<?php
if(isset($_GET['getchats'])){
	if(isset($_SESSION['playername'])){
	echo get_chats('Y-m-d - H:i:s ');
	}
	exit;
}
if(isset($_GET['receive'])){
	if(isset($_SESSION['playername'])){
	add_chat(1, $_SESSION['playername'], $_POST['message']);
	exit;
	}
}
?>
<html>
<head>
	<?php
	if(isset($_SESSION['playername'])){?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script>
	function scrollToBottom(elm_id)
	{
	var elm = document.getElementById(elm_id);
	try
		{
		elm.scrollTop = elm.scrollHeight;
		}
	catch(e)
		{
		var f = document.createElement("input");
		if (f.setAttribute) f.setAttribute("type","text")
		if (elm.appendChild) elm.appendChild(f);
		f.style.width = "0px";
		f.style.height = "0px";
		if (f.focus) f.focus();
		if (elm.removeChild) elm.removeChild(f);
		}
	}
	$(window).load(function() {
  $("html, body").animate({ scrollTop: $(document).height() }, 1000);
});
	function loadPosts(){
		$.ajax({
			url: 'index.php?getchats=1',
			success: function(data) {
				$("#chats").html(data);
				$("html, body").animate({ scrollTop: $(document).height() }, 1000);
				setTimeout("loadPosts()", 1000);
			}
		});
		scrollToBottom('chats');
	}
	$(function(){
		loadPosts();
	});
	
	  $(function() {
    $(".button").click(function() {
		scrollToBottom('chats');
      // validate and process form here
      var message = $("input#message").val();  
        var dataString = 'fromwhere=1&message='+ message;
  //alert (dataString);return false;
  $.ajax({
    type: "POST",
    url: "index.php?receive=1",
    data: dataString,
    success: function() {
		scrollToBottom('chats');
		      $('#contact_form').html("<div id='message'></div>");
      $('#message').html("<h2>Contact Form Submitted!</h2>")
      .append("<p>We will be in touch soon.</p>")
      .hide()
      .fadeIn(1, function() {
        $('#message').append("<img id='checkmark' src='images/check.png' />");
      });
      $("input#message").val("");
    }
  });
  return false;
  
    });
  });
  
</script>
<?php } ?>
<style>
body {
background-color:#46214e;
	font-family: "Comic Sans MS", cursive, sans-serif;
	margin: 0;
	color:#E49B0F;
	background-position: left top;
    background-repeat: no-repeat;
}
#Nav1 {
background-color:#693275;
border-radius: 15px;
margin-top:110px;
}
#sf_navigation {
margin-top:100px;
border-radius: 15px;
}

ul#Nav1 li a{
	text-shadow:1px 1px #46214e;
	margin-left:10px;
	margin-right:10px;
	text-align:center;
	margin-top:1px;
	margin-bottom:1px;
	background-color:#9DC209;
	color:#E49B0F;
	border-radius: 15px;
}
.sf_pagetitle{
	text-shadow:1px 1px #46214e;
}
.sf_main_wrapper{
	margin-left:10px;
	margin-right:10px;
	margin-top:10px;
	margin-top:1px;
	margin-bottom:1px;
	border-radius: 15px;
	background-color:#46214e;
}
.LayoutContainer{
	border-radius: 15px;
	background-color:#9DC209;
}
</style>
</head>
<body>
	<?php
	if(isset($_SESSION['playername'])){?>
		<div name="chats" id="chats" class="chats" height="200px" style="">
		</div>
		<form>
		<input type="text" name="message" id="message" class="text-input" size="100%"/>
		<input type="submit" name="submit" class="button" id="submit_btn" value="Send" /> 
		</form>
	<?php } else {?>
		<?php
		require_once('recaptchalib.php');
		if(isset($_POST['playername'])){
			  if ($_POST["recaptcha_response_field"]) {
        $resp = recaptcha_check_answer ('6LdkNsUSAAAAAE-h--n2TeQxniTJ522nYe9Qb7lB',
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
        if ($resp->is_valid) {
			$_SESSION['playername'] = clean_input($_POST['playername']);
			echo '<script>window.location="http://localhost/chat"</script>';
		} else {
			echo '<p>The captcha was wrong...</p>'; 
		}
		}
	}
		?>
		<form name="login" action="" method="post">
			<label for="playername">Screen Name: </label><input type="text" name="playername" id="playername" />
			<?php echo recaptcha_get_html('6LdkNsUSAAAAAC4ODtxqqcRvdsHpwOoYwLJ-37yP', $error); ?>
			<input type="submit" name="submit" value="Log In" />
		</form>
	<?php } ?>
</body>
</html>
