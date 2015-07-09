<?php
/**
 * Template Name: Locations w/ Maps Template
 * Description: Custom page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>

	<div class="main row" role="main">		
		<div class="page-content medium-12 columns">
			<h2 class="entry-title"><?php the_title();?></h2>

			<?php if (have_posts()) : while (have_posts()) : the_post();
				the_content();
			endwhile; endif; ?>

			<?php
				$largs = array(
					'post_type' => 'locations',
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC'
				);

				$locs = new WP_Query($largs);

				if($locs->have_posts()) {
					echo '<div class="locations-maps row">';
					$i=1;
					while($locs->have_posts()) {
						$locs->the_post();

						$cwl_address1 = get_post_meta($post->ID, '_cwmb_loc_address1', true);
						$cwl_address2 = get_post_meta($post->ID, '_cwmb_loc_address2', true);
						$cwl_city = get_post_meta($post->ID, '_cwmb_loc_city', true);
						$cwl_state = get_post_meta($post->ID, '_cwmb_loc_state', true);
						$cwl_zip = get_post_meta($post->ID, '_cwmb_loc_zip', true);
						$cwl_phone = get_post_meta($post->ID, '_cwmb_loc_phone', true);

						echo '<div class="medium-2 columns">';
							echo '<p class="address">';
								echo '<b>'.get_the_title().'</b>';
								if(!empty($cwl_address1)) {echo '<br>'.$cwl_address1; }
								if(!empty($cwl_address2)) {echo '<br>'.$cwl_address2; }
								if(!empty($cwl_city)) {echo '<br>'.$cwl_city; }
								if(!empty($cwl_state) && !empty($cwl_city)) {echo ',';}
								if(!empty($cwl_state)) {echo ' '.$cwl_state; }
								if(!empty($cwl_zip)) {echo ' '.$cwl_zip; }
								if(!empty($cwl_phone)) {echo '<br>'.$cwl_phone; }
							echo '</p>';
						echo '</div>';

						$address = $cwl_address1.' '.$cwl_address2.' '.$cwl_city.', '.$cwl_state.' '.$cwl_zip;
						$address_url = urlencode($address);
						echo '<input id="address'.$i.'" type="hidden" value="'.$address.'">';

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
						$longitude = $geometry['location']['lng']; ?>

						<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
						<script type="text/javascript">
							var geocoder<?php echo $i; ?> = '';
							var map<?php echo $i; ?> = '';
							var latlng<?php echo $i; ?> = '';
							var mapOptions<?php echo $i; ?> = '';
							var address<?php echo $i; ?> = '';
							var marker<?php echo $i; ?> = '';

							function initialize<?php echo $i; ?>() {
								geocoder<?php echo $i; ?> = new google.maps.Geocoder();
								latlng<?php echo $i; ?> = new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>);
								mapOptions<?php echo $i; ?> = {
									zoom: 14,
									scrollwheel: false,
									center: latlng<?php echo $i; ?>
								}

								map<?php echo $i; ?> = new google.maps.Map(document.getElementById('map-canvas<?php echo $i; ?>'), mapOptions<?php echo $i; ?>);
							}

							function codeAddress<?php echo $i; ?>() {
								address<?php echo $i; ?> = document.getElementById('address<?php echo $i; ?>').value;
								geocoder<?php echo $i; ?>.geocode( { 'address': address<?php echo $i; ?> }, function(results, status) {
									if (status == google.maps.GeocoderStatus.OK) {
										map<?php echo $i; ?>.setCenter(results[0].geometry.location);
										marker<?php echo $i; ?> = new google.maps.Marker({
											map: map<?php echo $i; ?>,
											position: results[0].geometry.location
										});
									} else {
										alert('Geocode was not successful for the following reason: ' + status);
									}
								});
							}

							google.maps.event.addDomListener(window, 'load', initialize<?php echo $i; ?>);
							google.maps.event.addDomListener(window, 'load', codeAddress<?php echo $i; ?>);
						</script>
						<div class="medium-4 columns">
							<div id="map-canvas<?php echo $i; ?>" style="width: 100%; height: 300px;"></div>
							<br>
							<a class="map" href="http://maps.google.com/maps?saddr=&addr=<?php echo $address; ?>" title="Get Directions" target="_blank"><small>Click for Directions</small></a> 
						</div>
						<?php $i++;
					}
					echo '</div>';
				}
			?>
		</div>
	</div>

<?php get_footer(); ?>