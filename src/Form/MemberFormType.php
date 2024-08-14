<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('member', EntityType::class, [
                'class' => User::class,
                'attr' => ['class' => 'data-choices data-choices-groups data-choices-search-true'],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        //->where('u.team is NULL')
                        ->orderBy('u.name', 'ASC');
                },
                'preferred_choices' => function (?User $entity) {
                    return !$entity->getTeam();
                },
                'choice_label' => function (?User $entity) {
                    return strtoupper($entity->getName()).' - '.strtolower($entity->getTeam()?->getName());
                },
                'group_by' => function (?User $entity) {

                    $role = $entity->getRole()?->getRoleKey() ?: '';

                    if (str_contains(strtolower($role), 'admin')) {
                        return 'ADMIN';
                    }

                    return "EMPLOYEE";

                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
