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

/**
 * Admin class
 * Store API KEY of YouTube
 * Store channel name
 * 
 */
class youtubeDevFacile_Admin
{
	private $adminOptionsConnectAPI = '';
	private $adminOptionsChannel = '';
	
	private $messages = '';



	public function __construct()
	{
        $this->adminOptionsConnectAPI = 'youtube_devfacile_connect_infos';
        $this->adminOptionsChannel = 'youtube_devfacile_channel';
	    $this->messages = array(); 
	}



	/**
	 * create token for app youtube Dev Facile
	 * 
	 * @return [type] [description]
	 */
	public function connectToyoutubeAccount()
    {
    	echo '<div class="wrap">
    		<h2>'.__( 'Title-Page-Admin', YT_DEV_NAME ).'</h2>
    		<h3>'.__( 'Text-Page-Admin', YT_DEV_NAME ).'</h3>
    			<form name="youtube_devfacile_import_form" method="post" action="options.php">';

    	wp_nonce_field('update-options');// add 2 hidden fields for redirect user

    	echo '<input type="hidden" name="youtube_forms_import_hidden" value="Y">
        	<table class="form-table">';

    	$pluginAdminAPI_KEY = get_option($this->adminOptionsConnectAPI);
    	$pluginAdminChannel = get_option($this->adminOptionsChannel);

    	// get the group of options
        settings_fields(YT_DEV_OPTION_SETTINGS);

	    if(empty($_GET['updated'])) 
	    {
	        echo '<script type="text/javascript">
	            	jQuery("#setting-error-settings_updated").hide();
	        		</script>';
	    }


	    // ask for API YouTube
    	echo '<tr valign="top">
            <th scope="row">'.__( 'api-key-youtube', YT_DEV_NAME ).'</th>
            <td><input type="text" size="69" name="'.$this->adminOptionsConnectAPI.'" value="'.$pluginAdminAPI_KEY.'" />
            <p><a href="https://console.developers.google.com/" target="_blank">'.__( 'link-console-google', YT_DEV_NAME ).'</a></p>
            </td></tr>

            <tr valign="top">
            <th scope="row">'.__( 'channel-name', YT_DEV_NAME ).'</th>
            <td><input type="text" size="69" name="'.$this->adminOptionsChannel.'" value="'.$pluginAdminChannel.'" /></td>
            </tr>

            </table>
            <p class="submit">
                <input type="submit" id="youtube-settings-button" class="button-primary" value="'.__( 'btn-save', YT_DEV_NAME ).'" />
            </p>';
	   

        // options the plugin
    	echo '<h2>'.__( 'Title-YouTube-Dev-Facile-Settings', YT_DEV_NAME ).'</h2>
            <p>'.__( 'Text-YouTube-Dev-Facile-Settings', YT_DEV_NAME ).'</p>';

 		// update value of plugin options
 		echo '<input type="hidden" name="action" value="update" />
        	  <input type="hidden" name="page_options" value="'.$this->adminOptionsConnectAPI.','.$this->adminOptionsChannel.'" />';

	    echo '</table>';
	    echo '</form></div>';

        // add marketing / copywriting
		$oCopywriting = new youtubeDevFacileCopy_Admin();
		$oCopywriting->addFormCopywritingFacile();

	}// end if connectToyoutubeAccount 

}


/**
 * register_setting user profil
 * 
 */
class youtubeDevFacile_Admin_Page 
{
	public function __construct() 
	{}
}


