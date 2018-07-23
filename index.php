<?php
/*
Plugin Name: Booking Ultra Pro
Plugin URI: http://bookingultrapro.com
Description: Booking Plugin for every service provider: dentists, medical services, hair & beauty salons, repair services, event planners, rental agencies, educational services, government agencies, school counsellors and more. This plugin allows you to manage your appointments easily.
Version: 1.0.70
Author: Booking Ultra Pro
Author URI: https://bookingultrapro.com/
*/

$dirName = dirname(__FILE__);

$dirName = dirname(__FILE__);
$WPdirName = substr($dirName, 0, (strlen($dirName)-34));

require_once( $WPdirName.'/wp-config.php');

?>
<div id="stocksMarquee">
	
		<marquee><?php echo getDataforMarquee(); ?></marquee>
		
</div>
<?php

function getDataforMarquee(){
		global $wpdb;
		$sqlGetMarqueeData = "SELECT 
				NS.CompanyName,NSI.CompanySymbol,
				NS.closingPrice,
				NS.tradedShares, NS.difference 
			FROM wp_nepse_stocks NS

			LEFT JOIN wp_nepse_stocks_info NSI
				ON NS.CompanyName = NSI.CompanyName";
		$Companies = $wpdb->get_results($sqlGetMarqueeData);
		$stocksMarquee = "";
		foreach($Companies as $Company){
			//print_r($Company);
			if($Company->CompanySymbol != NULL){
				if($Company->difference < 0){
					
					$stocksMarquee .= "<span class='stkSymbol' style='color:red'>".$Company->CompanySymbol ."</span>";
					$stocksMarquee .= "<span class='stkPrice' style='color:red'>(".$Company->closingPrice .")</span>";
					$stocksMarquee .= "<span class='stktradedShares' style='color:red'>".$Company->tradedShares ."</span>";
					$stocksMarquee .= '<span class="stkDifferenceGreen"><i  style="color:red">'.$Company->difference .'</i></span>';
				}else{
					$stocksMarquee .= "<span class='stkSymbol' style='color:green'>".$Company->CompanySymbol ."</span>";
					$stocksMarquee .= "<span class='stkPrice' style='color:green'>(".$Company->closingPrice .")</span>";
					$stocksMarquee .= "<span class='stktradedShares' style='color:green'>".$Company->tradedShares ."</span>";
					$stocksMarquee .= '<span class="stkDifferenceRed"><i  style="color:green">'.$Company->difference .'</i></span>';
				}
				$stocksMarquee .= "|";
			}
		}
		return $stocksMarquee;
		exit;
}





 exit;
/* Loading Function */
require_once (bookingup_path . 'functions/functions.php');

/* Init */
define('bup_pro_url','https://bookingultrapro.com/');

function bup_load_textdomain() 
{     	   
	   $locale = apply_filters( 'plugin_locale', get_locale(), 'booking-ultra-pro' );	   
       $mofile = bookingup_path . "languages/bookingup-$locale.mo";
			
		// Global + Frontend Locale
		load_textdomain( 'bookingup', $mofile );
		load_plugin_textdomain( 'bookingup', false, dirname(plugin_basename(__FILE__)).'/languages/' );
}

/* Load plugin text domain (localization) */
add_action('init', 'bup_load_textdomain');	
		
add_action('init', 'bup_output_buffer');
function bup_output_buffer() {
		ob_start();
}

/* Master Class  */
require_once (bookingup_path . 'classes/bookingultra.class.php');

// Helper to activate a plugin on another site without causing a fatal error by
register_activation_hook( __FILE__, 'bupro_activation');
 
function  bupro_activation( $network_wide ) 
{
	$plugin_path = '';
	$plugin = "booking-ultra-pro/index.php";	
	
	if ( is_multisite() && $network_wide ) // See if being activated on the entire network or one blog
	{ 
		activate_plugin($plugin_path,NULL,true);
			
		
	} else { // Running on a single blog		   	
			
		activate_plugin($plugin_path,NULL,false);		
		
	}
}

$bookingultrapro = new BookingUltraPro();
$bookingultrapro->plugin_init();

register_activation_hook(__FILE__, 'bup_my_plugin_activate');
add_action('admin_init', 'bup_my_plugin_redirect');

function bup_my_plugin_activate() 
{
    add_option('bup_plugin_do_activation_redirect', true);
}

function bup_my_plugin_redirect() 
{
    if (get_option('bup_plugin_do_activation_redirect', false)) {
        delete_option('bup_plugin_do_activation_redirect');
        wp_redirect(MY_PLUGIN_SETTINGS_URL);
    }
}