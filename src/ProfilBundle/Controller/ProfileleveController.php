<?php

namespace ProfilBundle\Controller;

use ProfilBundle\Entity\Profileleve;
use ProfilBundle\Form\ProfileleveType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProfileleveController extends Controller
{
    public function AjoutEleveAction(Request $request)
    {
        $eleve= new Profileleve();


        $form = $this->createForm(ProfileleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eleve);
            $em->flush();
            return $this->redirectToRoute('AffEleveAdmin');
        }

        return $this->render('@Profil/Front/Default/AjoutEleve.html.twig', array(
            'Profileleve' => $eleve,
            'form' => $form->createView(),
        ));
    }
    public function AffEleveAdminAction()
    {
        $em=$this->getDoctrine()->getRepository(Profileleve::class)->findAll();
        return $this->render('@Profil/Admin/Default/AffEleve.html.twig',array('Profileleve'=> $em));
    }
    public function AffEleveAction()
    {
        $em=$this->getDoctrine()->getRepository(Profileleve::class)->findAll();
        return $this->render('@Profil/Front/Default/AffEleve.html.twig',array('Profileleve'=> $em));
    }

    public function ModifEleveAdminAction(Request $request,$id)
    {
        $eleve=$this->getDoctrine()->getRepository(Profileleve::class)->find($id);
        //  $deleteForm = $this->createDeleteForm($absence);
        $editForm = $this->createForm('ProfilBundle\Form\ProfileleveType', $eleve);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ModifEleveAdmin', array('id' => $eleve->getId()));
        }

        return $this->render('@Profil/Admin/Default/modifEleve.html.twig', array(
            'Profileleve' => $eleve,
            'edit_form' => $editForm->createView(),
            // 'delete_form' => $deleteForm->createView(),
        ));
    }
    function SuppEleveAdminAction($id){
        $em=$this->getDoctrine()->getManager();
        $eleve=$this->getDoctrine()->getRepository(Profileleve::class)
            ->find($id);
        $em->remove($eleve);
        $em->flush();
        return $this->redirectToRoute('AffEleveAdmin');
    }

    public function affEleveMobAction()
    {
        $abs = $this->getDoctrine()->getManager()
            ->getRepository('ProfilBundle:Profileleve')
            ->findAll();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($abs) {
            return $abs->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($abs);
        return new JsonResponse($formatted);
    }
    public function findeleveMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM ProfilBundle:Profileleve a WHERE a.id=:id ");
        $query->setParameter('id',$request->get('id'));
        $Eleve = $query->getResult();        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Eleve);
        return new JsonResponse($formatted);
    }


    public function findelevenomMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM ProfilBundle:Profileleve a WHERE a.nom=:nom ");
        $query->setParameter('nom',$request->get('nom'));
        $Eleve = $query->getResult();        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Eleve);
        return new JsonResponse($formatted);
    }

}
