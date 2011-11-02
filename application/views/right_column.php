<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

		<!-- rightbar -->
		<div id="rightbar">
			<?php //print_r($this->userdata); ?>
			
			<?php if (isset($profile_photo)): ?>
			<div id="profile_photo">
				<?php echo img($profile_photo); ?>
			</div>
			<?php endif; ?>
			
			<?php if (isset($user_info)): ?>
			<div>
				<h2><?=$name?></h2>
				<p>
					<?php echo anchor('profile/view/'.$this->uri->segment(3, null), 'View Profile'); ?><br>
					<?php echo anchor($blog_url, 'Go to blog', array('target' => '_blank')); ?><br>
					<?php if ($this->userdata['group']['name'] == 'admin'): echo anchor('user/edit/'.$id, 'Edit User'); endif; ?>
				</p>
			</div>
			<?php endif; ?>
			
			<?php if (isset($links)): ?>
			<div class="links">
				<h2>Suggested Reading</h2>
				<p>
					<?php $count = count($links); foreach ($links as $link): ?>
					<?php echo $link; if ($count > 1) echo '<br />'; $count--;?>
					<?php endforeach; ?>
				</p>
			</div>
			<?php endif; ?>
			
			<?php if (isset($authors)): ?>
			<div class="authors">
				<h3>Authors</h3>
				<p>
					<?php $count = count($authors); foreach ($authors as $author_id => $author): ?>
					<?php echo anchor('profile/view/'.$author['url'], $author['name']); if ($count > 1) echo '&nbsp;|&nbsp;'; $count--;?>
					<?php endforeach; ?>
				</p>
			</div>
			<?php endif; ?>
			

			<?php if (isset($tags) && is_array($tags)): ?>
			<div class="tags">
				<h3>Tags</h3>
				<p>
				<?php foreach ($tags as $tag): ?>
					<?php echo '<span class="hash">#</span>'.anchor('feed/tag/'.$tag, $tag).' '; ?>
				<?php endforeach; ?>
				</p>
			</div>
			<?php endif; ?>
	
			<div id ="social">
				<h2>Share</h2>
				
				
				<!-- facebook like interface -->
				<div id="fb-root"></div>
				<script src="http://connect.facebook.net/en_US/all.js#appId=269078833104121&amp;xfbml=1"></script>
				<fb:like href="<?php echo site_url(); ?>" send="true" layout="box_count" width="55" show_faces="true" action="like" font="arial"></fb:like>
				<!-- END facebook like interface -->
				
				<!-- Google plusone button -->
				<!-- Place this tag where you want the +1 button to render -->
				<div class="g-plusone" data-size="tall"></div>
				<!-- Place this render call where appropriate -->
				<script type="text/javascript">
				  (function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/plusone.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				  })();
				</script>
				<!-- END google plusone button -->
				
				<!-- tweet this page -->
				<a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical" data-via="hedrickchris">Tweet</a>
				<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
				<!-- END tweet this page -->
				
				<br /><br />
				<!-- Diaspora* share button -->
				<div id="diaspora_share">
					<div style="float:left;width:31px;height:31px;border:#333 3px solid;-moz-border-radius:6px;-webkit-border-radius:6px;border-radius:6px; cursor:pointer;box-shadow:1px 1px 4px rgb(204,204,204);margin-right:5px;" onMouseOver="init();" onMouseOut="stop();" onClick="getPodName();">
						<canvas width="27" height="27" id="canvas" style="margin:2px 0 0 2px;"></canvas>
					</div>
					Share on <a href="https://joindiaspora.com/" target="_blank">Diaspora*</a>
					<br class="clearfloat" />
				</div>
				<script>
				var intervalID;
				var asterisk=new Image();
				asterisk.src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABsAAAAbCAYAAACN1PRVAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAQ1JREFUeNpi/P//PwO9ACMJajuA2BiL+FkgriDGABYSLANZ5EKJz5gY6AhGLaO6ZaAEoERl85WQUzCyZeVAfBeIz0DZShRYUA41B2ReGjZF/7FgZIt341CzG80CdPl36BaF4jCIWjgUORhdaJw2UMx/R2OfgYOSGYgFgfgoED8HYikon1rgHhDPAuJOIH6PqwzEFdnEYFiiMiYnGc8k0pIOSkNFiYT4fEepZbtJDMJV5FpUTmaclZNqkTER8YMvOIlOHIIEUmIHET4/Q0pb4z+echAZrCLCUXiLFVJSmyC0ZMelh2AxGIojubuQEL/vYIUvsflrNwkprBxLlUNW8ic276wi5ChGeraIAQIMAFUG5PAQfeaJAAAAAElFTkSuQmCC";
				var ctx=document.getElementById("canvas").getContext("2d");
				var rotation=0;
				function stop(){
					clearInterval(intervalID);
					rotation=0;
					ctx.clearRect(0,0,27,27);
					ctx.drawImage(asterisk,0,0);
				};
				function init(){
					intervalID=setInterval(rotateimg,20);
				};
				function rotateimg(){
					ctx.globalCompositeOperation="destination-over";
					ctx.save();
					ctx.clearRect(0,0,27,27);
					ctx.translate(13.5,13.5);
					rotation+=1;
					ctx.rotate(rotation*Math.PI/64);
					ctx.translate(-13.5,-13.5);
					ctx.drawImage(asterisk,0,0);
					ctx.restore();
				};
				function getPodName(){
					var _1=localStorage.getItem("diasporapodname");
					if(_1==null){
						_1=prompt("Enter your Diaspora pod...","");
						if(_1==null){
							alert("Pod name is empty or invalid!");
							return;
						}else{
							localStorage.setItem("diasporapodname",_1);
						}
					}
					shareOnD(_1);
				};
				function shareOnD(_2){
					f="https://"+_2+"/bookmarklet?url="+encodeURIComponent(window.location.href)+"&title="+encodeURIComponent(document.title)+"&notes="+encodeURIComponent(""+(window.getSelection?window.getSelection():document.getSelection?document.getSelection():document.selection.createRange().text))+"&v=1&";
					a=function(){
						if(!window.open(f+"noui=1&jump=doclose","diasporav1","location=yes,links=no,scrollbars=no,toolbar=no,width=620,height=350")){
							location.href=f+"jump=yes";
						}
					};
					if(/Firefox/.test(navigator.userAgent)){
						setTimeout(a,0);
					}else{
						a();
						}
					};
					window.Modernizr=function(a,b,c){
						function w(a,b){
							return !!~(""+a).indexOf(b);
						};
						function v(a,b){
							return typeof a===b;
						};
						function u(a,b){
							return t(prefixes.join(a+";")+(b||""));
						};
						function t(a){
							j.cssText=a;
						};
						var d="2.0.6",e={},f=b.documentElement,g=b.head||b.getElementsByTagName("head")[0],h="modernizr",i=b.createElement(h),j=i.style,k,l=Object.prototype.toString,m={},n={},o={},p=[],q,r={}.hasOwnProperty,s;
						!v(r,c)&&!v(r.call,c)?s=function(a,b){
							return r.call(a,b);
						}:s=function(a,b){
							return b in a&&v(a.constructor.prototype[b],c);
						},m.canvas=function(){
							var a=b.createElement("canvas");
							return !!a.getContext&&!!a.getContext("2d");
						},m.localstorage=function(){
							try{
								return !!localStorage.getItem;
							}catch(a){
								return !1;
							}
						};
						for(var x in m){
							s(m,x)&&(q=x.toLowerCase(),e[q]=m[x](),p.push((e[q]?"":"no-")+q));
						}t(""),i=k=null,e._version=d;return e;
					}(this,this.document);
					if(Modernizr.localstorage&&Modernizr.canvas){
						asterisk.onload=function(){
							ctx.drawImage(asterisk,0,0);
						};
					}else{
						alert("Sorry. Your browser does not support html5!");
					}
				</script>
				<!-- END Dispora* share button -->
				
				
			</div>
			
			<div>
				<h2>Follow Us</h2>
				<br>
				<!-- follow hedrickchris -->
				<a href="http://twitter.com/hedrickchris" class="twitter-follow-button" data-show-count="false">Follow @hedrickchris</a>
				<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
				<!-- END follow hedrickchris -->
				<br><br>
				<!-- youtube button -->
				<a href="http://www.youtube.com/subscription_center?add_user=pcsenegaladmin&feature=creators_cornier-http%3A//s.ytimg.com/yt/img/creators_corner/Subscribe_to_my_videos/YT_Subscribe_160x27_red.png">
					<img src="http://s.ytimg.com/yt/img/creators_corner/Subscribe_to_my_videos/YT_Subscribe_160x27_red.png" alt="Subscribe to me on YouTube"/>
				</a>
				<img src="http://www.youtube-nocookie.com/gen_204?feature=creators_cornier-http%3A//s.ytimg.com/yt/img/creators_corner/Subscribe_to_my_videos/YT_Subscribe_160x27_red.png" style="display: none"/>
				<!-- END youtube button -->
				
			</div>
			<!-- END social links -->
			
		</div>
		<!-- END rightbar -->