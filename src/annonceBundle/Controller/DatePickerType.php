<?php
/**
 * Created by PhpStorm.
 * User: Moussa
 * Date: 14/05/2018
 * Time: 01:00
 */

namespace annonceBundle\Controller;


use Symfony\Component\Form\AbstractType;

class DatePickerType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'widget' => 'single_text'
        ));
    }
    public function getParent()
    {
        return 'date';
    }

    public function getName()
    {
        return 'datePicker';
    }

}