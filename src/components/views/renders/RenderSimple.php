<?php
namespace df\components\views\renders;

use jeyroik\tools\components\Preg;

/**
 * Class RenderSimple
 *
 * @package df\components\views\renders
 * @author aivanov@fix.ru
 */
class RenderSimple
{
    /**
     * @param $viewPath
     * @param array $data
     *
     * @return mixed|string
     */
    public function render($viewPath, $data = [])
    {
        $basePath = getenv('DF__VIEW_BASE_PATH') ?: APP_ROOT_PATH . 'views/';
        $viewFullPath = $basePath . $viewPath;

        if (is_file($viewFullPath)) {
            $content = file_get_contents($viewFullPath);
            $preg = new Preg();
            return $preg->apply($data)->to($content);
        }

        return '';
    }
}
