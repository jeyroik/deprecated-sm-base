<?php
namespace df\interfaces\extensions\views;

/**
 * Interface IViewContextExtension
 *
 * @package df\interfaces\extensions\views
 * @author aivanov@fix.ru
 */
interface IViewContextExtension
{
    const CONTEXT_ITEM__VIEW_RENDER = 'df.view.render';

    /**
     * @return mixed
     */
    public function getViewRender();

    /**
     * @param $render
     *
     * @return mixed
     */
    public function setViewRender($render);
}
