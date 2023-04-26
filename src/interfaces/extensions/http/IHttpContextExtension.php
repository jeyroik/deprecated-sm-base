<?php
namespace df\interfaces\extensions\http;

use gosp\webhooks\interfaces\http\IRequestPattern;

/**
 * Interface IHttpContextExtension
 *
 * @package df\interfaces\extensions\http
 * @author aivanov@fix.ru
 */
interface IHttpContextExtension
{
    /**
     * @param $subject
     *
     * @return IRequestPattern
     */
    public function getPattern($subject);

    /**
     * @param $version
     *
     * @return mixed
     */
    public function setRequestVersion($version);

    /**
     * @return mixed
     */
    public function getRequestVersion();

    /**
     * @return mixed
     */
    public function getRequestParams();

    /**
     * @param $params
     *
     * @return mixed
     */
    public function setRequestParams($params);

    /**
     * @param $name
     * @param $default
     *
     * @return mixed
     */
    public function getRequestParam($name, $default = null);

    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function setRequestParam($name, $value);

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasRequestParam($name): bool;

    /**
     * @return bool
     */
    public function isRequestJson(): bool;

    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function addToResponseData($key, $value);

    /**
     * @param $status
     *
     * @return IHttpContextExtension
     */
    public function setStatus($status);

    /**
     * @return mixed
     */
    public function getResponse();

    /**
     * @param $response
     *
     * @return mixed
     */
    public function setResponse($response);
}
