<?php
namespace df\components\plugins\http\patterns;

use gosp\webhooks\components\http\patterns\PatternFactory;
use jeyroik\extas\components\systems\Plugin;

/**
 * Class PatternPluginFactoryInit
 *
 * @package df\components\plugins\http\patterns
 * @author aivanov@fix.ru
 */
class PatternPluginFactoryInit extends Plugin
{
    public $preDefinedStage = PatternFactory::SUBJECT . '.init';

    /**
     * @param PatternFactory $patternFactory
     *
     * @return $this
     */
    public function __invoke(&$patternFactory)
    {
        $configPath = getenv('DF__PATTERNS_PATH') ?: APP_ROOT_PATH . 'config/api/patterns.php';
        $config = is_file($configPath) ? include $configPath : [];
        $patternFactory->setConfig($config);

        return $this;
    }
}
