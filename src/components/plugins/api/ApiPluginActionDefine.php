<?php
namespace df\components\plugins\api;

use df\interfaces\extensions\http\IHttpContextExtension;
use gosp\webhooks\interfaces\http\patterns\IPatternBase;
use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\machines\plugins\IPluginStateRunNext;

/**
 * Class ApiPluginActionDefine
 *
 * @package df\components\plugins\api
 * @author aivanov@fix.ru
 */
class ApiPluginActionDefine extends Plugin implements IPluginStateRunNext
{
    public $preDefinedStage = IStateMachine::STAGE__STATE_RUN_NEXT;

    /**
     * @param IStateMachine $machine
     * @param IState|null $currentState
     * @param IContext|IHttpContextExtension $context
     *
     * @return bool|false|string
     * @throws \Exception
     */
    public function __invoke(IStateMachine $machine, IState $currentState = null, IContext $context = null)
    {
        if (strpos($currentState->getId(),':run') !== false) {
            if ($context->isImplementsInterface(IHttpContextExtension::class)) {
                /**
                 * @var $pattern IPatternBase
                 */
                $pattern = $context->getPattern(IPatternBase::SUBJECT);

                return $pattern->getAction();
            }
        }

        return false;
    }
}
