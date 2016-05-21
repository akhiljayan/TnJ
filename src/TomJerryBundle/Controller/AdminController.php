<?php

namespace TomJerryBundle\Controller;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AkjnBundle\Forms\LoginForm;
use AkjnBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use TomJerryBundle\Interfaces\AuditableControllerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AdminController
 *
 * @author akhil
 */
class AdminController extends Controller implements AuditableControllerInterface {

    public function adminLoginAction(Request $request) {
        $session = $request->getSession();
        $user = new User();
        $form = $this->createForm(new LoginForm(), $user);
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new RedirectResponse($this->generateUrl("_logout"));
        }
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }
        if ($error) {
            $error = $error->getMessage();
        }
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);
        $csrfToken = $this->container->has('form.csrf_provider') ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate') : null;
        $salt = md5(uniqid(php_uname('n')));
        return $this->render('TomJerryBundle:AdminSection:login.html.twig', array('form' => $form->createView(), 'error' => $error, 'csrf_token' => $csrfToken, 'browserSalt' => $salt, 'lastUserName' => $lastUsername));
    }

    public function mainRedirectAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($user->hasRole('ROLE_TMJR_SUPERUSER')) {
                return $this->render('TomJerryBundle:AdminSection:adminDashboard.html.twig');
            } elseif ($user->hasRole('ROLE_TMJR_ADMIN')) {}
        } else {
            return $this->indexAction($request);
        }
    }

}
