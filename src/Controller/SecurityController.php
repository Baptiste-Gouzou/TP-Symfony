<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
    * @Route("/inscription", name="app_inscription")
    */
    public function inscription(Request $requeteHttp, EntityManagerInterface $entityManager,UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();

        $formulaireUser = $this->createForm(UserType::class, $user);

        $formulaireUser->handleRequest($requeteHttp);



        if($formulaireUser->isSubmitted() && $formulaireUser->isValid())
        {
          
            $encodagePassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodagePassword);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('pro_stage');
        }

          return $this->render('security/inscription.html.twig',['vueFormulaireUser' => $formulaireUser->createView(),
          'action' => "ajouter"]);
    }
}
