<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
	/**
	 * @param AuthenticationUtils $authenticationUtils
	 * @return Response
	 */
	public function login(AuthenticationUtils $authenticationUtils)
	{
		// Get the error
		$error = $authenticationUtils->getLastAuthenticationError();
		// Get the last username
		$last_username = $authenticationUtils->getLastUsername();

		return $this->render('security/login.html.twig', [
			'current_menu' => 'connexion_menu',
			'last_username' => $last_username,
			'error' => $error
		]);
	}
}