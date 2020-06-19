<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /**
    * @Route("/user/{id}", name="user_show")
    */
    public function show($id)
    {
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($id);

    if (!$user) {
        throw $this->createNotFoundException(
            'No user found for id '.$id
        );
    }

    // or render a template
    // in the template, print things with {{ user.pseudo }}
    return $this->render('user/show.html.twig', ['user' => $user]);
    }
    
    /**
     * @Route("/creer-utilisateur", name="create_user")
     */
    public function createUser(ValidatorInterface $validator): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setPseudo('greg');
        $user->setPassword('123');
        $user->setMail('canugregoire@gmail.com');

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
        
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$user->getId());
    }
}
