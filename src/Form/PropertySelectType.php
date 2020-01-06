<?php


namespace App\Form;


use App\Form\DataTransformer\AddressToPropertyTransformer;
use App\Repository\ClientRepository;
use App\Repository\PropertyRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class PropertySelectType extends AbstractType
{
    private $propertyRepository;
    private $router;

    public function __construct(PropertyRepository $propertyRepository, RouterInterface $router)
    {
        $this->propertyRepository = $propertyRepository;
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new AddressToPropertyTransformer(
            $this->propertyRepository,
            $options['finder_callback']
        ));
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'Calle no encontrada',
            'finder_callback' => function(PropertyRepository $propertyRepository, string $street) {
                return $propertyRepository->findOneBy(['street' => $street]);
            },
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $attr = $view->vars['attr'];
        $class = isset($attr['class']) ? $attr['class']. ' ' : '';
        $class .= 'js-property-autocomplete';

        $attr['class'] = $class;
        $attr['data-autocomplete-url'] = $this->router->generate('api_property_autocomplete');
        $view->vars['attr'] = $attr;
    }
}