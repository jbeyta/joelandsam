<?php
/**
 * Template Name: Contact Page Template
 * Description: Custom page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>
	<div class="main row" role="main">
		<h2 class="entry-title"><?php the_title();?></h2>

		<div class="medium-4 large-4 columns">	
			<?php the_post_thumbnail() ?>

			<?php
				//get the contact info
				$cwo_name = cw_options_get_option( '_cwo_name' ); 
				$cwo_title = cw_options_get_option( '_cwo_title' );
				$cwo_address1 = cw_options_get_option( '_cwo_address1' );
				$cwo_address2 = cw_options_get_option( '_cwo_address2' );
				$cwo_city = cw_options_get_option( '_cwo_city' );
				$cwo_state = cw_options_get_option( '_cwo_state' );
				$cwo_zip = cw_options_get_option( '_cwo_zip' );
				$cwo_phone = cw_options_get_option( '_cwo_phone' );
				$cwo_phone2 = cw_options_get_option( '_cwo_phone2' );
				$cwo_fax = cw_options_get_option( '_cwo_fax' );
				$cwo_email = cw_options_get_option( '_cwo_email' );
				$cwo_facebook = cw_options_get_option( '_cwo_facebook' );
				$cwo_twitter = cw_options_get_option( '_cwo_twitter' );

				if(!empty($cwo_name)) {echo '<h3 class="large-12 columns">'.$cwo_name.'</h3>'; }
				if(!empty($cwo_title)) {echo '<h4 class="large-12 columns">'.$cwo_title.'</h4>'; }

				if( !empty($cwo_address1) || !empty($cwo_address2) || !empty($cwo_city) || !empty($cwo_state) || !empty($cwo_zip) || !empty($cwo_phone) || !empty($cwo_phone2) || !empty($cwo_fax) || !empty($cwo_email) || !empty($cwo_facebook) || !empty($cwo_twitter) ) {
					echo '<p>';
				}

				if(!empty($cwo_address1)) {echo $cwo_address1; }
				if(!empty($cwo_address2)) {echo '<br>'.$cwo_address2; }
				if(!empty($cwo_city)) {echo '<br>'.$cwo_city; }
				if(!empty($cwo_state) && !empty($cwo_city)) {echo ',';}
				if(!empty($cwo_state)) {echo ' '.$cwo_state; }
				if(!empty($cwo_zip)) {echo ' '.$cwo_zip; }
				if(!empty($cwo_phone)) {echo '<br><b>Phone:</b> '.$cwo_phone; }
				if(!empty($cwo_phone2)) {echo '<br><b>Office:</b> '.$cwo_phone2; }
				if(!empty($cwo_fax)) {echo '<br><b>Fax:</b> '.$cwo_fax; }
				if(!empty($cwo_email)) {echo '<br><b>Email:</b> <a href="mailto:'.$cwo_email.'">'.$cwo_email.'</a>'; }
				if(!empty($cwo_facebook)) {echo '<br><b>Facebook:</b> <a href="'.$cwo_facebook.'">'.$cwo_facebook.'</a>'; }
				if(!empty($cwo_twitter)) {echo '<br><b>Twitter:</b> <a href="https://twitter.com/'.$cwo_twitter.'">'.$cwo_twitter.'</a>'; }

				if( !empty($cwo_address1) || !empty($cwo_address2) || !empty($cwo_city) || !empty($cwo_state) || !empty($cwo_zip) || !empty($cwo_phone) || !empty($cwo_phone2) || !empty($cwo_fax) || !empty($cwo_email) || !empty($cwo_facebook) || !empty($cwo_twitter) ) {
					echo '</p>';
				}

				$address = urlencode($cwo_address1.' '.$cwo_address2.' '.$cwo_city.', '.$cwo_state.' '.$cwo_zip);
			?>
			
			<?php if( !empty($cwo_address1) || !empty($cwo_address2) || !empty($cwo_city) || !empty($cwo_state) || !empty($cwo_zip) ) {?>

				<?php 
					$address = $cwo_address1.' '.$cwo_address2.' '.$cwo_city.', '.$cwo_state.' '.$cwo_zip;
					$address_url = urlencode($address);
					echo '<input id="address" type="hidden" value="'.$address.'">';

					$details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$address_url."&sensor=false";
				 
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $details_url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$response = json_decode(curl_exec($ch), true);
				 
					// If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
					if ($response['status'] != 'OK') {
						return null;
					}
				 
					$geometry = $response['results'][0]['geometry'];
					$latitude = $geometry['location']['lat'];
					$longitude = $geometry['location']['lng'];
				?>
				<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
				<script type="text/javascript">
					var geocoder;
					var map;
					function initialize() {
						geocoder = new google.maps.Geocoder();
						var latlng = new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>);
						var mapOptions = {
							zoom: 14,
							center: latlng,
							scrollwheel: false
						}
							map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
						}

					function codeAddress() {
						var address = document.getElementById('address').value;
						geocoder.geocode( { 'address': address}, function(results, status) {
							if (status == google.maps.GeocoderStatus.OK) {
								map.setCenter(results[0].geometry.location);
								var marker = new google.maps.Marker({
									map: map,
									position: results[0].geometry.location
								});
							} else {
								alert('Geocode was not successful for the following reason: ' + status);
							}
						});
					}

					google.maps.event.addDomListener(window, 'load', initialize);
					google.maps.event.addDomListener(window, 'load', codeAddress);
				</script>
				<div id="map-canvas" style="height: 300px; width: 100%;"></div>
				<a class="map" href="http://maps.google.com/maps?saddr=&daddr=<?php echo $address; ?>" title="Get Directions" target="_blank"><small>Click for Directions</small></a>
			<?php } ?>
		</div>
		<div class="medium-4 large-4 columns">
			<?php if (have_posts()) : while (have_posts()) : the_post();
				the_content();
			endwhile; endif; ?>
		</div>

		<?php get_sidebar(); ?>
	</div>

<?php get_footer(); ?>