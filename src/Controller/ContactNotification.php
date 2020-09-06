<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;

class ContactNotification extends AbstractController
{

	/**
	 * @var \Swift_Mailer
	 */
	private $mailer;
	/**
	 * @var Environment
	 */
	private $environment;

	// L'injection qu'on aime tant <3
	public function __construct(\Swift_Mailer $mailer, Environment $environment)
	{

		$this->mailer = $mailer;
		$this->environment = $environment;
	}

	/**
	 * @param Contact $contact
	 * @throws \Twig_Error_Loader
	 * @throws \Twig_Error_Runtime
	 * @throws \Twig_Error_Syntax
	 */
	public function notification(Contact $contact)
	{
		// New mail
		$message = (new \Swift_Message('Demande de contact pour le bien : ' . $contact->getProprieteBien()->getName()))
			->setFrom('noreply@SRoom.fr')
			->setTo('contact@SRoom.fr')
			->setBody($this->environment->render('contact/contact.html.twig', [
				'contact' => $contact
			]), 'text/html');

		// Sent email
		$this->mailer->send($message);
	}

}