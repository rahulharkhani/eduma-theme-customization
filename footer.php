<?php do_action( 'thim_above_footer_area' ); ?>

<footer id="colophon" class="<?php thim_footer_class(); ?>">
	<?php if ( is_active_sidebar( 'footer' ) ) : ?>
		<div class="footer">
			<div class="container">
				<div class="row">
					<?php dynamic_sidebar( 'footer' ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php do_action( 'thim_copyright_area' ); ?>

</footer><!-- #colophon -->
</div><!--end main-content-->

<?php do_action( 'thim_end_content_pusher' ); ?>

</div><!-- end content-pusher-->

<?php do_action( 'thim_end_wrapper_container' ); ?>


</div><!-- end wrapper-container -->

<?php //echo do_shortcode('[njwa_button id="8168"]'); ?>
<?php wp_footer(); ?>

<script>
	jQuery(document).ready(function () {
		setTimeout( function(){ 
			if (jQuery(window).width() > 600) {
				var mb = jQuery('.footer-bottom').height() - 20;
				jQuery('footer#colophon.has-footer-bottom').css('margin-bottom', mb);
			}
		}, 3000 );
	});
</script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
	/*var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	(function(){
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src='https://embed.tawk.to/615c234fd326717cb684d077/1fh7ujru5';
		s1.charset='UTF-8';
		s1.setAttribute('crossorigin','*');
		s0.parentNode.insertBefore(s1,s0);
	})();*/
</script>
<!--End of Tawk.to Script-->

</body>
</html>