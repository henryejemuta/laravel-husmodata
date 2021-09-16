# Laravel HusmoData

[![Latest Version on Packagist](https://img.shields.io/packagist/v/henryejemuta/laravel-husmodata.svg?style=flat-square)](https://packagist.org/packages/henryejemuta/laravel-husmodata)
[![Latest Stable Version](https://poser.pugx.org/henryejemuta/laravel-husmodata/v/stable)](https://packagist.org/packages/henryejemuta/laravel-husmodata)
[![Total Downloads](https://poser.pugx.org/henryejemuta/laravel-husmodata/downloads)](https://packagist.org/packages/henryejemuta/laravel-husmodata)
[![License](https://poser.pugx.org/henryejemuta/laravel-husmodata/license)](https://packagist.org/packages/henryejemuta/laravel-husmodata)
[![Quality Score](https://img.shields.io/scrutinizer/g/henryejemuta/laravel-husmodata.svg?style=flat-square)](https://scrutinizer-ci.com/g/henryejemuta/laravel-husmodata)

## What is HusmoData
The HusmoData API allows you to integrate all virtual top-up and bills payment services available on the HusmoData platform with your application (websites, desktop apps & mobile apps). You can also start your own VTU business by integrating this API and resell HusmoData services in Nigeria.

## What is Laravel HusmoData
Laravel HusmoData is a laravel package to seamlessly integrate HusmoData api within your laravel application.

Create a HusmoData Account [Sign Up](https://www.husmodata.com/signup/).

Get your API Token from your HusmoData Dashboard [Get My API Token](https://www.husmodata.com/documentation/).

Look up HusmoData API Documentation [API Documentation](https://documenter.getpostman.com/view/10645604/TVKHVFW7).

## Installation

You can install the package via composer:

```bash
composer require henryejemuta/laravel-husmodata
```

Publish HusmoData configuration file, migrations as well as set default details in .env file:

```bash
php artisan husmodata:init
```

## Usage

**Important: Kindly use the ``$response->successful()`` to check the response state before proceeding with working with the response and gracefully throw and handle the HusmoDataErrorException on failed request**

Before initiating any transaction kindly check your balance to confirm you have enough HusmoData balance to handle the transaction

The Laravel HusmoData Package is quite easy to use via the HusmoData facade
```php
use HenryEjemuta\LaravelHusmoData\Facades\HusmoData;
use HenryEjemuta\LaravelHusmoData\Classes\HusmoDataResponse;

...

//To buy Airtime
try{
    $response = HusmoDataFacade::buyAirtime(NetworkEnum::getNetwork('mtn'), 100, '08134567890');
} catch (HusmoDataErrorException $exception) {
    Log::error($exception->getMessage() . "\n\r" . $exception->getCode());
}

//A dump of the HusmoDataResponse on successful airtime purchase
/*
HenryEjemuta\LaravelHusmoData\Classes\HusmoDataResponse {#1423 ▼
  -message: ""
  -hasError: false
  -error: null
  -code: 200
  -body: {#1539 ▼
    +"id": 167630
    +"airtime_type": "VTU"
    +"network": 1
    +"paid_amount": "97.0"
    +"mobile_number": "08134567890"
    +"amount": "100"
    +"plan_amount": "₦100"
    +"plan_network": "MTN"
    +"balance_before": "2892.6"
    +"balance_after": "2795.6"
    +"Status": "successful"
    +"create_date": "2021-08-28T21:02:54.311846"
    +"Ported_number": true
  }
}
*/


//To buy Data Bundle
try{
    $response = HusmoDataFacade::buyData(HusmoDataNetworkEnum::getNetwork("mtn"), 7, "08134567890");
} catch (HusmoDataErrorException $exception) {
    Log::error($exception->getMessage() . "\n\r" . $exception->getCode());
}

//A dump of the HusmoDataResponse on successful data purchase
/*
HenryEjemuta\LaravelHusmoData\Classes\HusmoDataResponse {#1423 ▼
  -message: ""
  -hasError: false
  -error: null
  -code: 200
  -body: {#1539 ▼
    +"id": 108602
    +"network": 1
    +"balance_before": "2698.6"
    +"balance_after": "2459.6"
    +"mobile_number": "08134567890"
    +"plan": 7
    +"Status": "successful"
    +"plan_network": "MTN"
    +"plan_name": "1.0GB"
    +"plan_amount": "₦239.0"
    +"create_date": "2021-08-28T21:27:41.169631"
    +"Ported_number": true
  }
}
...
*/

```


Find an overview of all method with comment on what they do and expected arguments
```php

    /**
     * Get Your MegaSub account details including available balance
     * @return HusmoDataResponse
     * @throws HusmoDataErrorException
     */
    public function checkUserDetails(): HusmoDataResponse

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

    /**
     * Cable TV Bill handler to access:
     * CableTv()->verifyIUC(CableTvEnum $cableTv, $smartCardNo): HusmoDataResponse
     * CableTv()->purchasePackage(CableTvEnum $cableTv, string $package, $smartCardNo): HusmoDataResponse
     *
     * @return CableTv
     */
    public function CableTv(): CableTv


    /**
     * @param NetworkEnum $network
     * @param string $plan
     * @param string $phoneNumber
     * @param bool $portedNumber
     * @return HusmoDataResponse
     * @throws HusmoDataErrorException
     */
    public function buyData(NetworkEnum $network, string $plan, string $phoneNumber, bool $portedNumber = true): HusmoDataResponse


    /**
     * Electricity Bills payment handler to access:
     * Electricity()->verifyMeterNumber(DiscoEnum $disco, $meterNumber, MeterTypeEnum $meterType): HusmoDataResponse
     * Electricity()->buyElectricity(DiscoEnum $disco, $meterNumber, $amount, MeterTypeEnum $meterType): HusmoDataResponse
     *
     * @return Electricity
     */
    public function Electricity(): Electricity

```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email henry.ejemuta@gmail.com instead of using the issue tracker.

## Credits

- [Henry Ejemuta](https://github.com/henryejemuta)
- [All Contributors](https://github.com/henryejemuta/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
