<html>
<head>
    <title>Chat with us</title>
</head>
<body>
<script>
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1'; 
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<div class="fb-customerchat"
     page_id="505487326557587>"
     logged_in_greeting="How can we help you shop today?"
     logged_out_greeting="How can we help you shop today?"
     theme_color="#5c9165">
</div>
<script type="text/javascript">
    window.onload=function (){

    var userName='xiaoming';

    alert(userName);
 FB.CustomerChat.show(true);FB.CustomerChat.showDialog();
}
</script>
</body>
</html>