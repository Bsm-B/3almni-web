<?php

namespace ProfilBundle\Controller;

use ProfilBundle\Entity\Profilparent;
use ProfilBundle\Form\ProfilparentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfilparentController extends Controller
{
    public function AjoutParentAction(Request $request)
    {
        $parent= new Profilparent();


        $form = $this->createForm(ProfilparentType::class, $parent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($parent);
            $em->flush();
            return $this->redirectToRoute('AffParentAdmin');
        }

        return $this->render('@Profil/Front/Default/AjoutParent.html.twig', array(
            'Profilparent' => $parent,
            'form' => $form->createView(),
        ));
    }

    public function AffParentAdminAction()
    {
        $em=$this->getDoctrine()->getRepository(Profilparent::class)->findAll();
        return $this->render('@Profil/Admin/Default/AffParent.html.twig',array('Profilparent'=> $em));
    }
    public function ModifParentAdminAction(Request $request,$id)
    {
        $parent=$this->getDoctrine()->getRepository(Profilparent::class)->find($id);
        //  $deleteForm = $this->createDeleteForm($absence);
        $editForm = $this->createForm('ProfilBundle\Form\ProfilparentType', $parent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ModifParentAdmin', array('id' => $parent->getId()));
        }

        return $this->render('@Profil/Admin/Default/modifParent.html.twig', array(
            'Profilparent' => $parent,
            'edit_form' => $editForm->createView(),
            // 'delete_form' => $deleteForm->createView(),
        ));
    }
    function SuppParentAdminAction($id){
        $em=$this->getDoctrine()->getManager();
        $parent=$this->getDoctrine()->getRepository(Profilparent::class)
            ->find($id);
        $em->remove($parent);
        $em->flush();
        return $this->redirectToRoute('AffParentAdmin');
    }

}
