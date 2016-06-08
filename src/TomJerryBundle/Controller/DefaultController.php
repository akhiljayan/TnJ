<?php

namespace TomJerryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $images = $qb->select('i')
                ->from('TomJerryBundle:GalaryImages', 'i')
                ->where('i.enableDissable = 1')
                ->orderBy('i.id', 'DESC')
                ->setMaxResults(5)
                ->getQuery()
                ->getArrayResult();
        return $this->render('TomJerryBundle:MainsiteSection:index.html.twig', array('images' => $images));
    }

    public function aboutUsAction() {
        return $this->render('TomJerryBundle:MainsiteSection:aboutUs.html.twig');
    }

    public function outStaffsAction() {
        return $this->render('TomJerryBundle:MainsiteSection:ourStaffs.html.twig');
    }

    public function servicesAction() {
        return $this->render('TomJerryBundle:MainsiteSection:services.html.twig');
    }

    public function contactUsAction() {
        return $this->render('TomJerryBundle:MainsiteSection:contactUs.html.twig');
    }

    public function fullGalaryPageAction() {
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository("TomJerryBundle:GalaryImages")->findBy(array('enableDissable' => true));
        return $this->render('TomJerryBundle:MainsiteSection:fullGalaryPage.html.twig', array('images' => $images));
    }

}
