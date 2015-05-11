<?php

/**

  The Initial Developer of the Original Code is
  Matthieu  - http://www.programmation-facile.com/

  Contributor(s) :

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



//_________________________________________________________________________________
//____________________ for the visitor plugin _____________________________________
//_________________________________________________________________________________


/**
 * Get Total YouTube Views from a channel and / or
 * Get Total number of Public Videos from a channel
 * [YTcount select="nbVideos"]
 * [YTcount select="nbViews"]
 * 
 * @return [type] [description]
 */
function get_YT_count($atts)
{
	global $oYouTubeDevFacile, $wpdb;
	$nTotal = 0;

	// get all selected lists
    extract(
    	shortcode_atts(
    		array(
    			'select' => '',    			
    		), 
    		$atts
    	)
    );


    if( $select == 'nbVideos' ) 
    {
	    $oStoredSettings = new YouTubeDevFacile_Settings();
	    $oDataInfos = $oStoredSettings->getNbVideosPublic();

        if( $oDataInfos->nCodeContinue == -9 )
        {
            //echo "<br/>get infos of nb videos with API YouTube";

            // get infos of videos with API YouTube
            $oDataYoutube = $oYouTubeDevFacile['client'];
            $nTotal = $oDataYoutube->getNbVideos();

            // store datas in options wordpress
            if( $nTotal >= 0)
                $oStoredSettings->addRecord($select, $nTotal);
        }
        else
            $nTotal = $oDataInfos->nTotal;

    }
    elseif( $select == 'nbViews' ) 
    {
        $oStoredSettings = new YouTubeDevFacile_Settings();
        $oDataInfos = $oStoredSettings->getNbView();

        if( $oDataInfos->nCodeContinue == -9 )
        {
            //echo "<br/>get infos of views with API YouTube";

            // get infos of videos with API YouTube
            $oDataYoutube = $oYouTubeDevFacile['client'];
            $nTotal = $oDataYoutube->getNbViews();

            // store datas in options wordpress
            if( $nTotal >= 0)
                $oStoredSettings->addRecord($select, $nTotal);
        }
        else
            $nTotal = $oDataInfos->nTotal;
    }
    
    return number_format($nTotal, 0, ' ', ' ');
}



//_________________________________________________________________________________
//____________________ for the admin plugin _______________________________________
//_________________________________________________________________________________



/**
 * Add link in panel admin of wordpress
 * 
 * @return [type] [description]
 */
function displayAdminYoutubeDevFacile()
{
	if (function_exists('add_options_page')) 
	{
		// add settings options for the plugin
        register_setting(YT_DEV_OPTION_SETTINGS, 'youtube_devfacile_settings');
        register_setting(YT_DEV_OPTION_SETTINGS, 'youtube_devfacile_channel');
        register_setting(YT_DEV_OPTION_SETTINGS, 'youtube_devfacile_connect_infos');

		// add a link tu sub menu settings
        add_options_page('YouTube DevFacile', 'YouTube DevFacile', 'manage_options', basename(__FILE__), 'displayAdminPageYouTubeDevFacile');
    }
}


/**
 * Build the page in admin panel
 * 
 * @return [type] [description]
 */
function displayAdminPageYouTubeDevFacile()
{
	global $oYouTubeDevFacile;

	$oAppAdminYouTube = $oYouTubeDevFacile['admin'];
	$oAppAdminYouTube->connectToyoutubeAccount();
}


//_________________________________________________________________________________
//____________________ for the plugin _____________________________________________
//_________________________________________________________________________________



/**
 * Define the language by default for the plugin
 * 
 * @param  [type] $locale [description]
 * @return [type]         [description]
 */
function youtube_devfacile_redefine_locale($locale)
{
    $wpsx_url = $_SERVER['REQUEST_URI'];
    $wpsx_url_lang = substr($wpsx_url, -4); // test for the last 4 chars:
    
    if ( $wpsx_url_lang == "-fr/")
        $locale = 'fr_FR';
    else if ( $wpsx_url_lang == "-en/") 
        $locale = 'en_US';
    else // fallback to default
        $locale = 'en_US'; 

    // remove the hook of language
    remove_action('locale', 'youtube_devfacile_redefine_locale');
    
    return $locale;
}




