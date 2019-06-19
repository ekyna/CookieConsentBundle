<?php

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

/**
 * Class CookiesSettingSchema
 * @package Ekyna\Bundle\CookieConsentBundle\Service\Setting
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class CookiesSettingSchema extends AbstractSchema implements LocalizedSchemaInterface
{
    use LocalizedSchemaTrait;


    /**
     * @inheritdoc
     */
    public function buildSettings(SettingsBuilder $builder)
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

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', Type\ChoiceType::class, [
                'label'       => 'setting.position',
                'required'    => true,
                'multiple'    => false,
                'choices'     => Position::getChoices(),
                'constraints' => [
                    new Constraints\NotNull(),
                    new Constraints\Choice([
                        'callback' => [Position::class, 'getConstants'],
                    ]),
                ],
            ])
            ->add('backdrop', Type\CheckboxType::class, [
                'label'       => 'setting.backdrop',
                'required'    => false,
                'constraints' => [
                    new Constraints\NotNull(),
                ],
            ])
            ->add('title', I18nParameterType::class, [
                'label'        => 'setting.title',
                'required'     => false,
                'form_type'    => Type\TextareaType::class,
                'form_options' => [
                    'label'    => false,
                    'required' => false,
                ],
            ])
            ->add('intro', I18nParameterType::class, [
                'label'        => 'setting.intro',
                'required'     => false,
                'form_type'    => Type\TextareaType::class,
                'form_options' => [
                    'label'    => false,
                    'required' => false,
                ],
            ]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('translation_domain', 'EkynaCookieConsent');
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return ['setting.label', 'EkynaCookieConsent'];
    }

    /**
     * @inheritdoc
     */
    public function getShowTemplate()
    {
        return '@EkynaCookieConsent/Setting/show.html.twig';
    }

    /**
     * @inheritdoc
     */
    public function getFormTemplate()
    {
        return '@EkynaCookieConsent/Setting/form.html.twig';
    }
}
