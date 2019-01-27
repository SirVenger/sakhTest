<?php
/**
 * Created by PhpStorm.
 * User: venger
 * Date: 27.01.19
 * Time: 14:59
 */

namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Range;

class TranserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $maxBalance = $options['maxBalance'];

        $builder
            ->add('balance', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => $maxBalance
                ],
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'max' => $maxBalance
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('maxBalance');
    }
}
