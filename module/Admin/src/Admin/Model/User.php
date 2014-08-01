<?php
namespace Admin\Model;

use Zend\Db\RowGateway\RowGateway;
use Zend\Permissions\Rbac\Rbac;

/**
 * User.php
 * @author Administrator
 * @DateTime 12-12-29 上午11:43
 * @version $Id: User.php 1361 2014-04-09 19:38:47Z maomao $
 *
 * @property $user_id
 * @property $account
 * @property $real_name
 * @property $email
 * @property $password
 * @property $status
 * @property UserTable $table
 */
class User extends RowGateway
{
    private $roles;
    private $rbac;

    /**
     * @param mixed $user_id
     *
     * @return User
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $account
     *
     * @return User
     */
    public function setAccount($account)
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return mixed
     */
    public function egetAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = UserTable::encrypt($password);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $real_name
     *
     * @return User
     */
    public function setRealName($real_name)
    {
        $this->real_name = $real_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRealName()
    {
        return $this->real_name;
    }

    /**
     * @param mixed $status
     *
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get user roles
     * @return array
     */
    public function getRoles()
    {
        if (!$this->roles) {
            $this->roles = AssignUserTable::getInstance()->getRoleNamesByUserId($this->getUserId());
        }
        return $this->roles;
    }

    public function __sleep()
    {
        return array('data', 'primaryKeyColumn', 'primaryKeyData');
    }

    public function __wakeup()
    {
        $this->table = UserTable::getInstance()->getTable();
        $this->sql = UserTable::getInstance()->getSql();
        $this->initialize();
    }

    /**
     * @param $permission
     * @return Rbac
     */
    public function isAllow($permission)
    {
        return true;
        foreach ($this->getRoles() as $role) {
            if ($this->getRbac()->isGranted($role, $permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Rbac
     */
    public function getRbac()
    {
        return $this->rbac;
    }

    /**
     * @param Rbac $rbac
     * @return $this
     */
    public function setRbac(Rbac $rbac)
    {
        $this->rbac = $rbac;
        return $this;
    }
}
