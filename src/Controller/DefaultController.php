<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\SearchFronted;
use App\Form\ContactType;
use App\Form\SearchFrontedType;
use App\Repository\ClientRepository;
use App\Repository\NoteCommercialRepository;
use App\Repository\PropertyRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\NamedAddress;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/prueba", name="prueba", methods={"GET"})
     */
    public function prueba(Request $request): Response
    {
        $client = new SearchFronted();
        $form = $this->createForm(SearchFrontedType::class, $client);

        if ($request->isMethod('POST')) {
            dd($request->getMethod());
        }

        return $this->render('fronted/default/prueba.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/correo", name="correo")
     */
    public function correo(Request $request): Response
    {
        return $this->render('fronted/default/correo.html.twig', [
        ]);
    }

    /**
     * @Route("/", name="homepage", methods={"GET", "POST"})
     */
    public function index(Request $request, PropertyRepository $propertyRepository): Response
    {
        $queryBuilder = $propertyRepository
            ->createQueryBuilder('p')
            ->innerJoin('p.charge', 'c')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->innerJoin('p.typeProperty', 'tp')
            ->innerJoin('p.rateHousing', 'rh')
            ->leftJoin('p.propertyReductions', 'pr')
            ->leftJoin('p.proposals', 'pro')
            ->andWhere('tp.name = :typePropertyName')
            ->addSelect('SUM(pr.price) as sumPropertyReduction')
            ->addSelect('COUNT(pro.contract) as countPropertyContract')
            ->addSelect('COUNT(pro.scriptures) as countPropertyScriptures')
            ->setParameter('typePropertyName', 'Vivienda')
            ->groupBy('c.id')
            ->orderBy('c.start_date', 'DESC')
            ->setMaxResults(6)
        ;

        $properties = $queryBuilder->getQuery()->getResult();

        if ($request->isMethod('POST')) {
            dd($request->getMethod());

        }

        return $this->render('fronted/default/index.html.twig', [
            //'properties' => $propertyRepository->onlyChargesWithoutAgency()
            'properties' => $properties
        ]);
    }

    public function searchHome(Request $request): Response
    {
        $client = new SearchFronted();
        $form = $this->createForm(SearchFrontedType::class, $client);

        return $this->render('fronted/default/_search_home.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/vender-piso", name="sell")
     */
    public function sell(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();

            $emailClient = (new TemplatedEmail())
                ->from(new NamedAddress('info@errekainmobiliaria.com', 'Erreka Inmobiliaria'))
                ->to(new NamedAddress($formData['email'], $formData['fullName']))
                ->subject('¡Vendemos tu vivienda antes de 90 días!')
                ->htmlTemplate('fronted/email/email_client_sell.html.twig')
                ->context([
                    'fullName' => $formData['fullName'],
                ])
            ;

            $emailAgency = (new TemplatedEmail())
                ->from(new NamedAddress('noreply@errekainmobiliaria.com', $formData['fullName']))
                ->to(new NamedAddress('info@errekainmobiliaria.com', 'Erreka Inmobiliaria'))
                ->subject($formData['fullName'] . ' necesita información de venta de su piso.')
                ->htmlTemplate('fronted/email/email_agency_sell.html.twig')
                ->context([
                    'fullName' => $formData['fullName'],
                    'mobile' => $formData['mobile'],
                    'correo' => $formData['email'],
                    'message' => $formData['comment'],
                ])
            ;

            try {
                $mailer->send($emailClient);
                $mailer->send($emailAgency);
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('danger', 'Error: Mensaje no enviado.');
            }


            $this->addFlash('success', 'Mensaje enviado correctamente.');

            return $this->redirectToRoute('sell');
        }

        return $this->render('fronted/default/sell.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/alquiler-garantizado", name="guaranteed_rental")
     */
    public function guaranteedRental(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();

            $emailClient = (new TemplatedEmail())
                ->from(new NamedAddress('info@errekainmobiliaria.com', 'Erreka Inmobiliaria'))
                ->to(new NamedAddress($formData['email'], $formData['fullName']))
                ->subject('¡Alquiler Garantizado!')
                ->htmlTemplate('fronted/email/email_client_rent.html.twig')
                ->context([
                    'fullName' => $formData['fullName'],
                ])
            ;

            $emailAgency = (new TemplatedEmail())
                ->from(new NamedAddress('noreply@errekainmobiliaria.com', $formData['fullName']))
                ->to(new NamedAddress('info@errekainmobiliaria.com', 'Erreka Inmobiliaria'))
                ->subject($formData['fullName'] . ' necesita información alquiler garantizado.')
                ->htmlTemplate('fronted/email/email_agency_rent.html.twig')
                ->context([
                    'fullName' => $formData['fullName'],
                    'mobile' => $formData['mobile'],
                    'correo' => $formData['email'],
                    'message' => $formData['comment'],
                ])
            ;

            try {
                $mailer->send($emailClient);
                $mailer->send($emailAgency);
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('danger', 'Error: Mensaje no enviado.');
            }

            $this->addFlash('success', 'Mensaje enviado correctamente');

            return $this->redirectToRoute('guaranteed_rental');
        }

        return $this->render('fronted/default/guaranteed_rental.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/servicios/abogados", name="services_lawyers")
     */
    public function servicesLawyers()
    {
        return $this->render('fronted/default/services/lawyers.html.twig');
    }

    /**
     *
     * @Route("/servicios/asesoria-fiscal", name="services_tax_advice")
     */
    public function servicesTaxAdvice()
    {
        return $this->render('fronted/default/services/tax_advice.html.twig');
    }

    /**
     *
     * @Route("/servicios/seguros", name="services_insurance")
     */
    public function servicesInsurance()
    {
        return $this->render('fronted/default/services/insurance.html.twig');
    }

    /**
     *
     * @Route("/servicios/reformas", name="services_reforms")
     */
    public function servicesReforms()
    {
        return $this->render('fronted/default/services/reforms.html.twig');
    }

    /**
     *
     * @Route("/servicios/financiacion", name="services_financing")
     */
    public function servicesFinancing()
    {
        return $this->render('fronted/default/services/financing.html.twig');
    }

    /**
     *
     * @Route("/servicios/certificado-energetico", name="services_energy_certificate")
     */
    public function servicesEnergyCertificate()
    {
        return $this->render('fronted/default/services/energy_certificate.html.twig');
    }

    /**
     * @Route("/nosotros", name="about_us")
     */
    public function about()
    {
        return $this->render('fronted/default/about.html.twig');
    }

    /**
     * @Route("/contacto", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();

            $message = (new \Swift_Message('Mensaje de: ' . $formData['fullName']))
                ->setFrom($formData['email'])
                ->setTo('info@loyaltylabel.es')
                ->setBody(
                    $this->renderView(
                        'fronted/email/contact.twig',
                        [
                            'fullName' => $formData['fullName'],
                            'mobile' => $formData['mobile'],
                            'comment' => $formData['comment'],
                        ]
                    ),
                    'text/html'
                )
            ;

            $mailer->send($message);
            $this->addFlash('success', 'Mensaje enviado correctamente');

            return $this->redirectToRoute('contact');
        }

        return $this->render('fronted/default/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/alerts/recados", name="alerts_notes", methods={"GET"})
     */
    public function notes(NoteCommercialRepository $noteCommercialRepository): Response
    {
        return $this->render('admin/default/note.html.twig', [
            'note_commercials' => $noteCommercialRepository->findByDate(['commercial' => $this->getUser()]),
        ]);
    }

    /**
     * @Route("/alerts/notices-to-developer", name="alerts_notices_to_developer", methods={"GET"})
     */
    public function noticestodeveloper(PropertyRepository $propertyRepository): Response
    {
        return $this->render('admin/default/notices_to_developer.html.twig', [
            'noticestodeveloper' => $propertyRepository->alertsOnlyNoticesToDeveloper($this->getUser())
        ]);
    }

    /**
     * @Route("/alerts/notices", name="alerts_notices", methods={"GET"})
     */
    public function notices(PropertyRepository $propertyRepository): Response
    {
        return $this->render('admin/default/notices.html.twig', [
            'notices' => $propertyRepository->alertsOnlyNotices($this->getUser(), $this->getUser()->getAgency())
        ]);
    }

    /**
     * @Route("/alerts/charges", name="alerts_charges", methods={"GET"})
     */
    public function charges(PropertyRepository $propertyRepository): Response
    {
        return $this->render('admin/default/charges.html.twig', [
            'charges' => $propertyRepository->alertsOnlyCharges($this->getUser())
        ]);
    }

    /**
     * @Route("/alerts/clients", name="alerts_clients", methods={"GET"})
     */
    public function clients(ClientRepository $clientRepository): Response
    {
        //SEPARARLOS POR VENTA Y ALQUILER
        return $this->render('admin/default/clients.html.twig', [
            'clientsSells' => $clientRepository->alertsOnlyClientsSell($this->getUser()),
            'clientsRents' => $clientRepository->alertsOnlyClientsRent($this->getUser())
        ]);
    }

    /**
     * @Route("/admin/buscar", name="search")
     */
    public function search(Request $request, ClientRepository $clientRepository, PropertyRepository $propertyRepository): Response
    {

        $dataSearch = '%' . $request->request->get('search') . '%';

        $clients = $clientRepository->createQueryBuilder('c')
            ->andWhere('c.full_name LIKE :dataFullName OR c.mobile LIKE :dataMobile')
            ->setParameter('dataFullName', $dataSearch)
            ->setParameter('dataMobile', $dataSearch)
            ->getQuery()
            ->getResult()
        ;

        $properties = $propertyRepository->createQueryBuilder('p')
            ->andWhere('p.full_name LIKE :dataFullName OR p.mobile LIKE :dataMobile')
            ->setParameter('dataFullName', $dataSearch)
            ->setParameter('dataMobile', $dataSearch)
            ->getQuery()
            ->getResult()
        ;
        //$properties = $propertyRepository->findBy(['full_name' => $dataSearch]);

        return $this->render('admin/default/search.html.twig', [
            'clients' => $clients,
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("/buscar/vivienda", name="search_fronted", methods={"GET"})
     */
    public function searchFronted(Request $request, PropertyRepository $propertyRepository, PaginatorInterface $paginator): Response
    {
        $currentPage = $request->query->getInt('page') ?: 1;

        $searchFronted = new SearchFronted();
        $form = $this->createForm(SearchFrontedType::class, $searchFronted);
        $form->handleRequest($request);

        $queryBuilder = $propertyRepository
            ->createQueryBuilder('p')
            ->innerJoin('p.charge', 'c')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->innerJoin('p.typeProperty', 'tp')
            ->innerJoin('p.rateHousing', 'rh')
            ->leftJoin('p.propertyReductions', 'pr')
            ->leftJoin('p.proposals', 'pro')
            ->addSelect('SUM(pr.price) as sumPropertyReduction')
            ->addSelect('COUNT(pro.contract) as countPropertyContract')
            ->addSelect('COUNT(pro.scriptures) as countPropertyScriptures')
            ->groupBy('c.id')
            ->orderBy('c.start_date', 'DESC')
        ;

        if ($form->get('bedrooms')->getData()) {
            $queryBuilder
                ->andWhere('rh.bedrooms = :bedrooms')
                ->setParameter('bedrooms', $form->get('bedrooms')->getData())
                ;
        }

        if ($form->get('price')->getData()) {
            $queryBuilder
                ->andWhere('c.price <= :price')
                ->setParameter('price', $form->get('price')->getData())
            ;
        }

        if ($form->get('typeProperty')->getData()) {
            //dd($form->get('typeProperty')->getData()->getId());
            $queryBuilder
                ->andWhere('tp.id = :typeProperty')
                ->setParameter('typeProperty', $form->get('typeProperty')->getData())
            ;
        }

        if ($form->get('sellOrRent')->getData() !== null) {

            if ($form->get('sellOrRent')->getData() == 0) {
                $queryBuilder
                   ->andWhere('s.name = :situation')
                   ->andWhere('r.name = :reason')
                   ->setParameter('situation', 'Noticia')
                   ->setParameter('reason', 'Venta')
               ;
           }

           if ($form->get('sellOrRent')->getData() == 1) {
               $queryBuilder
                   ->andWhere('s.name = :situation')
                   ->andWhere('r.name = :reason')
                   ->setParameter('situation', 'Noticia')
                   ->setParameter('reason', 'Alquiler')
               ;
           }
        }

        $properties = $queryBuilder->getQuery()->getResult();

/*        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            9
        );*/

        return $this->render('fronted/default/search-fronted.html.twig', [
            //'properties' => $properties,
            'properties' => $properties,
            //'maxPages' => $maxPages,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/comprar", name="property_sell", methods={"GET"})
     */
    public function propertySell(): Response
    {
        return $this->render('fronted/default/property_sell.html.twig', [
        ]);
    }

    /**
     * @Route("/buscar/vivienda/detalles/{reference}", name="search_details")
     */
    public function searchDetails(Request $request, Property $property)
    {
        return $this->render('fronted/default/search_details.html.twig', [
           'property' => $property
        ]);
    }

    /**
     * @Route("/politica-de-privacidad", name="privacy_police")
     */
    public function privacyPolice(Request $request)
    {
        return $this->render('fronted/default/legal/privacy_police.html.twig');
    }

    /**
     * @Route("/aviso-legal", name="legal_warning")
     */
    public function legalWarning(Request $request)
    {
        return $this->render('fronted/default/legal/legal_warning.html.twig');
    }

}
