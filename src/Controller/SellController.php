<?php

namespace App\Controller;

use App\Entity\ProprieteBien;
use App\Form\SellType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SellController extends AbstractController
{
	public function sellHome(Request $request):Response
	{
		$propriete_bien = new ProprieteBien();

		// Create Form
		$form = $this->createForm(SellType::class, $propriete_bien);
        $form->handleRequest($request);

		// Check form
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Set datetime "NOW"
			$current_time = new \DateTime();
			// Recup data
            $formData = $form->getData();

            $propriete_bien->setName($formData->getName());
            $propriete_bien->setDescription($formData->getDescription());
            $propriete_bien->setCity($formData->getCity());
            $propriete_bien->setAddress($formData->getAddress());
            $propriete_bien->setZipCode($formData->getZipCode());
            $propriete_bien->setNbrRooms($formData->getNbrRooms());
            $propriete_bien->setSurface($formData->getSurface());
            $propriete_bien->setNbrBedrooms($formData->getNbrBedrooms());
            $propriete_bien->setPrice($formData->getPrice());
            $propriete_bien->setSold(0);
            $propriete_bien->setMakeAt($current_time);

            $em->persist($propriete_bien);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        
		return $this->render('sell.html.twig', [
			'current_menu' => "sell_properties",
			'form' => $form->createView(),
		]);
	}
}