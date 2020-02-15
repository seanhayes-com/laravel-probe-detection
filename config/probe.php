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
     * Here you may configure the "store" that the underlying Client will
     * use to store it's data.  You may also add extra parameters that will
     * be passed on setCacheConfig.
     *
     * Optional parameters: "lifetime", "prefix"
     */
    'cache' => [
        'store' => 'file',
    ],
];