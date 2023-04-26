<?php
namespace df\components\extensions\services;

use app\models\mongo\Services;
use df\interfaces\extensions\http\IHttpContextExtension;
use gosp\webhooks\components\services\api\actions\ActionAbstract;

use df\interfaces\extensions\services\IServiceApiContextExtension;
use gosp\webhooks\components\services\http\patterns\request\PatternServiceV1;
use gosp\webhooks\components\services\ServicesRepository;
use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class ServiceApiContextExtension
 *
 * @package df\components\extensions\services
 * @author aivanov@fix.ru
 */
class ServiceApiContextExtension extends Extension implements IServiceApiContextExtension
{
    protected const CONTEXT__ACTIONS = '@api/service:actions';
    protected const CONTEXT__CURRENT_ACTION = '@api/service:current_action';
    protected const CONTEXT__SERVICE = '@api/service:service';

    public $subject = IContext::SUBJECT;

    /**
     * @param IContext|null $context
     *
     * @return mixed|null
     */
    public function getServiceApiAction(IContext &$context = null)
    {
        return isset($context[static::CONTEXT__CURRENT_ACTION])
            ? $context[static::CONTEXT__CURRENT_ACTION]
            : null;
    }

    /**
     * @param IContext|IHttpContextExtension $context
     *
     * @return mixed|Services|null
     * @throws \Exception
     */
    public function getService(IContext &$context = null)
    {
        if (!isset($context[static::CONTEXT__SERVICE])) {
            /**
             * @var $pattern PatternServiceV1
             */
            $pattern = $context->getPattern('service');
            $serviceName = $pattern->getServiceName();

            if ($serviceName) {
                $context[static::CONTEXT__SERVICE] = ServicesRepository::find(['name' => $serviceName])->one();
            } else {
                throw new \Exception('Unknown service "' . $serviceName . '".');
            }
        }

        return isset($context[static::CONTEXT__SERVICE])
            ? $context[static::CONTEXT__SERVICE]
            : null;
    }

    /**
     * @param $service
     * @param IContext|null $context
     *
     * @return IContext
     */
    public function setService($service, IContext &$context = null)
    {
        $context[static::CONTEXT__SERVICE] = $service;

        return $context;
    }

    /**
     * @param $serviceAction
     * @param IContext|null $context
     *
     * @return IContext
     */
    public function setServiceAction($serviceAction, IContext &$context = null)
    {
        $actions = $context[static::CONTEXT__ACTIONS];
        $context[static::CONTEXT__CURRENT_ACTION] = $actions[$serviceAction];

        return $context;
    }

    /**
     * @param $path
     * @param IContext|null $context
     *
     * @return IContext
     * @throws \Exception
     */
    public function loadServiceActions($path, IContext &$context = null)
    {
        $path = getenv('DF__SERVICE_API_ACTIONS_PATH') ?: APP_ROOT_PATH . '/config/services/api.php';

        if (is_file($path)) {
            $actions = include $path;
            $contextActions = [];

            foreach ($actions as $actionName => $actionOptions) {
                /**
                 * @var ActionAbstract $action
                 */
                $action = new $actionName($actionOptions);
                $contextActions[$action->getAlias()] = $action;
            }
            $context[static::CONTEXT__ACTIONS] = $contextActions;
        } else {
            throw new \Exception('Unknown path "' . $path . '"');
        }

        return $context;
    }

    /**
     * @param $name
     * @param IContext|null $context
     *
     * @return bool
     */
    public function hasServiceAction($name, IContext &$context = null): bool
    {
        $actions = isset($context[static::CONTEXT__ACTIONS]) ? $context[static::CONTEXT__ACTIONS] : [];

        return isset($actions[$name]);
    }
}
