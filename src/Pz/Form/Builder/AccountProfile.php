<?php

namespace Pz\Form\Builder;

use Pz\Form\Constraints\ConstraintBillingRequired;
use Pz\Form\Constraints\ConstraintIfNotSameThenRequired;
use Pz\Form\Constraints\ConstraintUnique;
use Pz\Form\Type\ChoiceMultiJson;
use Pz\Orm\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Tests\Constraints\EmailTest;

class AccountProfile extends AbstractType
{

    public function getBlockPrefix()
    {
        return 'register';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $connection = $options['container']->get('doctrine.dbal.default_connection');
        $pdo = $connection->getWrappedConnection();

        parent::buildForm($builder, $options);

        $builder->add('firstName', TextType::class, array(
            'label' => 'First name:',
            'constraints' => array(
                new Assert\NotBlank(),
            )
        ))->add('lastName', TextType::class, array(
            'label' => 'Last name:',
            'constraints' => array(
                new Assert\NotBlank(),
            )
        ))->add('description', TextareaType::class, array(
            'label' => 'Description:',
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'container' => null,
        ));
    }
}
