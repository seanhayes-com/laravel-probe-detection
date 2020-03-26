<?php

namespace SeanHayes\Probe\Tests;

use SeanHayes\Probe\Probe;

class ProbeTest extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
		
		$this->probe = new Probe;
		
		//mock up config	
	    $this->do_geolocate 	= false;
	    $this->do_hostname 		= false;
	    $this->ignore_ips 		= ['127.0.0.1'];
	    $this->ignore_agents 	= ['Googlebot',
		'Bingbot',
		'Slurp',
		'DuckDuckBot',
		'Baiduspider',
		'YandexBot',
		'Sogou',
		'Exabot',
		'facebookexternalhit',
		'facebot',
		'ia_archiver'];
	    $this->ignore_isocodes 	= [];
	    $this->watch_ips 		= [];
	    $this->watch_agents 	= ['Installatron',
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
		'PhantomJS'];
	    $this->watch_isocodes 	= [];
	    $this->watch_refers 	= ['.cn',
		'.ru',];
		$this->watch_uris 		= ['/wp-login.php',
		'/wp-admin.php',
		'/xmlrpc.php',
		'/wp-cron.php',
		'/wp-content/',
		'/wp-admin/',
		'UNION%20SELECT%20',];
		
		$this->test_target = [
			'ip' => '123.123.123.123',
			'agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:7.0.1) Gecko/20100101 Firefox/7.0.1',
			'identifier' => 'test',
			'uri' => '/test',
			'refer' => 'https://google.com/',
			'host' => 'test.host',
			'city' => 'San Diego',
			'state' => 'CA',
			'postcode' => '92121',
			'hostname' => 'target.host',
			'created_at' => '2020-01-01 00:00:01',
			'updated_at' => '2020-01-01 00:00:02',
			'iso_code' => 'US'
		];

    }
	
    public function test_can_find_exact_string_in_list()
    {
		
        $this->assertTrue($this->probe->exactInList('127.0.0.1', $this->ignore_ips));
		
    }
	
    public function test_can_find_exact_match_in_list()
    {
		
        $this->assertTrue($this->probe->matchInList('Googlebot', $this->ignore_agents));
		
    }
		
    public function test_can_set_valid_target_ip()
    {
				
		$this->assertRegExp('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $this->probe->target_ip);
				
    }
	
    public function test_target_array_contains_ip()
    {
	    $this->assertArrayHasKey('ip', $this->probe->setTarget());
    }
	
    public function test_target_array_contains_agent()
    {
	    $this->assertArrayHasKey('agent', $this->probe->setTarget());
    }
	
    public function test_target_array_contains_identifier()
    {
	    $this->assertArrayHasKey('identifier', $this->probe->setTarget());
    }
	
    public function test_target_array_contains_uri()
    {
	    $this->assertArrayHasKey('uri', $this->probe->setTarget());
    }
	
    public function test_target_array_contains_refer()
    {
	    $this->assertArrayHasKey('refer', $this->probe->setTarget());
    }
	
    public function test_target_array_contains_host()
    {
	    $this->assertArrayHasKey('host', $this->probe->setTarget());
    }
	
    public function test_target_array_contains_city()
    {
	    $this->assertArrayHasKey('city', $this->probe->setTarget());
    }
	
    public function test_target_array_contains_state()
    {
	    $this->assertArrayHasKey('state', $this->probe->setTarget());
    }
	
    public function test_target_array_contains_postcode()
    {
	    $this->assertArrayHasKey('postcode', $this->probe->setTarget());
    }
	
    public function test_target_array_contains_hostname()
    {
	    $this->assertArrayHasKey('hostname', $this->probe->setTarget());
    }
	
    public function test_target_array_contains_created_at()
    {
	    $this->assertArrayHasKey('created_at', $this->probe->setTarget());
    }
	
    public function test_target_array_contains_updated_at()
    {
	    $this->assertArrayHasKey('updated_at', $this->probe->setTarget());
    }
	
    public function test_target_array_contains_iso_code()
    {
	    $this->assertArrayHasKey('iso_code', $this->probe->setTarget());
    }

    public function test_can_set_valid_target_agent()
    {
		$this->assertIsString($this->probe->target_agent);				
    }
	
    public function test_can_set_valid_identifier()
    {
		$this->assertIsString($this->probe->identifier);				
    }
	
    public function test_can_set_valid_request_uri()
    {
		$this->assertIsString($this->probe->request_uri);				
    }
	
    public function test_can_set_valid_request_refer()
    {
		$this->assertIsString($this->probe->request_refer);				
    }
	
    public function test_can_set_valid_request_host()
    {
		$this->assertIsString($this->probe->request_host);				
    }
	
    public function test_can_set_valid_target_location()
    {
		$this->assertIsString($this->probe->target_location);				
    }
	
    public function test_can_set_valid_target_city()
    {
		$this->assertIsString($this->probe->target_city);				
    }
	
    public function test_can_set_valid_target_state()
    {
		$this->assertIsString($this->probe->target_state);				
    }
	
    public function test_can_set_valid_target_postal_code()
    {
		$this->assertIsString($this->probe->target_postal_code);				
    }
	
    public function test_can_set_valid_target_hostname()
    {
		$this->assertIsString($this->probe->target_hostname);				
    }
	
    public function test_can_set_valid_target_iso_code()
    {
		$this->assertIsString($this->probe->target_iso_code);				
    }
}
