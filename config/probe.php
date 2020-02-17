<?php

return [

    /*
     * Determine if we should look up the full hostname
     */
    'resolve_hostnames' => false,

    /*
     * Determine if we should look up the GEO Location
     */
    'geolocate_ip' => true,
	
    /*
     * IP addresses to ignore logging for
     */
    'ignore_ips' => array(
    	'127.0.0.2',
    ),
	
    /*
     * User Agents to ignore logging
     */
    'ignore_agents' => array(
    	'Googlebot',
		'Bingbot',
		'Slurp',
		'DuckDuckBot',
		'Baiduspider',
		'YandexBot',
		'Sogou',
		'Exabot',
		'facebookexternalhit',
		'facebot',
		'ia_archiver'
    ),
	
    /*
     * ISO Country codes to ignore logging
     */
    'ignore_isocodes' => array(
    	
    ),
	
    /*
     * IP addresses to auto ban
     */
    'watch_ips' => array(
  	  	
    ),
	
    /*
     * User Agents to auto ban
	 * See http://www.botreports.com/badbots/index.shtml
     */
    'watch_agents' => array(
    	'80legs.com',
		'Aboundex',
		'BLEXBot',
		'BlinkaCrawler',
		'BomboraBot',
		'BUbiNG',
		'Bytespider',
		'CCBot',
		'CRAZYWEBCRAWLER',
		'DotBot',
		'EventMachine',
		'istellabot',
		'libwww-perl',
		'LMAO',
		'MauiBot',
		'MJ12bot',
		'NerdyBot',
		'PhantomJS'
    ),
	
    /*
     * ISO Country codes to auto ban (Alpha 2-codes)
	 * https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes
     */
    'watch_isocodes' => array(
    	
    ),
	
    /*
     * Referrers to auto ban
     */
    'watch_refers' => array(
  	  	'.cn',
		'.ru',
    ),
	
    /*
     * URIs to auto ban
     */
    'watch_uris' => array(
  	  	'/wp-login.php',
		'/wp-admin.php',
		'UNION%20SELECT%20',
    ),
	
	

];