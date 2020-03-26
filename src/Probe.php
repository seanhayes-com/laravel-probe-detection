<?php

namespace SeanHayes\Probe;

use DB;
use Torann\GeoIP\Facades\GeoIP;

class Probe
{
    public function __construct($identifier = 'default', $do_geolocate = false, $do_hostname = false)
    {
        $this->target_ip = $this->setTargetIp();
        $this->target_agent = $this->setUserAgent();
        $this->identifier = $this->setIndentifier($identifier);
        $this->request_uri = $this->setRequestUri();
        $this->request_refer = $this->setRequestRefer();
        $this->request_host = $this->setRequestHost();
        $this->target_location = ($do_geolocate) ? geoip($this->target_ip) : '';
        $this->target_city = $this->setTargetCity($this->target_location);
        $this->target_state = $this->setTargetState($this->target_location);
        $this->target_postal_code = $this->setTargetPostalCode($this->target_location);
        $this->target_hostname = ($do_hostname) ? gethostbyaddr($this->target_ip) : '';
        $this->target_iso_code = $this->setTargetIsoCode($this->target_location);
    }

    public static function logRequest($identifier = 'default')
    {
        $do_geolocate = config('probe.geolocate_ip');
        $do_hostname = config('probe.resolve_hostnames');
        $ignore_ips = config('probe.ignore_ips');
        $ignore_agents = config('probe.ignore_agents');
        $ignore_isocodes = config('probe.ignore_isocodes');
        $watch_ips = config('probe.watch_ips');
        $watch_agents = config('probe.watch_agents');
        $watch_isocodes = config('probe.watch_isocodes');
        $watch_refers = config('probe.watch_refers');
        $watch_uris = config('probe.watch_uris');
        $dolog = false;
        $doban = false;

        $target = $this->setTarget();

        $ignore_this_ip = $this->exactInList($target['ip'], $ignore_ips);
        $ignore_this_agent = $this->matchInList($target['agent'], $ignore_agents);
        $ignore_this_isocode = $this->exactInList($target['iso_code'], $ignore_isocodes);
        $watch_this_ip = $this->exactInList($target['ip'], $watch_ips);
        $watch_this_agent = $this->matchInList($target['agent'], $watch_agents);
        $watch_this_isocode = $this->exactInList($target['iso_code'], $watch_isocodes);
        $watch_this_refer = $this->matchInList($target['refer'], $watch_refers);
        $watch_this_uri = $this->matchInList($target['uri'], $watch_uris);
		
        if ($ignore_this_ip || $ignore_this_agent || $ignore_this_isocode) {
            $dolog = false;
            $doban = false;
        } else {
            $dolog = true;
        }

        if ($watch_this_ip || $watch_this_agent || $watch_this_isocode || $watch_this_refer || $watch_this_uri) {
            $dolog = true;
            $doban = true;
        }

        if ($dolog) {
            $item_id = $this->setLogEntry($target);
        }

        if ($doban) {
            abort(503);
        }
    }

    public function matchInList($needle, $haystack)
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

    public function exactInList($needle, $haystack)
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

    public function setTarget()
    {
        $target = [];
        $target['ip'] = $this->target_ip;
        $target['agent'] = $this->target_agent;
        $target['identifier'] = $this->identifier;
        $target['uri'] = $this->request_uri;
        $target['refer'] = $this->request_refer;
        $target['host'] = $this->request_host;
        $target['city'] = $this->target_city;
        $target['state'] = $this->target_state;
        $target['postcode'] = $this->target_postal_code;
        $target['hostname'] = $this->target_hostname;
        $target['created_at'] = date('Y-m-d H:i:s');
        $target['updated_at'] = date('Y-m-d H:i:s');
        $target['iso_code'] = $this->target_iso_code;

        return $target;
    }

    public function setLogEntry($target)
    {
        $item_id = DB::table('probe_log')->insertGetId($target);

        return $item_id;
    }

    public function getLogEntry()
    {
        return $this->target_ip;
    }

    public function setTargetIp()
    {
        return (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
    }

    public function getTargetIp()
    {
        return $this->target_ip;
    }

    public function setUserAgent()
    {
        return (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }

    public function getUserAgent()
    {
        return $this->target_agent;
    }

    public function setIndentifier()
    {
        return (!empty($identifier)) ? $identifier : '';
    }

    public function getIndentifier()
    {
        return $this->identifier;
    }

    public function setRequestUri()
    {
        return (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
    }

    public function getRequestUri()
    {
        return $this->request_uri;
    }

    public function setRequestRefer()
    {
        return (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
    }

    public function getRequestRefer()
    {
        return $this->request_refer;
    }

    public function setRequestHost()
    {
        return (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : '';
    }

    public function getRequestHost()
    {
        return $this->request_host;
    }

    public function setTargetCity($target_location)
    {
        return (isset($target_location->city) && !empty($target_location->city)) ? $target_location->city : '';
    }

    public function getTargetCity()
    {
        return $this->target_city;
    }

    public function setTargetState($target_location)
    {
        return (isset($target_location->state) && !empty($target_location->state)) ? $target_location->state : '';
    }

    public function getTargetState()
    {
        return $this->target_state;
    }

    public function setTargetPostalCode($target_location)
    {
        return (isset($target_location->postal_code) && !empty($target_location->postal_code)) ? $target_location->postal_code : '';
    }

    public function getTargetPostalCode()
    {
        return $this->target_postal_code;
    }

    public function setTargetIsoCode($target_location)
    {
        return (isset($target_location->iso_code) && !empty($target_location->iso_code)) ? $target_location->iso_code : '';
    }

    public function getTargetIsoCode()
    {
        return $this->target_iso_code;
    }
}
