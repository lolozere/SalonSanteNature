<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="stic-fb-box">
	<div class="fb-like-box" data-href="<? echo $href;?>" data-width="<?php echo $width;?>" data-colorscheme="<?php echo $colorscheme;?>" data-show-faces="<?php echo ($show_faces)?'true':'false';?>" data-header="<?php echo ($header)?'true':'false';?>" data-stream="<?php echo ($stream)?'true':'false';?>" data-show-border="<?php echo ($show_border)?'true':'false';?>"></div>
</div>