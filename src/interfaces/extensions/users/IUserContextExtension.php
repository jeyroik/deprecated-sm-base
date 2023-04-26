<?php
namespace df\interfaces\extensions\users;

use app\models\mongo\Users;

/**
 * Interface IUserContextExtension
 *
 * @package df\interfaces\extensions\users
 * @author aivanov@fix.ru
 */
interface IUserContextExtension
{
    const CONTEXT__USER = 'user';

    /**
     * @return Users
     */
    public function getUser();

    /**
     * @param $user
     *
     * @return mixed
     */
    public function setUser($user);
}
