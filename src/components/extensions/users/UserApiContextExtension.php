<?php
namespace df\components\extensions\users;

use app\models\mongo\Users;
use df\interfaces\extensions\users\IUserContextExtension;
use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class UserApiContextExtension
 *
 * @package df\components\extensions\users
 * @author aivanov@fix.ru
 */
class UserApiContextExtension extends Extension implements IUserContextExtension
{
    public $subject = IContext::SUBJECT;

    /**
     * @param IContext|null $context
     *
     * @return \app\models\mongo\Users|mixed|null
     */
    public function getUser(IContext $context = null)
    {
        if (!isset($context[static::CONTEXT__USER])) {
            $this->initUser($context);
        }

        return $context[static::CONTEXT__USER];
    }

    /**
     * @param $user
     * @param IContext|null $context
     *
     * @return IContext|mixed
     */
    public function setUser($user, IContext &$context = null)
    {
        $context[static::CONTEXT__USER] = $user;

        return $context;
    }

    /**
     * @param IContext $context
     *
     * @return $this
     */
    protected function initUser(IContext &$context)
    {
        $user = new \gosp\webhooks\components\User();
        $userId = $user->getIdentity()->getId();
        $user = Users::find()->where(['_id' => $userId])->one();

        $this->setUser($user, $context);

        return $this;
    }
}
