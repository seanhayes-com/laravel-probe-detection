<?php

namespace SeanHayes\Probe;

use \Torann\GeoIP\Facades\GeoIP;

class Probe
{
    //protected $inv;

    public function __construct()
    {
        //$this->val = 'probe';
    }

    public function logRequest($identifier='default')
    {
        $do_geolocate = config('probe.geolocate_ip');
		$do_hostname = config('probe.resolve_hostnames');
		
		$target = [];
		
		$target['uri'] = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
		$target['ip'] = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
		$target['agent'] = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$target['refer'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		
		$target['location'] = ($do_geolocate) ? geoip($target_ip) : '';
		
		$target['hostname'] = ($do_hostname) ? gethostbyaddr($target_ip) : '';
		
		dd($target);
		
    }
}
