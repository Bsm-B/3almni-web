<?php

namespace SancAbsBundle\Controller;

use SancAbsBundle\Entity\Sanctionemploye;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SanctionemployeController extends Controller
{
    public function affSancempAdminAction()
    {
        $em=$this->getDoctrine()->getRepository(Sanctionemploye::class)->findAll();
        return $this->render('@SancAbs/Admin/Default/affSancemp.html.twig',array('Sanctionemploye'=> $em));
    }

    function suppSancempAdminAction($id){
        $em=$this->getDoctrine()->getManager();
        $Sanctionemploye=$this->getDoctrine()->getRepository(Sanctionemploye::class)
            ->find($id);
        $em->remove($Sanctionemploye);
        $em->flush();
        return $this->redirectToRoute('affSancempAdmin');
    }
    public function affSancempAction(Request $request)
    {
        $id=$this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM SancAbsBundle:Sanctionemploye a WHERE a.employe=:id ");
        $query->setParameter('id',$id);
        $Sanctionemploye = $query->getResult();
        return $this->render("@SancAbs/Front/Default/affSancemp.html.twig",array(
            'Sanctionemploye'=>$Sanctionemploye,));
    }
}
