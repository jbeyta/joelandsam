<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
?><!DOCTYPE html>
<!--[if lt IE 7]> <html style="margin-top: 0!important;" class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html style="margin-top: 0!important;" class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html style="margin-top: 0!important;" class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html style="margin-top: 0!important;" class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<?php
		$favicon = cw_options_get_option( '_cwo_favicon' );
		if(!empty($favicon)) { echo '<link rel="shortcut icon" type="image/png" href="'.$favicon.'"/>'; }
	?>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="author" href="<?php echo get_template_directory_uri(); ?>/humans.txt">
	<link rel="dns-prefetch" href="//ajax.googleapis.com">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href='http://fonts.googleapis.com/css?family=Raleway:700,100,400' rel='stylesheet' type='text/css'>	
	
	<!-- WP_HEAD() -->
	<?php wp_head(); ?>

	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie.css">
	<![endif]-->
</head>

<body <?php body_class(); ?>>
	<header role="banner">
		<div class="nav-container contain-to-grid">
			<nav class="top-bar" data-topbar role="navigation">
				<ul class="title-area">
					<li class="name">
						<?php $logo_url = cw_options_get_option( '_cwo_logo' ); ?>
						<h1 class="logo">
							<a href="/" title="<?php bloginfo( 'name' ); ?>">
								<?php if(!empty($logo_url)) { ?>
									<img src="<?php echo $logo_url; ?>" alt="<?php bloginfo( 'name' ); ?>" />
								<?php } else {
									bloginfo( 'name' );
								} ?>
							</a>
						</h1>					
					</li>
					<li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
				</ul>

				<section class="top-bar-section">
					<?php 
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container' => '',
								'menu_class' => 'menu right',
								'depth' => 2,
								'fallback_cb' => 'wp_page_menu',
								'walker' => new Foundation_Walker_Nav_Menu()
							)
						);
					?>
				</section>
			</nav>
		</div>
	</header>

	<?php get_template_part('content', 'slides'); ?>