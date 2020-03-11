<?php

namespace App\Form;

use App\Entity\Account;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class PostingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Account $account */
        $account = $builder->getData()['account'] ?? null;
        /** @var Category $category */
        $category = $builder->getData()['category'] ?? null;

        $builder
            ->add(
                'money',
                NumberType::class,
                [
                    'html5'    => true,
                    'attr'     => ['min' => 0, 'step' => '0.01'],
                    'label'    => false,
                    'row_attr' => $this->getRowAttr('money'),
                ]
            )
            ->add(
                'dateOperation',
                DateType::class,
                [
                    'widget'   => 'single_text',
                    'data'     => new \DateTime(),
                    'label'    => false,
                    'row_attr' => $this->getRowAttr('date-operation'),
                ]
            )
            ->add(
                'type',
                ChoiceType::class,
                [
                    'choices' => array_flip(\App\Lib\PostingType::getAllTypes()),
                    'label'   => false,
                    'row_attr' => $this->getRowAttr('type'),
                ]
            );
        if ($account === null) {
            $builder->add(
                'account',
                EntityType::class,
                $this->getEntityOptions(Account::class),
                );
        } else {
            $builder->add(
                'account',
                HiddenType::class,
                [
                    'data' => $account->getId(),
                ]
            );
        }

        if ($category === null) {
            $builder->add(
                'category',
                EntityType::class,
                $this->getEntityOptions(Category::class),
                );
        } else {
            $builder->add(
                'category',
                HiddenType::class,
                [
                    'data' => $category->getId(),
                ]
            );
        }

        $builder
            ->add(
                'comment',
                CommentFormType::class,
                [
                    'required' => false,
                    'label'    => false,
                    'row_attr' => $this->getRowAttr('comment'),
                ]
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    'label' => 'Добавить',
                    'row_attr' => $this->getRowAttr('btn-save'),
                ]
            );

    }

    private function getRowAttr(string $fieldName): array
    {
        return [
            'class' => sprintf('reg-posting-form-%s', $fieldName),
        ];
    }

    private function getEntityOptions(string $className): array
    {
        return [
            'class'         => $className,
            'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('e');
            },
            'choice_label'  => false,
        ];
    }
}
