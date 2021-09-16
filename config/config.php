<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    /*
     * ---------------------------------------------------------------
     * Base Url
     * ---------------------------------------------------------------
     *
     * The HusmoData base url upon which others is based, if not set it's going to use the sandbox version
     */
    'base_url' => env('HUSMODATA_BASE_URL', 'https://www.husmodata.com/api/'),

    /*
     * ---------------------------------------------------------------
     * ApiToken
     * ---------------------------------------------------------------
     *
         * Your HusmoData ApiToken
     */
    'api_token' => env('HUSMODATA_API_TOKEN'),
];
