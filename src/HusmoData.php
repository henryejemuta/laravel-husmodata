<?php

namespace HenryEjemuta\LaravelHusmoData;

use HenryEjemuta\LaravelHusmoData\Classes\HusmoDataResponse;
use HenryEjemuta\LaravelHusmoData\Enums\NetworkEnum;
use HenryEjemuta\LaravelHusmoData\Exceptions\HusmoDataErrorException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class HusmoData
{
    /**
     * base url
     *
     * @var string
     */
    private $baseUrl;

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * the session key
     *
     * @var string
     */
    protected $instanceName;

    protected $config;

    public function __construct($baseUrl, $instanceName, $config)
    {
        $this->baseUrl = $baseUrl;
        $this->instanceName = $instanceName;
        $this->config = $config;
    }

    /**
     * get instance name of the cart
     *
     * @return string
     */
    public function getInstanceName()
    {
        return $this->instanceName;
    }

    /**
     * @param array $headers
     * @return PendingRequest
     */
    private function withAuth(array $headers = []): PendingRequest
    {
        return Http::withToken($this->config['api_token'], 'Token')->withHeaders($headers)->contentType("application/json");
    }

    /**
     * Make GET request with data and auth
     * @param string $endpoint
     * @param array $data
     * @return HusmoDataResponse
     * @throws HusmoDataErrorException
     */
    public function getRequest(string $endpoint, array $data = []): HusmoDataResponse
    {
        $response = $this->withAuth()->get("{$this->baseUrl}$endpoint", $data);
//        dd($response->body());
        if ($response->status() == 200)
            return new HusmoDataResponse($response->object());
        throw new HusmoDataErrorException($response->body(), $response->status());
    }

    /**
     * Make POST request with data and auth
     * @param string $endpoint
     * @param array $data
     * @return HusmoDataResponse
     * @throws HusmoDataErrorException
     */
    public function postRequest(string $endpoint, array $data = []): HusmoDataResponse
    {
        $response = $this->withAuth()->post("{$this->baseUrl}$endpoint", $data);
//        dd($response->object(), $response, new HusmoDataResponse($response->object()));

        if ($response->status() == 200)
            return new HusmoDataResponse($response->object());
        throw new HusmoDataErrorException($response->body(), $response->status());
    }

    /**
     * Get Your MegaSub account details including available balance
     * @return HusmoDataResponse
     * @throws HusmoDataErrorException
     */
    public function checkUserDetails(): HusmoDataResponse
    {
        return $this->getRequest("user/");
    }

    /**
     * @param NetworkEnum $mobileNetwork
     * @param int $amount
     * @param $phoneNumber
     * @param bool $portedNumber
     * @param string $airtimeType
     * @return HusmoDataResponse
     * @throws HusmoDataErrorException
     */
    public function buyAirtime(NetworkEnum $mobileNetwork, int $amount, $phoneNumber, bool $portedNumber = true, string $airtimeType = "VTU"): HusmoDataResponse
    {
        return $this->postRequest("topup/", [
            'network' => $mobileNetwork->getCode(),
            'amount' => $amount,
            'mobile_number' => $phoneNumber,
            'Ported_number' => $portedNumber,
            'airtime_type' => $airtimeType
        ]);
        //{"id":16230,"airtime_type":"VTU","network":1,"paid_amount":"97.0","mobile_number":"08132796615","amount":"100","plan_amount":"N100","plan_network":"MTN","balance_before":"2892.6","balance_after":"2795.6","Status":"successful","create_date":"2021-08-28T21:02:54.311846","Ported_number":true}
    }

    private $transaction;

    /**
     * HusmoData API Transaction handler to access:
     * Transaction()->getAllDataTransaction(): HusmoDataResponse
     * Transaction()->queryDataTransaction(int $txnId): HusmoDataResponse
     * Transaction()->queryAirtimeTransaction(int $txnId): HusmoDataResponse
     * Transaction()->queryElectricityBillTransaction(int $txnId): HusmoDataResponse
     * Transaction()->queryCableTvTransaction(int $txnId): HusmoDataResponse
     *
     * @return Transaction
     */
    public function Transaction(): Transaction
    {
        if (is_null($this->transaction))
            $this->transaction = new class($this) extends Transaction {
            };
        return $this->transaction;
    }

    private $cableTv;

    /**
     * Cable TV Bill handler to access:
     * CableTv()->verifyIUC(CableTvEnum $cableTv, $smartCardNo): HusmoDataResponse
     * CableTv()->purchasePackage(CableTvEnum $cableTv, string $package, $smartCardNo): HusmoDataResponse
     *
     * @return CableTv
     */
    public function CableTv(): CableTv
    {
        if (is_null($this->cableTv))
            $this->cableTv = new class($this, $this->config) extends CableTv {
            };
        return $this->cableTv;
    }


    /**
     * @param NetworkEnum $network
     * @param string $plan
     * @param string $phoneNumber
     * @param bool $portedNumber
     * @return HusmoDataResponse
     * @throws HusmoDataErrorException
     */
    public function buyData(NetworkEnum $network, string $plan, string $phoneNumber, bool $portedNumber = true): HusmoDataResponse
    {
        return $this->postRequest('data/', [
            'network' => $network->getCode(),
            'plan' => $plan,
            'mobile_number' => $phoneNumber,
            'Ported_number' => $portedNumber,
        ]);
    }


    private $electricity;

    /**
     * Electricity Bills payment handler to access:
     * Electricity()->verifyMeterNumber(DiscoEnum $disco, $meterNumber, MeterTypeEnum $meterType): HusmoDataResponse
     * Electricity()->buyElectricity(DiscoEnum $disco, $meterNumber, $amount, MeterTypeEnum $meterType): HusmoDataResponse
     *
     * @return Electricity
     */
    public function Electricity(): Electricity
    {
        if (is_null($this->electricity))
            $this->electricity = new class($this, $this->config) extends Electricity {
            };
        return $this->electricity;
    }
}
