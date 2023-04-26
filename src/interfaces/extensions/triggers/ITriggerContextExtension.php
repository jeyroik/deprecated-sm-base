<?php
namespace df\interfaces\extensions\triggers;

use gosp\webhooks\interfaces\IJob;

/**
 * Interface ITriggerContextExtension
 *
 * @package df\interfaces\extensions\triggers
 * @author aivanov@fix.ru
 */
interface ITriggerContextExtension
{
    /**
     * @param $triggers
     *
     * @return mixed
     */
    public function setTriggers($triggers);

    /**
     * @return mixed
     */
    public function getTriggers();

    /**
     * @param $triggers
     *
     * @return mixed
     */
    public function setFilteredTriggers($triggers);

    /**
     * @return mixed
     */
    public function getFilteredTriggers();

    /**
     * @param IJob $job
     * @param $result
     *
     * @return mixed
     */
    public function addJobResult($job, $result);

    /**
     * @return mixed
     */
    public function getJobResults();
}
