<?php


namespace App\Form;


use App\Form\DataTransformer\FullnameToClientTransformer;
use App\Repository\ClientRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class ClientSelectType extends AbstractType
{
    private $clientRepository;
    private $router;

    public function __construct(ClientRepository $clientRepository, RouterInterface $router)
    {
        $this->clientRepository = $clientRepository;
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new FullnameToClientTransformer(
            $this->clientRepository,
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
            'invalid_message' => 'Cliente no encontrado',
            'finder_callback' => function(ClientRepository $clientRepository, string $fullname) {
                return $clientRepository->findOneBy(['full_name' => $fullname]);
            },
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $attr = $view->vars['attr'];
        $class = isset($attr['class']) ? $attr['class']. ' ' : '';
        $class .= 'js-client-autocomplete';

        $attr['class'] = $class;
        $attr['data-autocomplete-url'] = $this->router->generate('api_client_autocomplete');
        $view->vars['attr'] = $attr;
    }
}