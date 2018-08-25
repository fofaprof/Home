<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
	/**
     * @Route("/contact", name="create-contact")
     */
	public function create(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $contact = new Contact();
            $contact->setName($data->getName());
            $contact->setEmail($data->getEmail());
            $contact->setPhone($data->getPhone());
            $contact->setMessage($data->getMessage());

            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('contact-send');
        }

        return $this->render('contact/create.html.twig', [
            'contact_form' => $form->createView()
        ]);
    }



    /**
     * @Route("/contact-send", name="contact-send")
     */
    public function index()
    {
        return $this->render('contact/index.html.twig');
    }
}
