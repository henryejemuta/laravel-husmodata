<?php
/**
 * Created By: Henry Ejemuta
 * PC: Enrico Systems
 * Project: laravel-husmodata
 * Company: Stimolive Technologies Limited
 * Class Name: HusmoDataResponse.php
 * Date Created: 9/27/20
 * Time Created: 6:00 PM
 */

namespace HenryEjemuta\LaravelHusmoData\Classes;


use HenryEjemuta\LaravelHusmoData\Enums\HusmoDataStatusCodeEnum;
use HenryEjemuta\LaravelHusmoData\Exceptions\HusmoDataErrorException;

class HusmoDataResponse
{
    private $message;

    /**
     * @var bool
     */
    private $hasError;

    /**
     * @var HusmoDataErrorException
     */
    private $error;

    /**
     * @var int
     */
    private $code;

    /**
     * Response Body from
     * @var object|null $body
     */
    private $body;


    /**
     * HusmoDataResponse constructor.
     * @param object|array|null $responseBody
     */
    public function __construct($responseBody = null)
    {
        if (isset($responseBody->status)) {
            $statusCode = HusmoDataStatusCodeEnum::getStatusCode($responseBody->status);
            $this->code = $statusCode->getCode();
            $remark = ($responseBody->status == $statusCode->getRemark()) ? '' : $statusCode->getRemark();
            $this->message = $remark . (!empty($remark) ? ', ' : '') . $statusCode->getDescription();
        } else {
            $this->code = 200;
            $this->message = '';
        }

        $this->body = $responseBody;
        $this->hasError = !in_array($this->code, HusmoDataStatusCodeEnum::$successCodes);

        if ($this->hasError) {
            $this->error = new HusmoDataErrorException($this->message, $this->code);
        } else {
            $this->error = null;
        }

    }

    /**
     * Determine if this is a success response object
     * @return bool
     */
    public function successful(): bool
    {
        return !($this->hasError);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Returns HusmoDataErrorException with appropriate HusmoData status code and Message if this isn't a successful response, otherwise, null is returned
     * @return HusmoDataErrorException|null
     */
    public function getErrorException()
    {
        return $this->error;
    }

    /**
     * Return the response body as specified in the ClubKunnect API documentation for the corresponding request. This would be null on fail request
     * @return object|array|null
     */
    public function getBody()
    {
        return $this->body;
    }

    public function __toString()
    {
        return json_encode($this->body);
    }

}
