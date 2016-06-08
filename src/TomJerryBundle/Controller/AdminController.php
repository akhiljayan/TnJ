<?php

namespace TomJerryBundle\Controller;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AkjnBundle\Forms\LoginForm;
use AkjnBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use TomJerryBundle\Interfaces\AuditableControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use TomJerryBundle\Controller\uploaderHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

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
            } elseif ($user->hasRole('ROLE_TMJR_ADMIN')) {
                return $this->render('TomJerryBundle:AdminSection:adminDashboard.html.twig');
            }
        } else {
            return $this->generateUrl("_logout");
//            return $this->indexAction($request);
        }
    }

    public function redirectGalaryAction(Request $request) {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($user->hasRole('ROLE_TMJR_SUPERUSER')) {
                return $this->render('TomJerryBundle:AdminSection:adminGalary.html.twig');
            } elseif ($user->hasRole('ROLE_TMJR_ADMIN')) {
                return $this->render('TomJerryBundle:AdminSection:adminGalary.html.twig');
            }
        } else {
            return $this->indexAction($request);
        }
    }

    public function uploaderEndPointAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $uploader = new uploaderHandler();
        $uploader->allowedExtensions = array();
        $uploader->sizeLimit = null;
        $uploader->inputName = "qqfile";
        $uploader->chunksFolder = "chunks";

        $method = $_SERVER["REQUEST_METHOD"];
        if ($method == "POST") {
            header("Content-Type: text/plain");
            $result = $uploader->handleUpload($request, "files");
            $uploadingImgTable = new \TomJerryBundle\Entity\GalaryImages();

            $uploadingImgTable->setName($result['fileName']);
            $uploadingImgTable->setSize($result['fileSize']);
            $uploadingImgTable->setImgType($result['fileType']);
            $uploadingImgTable->setUploadedBy($user);
            $uploadingImgTable->setImgBlob($result['base64']);
            $uploadingImgTable->setEnableDissable(false);
            $em->persist($uploadingImgTable);
            $em->flush();

//            unlink($result['target']);
            return new \Symfony\Component\HttpFoundation\JsonResponse($result);
        } else if ($method == "DELETE") {
            $result = $uploader->handleDelete("files");
            return json_encode($result);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
        }
    }

    public function renderGalaryImgTableAction() {
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository("TomJerryBundle:GalaryImages")->findAll();
        return $this->render('TomJerryBundle:AdminSection:renderGalaryImgTable.html.twig', array('images' => $images));
    }

    public function saveDisplayTitleAction(Request $request, $guId) {
        $em = $this->getDoctrine()->getManager();
        $dispName = $request->request->get('dispName');
        $image = $em->getRepository("TomJerryBundle:GalaryImages")->findOneByGuId($guId);
        $image->setImgDisplayName($dispName);
        $em->persist($image);
        $em->flush();
        return new JsonResponse(true);
    }

    public function enableDissableGalaryImageAction(Request $request, $guId) {
        $em = $this->getDoctrine()->getManager();
        $flag = $request->request->get('flag');
        $image = $em->getRepository("TomJerryBundle:GalaryImages")->findOneByGuId($guId);
        if ($flag == 'on') {
            $image->setEnableDissable(true);
        } else {
            $image->setEnableDissable(false);
        }
        $em->persist($image);
        $em->flush();
        return new JsonResponse(true);
    }

}
