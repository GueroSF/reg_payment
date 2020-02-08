<?php
declare(strict_types=1);

namespace App\Form;


use App\Entity\Account;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'account',
                EntityType::class,
                [
                    'mapped'        => false,
                    'class'         => Account::class,
                    'query_builder' => function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('e');
                    },
                    'choice_label'  => 'name',
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Наименование',
                ]
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    'label' => 'Добавить',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Category::class);
    }
}
