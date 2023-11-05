<?php
			echo '<ul id="sponsors" style="">';
			echo '<li><strong>'.__("Sponsors", 'featured-image-from-external-sources').'</strong> &nbsp;</li>';


    $response = wp_remote_get( 'https://www.dadok.cz/?wordpress_plugin_sponsors=1' );
    $result = $response['body'];

			 $sponsors = json_decode($result);
			 foreach ($sponsors as $key => $value) {
				echo '<li>&nbsp;&nbsp;'.$value.'</li>';
			 }


echo '<li>&nbsp;&nbsp;<strong>Thank You!</strong></li></ul>';
?>