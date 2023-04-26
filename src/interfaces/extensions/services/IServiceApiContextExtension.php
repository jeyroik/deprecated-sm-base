<?php
namespace df\interfaces\extensions\services;

/**
 * Interface IServiceApiContextExtension
 *
 * @package df\interfaces\extensions\services
 * @author aivanov@fix.ru
 */
interface IServiceApiContextExtension
{
    /**
     * @return mixed
     */
    public function getServiceApiAction();

    /**
     * @return mixed
     */
    public function getService();

    /**
     * @param $service
     *
     * @return mixed
     */
    public function setService($service);

    /**
     * @param $serviceAction
     *
     * @return mixed
     */
    public function setServiceAction($serviceAction);

    /**
     * @param $path
     *
     * @return mixed
     */
    public function loadServiceActions($path);

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasServiceAction($name): bool;
}
