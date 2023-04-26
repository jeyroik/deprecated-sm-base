<?php
namespace df\components\extensions\http;

use gosp\webhooks\components\http\HttpJsonResponse;
use gosp\webhooks\components\http\patterns\PatternAbstract;
use gosp\webhooks\components\http\patterns\PatternFactory;
use gosp\webhooks\interfaces\http\patterns\IPatternBase;

use df\interfaces\extensions\http\IHttpContextExtension;
use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\components\systems\SystemContainer;
use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class HttpContextExtension
 *
 * @package df\components\extensions\http
 * @author aivanov@fix.ru
 */
class HttpContextExtension extends Extension implements IHttpContextExtension
{
    protected const CONTEXT__REQUEST_API = '@api.request';
    protected const CONTEXT__REQUEST_VERSION = '@api.request.version';
    protected const CONTEXT__RESPONSE = '@api.response';

    public $subject = IContext::SUBJECT;

    /**
     * @param $key
     * @param $value
     * @param IContext|null $context
     *
     * @return IContext|mixed
     */
    public function addToResponseData($key, $value, IContext &$context = null)
    {
        $response = $this->getResponse($context);
        $response->addToData($key, $value);
        $this->setResponse($response, $context);

        return $context;
    }

    /**
     * @param $status
     * @param IContext|null $context
     *
     * @return IHttpContextExtension|IContext
     * @throws \Exception
     */
    public function setStatus($status, IContext &$context = null)
    {
        $response = $this->getResponse($context);
        $response->setStatus($status);
        $this->setResponse($response, $context);

        return $context;
    }

    /**
     * @param $response
     * @param IContext|null $context
     *
     * @return IContext|mixed
     */
    public function setResponse($response, IContext &$context = null)
    {
        $context[static::CONTEXT__RESPONSE] = $response;

        return $context;
    }

    /**
     * @param IContext|null $context
     *
     * @return mixed|HttpJsonResponse
     */
    public function getResponse(IContext $context = null)
    {
        if (!isset($context[static::CONTEXT__RESPONSE])) {
            $context[static::CONTEXT__RESPONSE] = new HttpJsonResponse();
        }

        return $context[static::CONTEXT__RESPONSE];
    }

    /**
     * @param IContext|null $context
     *
     * @return mixed
     */
    public function getRequestVersion(IContext $context = null)
    {
        return isset($context[static::CONTEXT__REQUEST_VERSION])
            ? $context[static::CONTEXT__REQUEST_VERSION]
            : IPatternBase::VERSION__DEFAULT;
    }

    /**
     * @param $version
     * @param IContext|null $context
     *
     * @return IContext|mixed
     */
    public function setRequestVersion($version, IContext &$context = null)
    {
        $context[static::CONTEXT__REQUEST_VERSION] = $version;

        return $context;
    }

    /**
     * @param $subject
     * @param IContext|null $context
     *
     * @return \gosp\webhooks\interfaces\http\IRequestPattern
     * @throws \Exception
     */
    public function getPattern($subject, IContext &$context = null)
    {
        /**
         * @var $patternFactory PatternFactory
         */
        $patternFactory = SystemContainer::getItem(PatternFactory::class);
        $pattern = $patternFactory->build($this->getRequestVersion($context), $subject);
        $pattern->import($this->getRequestParams($context));

        return $pattern;
    }

    /**
     * @param $name
     * @param IContext|null $context
     *
     * @return bool
     */
    public function hasRequestParam($name, IContext &$context = null): bool
    {
        $this->parseApiRequest($context);
        $request = $context[static::CONTEXT__REQUEST_API];

        return isset($request[$name]);
    }

    /**
     * @param $name
     * @param $value
     * @param IContext|null $context
     *
     * @return IContext|mixed
     */
    public function setRequestParam($name, $value, IContext &$context = null)
    {
        $this->parseApiRequest($context);
        $context[static::CONTEXT__REQUEST_API][$name] = $value;

        return $context;
    }

    /**
     * @param $params
     * @param IContext|null $context
     *
     * @return IContext|mixed
     */
    public function setRequestParams($params, IContext &$context = null)
    {
        $context[static::CONTEXT__REQUEST_API] = $params;

        return $context;
    }

    /**
     * @param IContext|null $context
     *
     * @return mixed
     */
    public function getRequestParams(IContext &$context = null)
    {
        $this->parseApiRequest($context);

        return $context[static::CONTEXT__REQUEST_API];
    }

    /**
     * @param $name
     * @param null $default
     * @param IContext|null $context
     *
     * @return mixed|null
     */
    public function getRequestParam($name, $default = null, IContext $context = null)
    {
        $this->parseApiRequest($context);
        $request = $context[static::CONTEXT__REQUEST_API];

        return $request[$name] ?? null;
    }

    /**
     * @return bool
     */
    public function isRequestJson(): bool
    {
        $postData = file_get_contents('php://input');

        if ($postData) {
            try {
                $decoded = json_decode($postData, true);
                return $decoded ? true : false;
            } catch (\Exception $e) {
                return false;
            }
        }

        return false;
    }

    /**
     * @param IContext|null $context
     *
     * @return $this
     */
    protected function parseApiRequest(IContext &$context = null)
    {
        if (!isset($context[static::CONTEXT__REQUEST_API])) {
            $json = $this->isRequestJson() ? $this->parseJsonApiRequest() : [];
            $uriQuery = $this->parseFormApiRequest();
            $context[static::CONTEXT__REQUEST_API] = array_merge($uriQuery, $json);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    protected function parseJsonApiRequest()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    /**
     * @return mixed
     */
    protected function parseFormApiRequest()
    {
        return $_REQUEST;
    }

    /**
     * @return PatternAbstract|null
     */
    protected function getApiPattern()
    {
        return SystemContainer::getItem(PatternAbstract::class);
    }
}
