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
use HenryEjemuta\LaravelHusmoData\Enums\DiscoEnum;
use HenryEjemuta\LaravelHusmoData\Enums\MeterTypeEnum;

abstract class Electricity
{
    private $config;
    private $husmoData;

    public function __construct(HusmoData $husmoData, $config)
    {
        $this->config = $config;
        $this->husmoData = $husmoData;
    }

    /**
     * @param DiscoEnum $disco
     * @param $meterNumber
     * @param $meterType
     * @return HusmoDataResponse
     * @throws Exceptions\HusmoDataErrorException
     */
    public function verifyMeterNumber(DiscoEnum $disco, $meterNumber, MeterTypeEnum $meterType): HusmoDataResponse
    {
        return $this->husmoData->getRequest('validatemeter', [
            'disconame' => $disco->getID(),
            'meternumber' => $meterNumber,
            'mtype' =>  $meterType->getCode(),
        ]);
    }

    /**
     * @param DiscoEnum $disco
     * @param $meterNumber
     * @param $amount
     * @param MeterTypeEnum $meterType
     * @return HusmoDataResponse
     * @throws Exceptions\HusmoDataErrorException
     */
    public function buyElectricity(DiscoEnum $disco, $meterNumber, $amount, MeterTypeEnum $meterType): HusmoDataResponse
    {
        return $this->husmoData->postRequest('billpayment/', [
            'disco_name' => $disco->getID(),
            'meter_number' => $meterNumber,
            'amount' => $amount,
            'MeterType' => $meterType->getCode()
        ]);
    }

}
