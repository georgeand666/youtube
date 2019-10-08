<?php

namespace App;

use Google_Client;
use Google_Service_YouTube;

class YouTubeClass

{
	
	/**
	 * @var string
	 */
	protected $youtube_key; // from the config file
	
	/**
	 * @var array
	 */
	protected $APIs = [
		'auth' => 'https://www.googleapis.com/auth/youtube',
		'categories.list' => 'https://www.googleapis.com/youtube/v3/videoCategories',
		'videos.list' => 'https://www.googleapis.com/youtube/v3/videos',
		'search.list' => 'https://www.googleapis.com/youtube/v3/search',
		'channels.list' => 'https://www.googleapis.com/youtube/v3/channels',
		'playlists.list' => 'https://www.googleapis.com/youtube/v3/playlists',
		'playlistItems.list' => 'https://www.googleapis.com/youtube/v3/playlistItems',
		'activities' => 'https://www.googleapis.com/youtube/v3/activities',
		'commentThreads.list' => 'https://www.googleapis.com/youtube/v3/commentThreads',
	];
	
	
	/**
	 * @var array
	 */
	public $page_info = [];
	
	/**
	 * Constructor
	 * $youtube = new Youtube(['key' => 'KEY HERE'])
	 *
	 * @param string $key
	 * @throws \Exception
	 */
	public function __construct()
	{
		$key = config('youtube');
		
		// print_r($config);
		
		if (!empty($key)) {
			$this->setApiKey( $key );
		} else {
			throw new \Exception('Google API key is Required, please visit https://console.developers.google.com/');
		}
	}
	
	/**
	 * @param $key
	 * @return Youtube
	 */
	public function setApiKey($key)
	{
		$this->youtube_key = $key;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getApiKey()
	{
		return $this->youtube_key;
	}
		
	/**
	* Search only videos
	*
	* @param  string $q Query
	* @param  integer $maxResults number of results to return
	* @return json
	*/
	public function searchVideos($q, $maxResults = 25)
	{
		//$q = 'globo';
		
		$params = [
				'q' => $q,
				'maxResults' => $maxResults,
				'key' => $this->youtube_key,
		];
		
		//echo $params['key']['API_key'];
		
		$client = new Google_Client();
		$client->setDeveloperKey( $params['key']['API_key'] );
		
		// Define an object that will be used to make all API requests.
		$youtube = new Google_Service_YouTube($client);
		
		$return = array();
		
		$retur['video'] = array();
		$retur['channel'] = array();
		$retur['playlist'] = array();
		$retur['error'] = '';
		
		try {
			
			// Call the search.list method to retrieve results matching the specified
			// query term.
			$searchResponse = $youtube->search->listSearch('id,snippet', array(
					'q' => $params['q'],
					'maxResults' => $params['maxResults'],
			));
			
			//print_r( $searchResponse['items'] );
			
			// Add each result to the appropriate list, and then display the lists of
			// matching videos, channels, and playlists.
			foreach($searchResponse['items'] as $searchResult) {
				switch ($searchResult['id']['kind']) {
					case 'youtube#video':
						//$videos .= sprintf('<li>%s (%s)</li>',
						//$searchResult['snippet']['title'], $searchResult['id']['videoId']);
						
						$retur['video'][] = array(
							'title' => $searchResult['snippet']['title'],
							'videoId' => $searchResult['id']['videoId'],
						);
						break;
					case 'youtube#channel':
						//$channels .= sprintf('<li>%s (%s)</li>',
						//$searchResult['snippet']['title'], $searchResult['id']['channelId']);
						
						$retur['channel'][] = array(
							'title' => $searchResult['snippet']['title'],
							'videoId' => $searchResult['id']['videoId'],
						);
						break;
					case 'youtube#playlist':
						//$playlists .= sprintf('<li>%s (%s)</li>',
						//$searchResult['snippet']['title'], $searchResult['id']['playlistId']);
						
						$retur['playlist'][] = array(
							'title' => $searchResult['snippet']['title'],
							'videoId' => $searchResult['id']['videoId'],
						);
						break;
				}
			}
			
		} catch (Google_Service_Exception $e) {
			$retur['error'] = sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
			//$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
		} catch (Google_Exception $e) {
			$retur['error'] = sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
			//$htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
		}
		
		echo json_encode( $retur );
		
	}
	
	public function Teste()
	{
		
		$TextSearch = isset($_POST['TextSearch']) ? trim($_POST['TextSearch']) : '';
		
		$this->searchVideos( $TextSearch );
		
		//return 'testado ' . $TextSearch . ' --  ' . implode(' - ', $this->youtube_key);
	}
}
