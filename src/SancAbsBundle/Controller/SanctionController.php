<?php

namespace SancAbsBundle\Controller;

use AlmniBundle\Entity\User;
use ProfilBundle\Entity\Profileleve;
use SancAbsBundle\Entity\Sanction;
use SancAbsBundle\Form\SanctionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
class SanctionController extends Controller
{
    public function AjoutSancAdminAction(Request $request)
    {
        $user = $this->getUser();
        $sanction= new Sanction();
        $sanction->setUser($user);
        $sanction->setDatecreation(new \DateTime('now'));

        $form = $this->createForm(SanctionType::class, $sanction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sanction);
            $em->flush();
            return $this->redirectToRoute('affSancAdmin');
        }

        return $this->render('@SancAbs/Admin/Default/ajoutSanc.html.twig', array(
            'Sanction' => $sanction,
            'form' => $form->createView(),
        ));
    }
    public function affSancAdminAction()
    {
        $em=$this->getDoctrine()->getRepository(Sanction::class)->findAll();
        return $this->render('@SancAbs/Admin/Default/affSanc.html.twig',array('Sanction'=> $em));
    }
    public function affSancAction(Request $request)
    {
        $id=$this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM SancAbsBundle:Sanction a WHERE a.eleve=:id ");
        $query->setParameter('id',$id);
        $Sanction = $query->getResult();
        return $this->render("@SancAbs/Front/Default/affSanc.html.twig",array(
            'Sanction'=>$Sanction,));
    }

    public function modifSancAdminAction(Request $request,$id)
    {
        $sanction=$this->getDoctrine()->getRepository(Sanction::class)->find($id);
        //  $deleteForm = $this->createDeleteForm($absence);
        $editForm = $this->createForm('SancAbsBundle\Form\SanctionType', $sanction);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('affSancAdmin');
        }

        return $this->render('@SancAbs/Admin/Default/modifSanc.html.twig', array(
            'Sanction' => $sanction,
            'edit_form' => $editForm->createView(),
            // 'delete_form' => $deleteForm->createView(),
        ));
    }
    function suppSancAdminAction($id){
        $em=$this->getDoctrine()->getManager();
        $sanction=$this->getDoctrine()->getRepository(Sanction::class)
            ->find($id);
        $em->remove($sanction);
        $em->flush();
        return $this->redirectToRoute('affSancAdmin');
    }

    public function affSancMobAction()
    {

        $abs = $this->getDoctrine()->getManager()
            ->getRepository('SancAbsBundle:Sanction')
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

    public function findSancMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM SancAbsBundle:Sanction a WHERE a.eleve=:id ");
        $query->setParameter('id',$request->get('id'));
        $Absence = $query->getResult();        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Absence);
        return new JsonResponse($formatted);
    }

    public function ajoutSancMobAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $Sanction = new Sanction();
        $Eleve=$this->getDoctrine()->getRepository(Profileleve::class)->find($request->get('eleve'));
        $Sanction->setEleve($Eleve);
        $user=$this->getDoctrine()->getRepository(User::class)->find($request->get('id'));

        $Sanction->setUser($user);
        $Sanction->setNature($request->get('nature'));
        $Sanction->setCommentaire($request->get('commentaire'));
        $Sanction->setDatecreation(new \DateTime('now'));
        $em->persist($Sanction);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Sanction);
        return new JsonResponse($formatted);
    }
    public function modifSancMobAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $Sanction = $em->getRepository(Sanction::class)->find($request->get('id'));
        $Eleve=$this->getDoctrine()->getRepository(Profileleve::class)->find($request->get('eleve'));
        $Sanction->setEleve($Eleve);
        $Sanction->setNature($request->get('nature'));
        $Sanction->setCommentaire($request->get('commentaire'));
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($Sanction) {
            return $Sanction->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($Sanction);
        return new JsonResponse($formatted);
    }
    function suppSancMobAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $Sanction=$this->getDoctrine()->getRepository(Sanction::class)
            ->find($request->get('id'));
        $em->remove($Sanction);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Sanction);
        return new JsonResponse($formatted);
    }

}
