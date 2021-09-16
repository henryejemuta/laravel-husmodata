<?php

namespace HenryEjemuta\LaravelHusmoData;

use HenryEjemuta\LaravelHusmoData\Classes\HusmoDataResponse;
use HenryEjemuta\LaravelHusmoData\Enums\NetworkEnum;
use Illuminate\Support\Facades\Facade;

/**
 * @method static HusmoDataResponse checkUserDetails()
 * @method static HusmoDataResponse buyAirtime(NetworkEnum $mobileNetwork, int $amount, $phoneNumber, bool $portedNumber = true, string $airtimeType = "VTU")
 * @method static Transaction Transaction()
 * @method static CableTv CableTv()
 * @method static Electricity Electricity()
 * @method static HusmoDataResponse buyData(NetworkEnum $network, string $plan, string $phoneNumber, bool $portedNumber = true)
 *
 * For respective method implementation:
 * @see \HenryEjemuta\LaravelHusmoData\HusmoData
 */
class HusmoDataFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'husmodata';
    }
}
