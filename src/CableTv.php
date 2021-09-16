<?php
/**
 * Created By: Henry Ejemuta
 * PC: Enrico Systems
 * Project: laravel-husmodata
 * Company: Stimolive Technologies Limited
 * Class Name: Transaction.php
 * Date Created: 5/14/21
 * Time Created: 10:24 AM
 */

namespace HenryEjemuta\LaravelHusmoData;

use HenryEjemuta\LaravelHusmoData\Classes\HusmoDataResponse;
use HenryEjemuta\LaravelHusmoData\Enums\CableTvEnum;

abstract class CableTv
{
    private $config;
    private $husmoData;

    public function __construct(HusmoData $husmoData, $config)
    {
        $this->config = $config;
        $this->husmoData = $husmoData;
    }


    /**
     * @param CableTvEnum $cableTv
     * @param $smartCardNo
     * @return HusmoDataResponse
     * @throws Exceptions\HusmoDataErrorException
     */
    public function verifyIUC(CableTvEnum $cableTv, $smartCardNo): HusmoDataResponse
    {
        return $this->husmoData->getRequest('validateiuc', [
            'cablename' => $cableTv->getID(),
            'smart_card_number' => $smartCardNo,
        ]);
    }

    /**
     * @param CableTvEnum $cableTv
     * @param string $package
     * @param $smartCardNo
     * @return HusmoDataResponse
     * @throws Exceptions\HusmoDataErrorException
     */
    public function purchasePackage(CableTvEnum $cableTv, string $package, $smartCardNo): HusmoDataResponse
    {
        return $this->husmoData->postRequest('cablesub', [
            'cablename' => $cableTv->getID(),
            'cableplan' => $package,
            'smart_card_number' => $smartCardNo,
        ]);
    }


}
