<?php

namespace ProfilBundle\Controller;

use ProfilBundle\Entity\Profilprof;
use ProfilBundle\Form\ProfilprofType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProfilprofController extends Controller
{
    public function AjoutProfAction(Request $request)
    {
        $prof= new Profilprof();


        $form = $this->createForm(ProfilprofType::class, $prof);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prof);
            $em->flush();
            return $this->redirectToRoute('AffProfAdmin');
        }

        return $this->render('@Profil/Admin/Default/AjoutProf.html.twig', array(
            'Profilprof' => $prof,
            'form' => $form->createView(),
        ));
    }

    public function AffProfAdminAction()
    {
        $em=$this->getDoctrine()->getRepository(Profilprof::class)->findAll();
        return $this->render('@Profil/Admin/Default/affProf.html.twig',array('Profilprof'=> $em));
    }
    public function ModifProfAdminAction(Request $request,$id)
    {
        $prof=$this->getDoctrine()->getRepository(Profilprof::class)->find($id);
        //  $deleteForm = $this->createDeleteForm($absence);
        $editForm = $this->createForm('ProfilBundle\Form\ProfilprofType', $prof);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ModifProfAdmin', array('id' => $prof->getId()));
        }

        return $this->render('@Profil/Admin/Default/modifProf.html.twig', array(
            'Profilprof' => $prof,
            'edit_form' => $editForm->createView(),
            // 'delete_form' => $deleteForm->createView(),
        ));
    }

    function SuppProfAdminAction($id){
        $em=$this->getDoctrine()->getManager();
        $prof=$this->getDoctrine()->getRepository(Profilprof::class)
            ->find($id);
        $em->remove($prof);
        $em->flush();
        return $this->redirectToRoute('AffProfAdmin');
    }
    public function affProfMobAction()
    {
        $prof = $this->getDoctrine()->getManager()
            ->getRepository('ProfilBundle:Profilprof')
            ->findAll();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($prof) {
            return $prof->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($prof);
        return new JsonResponse($formatted);
    }
    public function findProfMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM ProfilBundle:Profilprof a WHERE a.id=:id ");
        $query->setParameter('id',$request->get('id'));
        $prof = $query->getResult();        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($prof);
        return new JsonResponse($formatted);
    }


    public function findProfnomMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM ProfilBundle:Profilprof a WHERE a.nom=:nom ");
        $query->setParameter('nom',$request->get('nom'));
        $prof = $query->getResult();        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($prof);
        return new JsonResponse($formatted);
    }

}
