<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\ProprieteBien;
use App\Entity\ProprieteBienSearch;
use App\Form\ContactType;
use App\Form\ProprieteBienSearchType;
use App\Repository\ProprieteBienRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

	/**
	 * @var ProprieteBienRepository
	 */
	private $repository;

	/**
	 * @var ObjectManager
	 */
	private $em;

	// Recuperation du repo par injection #C'estPlusSimple <3
	public function __construct(ProprieteBienRepository $repository, ObjectManager $em)
	{
		$this->repository = $repository;
		$this->em = $em;
	}

	/**
	 * @return Response
	 */
	public function home():Response
	{
		$propriete_bien = $this->repository->latestBien();
		
		return $this->render('home.html.twig', [
            'properties' => $propriete_bien
        ]);
	}

	/**
	 * @param PaginatorInterface $paginator
	 * @param Request $request
	 * @return Response
	 */
	public function buyHome(PaginatorInterface $paginator, Request $request):Response
	{

		// Search options
		$search = new ProprieteBienSearch();
		$form = $this->createForm(ProprieteBienSearchType::class, $search);
		$form->handleRequest($request);

		// Pagination
		$propriete_bien = $paginator->paginate(
			$this->repository->findAllVisibleBien($search),
			$request->query->getInt('page', 1),
			6
		);

		return $this->render('buy.html.twig', [
			'current_menu' => 'buy_properties',
			'properties' => $propriete_bien,
			'form' => $form->createView()
		]);
	}

	/**
	 * @param ProprieteBien $proprieteBien
	 * @param Request $request
	 * @param ContactNotification $contactNotification
	 * @param $id
	 * @param $slug
	 * @return Response
	 * @throws \Twig_Error_Loader
	 * @throws \Twig_Error_Runtime
	 * @throws \Twig_Error_Syntax
	 */
	public function showBienById(ProprieteBien $proprieteBien, Request $request, ContactNotification $contactNotification, int $id, string $slug):Response
	{
		// Verif slug
		if ($proprieteBien->getSlug() !== $slug)
		{
			return $this->redirectToRoute('show', [
				'id' => $proprieteBien->getId(),
				'slug' => $proprieteBien->getSlug()
			], 301);
		}

		$propriete_bien = $this->repository->find($id);

		// Instance new contact
		$contact = new Contact();
		// On set le bien dans lequel nous sommes
		$contact->setProprieteBien($proprieteBien);

		$form = $this->createForm(ContactType::class, $contact);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			// Send notification
			$contactNotification->notification($contact);
			// Add flash message
			$this->addFlash('success', 'Votre email à bien été envoyé');

			return $this->redirectToRoute('show', [
				'id' => $proprieteBien->getId(),
				'slug' => $proprieteBien->getSlug()
			]);
		}

		return $this->render('show.html.twig', [
			'propriety' => $propriete_bien,
			'form' => $form->createView()
		]);
	}
}