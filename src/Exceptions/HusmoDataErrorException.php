<?php
/**
 * Created By: Henry Ejemuta
 * PC: Enrico Systems
 * Project: laravel-husmodata
 * Company: Stimolive Technologies Limited
 * Class Name: HusmoDataErrorException.php
 * Date Created: 9/27/20
 * Time Created: 7:24 PM
 */

namespace HenryEjemuta\LaravelHusmoData\Exceptions;


class HusmoDataErrorException extends \Exception
{
    /**
     * HusmoDataErrorException constructor.
     * @param string $message
     * @param $code
     */
    public function __construct(string $message, $code)
    {
        parent::__construct($message, $code);
    }
}
