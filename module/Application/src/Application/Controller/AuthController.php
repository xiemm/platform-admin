<?php

namespace Application\Controller;

use System\Model\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService;
use Application\Form\LoginForm;
use System\Model\User;
use Zend\View\Model\ViewModel;

/**
 *
 * @method \Zend\Http\PhpEnvironment\Request getRequest()
 */
class AuthController extends AbstractActionController
{
    protected $userTable;

    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
        if ($this->getRequest()->isPost()) {
            $form = new LoginForm();
            $form->loadInputFilter();
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $formData = $form->getData();
                $authAdapter = $this->getUserTable()->getAuthAdapter(
                    $formData['account'], $formData['password']
                );
                $auth        = new AuthenticationService(null, $authAdapter);
                $result      = $auth->authenticate();

                if ($result->isValid()) {
                    $user = new User();
                    $user->exchangeArray((array)$authAdapter->getResultRowObject());
                    $auth->getStorage()->write($user);
                    $return = array('code' => 1);
                } else {
                    $return = array(
                        'code' => $result->getCode(),
                        'msg'  => $result->getMessages()
                    );
                }
            } else {
                $return = array(
                    'code' => 0,
                    'msg'  => $form->getMessages()
                );
            }

            return new JsonModel($return);
        }
        return (new ViewModel())->setTerminal(true);
    }


    /**
     * @return \System\Model\UserTable;
     */
    public function getUserTable()
    {
        if (!$this->userTable) {
            $this->userTable = new UserTable();
        }
        return $this->userTable;
    }
}
