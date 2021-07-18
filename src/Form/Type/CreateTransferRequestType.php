<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Wallet;
use App\Request\CreateTransferRequest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CreateTransferRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('recipientWallet', EntityType::class, [
                'class' => Wallet::class,
                'documentation' => [
                    'example' => '050eac74-e549-4db1-9ae1-bd83a8827d13',
                    'description' => 'ID of receiving wallet'
                ]
            ])
            ->add('amount', IntegerType::class, [
                'documentation' => [
                    'example' => 10000,
                    'description' => 'Amount of transaction in cents'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateTransferRequest::class,
            'method' => 'POST',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}