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

abstract class Transaction
{
    private $husmoData;

    /**
     * Transactions constructor.
     * @param HusmoData $husmoData
     */
    public function __construct(HusmoData $husmoData)
    {
        $this->husmoData = $husmoData;
    }


    /**
     * Get All Data Transactions
     * @return HusmoDataResponse
     * @throws Exceptions\HusmoDataErrorException
     */
    public function getAllDataTransaction(): HusmoDataResponse
    {
        return $this->husmoData->getRequest("data/");
    }

    /**
     * Query Transactions
     * @param string $txnType
     * @param int $txnId
     * @return HusmoDataResponse
     * @throws Exceptions\HusmoDataErrorException
     */
    private function queryTransaction(string $txnType, int $txnId): HusmoDataResponse
    {
        return $this->husmoData->getRequest("$txnType/$txnId");
    }

    /**
     * Query Data Transactions
     * @param int $txnId
     * @return HusmoDataResponse
     * @throws Exceptions\HusmoDataErrorException
     */
    public function queryDataTransaction(int $txnId): HusmoDataResponse
    {
        return $this->queryTransaction('data', $txnId);
    }

    /**
     * Query Airtime Transactions
     * @param int $txnId
     * @return HusmoDataResponse
     * @throws Exceptions\HusmoDataErrorException
     */
    public function queryAirtimeTransaction(int $txnId): HusmoDataResponse
    {
        return $this->queryTransaction('topup', $txnId);
    }

    /**
     * Query Bill Payment Transactions
     * @param int $txnId
     * @return HusmoDataResponse
     * @throws Exceptions\HusmoDataErrorException
     */
    public function queryElectricityBillTransaction(int $txnId): HusmoDataResponse
    {
        return $this->queryTransaction('billpayment', $txnId);
    }

    /**
     * Query Cable Subscription Transactions
     * @param int $txnId
     * @return HusmoDataResponse
     * @throws Exceptions\HusmoDataErrorException
     */
    public function queryCableTvTransaction(int $txnId): HusmoDataResponse
    {
        return $this->queryTransaction('cablesub', $txnId);
    }

}
