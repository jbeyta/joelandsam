<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
?>
	<footer role="contentinfo">
		<div class="row">
			<div class="large-12 columns">
				<p class="copy">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>, All Rights Reserved.</p>
			</div>
		</div>
	</footer>

	<!-- WP_FOOTER() -->
	<?php wp_footer(); ?>
	<?php
		// must activate CW Options Page plugin for the line below to work
		$ga_code = cw_options_get_option('_cwo_ga'); if( !empty($ga_code) ) {
	?>
	<script type="text/javascript">
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', '<?php echo $ga_code; ?>', 'auto');
		ga('send', 'pageview');
	</script>
	<?php } ?>
</body>
</html>