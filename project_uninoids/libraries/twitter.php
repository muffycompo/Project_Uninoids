<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');	
	
/**
 * Very Simple Twitter Helper
 *
 * Contents are cached with the file driver
 *
 * @author 		Boris Strahija <boris@creolab.hr>
 * @copyright 	Copyright (c) 2011, Boris Strahija, Creo
 * @version 	0.1
 */

class Twitter {
	
	protected static $ci;
	protected static $base_url = 'https://api.twitter.com/1/';
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public function __construct()
	{
		self::$ci = get_instance();
		
		// Load resources
		self::$ci->load->driver('cache', array('adapter' => self::$ci->config->item('twitter_cache_driver'), 'backup' => 'file'));
		
	} // __construct()
	
	/* ------------------------------------------------------------------------------------------ */
	
	public static function timeline($username = null, $num = 5)
	{
		if ( ! $username) $username = self::$ci->config->item('twitter_default_user');
		
		if ($tweets = self::$ci->cache->file->get('twitter_timeline_'.$username.'_'.$num))
		{
			return $tweets;
		}
		else
		{
			// Get tweets
			$call_url = self::$base_url.'statuses/user_timeline.json?screen_name='.$username.'&count='.$num;
			$tweets = json_decode(file_get_contents($call_url));
			
			if($tweets)
			{
				// Format some of the data
				foreach ($tweets as $key=>$tweet)
				{
					$tweets[$key]->text            = self::auto_link((string) $tweet->text);
					$tweets[$key]->when            = strtotime((string) $tweet->created_at);
					$tweets[$key]->author          = (string) $tweet->user->name;
				}
				
				// Cache results
				self::$ci->cache->file->save('twitter_timeline_'.$username.'_'.$num, $tweets, self::$ci->config->item('twitter_cache_ttl'));
				
				return $tweets;
			}
		}
		
		return null;
	        
	} // twitter_timeline()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public static function timeline_list($username = null, $num = 5, $return = false)
	{
		$tweets = self::timeline($username, $num);
		
		if ($tweets)
		{
			$html = '<ul class="twitter-timeline-list">';
			
			foreach ($tweets as $tweet)
			{
				$html .= '<li><p>'.$tweet->text.'</p>';
				$html .= '</li>';
			}
			
			$html .= '</ul>';
			
			if ($return) return $html;
			else         echo   $html;
		}
		
		return null;
		
	} // timeline_list()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
	/**
	 *
	 */
	public static function auto_link($string = '')
	{
		$search  = array('|#([\w_]+)|', '|@([\w_]+)|');
		$replace = array('<a href="http://search.twitter.com/search?q=%23$1" target="_blank">#$1</a>', '<a href="http://twitter.com/$1" target="_blank">@$1</a>');
		$string  = preg_replace($search, $replace, $string);
		
		return auto_link($string);
		
	} // auto_link()
	
	
	/* ------------------------------------------------------------------------------------------ */
	
} // Twitter 


/* End of file twitter.php */