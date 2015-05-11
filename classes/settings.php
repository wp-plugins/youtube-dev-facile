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
 * Save options of the plugin
 * 
 */
class YouTubeDevFacile_Settings
{
	private $adminOptionsSettings = '';
	private $pluginAdminSettings = '';

	private $nValueExpire = 3600;// number of seconds



	public function __construct() 
	{
        $this->adminOptionsSettings = 'youtube_devfacile_settings';
        $this->pluginAdminSettings = get_option($this->adminOptionsSettings);
	}


	/**
	 * Find the number of public video from a channel YouTube
	 * 
	 * @param  [type] $sSelectedLists [description]
	 * @return [type]                 [description]
	 */
	public function getNbVideosPublic()
	{	
		if ( ! isset($this->pluginAdminSettings['content_infos']['nbVideos']) ) 
		{
			//echo "--- <br/>no infos in database options getNbVideosPublic";
			$oDataInfos = new YouTubeDevFacile_dataInfos(-9, 0);
			return $oDataInfos;// no infos in database options
		}	
		else
		{
			extract($this->pluginAdminSettings);// get admin option YouTube Dev Facile

			// get record
			if( $content_infos['nbVideos'] != 0 or $content_infos['nbVideos'] != '' )
			{
				$oDateTime = new DateTime();
				$oData = $content_infos['nbVideos'];

				// test if update count is necessary
				if( ( $oData->nTimeStamp + $this->nValueExpire ) < ( $oDateTime->getTimestamp() ) )// update every hour
				{
					//echo '--- <br/>delete record nbVideos<pre>'; 
			    	/*echo '--- <br/>delete record<pre>'; 
					print_r($content_infos[0]);*/

					$oDataInfos = new YouTubeDevFacile_dataInfos(-9, $oData->nTotal);
				}
				else
					$oDataInfos = new YouTubeDevFacile_dataInfos(1, $oData->nTotal);// no update
	
				return $oDataInfos;// infos in database options
			}

		}	

		$oDataInfos = new YouTubeDevFacile_dataInfos(-9, 0);
		return $oDataInfos;// no infos in database options
	}


	/**
	 * Find the number of views from a channel YouTube
	 * 
	 * @param  [type] $sSelectedLists [description]
	 * @return [type]                 [description]
	 */
	public function getNbView()
	{	
		if ( ! isset($this->pluginAdminSettings['content_infos']['nbViews']) ) 
		{
			//echo "--- <br/>no infos in database options getNbView";
			$oDataInfos = new YouTubeDevFacile_dataInfos(-9, 0);
			return $oDataInfos;// no infos in database options
		}	
		else
		{
			extract($this->pluginAdminSettings);// get admin option YouTube Dev Facile

			// get record
			if( $content_infos['nbViews'] != 0 or $content_infos['nbViews'] != '' )
			{
				$oDateTime = new DateTime();
				$oData = $content_infos['nbViews'];

				// test if update count is necessary
				if( ( $oData->nTimeStamp + $this->nValueExpire ) < ( $oDateTime->getTimestamp() ) )// update every hour
				{
			    	//echo '--- <br/>delete record nbViews<pre>'; 
					//print_r($oData);

					$oDataInfos = new YouTubeDevFacile_dataInfos(-9, $oData->nTotal);
				}
				else
					$oDataInfos = new YouTubeDevFacile_dataInfos(1, $oData->nTotal);// no update
	
				return $oDataInfos;// infos in database options
			}

		}	

		$oDataInfos = new YouTubeDevFacile_dataInfos(-9, 0);
		return $oDataInfos;// no infos in database options
	}


	/**
	 * Store informations in options wordpress
	 * 
	 * @param  [type] $sSelectedLists [description]
	 * @return [type]                 [description]
	 */
	public function addRecord($sType, $nCount)
	{
		$oStoredSettings = new YouTubeDevFacile_OneField($sType, $nCount);

		// create an array with infos
		if ( ! isset( $this->pluginAdminSettings['content_infos'][$sType]) ) 
		{
			if( ! isset($this->pluginAdminSettings['content_infos']) )
			{
				//echo "<br/> __________> create an array <br />";
				$this->pluginAdminSettings['content_infos'] = array();
			}
		}
			
		$this->pluginAdminSettings['content_infos'][$sType] = $oStoredSettings;
		//echo '--- <br/>addRecord pluginAdminOptions <pre>'.$sType; 
		//print_r($this->pluginAdminSettings);

	    update_option($this->adminOptionsSettings, $this->pluginAdminSettings);
	}

}


/**
 * Object stored in settings option wordpress
 * 
 */
class YouTubeDevFacile_OneField
{

    public $nTimeStamp = '';
    public $sTypeNumber = '';
    public $nTotal = '';



	public function __construct($sType, $nCount) 
	{
		$oDate = new DateTime();
        $this->nTimeStamp = $oDate->getTimestamp();
        $this->sTypeNumber = $sType;
        $this->nTotal = $nCount;
	}


	/**
	 * Return selected lists
	 * 
	 * @return [type] [description]
	 */
	/*public function getSelectedList()
	{
		return $this->sSelectedLists;
	}*/

}


/**
 * Object with number of subscribers and code continue
 * 
 */
class YouTubeDevFacile_dataInfos
{

    public $nCodeContinue = '';
    public $nTotal = '';


	public function __construct($nCode, $nCount) 
	{
        $this->nCodeContinue = $nCode;
        $this->nTotal = $nCount;
	}
}


