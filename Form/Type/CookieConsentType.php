<?php

declare(strict_types=1);

namespace Ekyna\Bundle\CookieConsentBundle\Form\Type;

use Ekyna\Bundle\CookieConsentBundle\Service\Manager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class CookieConsentType
 * @package Ekyna\Bundle\CookieConsentBundle\Form\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class CookieConsentType extends AbstractType
{
    private Manager $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->manager->getCategories() as $category) {
            $builder->add($category, ChoiceType::class, [
                'expanded'                  => true,
                'multiple'                  => false,
                'choices'                   => [
                    'choice.allow' => 1,
                    'choice.deny'  => 0,
                ],
                'choice_translation_domain' => 'EkynaCookieConsent',
            ]);
        }
    }
}
