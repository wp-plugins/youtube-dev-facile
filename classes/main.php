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
 * Display Total YouTube Views from a channel
 * Display Total number of Public Videos from a channel
 * 
 */
class YouTubeDevFacile_Client 
{
 
    private $adminOptionsConnectAPI = '';
    private $adminOptionsChannel = '';
    private $pluginAdminAPI_KEY = '';
    private $pluginAdminChannel = '';


    public function __construct() 
    {
        $this->adminOptionsConnectAPI = 'youtube_devfacile_connect_infos';
        $this->adminOptionsChannel = 'youtube_devfacile_channel';

        $this->pluginAdminAPI_KEY = get_option($this->adminOptionsConnectAPI);
        $this->pluginAdminChannel = get_option($this->adminOptionsChannel);
    }


    /**
     * Return Total number of Public Videos from a channel
     * 
     * @return [type] [description]
     */
    public function getNbVideos()
    {
        $nNumberVideos = -1;
        $API_KEY = $this->pluginAdminAPI_KEY;

        $oClient = new Google_Client();
        $oClient->setDeveloperKey($API_KEY);

        $oYouTube = new Google_Service_YouTube($oClient);

        try
        {
            // get the id of the playlist
            $sResponse = $oYouTube->channels->listChannels('statistics' , ['forUsername' => $this->pluginAdminChannel ] );
            $nNumberVideos = $sResponse['items'][0]['modelData']['statistics']['videoCount'];
        }
        catch (Google_ServiceException $e) 
        {
            $error = sprintf('<p>A service error occurred: <code>%s</code></p>',
            $error .= htmlspecialchars($e->getMessage()));
        }
        catch (Google_Exception $e)
        {
            $error = sprintf('<p>An client error occurred: <code>%s</code></p>',
            $error .= htmlspecialchars($e->getMessage()));
        }
        /*echo "<br/>-------> nNumberVideos :".$nNumberVideos;
        echo "<pre>";
            var_dump($sResponse);
        echo "</pre>";*/

        return $nNumberVideos;
    }


    /**
     * Return Total YouTube Views from a channel
     * 
     * @return [type] [description]
     */
    public function getNbViews()
    {
        $nNbViewsTotal = -1;
        $API_KEY = $this->pluginAdminAPI_KEY;

        $oClient = new Google_Client();
        $oClient->setDeveloperKey($API_KEY);

        $oYouTube = new Google_Service_YouTube($oClient);
        
        try
        {
          // get the id of the playlist
          $sResponse = $oYouTube->channels->listChannels('statistics' , ['forUsername' => $this->pluginAdminChannel ] );
          $nNbViewsTotal = $sResponse['items'][0]['modelData']['statistics']['viewCount'];
        }
        catch (Google_ServiceException $e) 
        {
            $error = sprintf('<p>A service error occurred: <code>%s</code></p>',
            $error .= htmlspecialchars($e->getMessage()));
        }
        catch (Google_Exception $e)
        {
            $error = sprintf('<p>An client error occurred: <code>%s</code></p>',
            $error .= htmlspecialchars($e->getMessage()));
        }
        //echo "<br/>-------> nNbViewsTotal :".$nNbViewsTotal;
        /*echo "<pre>";
            var_dump($sResponse);
        echo "</pre>";*/

        return $nNbViewsTotal;
    }


    /**
     * Add debug output when app comunicate with API YouTube
     * to be implemented
     * 
     * @param [type] $bValue [description]
     */
    public function setDebug($bValue)
    {
        # set this to true to view the actual api request and response
        //$this->application->adapter->debug = $bValue;
    } 

}

