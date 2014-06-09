<?php

namespace TempoSimple\Application\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ActivityType extends AbstractType
{
    /** {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text');
    }

    /** {@inheritdoc} */
    public function getName()
    {
        return 'activity';
    }
}
