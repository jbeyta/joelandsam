<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
?>

	<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
		<div class="row">
			<div class="medium-10 large-10 columns">
				<input type="text" value="" name="s" placeholder="Search" id="s">
			</div>

			<div class="medium-2 large-2 columns">
				<input type="submit" id="searchsubmit" value="Go" class="button">
			</div>
		</div>
	</form>