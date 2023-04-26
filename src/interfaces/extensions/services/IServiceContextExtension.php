<?php
namespace df\interfaces\extensions\services;

/**
 * Interface IServiceContextExtension
 *
 * @package df\interfaces\extensions\services
 * @author aivanov@fix.ru
 */
interface IServiceContextExtension
{
    /**
     * @param $serviceName
     *
     * @return mixed
     */
    public function setSourceServiceName($serviceName);

    /**
     * @return string
     */
    public function getSourceServiceName(): string;

    /**
     * @param $service
     *
     * @return mixed
     */
    public function setSourceService($service);

    /**
     * @return mixed
     */
    public function getSourceService();

    /**
     * @param $services
     *
     * @return mixed
     */
    public function setDestinationServices($services);

    /**
     * @return mixed
     */
    public function getDestinationServices();

    /**
     * @param $serviceName
     * @param $resolver
     *
     * @return mixed
     */
    public function setServiceResolver($serviceName, $resolver);

    /**
     * @param $serviceName
     *
     * @return mixed
     */
    public function getServiceResolver($serviceName);

    /**
     * @param $jobs
     *
     * @return mixed
     */
    public function setJobs($jobs);

    /**
     * @return mixed
     */
    public function getJobs();
}
