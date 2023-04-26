<?php
namespace df\components\extensions\access;

use gosp\webhooks\components\access\Rbac;
use gosp\webhooks\components\access\rbac\RbacConfig;
use gosp\webhooks\components\access\rbac\RbacContext;
use gosp\webhooks\components\access\rbac\RbacValidator;

use df\interfaces\extensions\access\IAccessContextExtensionBC;
use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class AccessContextExtension
 *
 * @package df\components\extensions\access
 * @author aivanov@fix.ru
 */
class AccessContextExtensionBC extends Extension implements IAccessContextExtensionBC
{
    const CONTEXT_ITEM__ACCESS = '@access.self';
    const CONTEXT_ITEM__ACCESS_ACTION = '@access.action';
    const CONTEXT_ITEM__ACCESS_CONTEXT = '@access.context';

    public $subject = IContext::SUBJECT;

    /**
     * @param $operation
     * @param $subject
     * @param $target
     * @param IContext|null $context
     *
     * @return IContext|mixed
     */
    public function setAccessAction($operation, $subject, $target, IContext &$context = null)
    {
        $context[static::CONTEXT_ITEM__ACCESS_ACTION] = Rbac::constructAction($operation, $subject, $target);

        return $context;
    }

    /**
     * @param $user
     * @param $data
     * @param IContext|null $context
     *
     * @return IContext|mixed
     */
    public function setAccessContext($user, $data, IContext &$context = null)
    {
        $context[static::CONTEXT_ITEM__ACCESS_CONTEXT] = new RbacContext($user, $data);

        return $context;
    }

    /**
     * @param $config
     * @param string $name
     * @param IContext|null $context
     *
     * @return IContext|mixed
     */
    public function setAccess($config, $name = '', IContext &$context = null)
    {
        $context[static::CONTEXT_ITEM__ACCESS] = RbacConfig::getInstance($config, $name);

        return $context;
    }

    /**
     * @param IContext|null $context
     *
     * @return mixed|null
     */
    public function getAccess(IContext &$context = null)
    {
        return isset($context[static::CONTEXT_ITEM__ACCESS]) ? $context[static::CONTEXT_ITEM__ACCESS] : null;
    }

    /**
     * @param IContext|null $context
     *
     * @return mixed|null
     */
    public function getAccessAction(IContext &$context = null)
    {
        return isset($context[static::CONTEXT_ITEM__ACCESS_ACTION])
            ? $context[static::CONTEXT_ITEM__ACCESS_ACTION]
            : null;
    }

    /**
     * @param IContext|null $context
     *
     * @return mixed|null
     */
    public function getAccessContext(IContext &$context = null)
    {
        return isset($context[static::CONTEXT_ITEM__ACCESS_CONTEXT])
            ? $context[static::CONTEXT_ITEM__ACCESS_CONTEXT]
            : null;
    }

    /**
     * @param IContext|null $context
     *
     * @return bool
     */
    public function isAllowed(IContext $context = null): bool
    {
        return RbacValidator::isAllowed(
            $this->getAccessAction($context),
            $this->getAccessContext($context),
            $this->getAccess($context)
        );
    }
}
