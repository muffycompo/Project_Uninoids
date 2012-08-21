<?php
/**
 * CodeIgniter TwitterFetch Class
 *
 * mmTwitterFetcher fetches Twitter data via the provided Twitter username
 *
 * Original By Joe Auty @ http://www.netmusician.org
 * http://getsparks.org/packages/TwitterFetcher/show
 *
 * Forked 2011-10-13
 * 
 */

class twitterfetcher
{
	function __construct()
	{
		$this->from_cache = true;
		$this->CI =& get_instance();
	}
	function clearCache()
	{
		// cache path
			$path 	= APPPATH."cache/";
		// get files
			$files	= @scandir( $path );
		// files starts with
			$ident	= "twitterstatus_";
		// files found
			if( $files )
			{
				// loop files
				foreach( $files AS $file )
				{
					// file match $ident
					if( substr( $file, 0, 1 ) != "." && substr( $file, 0, strlen( $ident ) ) == $ident )
					{
						// delete file
						@unlink( $path . $file );
					}
				}
			}
		// done
	}
	function getTweetsMulti( $userIds, $configObj = array() )
	{
		if( is_array( $userIds ) || is_object( $userIds ) && is_array( $configObj ) )
		{
			// disable getTweets' output, unless 'get_data' = true
				$this->from_cache = isset( $configObj['return'] ) ? $configObj['return'] : false;
			// enable cache
				$configObj['usecache'] = true;
			// get tweets
				foreach( $userIds AS $key => $username )
				{
					$configObj['twitterID'] = $username;
					$c = $this->getTweets( $configObj );
					if( $this->from_cache )
					{
						$l[ $username ] = $c;
					}
				}
			 // enable getTweets' output
				if( $this->from_cache )
				{
					return isset( $l ) ? $l : false;
				}
			$this->from_cache = true;
			return true;
		}
		return false;
	}
	function getTweets( $configObj = array() )
	{
		// set some defaults
			$configObj['count']			= isset($configObj['count']) 			? $configObj['count'] 			: '5';
			$configObj['usecache']		= isset($configObj['usecache'])			? $configObj['usecache']		: true;
			$configObj['format']		= isset($configObj['format'])			? $configObj['format']			: "json";
			$configObj['cacheduration'] = isset($configObj['cacheduration'])	? $configObj['cacheduration']	: "5";
			$configObj['createlinks']	= isset($configObj['createlinks'])		? $configObj['createlinks']		: true;

		// check [format]
			if( $configObj['format'] != "json" && $configObj['format'] != "xml" )
			{
				show_error('ERROR: mmTwitterFetcher $config["format"] must be either json or xml !');
			}

		// cache file name
			$this->cache_file = APPPATH."cache/twitterstatus_".$configObj['twitterID'].".".$configObj['format'];

		// throw up some errors
			if ( !$configObj['twitterID'] )
			{
				show_error('ERROR: a Twitter ID has not been provided');
			}
		// cache not found - fetch tweets
			else if ( $configObj['usecache'] && !file_exists( $this->cache_file ) )
			{
				$this->downloadTwitterStatus( $configObj );
				//show_error('ERROR: Twitter cache file cannot be found at ' . APPPATH . "cache/twitterstatus." . $configObj['format']);
			}

		if ( $configObj['usecache'] )
		{
		// download new twitter status if older than five minutes

		// timestamp five minutes ago
			$cache = mktime(date('H'), date('i') - $configObj['cacheduration'], date('s'), date('m'), date('d'), date('Y'));	

			if (filemtime( $this->cache_file ) < $cache || !file_get_contents( $this->cache_file ) )
			{
				// refresh cache
				$this->downloadTwitterStatus($configObj);
			}		

			// Dont get cache data !
				if( !$this->from_cache )
				{
					return;
				}

			if ( file_get_contents( $this->cache_file ) )
			{
				$twitterstatus = $this->formatTweets($configObj, json_decode( file_get_contents( $this->cache_file ) ) );	

				if ($configObj['count'] == 1)
				{
					if (isset($twitterstatus[0]))
					{
						$o[] = $twitterstatus[0];
						return $o; // return first object
					}
					else
					{
						return false;
					}
				}
				else
				{
					return $twitterstatus;		
				}
			}	
		}		
		else
		{
			// Dont get cache data !
				if( !$this->from_cache )
				{
					return;
				}

			$twitterstatus = $this->formatTweets($configObj, $this->downloadTwitterStatus($configObj));

			if ($configObj['count'] == 1)
			{
				if (isset($twitterstatus[0]))
				{
						$o[] = $twitterstatus[0];
						return $o; // return first object
				}
				else
				{
					return false;
				}
			}
			else
			{
				return $twitterstatus;
			}
		}	
	}
	function formatTweets( $configObj, $twitterstatus )
	{
		$totaltweets = count($twitterstatus);
		for ($x=0; $x < $totaltweets; $x++)
		{
			$thiselapsedtime = $this->elapsedTime(strtotime($twitterstatus[$x]->created_at));
			if (isset($configObj['numdays']) && $thiselapsedtime['days'] > $configObj['numdays'])
			{
				unset($twitterstatus[$x]);
				continue;
			}	
			if ($configObj['createlinks'])
			{								
				$twitterstatus[$x]->text = $this->convertToLinks($twitterstatus[$x]->text);	
			}
			$twitterstatus[$x]->elapsedtime = $this->elapsedTimeString($thiselapsedtime);									
		}
		return $twitterstatus;
	}
	function downloadTwitterStatus($configObj)
	{
	// Load the rest client spark
		//$this->CI->load->spark('restclient/2.0.0');
		$this->CI->load->library('Rest','rest');

	// Run some setup
		$this->CI->rest->initialize(array('server' => 'https://api.twitter.com/1/'));

	// Pull in an array of tweets
		if ($configObj['count'])
		{
			$tweeturl = 'statuses/user_timeline.' . $configObj['format'] . '?screen_name=' . $configObj['twitterID'] . '&count=' . $configObj['count'];
		}
		else
		{
			$tweeturl = 'statuses/user_timeline.' . $configObj['format'] . '?screen_name=' . $configObj['twitterID'];
		}
		$tweets = $this->CI->rest->get($tweeturl);

		if ($configObj['usecache'])
		{
			$twittercheck = json_encode($tweets);
			if (is_array($tweets) && isset($tweets[0]) && $tweets[0]->text) {
				//$fh = fopen( APPPATH . "cache/twitterstatus." . $configObj['format'], "w");
				$fh = fopen( $this->cache_file, "w" );
				fwrite($fh, $twittercheck);
				fclose($fh);
			}	
		}	
		else
		{
			return $tweets;
		}
	}
	function convertToLinks($string)
	{
	// added space to beginning and end of string to capture links anchored to either end
		$string = " " . $string . " ";
	// string contained in the middle
		$string = trim(preg_replace('/\s(http|https)\:\/\/(.+?)\s/m', ' <a href = "$1://$2" target="_blank">$1://$2</a> ', $string));
		return $string;
	}
	function elapsedTime ( $start, $end = false)
	{
		$returntime = array();
		// set defaults
			if ($end == false)
			{
				$end = time();
			}

		$diff = $end - $start;
		$days = floor($diff/86400); 

		$diff = $diff - ($days*86400); 
		$hours = floor ($diff/3600); 

		$diff = $diff - ($hours*3600); 
		$mins = floor ($diff/60); 

		$diff = $diff - ($mins*60); 
		$secs = $diff;

		$returntime['secs'] = !is_null( $secs ) ? $secs : "0";
		$returntime['mins'] = !is_null( $mins ) ? $mins : "0";
		$returntime['hours'] = !is_null( $hours ) ? $hours : "0";
		$returntime['days'] = !is_null( $days ) ? $days : "0";

		return $returntime;
	}
	function elapsedTimeString($elapsedtime) {
		if ($elapsedtime['days'] == 0) {
			if ($elapsedtime['hours'] == 0) {
					// show minutes
				return $elapsedtime['mins'] . " minute" . (($elapsedtime['mins']>1) ? "s":"") . " ago";
			}
			else {
					// show hours
				return $elapsedtime['hours'] . " hour" . (($elapsedtime['hours']>1) ? "s":"") . " ago";
			}
		}
		else {
				// show days
			return $elapsedtime['days'] . " day" . (($elapsedtime['days']>1) ? "s":"") . " ago";
		}
	}

}



