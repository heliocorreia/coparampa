			</div>
		</div>
		<div class="aux aux-1"></div>
	</div>
	<footer id="ft">
		<div id="ft-content">
			<div class="yui3-u-1-3">
				<p class="facebook"><a href="<?php echo CFG_FACEBOOK_HREF; ?>" target="_blank">Seja amigo do Rampa no Facebook</a></p>
			</div><div class="yui3-u-2-3 vcard">
				<?php
				if (function_exists('mytheme_get_option')): mytheme_get_option( 'rampa_theme_footer_message' );
				else:
				?>
				<p class="adr"><span class="street-address">Rua Sá Ferreira, 202</span> - <span class="extended-address">Copacabana</span> - <span class="locality">Rio de Janeiro</span> - <abbr class="region" title="Rio de Janeiro">RJ</abbr> - Tel. <span class="tel">(21) 3796-7303</span></p>
				<?php endif; ?>
			</div>
		</div>
	</footer>
<?php wp_footer(); ?>
<script>
//<![CDATA[
if ( window.jQuery ) {
	jQuery(document).ready(function($){
		// fancybox
		if ($.fn.fancybox) {
			var oGallery = $('.gallery');
			if (oGallery.size()) {
				$('a', oGallery).attr('rel', 'gallery').fancybox({
					'centerOnScroll': true,
					'hideOnContentClick': true,
					'autoScale': false,
					'overlayShow': true,
					'overlayOpacity': .8,
					'overlayColor': '#000',
					'titlePosition': 'inside',
					'titleFormat': function(title, elements, currentIndex, currentOpts){
						var oContent = $(elements[currentIndex]).parents('.gallery-item').find('.wp-caption-text');
						if (oContent.size()) return oContent.html();
					}
				});
			}
		}
	});
}
//]]>
</script>
</div>
</body>
</html>