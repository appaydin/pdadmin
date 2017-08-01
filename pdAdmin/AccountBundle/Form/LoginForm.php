<?php

/*
 * This file is part of the pdAdmin package.
 *
 * (c) pdAdmin <http://pdadmin.net/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AccountBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Login Form
 * @package AccountBundle\Form
 *
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class LoginForm extends AbstractType
{
    /**
     * Form Builder
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'security.login.username',
                'translation_domain' => 'FOSUserBundle'
            ])
            ->add('password', PasswordType::class, [
                'label' => 'security.login.password',
                'translation_domain' => 'FOSUserBundle'
            ]);
    }

    /**
     * Default Configuration
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false
        ]);
    }
}
