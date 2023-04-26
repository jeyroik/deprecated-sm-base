<?php
namespace df\components\extensions\views;

use df\interfaces\extensions\views\IViewContextExtension;
use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class ViewContextExtension
 *
 * @package df\components\extensions\views
 * @author aivanov@fix.ru
 */
class ViewContextExtension extends Extension implements IViewContextExtension
{
    public $subject = IContext::class;

    /**
     * @param IContext|null $context
     *
     * @return mixed|null
     */
    public function getViewRender(IContext $context = null)
    {
        return isset($context[static::CONTEXT_ITEM__VIEW_RENDER])
            ? $context[static::CONTEXT_ITEM__VIEW_RENDER]
            : null;
    }

    /**
     * @param $render
     * @param IContext|null $context
     *
     * @return IContext|mixed
     */
    public function setViewRender($render, IContext &$context = null)
    {
        $context[static::CONTEXT_ITEM__VIEW_RENDER] = $render;

        return $context;
    }
}
