<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="security_register")
     */
    public function create(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        // ->add('nom', TextType::class)
        // ->add('prenom', TextType::class)
        // ->add('email', TextType::class)
        // ->add('password', PasswordType::class)
        // ->add('role', HiddenType::class, [
        //     'empty_data' => 'user',
        // ])
        // ->add('save', SubmitType::class, array('label' => 'Register'))
        // ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute("security_login");
        }
        return $this->render('User/create.html.twig', [
            'User' => $form->createView()
        ]);
    }
    /**
     * @Route("/login", name="security_login")
     */
    public function login()
    {
        return $this->render('User/login.html.twig');
    }
    /**
     * @Route("/")
     */
    public function acceuil()
    {

        return $this->redirectToRoute("your_profile");
    }

    /**
     * @Route("/profile", name="your_profile")
     */
    public function profile()
    {
        return $this->render('User/profile.html.twig');
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
    }
}
