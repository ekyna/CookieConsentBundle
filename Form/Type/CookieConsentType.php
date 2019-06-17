<?php

namespace Ekyna\Bundle\CookieConsentBundle\Form\Type;

use Ekyna\Bundle\CookieConsentBundle\Service\Manager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CookieConsentType
 * @package Ekyna\Bundle\CookieConsentBundle\Form\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class CookieConsentType extends AbstractType
{
    /**
     * @var Manager
     */
    private $manager;


    /**
     * Constructor.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->manager->getCategories() as $category) {
            $builder->add($category, ChoiceType::class, [
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    'choice.allow' => 1,
                    'choice.deny'  => 0,
                ],
            ]);
        }
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('translation_domain', 'EkynaCookieConsent');
    }
}
