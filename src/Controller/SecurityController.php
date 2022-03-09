<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use App\Form\ResetPassType;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription",name="security_registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder,\Swift_Mailer $mailer)
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            // on génère le token d'activation
            $user->setActivationToken(md5(uniqid()));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            // do anything else you need here ,like send an email
            //on crée le message
            $message =(new \Swift_Message('Activation de votre compte'))
              //on attribue l'expéditeur
                ->setFrom('votre@adresse.com')
              //on attribue le destinataire
                ->setTo($user->getEmail())
              // on crée le contenu
                ->setBody($this->renderView('emails/activation.html.twig',['token' => $user->getActivationToken()]),'text/html'
               );

              //on envoie l'email
              $mailer->send($message);
            if ($user->getRole()=="ROLE_ADMIN")
                return $this->redirectToRoute('listutilisateurs');
            else if($user->getRole()=="ROLE_CLIENT")
                return $this->redirectToRoute('demande_evenement');
            else
                return $this->redirectToRoute('demande_evenement');

        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion",name="security_login")
     */
    public function login(Request $request, AuthenticationUtils $utils)
    {
        $user=new Utilisateur();
        $error = $utils->getLastAuthenticationError();
        $email = $utils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'error' => $error,
            'last_username' => $email]);
    }

    /**
     * @Route("/deconnexion",name="security_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('demande_evenement');
    }
    /**
     * @Route("/oubli-pass",name="app_forgotten_password")
     */
    public function forgottenPass(Request $request, UtilisateurRepository $userRepo, \Swift_Mailer $mailer,TokenGeneratorInterface $tokenGenerator){
        //on crée le formulaire
        $form=$this->createForm(ResetPassType::class);

        //on traite le formulaire
        $form->handleRequest($request);

        //Si le formulaire est valide
        if($form->isSubmitted() && $form->isValid()){
            // on récupère les données
            $donnees=$form->getData();

            //on cherche si un utilisateur a cet email
            $user= $userRepo->findOneByEmail($donnees['email']);

            //Si l'utilisateur n'existe pas
            if(!$user){
                //On envoie un message flash
                $this->addFlash('danger','Cette adresse n\'existe pas');

                $this->redirectToRoute('app_forgotten_password');
            }
            // on génère un token
            $token=$tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();
            }catch(\Exception $e){
                $this->addFlash('warning','une erreur est survenue : '.$e->getMessage());
                return $this->redirectToRoute('app_forgotten_password');
            }

            // on génère l'URL de réinitialisation de mot de passe
            $url = $this->generateUrl('app_reset_password' , ['token'=> $token],
             UrlGeneratorInterface::ABSOLUTE_URL);

            //On envoie le message
            $message =(new \Swift_Message('Mot de passe oublié'))
                //on attribue l'expéditeur
                ->setFrom('votre@gmail.com')
                //on attribue le destinataire
                ->setTo($user->getEmail())
                // on crée le contenu
                ->setBody("<p>Bonjour,</p><p>une demande de réinitialisation de mot de passe a été effectué 
                          pour le site.Veuillez cliquer sur le lien suivant : " .$url. '</p>','text/html');

            //on envoie l'email
            $mailer->send($message);

            //on crée le message flash
            $this->addFlash('message' ,'un e-mail de réinitialisation de mot de passe vous a été envoyé');

            $this->redirectToRoute('security_login');
         }
        //on envoie vers la page de demande de l'email
        return $this->render('security/forgotten_password.html.twig', ['emailForm' => $form->createView()]);
    }

    /**
     * @Route("/reset_pass/{token}", name="app_reset_password")
     */
    public function resetPassword($token,Request $request,UserPasswordEncoderInterface $passwordEncoder){
            $user=$this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['reset_token'=> $token]);

            if(!$user){
                $this->addFlash('danger','Token inconu');
                return $this->redirectToRoute('security_login');
            }
          //Si le formulaire est envoyé en méthode Post
          if($request->isMethod('POST')){
              // on supprime le token
              $user->setResetToken(null);

              //on chiffre le mot de passe
              $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
              $manager = $this->getDoctrine()->getManager();
              $manager->persist($user);
              $manager->flush();

              $this->addFlash('message','Mot de passe modifié avec succès');

              return $this->redirectToRoute('security_login');
          }else{
              return $this->render('security/reset_password.html.twig',['token' => $token]);
          }
    }
    /**
     * @Route("/activation/{token}",name="activation")
     */
    public function activation($token,UtilisateurRepository $usersRepo){
        //on vérifie si un utilisateur a ce token
         $user=$usersRepo->findOneBy(['activation_token' => $token]);
        //si aucun utilisateur existe avec ce token
        if(!$user){
                throw $this->createNotFoundException('Cet utilisateur n\existe pas');
               }

        //on supprime le token
        $user->setActivationToken(null);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();

        //on envoie un message flush
        $this->addFlash('message', 'Vous avez bien activé votre compte');

        // on retourne à l'acceuil
        if($user->getRole()=="ROLE_ADMIN") {
            return $this->redirectToRoute('utilisateur');
        }
        else return $this->redirectToRoute('demande_evenement');
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        /*if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }*/
        // For example : return new RedirectResponse($this->urlGenerator->generate('some_route'));
        //throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
        {
            // Get list of roles for current user
            $roles = $token->getRoles();
            // Tranform this list in array
            $rolesTab = array_map(function ($role) {
                return $role->getRole();
            }, $roles);
            // If is a admin or super admin we redirect to the backoffice area
            if (in_array('ROLE_ADMIN', $rolesTab, true))
                $redirection = new RedirectResponse($this->urlGenerator->generate('listutilisateurs'));
            else
                $redirection = new RedirectResponse($this->router->generate('demande_evenement'));

            return $redirection;
        }
    }
    /**
     * Redirect users after login based on the granted ROLE
     * @Route("/login/redirect", name="_login_redirect")
     */
    public function loginRedirectAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            return $this->redirectToRoute('security_login');
//throw $this->createAccessDeniedException();
        }
        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('listutilisateurs');
        }
        else if($this->get('security.authorization_checker')->isGranted('ROLE_USER'))
        {
            return $this->redirectToRoute('demande_evenement');
        }
        else
        {
            return $this->redirectToRoute('security_login');
        }
    }
}
