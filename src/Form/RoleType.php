<?php

namespace App\Form;

use App\Entity\Permission;
use App\Entity\Role;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre del rol',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
            ])
            ->add('permissions', EntityType::class, [
                'label' => 'Permisos',
                'attr' => ['size' => 15, 'class' => ''],
                'class' => Permission::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'name',
                // every option can use a string property path or any callable that get
                // passed each choice as argument, but it may not be needed
                'group_by' => function (?Permission $entity) {

                    $name = $entity->getPermissionKey() ?: '';

                    if (str_contains($name, 'create')) {
                        return 'CREAR';
                    }

                    if (str_contains($name, 'read')) {
                        return 'VER';
                    }

                    if (str_contains($name, 'update')) {
                        return 'ACTUALIZAR';
                    }

                    if (str_contains($name, 'delete')) {
                        return 'ELIMINAR';
                    }

                    return null;

                },
                'multiple' => true,
                //'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Role::class,
        ]);
    }
}
