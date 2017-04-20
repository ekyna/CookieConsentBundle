<?php

declare(strict_types=1);

namespace Ekyna\Bundle\CookieConsentBundle\Service\Setting;

use Ekyna\Bundle\CookieConsentBundle\Model\Position;
use Ekyna\Bundle\SettingBundle\Form\Type\I18nParameterType;
use Ekyna\Bundle\SettingBundle\Model\I18nParameter;
use Ekyna\Bundle\SettingBundle\Schema\AbstractSchema;
use Ekyna\Bundle\SettingBundle\Schema\LocalizedSchemaInterface;
use Ekyna\Bundle\SettingBundle\Schema\LocalizedSchemaTrait;
use Ekyna\Bundle\SettingBundle\Schema\SettingsBuilder;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;
use Symfony\Contracts\Translation\TranslatableInterface;

use function Symfony\Component\Translation\t;

/**
 * Class CookiesSettingSchema
 * @package Ekyna\Bundle\CookieConsentBundle\Service\Setting
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class CookiesSettingSchema extends AbstractSchema implements LocalizedSchemaInterface
{
    use LocalizedSchemaTrait;

    public function buildSettings(SettingsBuilder $builder): void
    {
        $builder
            ->setDefaults(array_merge([
                'position' => Position::CENTERED,
                'backdrop' => false,
                'title'    => $this->createI18nParameter(''),
                'intro'    => $this->createI18nParameter(''),
            ], $this->defaults))
            ->setAllowedTypes('position', 'string')
            ->setAllowedTypes('backdrop', 'bool')
            ->setAllowedTypes('title', I18nParameter::class)
            ->setAllowedTypes('intro', I18nParameter::class)
            ->setAllowedValues('position', Position::getConstants());
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', Type\ChoiceType::class, [
                'label'                     => t('setting.position', [], 'EkynaCookieConsent'),
                'required'                  => true,
                'multiple'                  => false,
                'choices'                   => Position::getChoices(),
                'choice_translation_domain' => 'EkynaCookieConsent',
                'constraints'               => [
                    new Constraints\NotNull(),
                    new Constraints\Choice([
                        'callback' => [Position::class, 'getConstants'],
                    ]),
                ],
            ])
            ->add('backdrop', Type\CheckboxType::class, [
                'label'       => t('setting.backdrop', [], 'EkynaCookieConsent'),
                'required'    => false,
                'attr'        => [
                    'align_with_widget' => true,
                ],
                'constraints' => [
                    new Constraints\NotNull(),
                ],
            ])
            ->add('title', I18nParameterType::class, [
                'label'        => t('setting.title', [], 'EkynaCookieConsent'),
                'required'     => false,
                'form_type'    => Type\TextareaType::class,
                'form_options' => [
                    'label'    => false,
                    'required' => false,
                ],
            ])
            ->add('intro', I18nParameterType::class, [
                'label'        => t('setting.intro', [], 'EkynaCookieConsent'),
                'required'     => false,
                'form_type'    => Type\TextareaType::class,
                'form_options' => [
                    'label'    => false,
                    'required' => false,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('translation_domain', 'EkynaCookieConsent');
    }

    public function getLabel(): TranslatableInterface
    {
        return t('setting.label', [], 'EkynaCookieConsent');
    }

    public function getShowTemplate(): string
    {
        return '@EkynaCookieConsent/Setting/show.html.twig';
    }

    public function getFormTemplate(): string
    {
        return '@EkynaCookieConsent/Setting/form.html.twig';
    }
}
