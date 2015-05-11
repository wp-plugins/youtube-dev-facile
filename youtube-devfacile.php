<?php

/**
 * @package YouTube Dev Facile
 */
/*
Plugin Name: YouTube Dev Facile
Plugin URI: http://www.programmation-facile.com/
Description: Display Total YouTube Views from a channel and / or Display Total number of Public Videos from a channel - exemple of use : [YTcount select="nbVideos"] or [YTcount select="nbViews"] / Affiche le nombre total de vues d'une chaine YouTube et / ou affiche le nombre total de vidéos publiques d'une chaîne - exemple d'utilisation : [YTcount select="nbVideos"] ou [YTcount select="nbViews"]. <a href="http://www.Developpement-Facile.com" target="_blank" >Cliquez ici pour Créer des Applications sur smartphones, tablettes et le web</a>
Version: 0.1
Author: Matthieu
Author URI: http://www.programmation-facile.com/
License: GPLv2 or later
Text Domain: www.programmation-facile.com
*/


/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


//ini_set('display_errors',1);// debug with ovh http://votre-site.fr:82

// don't load directly
if ( !defined('ABSPATH') )
	die('-1');


/**
 * Exemple of use
 *
 * [YTcount select="nbVideos"]
 * [YTcount select="nbViews"]
 * echo do_shortcode('YTcount select="nbVideos"]');
 * echo do_shortcode('YTcount select="nbViews"]');
 * 
 */

// Plugin tables
global $wpdb;
$wpdb->tables[]   = 'youtube-devfacile';
$wpdb->name_table = $wpdb->prefix . 'youtube-devfacile';


// les constantes
define( 'YT_DEV_URL', plugin_dir_url ( __FILE__ ) );
define( 'YT_DEV_DIR', plugin_dir_path( __FILE__ ) );
define( 'YT_DEV_VERSION', '0.1' );
define( 'YT_DEV_NAME', 'youtube-devfacile' );
define( 'YT_DEV_OPTION_SETTINGS', 'youtube-devfacile-settings' );


/**
 * Function for easy load and include files
 * 
 */
function _YT_devfacile_load_files($dir, $files, $prefix = '') 
{
	foreach ($files as $file) 
	{
		// echo $dir . $prefix . $file . ".php <br/> \n";
		if ( is_file($dir . $prefix . $file . ".php") ) 
			require_once($dir . $prefix . $file . ".php");	
	}	
}

// api youtube
_YT_devfacile_load_files( YT_DEV_DIR.'google-api-client/', array( 'autoload' ) );

// Les classes clientes
_YT_devfacile_load_files( YT_DEV_DIR.'classes/', array( 'main', 'plugin', 'settings' ) );

// Les classes admin
if (is_admin()) 
	_YT_devfacile_load_files( YT_DEV_DIR.'classes/admin/', array( 'admin', 'copywriting', 'main' ) );

// Les fonctions
_YT_devfacile_load_files( YT_DEV_DIR.'functions/', array( 'api-YT-devfacile' ) );


// Plugin activate/desactive hooks
register_activation_hook(__FILE__, array('YouTubeDevFacile', 'activate'));
register_deactivation_hook(__FILE__, array('YouTubeDevFacile', 'deactivate'));


// au moment du chargement des plugins
function init_YouTubeDevFacile_plugin() 
{
	global $oYouTubeDevFacile;

	// Load translations  -  How to internationalize your wordpress plugin
	load_plugin_textdomain ( YT_DEV_NAME, false, basename(rtrim(dirname(__FILE__), '/')) . '/languages' );
	
	// Load client
	$oYouTubeDevFacile['client'] = new YouTubeDevFacile_Client();
	
	// Load Admin
	if ( is_admin() ) 
	{
		$oYouTubeDevFacile['admin'] = new YouTubeDevFacile_Admin();
		add_action( 'admin_menu', 'displayAdminYoutubeDevFacile' );// create admin menu plugin
	}
}


/**
 * launch initialisation of the plugin
 * 
 */
add_action( 'plugins_loaded', 'init_YouTubeDevFacile_plugin' );


/**
 * [YTcount select="nbVideos"]
 * [YTcount select="nbViews"]
 * 
 */
add_shortcode( 'YTcount', 'get_YT_count' );


/**
 * To define the lang to use for translation
 * 
 */
if( get_locale() != 'fr_FR') 
	add_filter('locale','youtube_devfacile_redefine_locale');


/*
$calvin = "6 years";
$hobbes = "stuffed";
 
// "Prepare" the query
$sql = $wpdb->prepare( "INSERT INTO $wpdb->name_table( id, field1, field2 ) VALUES ( %d, %s, %s )", $_POST['id'], $calvin, $hobbes );
 
// Run it
$wpdb->query( $sql );
*/


