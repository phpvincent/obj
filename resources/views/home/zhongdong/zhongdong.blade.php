<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
  FB.CustomerChat.show(shouldShowDialog: true);FB.CustomerChat.showDialog();
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
  attribution=setup_tool
  page_id="505487326557587"
  logged_in_greeting="How can we help you shop today?"
     logged_out_greeting="How can we help you shop today?"
     theme_color="#5c9165">
</div>