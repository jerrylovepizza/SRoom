<?php

namespace App\Controller;

use App\Entity\ProprieteBien;
use App\Form\ProprieteType;
use App\Repository\ProprieteBienRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminProprieteController extends AbstractController
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
	public function index():Response
	{
		$property = $this->repository->findAll();
		return $this->render('admin/index.html.twig', [
			'current_menu' => 'admin_menu',
			'properties' => $property
		]);
	}

	/**
	 * @param Request $request
	 * @return Response
	 */
	public function addBien(Request $request)
	{
		// Instance new Bien
		$proprieteBien = new ProprieteBien();

		// Create Form
		$form = $this->createForm(ProprieteType::class, $proprieteBien);
		$form->handleRequest($request);

		// Check Form
		if ($form->isSubmitted() && $form->isValid())
		{

			$current_time = new \DateTime();
			$proprieteBien->setMakeAt($current_time);

			$this->em->persist($proprieteBien);
			$this->em->flush();
			// Add confirm message
			$this->addFlash('success', "Le bien <strong>{$proprieteBien->getName()}</strong> a été ajouté avec succès !");

			return $this->redirectToRoute('admin');
		}

		return $this->render('admin/add.html.twig', [
			'proprieteBien' => $proprieteBien,
			'form' => $form->createView()
		]);
	}

	/**
	 * @param ProprieteBien $proprieteBien
	 * @param Request $request
	 * @return Response
	 */
	public function editBien(ProprieteBien $proprieteBien, Request $request)
	{
		// Form -> PropertyType
		$form = $this->createForm(ProprieteType::class, $proprieteBien);
		$form->handleRequest($request);

		// Check Form
		if ($form->isSubmitted() && $form->isValid())
		{
			$this->em->flush();
			// Add confirm message
			$this->addFlash('success', "Le bien <strong>{$proprieteBien->getName()}</strong> a été modifié avec succès !");
			return $this->redirectToRoute('admin');
		}

		return $this->render('admin/edit.html.twig', [
			'proprieteBien' => $proprieteBien,
			'form' => $form->createView()
		]);
	}

	/**
	 * @param ProprieteBien $proprieteBien
	 * @param Request $request
	 * @return Response
	 */
	public function deleteBien(ProprieteBien $proprieteBien, Request $request)
	{
		// Check CSRF token is valid, id of proprieteBien
		if ($this->isCsrfTokenValid('delete' . $proprieteBien->getId(), $request->get('_token')))
		{
			// Remove
			$this->em->remove($proprieteBien);
			$this->em->flush();
			// Add confirm message
			$this->addFlash('success', "Le bien <strong>{$proprieteBien->getName()}</strong> a été supprimé avec succès !");
		}

		return $this->redirectToRoute('admin');
	}

}