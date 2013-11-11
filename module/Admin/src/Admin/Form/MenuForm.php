<?php
/**
 * platform-admin MenuForm.php
 * @DateTime 13-9-6 下午5:20
 */

namespace Admin\Form;
use Zend\Form\Form;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;

/**
 * Class MenuForm
 * @package Admin\Form
 * @author Xiemaomao
 * @version $Id$
 */
class MenuForm extends Form
{

    public function init()
    {
        $inputFilter = new InputFilter();
        $factory     = new Factory();

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'menu_id',
                    'filters'  => array(
                        array('name' => 'int')
                    ),
                )
            )
        );

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'parent_id',
                    'filters'  => array(
                        array('name' => 'int')
                    ),
                )
            )
        );

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'name',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StringTrim')
                    ),
                )
            )
        );
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'url',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StringTrim')
                    ),
                )
            )
        );

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'per_id',
                    'filters'  => array(
                        array('name' => 'int')
                    ),
                )
            )
        );
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'order',
                    'required' => false,
                    'filters'  => array(
                        array('name' => 'int')
                    ),
                )
            )
        );

        $this->setInputFilter($inputFilter);
    }
}