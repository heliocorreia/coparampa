<?php
// theme url path
$theme_directory = parse_url(get_bloginfo( 'stylesheet_directory' ));
$theme_directory = $theme_directory['path'];

get_header(); ?>
			<?php if (have_posts()): ?>
				<article <?php post_class('entry'); ?>>
				<?php while (have_posts()): the_post(); ?>
					<header class="block-title">
						<h1 class="title"><?php echo my_block_title(get_the_title()); ?></h1>
						<?php
						$subtitle = get_post_meta(get_the_ID(), 'subtitle_subtitle', true);
						if (!empty($subtitle)): ?>
							<div class="subtitle"><?php echo $subtitle; ?></div>
						<?php endif; ?>
					</header>
					<section class="entry-content">
						<div class="yui3-u-1-3">
							<div class="sb">
								<?php the_content(); ?>
							</div>
						</div><div class="yui3-u-2-3">
							<form id="frm-contato" method="post">
								<input type="hidden" name="action" value="frm_contact">
								<fieldset>
								<p>
									<label for="frm-nome">Nome</label>
									<input type="text" id="frm-nome" name="frm_nome" value="" class="input-text" />
								</p>
								<p>
									<label for="frm-mail">Email</label>
									<input type="email" id="frm-mail" name="frm_mail" value="" class="input-text" />
								</p>
								<p>
									<label for="frm-site">Website</label>
									<input type="url" id="frm-site" name="frm_site" value="" class="input-text" />
								</p>
								<p>
									<label for="frm-mens">Mensagem</label>
									<textarea id="frm-mens" name="frm_mens"></textarea>
								</p>
								<p class="buttons">
									<input type="submit" id="frm-submit" value="Enviar" class="input-submit input-button" />
								</p>
								</fieldset>
							</form>
							<script type="text/javascript">
							//<![CDATA[
							if ( window.jQuery ) { jQuery(document).ready(function($){
								oFrmContact = $('#frm-contato');
								// form submit handler
								$(oFrmContact).submit(function(e){
									e.preventDefault();
									var oFrm = $(this);
									$.post('<?php echo admin_url('admin-ajax.php'); ?>', $(oFrm).serialize(), null, 'json')
										.success(function(data){
											if (data) {
												alert(data.message);
												if (data.hasError && data.fieldName) {
													$('[name="' + data.fieldName + '"]', oFrmContact).focus();
												} else if (!data.hasError) {
													$(':input:not(input[type=hidden]), , textarea', $(oFrmContact)).val('');
												}
											}
										})
										.error(function(){
											alert("Desculpe, o serviço de envio de envio está temporariamente indisponível.\n\nPor favor, tente novamente mais tarde.");
									});
								});
							}); }
							//]]>
							</script>
						</div>
					</section>
				<?php endwhile;?>
				</article>
			<?php else: ?>
			<?php endif; ?>
<?php get_footer(); ?>