<?php
namespace df\interfaces\extensions\access;

/**
 * Interface IAccessContextExtensionBC
 *
 * Back Compatability
 *
 * @package df\interfaces\extensions\access
 * @author aivanov@fix.ru
 */
interface IAccessContextExtensionBC
{
    /**
     * @param $operation
     * @param $subject
     * @param $target
     *
     * @return mixed
     */
    public function setAccessAction($operation, $subject, $target);

    /**
     * @return mixed
     */
    public function getAccessAction();

    /**
     * @param $user
     * @param $data
     *
     * @return mixed
     */
    public function setAccessContext($user, $data);

    /**
     * @return mixed
     */
    public function getAccessContext();

    /**
     * @param $config
     * @param string $name
     *
     * @return mixed
     */
    public function setAccess($config, $name = '');

    /**
     * @return mixed
     */
    public function getAccess();

    /**
     * @return bool
     */
    public function isAllowed(): bool;
}
