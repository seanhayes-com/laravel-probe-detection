<?php

namespace SeanHayes\Probe;

use DB;
use Torann\GeoIP\Facades\GeoIP;

class Probe
{

    public static function logRequest($identifier = 'default')
    {

        //dd(config('probe'));
        $do_geolocate = config('probe.geolocate_ip');
        $do_hostname = config('probe.resolve_hostnames');

        $ignore_ips = config('probe.ignore_ips');
        $ignore_agents = config('probe.ignore_agents');
        $ignore_isocodes = config('probe.ignore_isocodes');

        //dd($ignore_agents);

        $watch_ips = config('probe.watch_ips');
        $watch_agents = config('probe.watch_agents');
        $watch_isocodes = config('probe.watch_isocodes');
        $watch_refers = config('probe.watch_refers');
		$watch_uris = config('probe.watch_uris');

        $dolog = false;
        $doban = false;

        $target = [];

        $target['ip'] = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
        $target_location = ($do_geolocate) ? geoip($target['ip']) : '';
        $target['agent'] = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';

        $target['identifier'] = (!empty($identifier)) ? $identifier : '';
        $target['uri'] = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
        $target['refer'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
        $target['host'] = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : '';
        $target['city'] = (isset($target_location->city) && !empty($target_location->city)) ? $target_location->city : '';
        $target['state'] = (isset($target_location->state) && !empty($target_location->state)) ? $target_location->state : '';
        $target['postcode'] = (isset($target_location->postal_code) && !empty($target_location->postal_code)) ? $target_location->postal_code : '';
        $target['hostname'] = ($do_hostname) ? gethostbyaddr($target['ip']) : '';
        $target['created_at'] = date('Y-m-d H:i:s');
        $target['updated_at'] = date('Y-m-d H:i:s');
        $target['iso_code'] = (isset($target_location->iso_code) && !empty($target_location->iso_code)) ? $target_location->iso_code : '';
		
        $ignore_this_ip = self::exactInList($target['ip'], $ignore_ips);
        $ignore_this_agent = self::matchInList($target['agent'], $ignore_agents);
        $ignore_this_isocode = self::exactInList($target['iso_code'], $ignore_isocodes);

        if ($ignore_this_ip || $ignore_this_agent || $ignore_this_isocode) {
            $dolog = false;
            $doban = false;
        } else {
            $dolog = true;
        }

        $watch_this_ip = self::exactInList($target['ip'], $watch_ips);
        $watch_this_agent = self::matchInList($target['agent'], $watch_agents);
        $watch_this_isocode = self::exactInList($target['iso_code'], $watch_isocodes);
        $watch_this_refer = self::matchInList($target['refer'], $watch_refers);
		$watch_this_uri = self::matchInList($target['uri'], $watch_uris);
		
        if ($watch_this_ip || $watch_this_agent || $watch_this_isocode || $watch_this_refer || $watch_this_uri) {
            $dolog = true;
            $doban = true;
        }

        if ($dolog) {
            $item_id = DB::table('probe_log')->insertGetId($target);
        }

        if ($doban) {
			abort(503);
        }
    }

    public static function matchInList($needle, $haystack)
    {
        $has_matches = false;

        if (!is_array($haystack) && !empty($haystack)) {
            $haystack[0] = $haystack;
        }

        if (is_array($haystack)) {
            foreach ($haystack as $bale) {
                if (stristr($needle, $bale)) {
                    $has_matches = true;
                }
            }
        }

        return $has_matches;
    }

    public static function exactInList($needle, $haystack)
    {
        if (!is_array($haystack) && !empty($haystack)) {
            $haystack[0] = $haystack;
        }

        if (is_array($haystack) && in_array($needle, $haystack)) {
            return true;
        } else {
            return false;
        }
    }
}
