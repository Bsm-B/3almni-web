<?php

namespace SancAbsBundle\Controller;

use ProfilBundle\Entity\Profilprof;
use SancAbsBundle\Entity\Absenceemploye;
use SancAbsBundle\Entity\Sanctionemploye;
use SancAbsBundle\Form\AbsenceemployeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
class AbsenceemployeController extends Controller
{
    public function AjoutAbsempAdminAction(Request $request)
    {
        $absenceemploye= new Absenceemploye();
        $absenceemploye->setDateabsence(new \DateTime('now'));

        $form = $this->createForm(AbsenceemployeType::class, $absenceemploye);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $absenceemploye->getEmploye();

            $message = \Swift_Message::newInstance()
                ->setSubject("test")
                ->setFrom('amel.khelifa@esprit.tn','Amel Khelifa')
                ->setTo('amel.khelifa@esprit.tn')
                ->setBody(
                    $this->renderView(
                        '@SancAbs/Admin/Default/mail.html.twig',
                        array('Absenceemploye'=> $absenceemploye)
                    ),'text/html');

            $this->get('mailer')->send($message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($absenceemploye);
            $em->flush();

            $em=$this->getDoctrine()->getManager();
            $statutAideA = $em->getRepository(Absenceemploye::class)->findBy(array('employe'=>$absenceemploye->getEmploye()));
            $nb=count($statutAideA);

            if($nb>5){
                $Sanctionemploye= new Sanctionemploye();
                $Sanctionemploye->setUser($this->getUser());
                $Sanctionemploye->setEmploye($absenceemploye->getEmploye());
                $Sanctionemploye->setDatecreation(new \DateTime('now'));
                $Sanctionemploye->setNature("Absence");
                $em = $this->getDoctrine()->getManager();
                $em->persist($Sanctionemploye);
                $em->flush();
            }
            return $this->redirectToRoute('affAbsempAdmin');
        }

        return $this->render('@SancAbs/Admin/Default/ajoutAbsemp.html.twig', array(
            'Absenceemploye' => $absenceemploye,
            'form' => $form->createView(),
        ));
    }
    public function affAbsempAdminAction()
    {
        $em=$this->getDoctrine()->getRepository(Absenceemploye::class)->findAll();
        return $this->render('@SancAbs/Admin/Default/affAbsemp.html.twig',array('Absenceemploye'=> $em));
    }
    public function affAbsempAction(Request $request)
    {
        $id=$this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM SancAbsBundle:Absenceemploye a WHERE a.employe=:id ");
        $query->setParameter('id',$id);
        $Absenceemploye = $query->getResult();
        return $this->render("@SancAbs/Front/Default/affAbsemp.html.twig",array(
            'Absenceemploye'=>$Absenceemploye,));
    }

    public function modifAbsempAdminAction(Request $request,$id)
    {
        $absenceemploye=$this->getDoctrine()->getRepository(Absenceemploye::class)->find($id);
        //  $deleteForm = $this->createDeleteForm($absence);
        $editForm = $this->createForm('SancAbsBundle\Form\AbsenceemployeType', $absenceemploye);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('affAbsempAdmin');
        }

        return $this->render('@SancAbs/Admin/Default/modifAbsemp.html.twig', array(
            'Absenceemploye' => $absenceemploye,
            'edit_form' => $editForm->createView(),
            // 'delete_form' => $deleteForm->createView(),
        ));
    }
    function suppAbsempAdminAction($id){
        $em=$this->getDoctrine()->getManager();
        $absenceemploye=$this->getDoctrine()->getRepository(Absenceemploye::class)
            ->find($id);
        $em->remove($absenceemploye);
        $em->flush();
        return $this->redirectToRoute('affAbsempAdmin');
    }

    public function affAbsEmpMobAction()
    {
        $Absenceemployes=$this->getDoctrine()->getManager()->getRepository(Absenceemploye::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Absenceemployes);
        return new JsonResponse($formatted);

    }


    public function findAbsEmpMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM SancAbsBundle:Absenceemploye a WHERE a.employe=:id ");
        $query->setParameter('id',$request->get('id'));
        $Absenceemployes = $query->getResult();        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Absenceemployes);
        return new JsonResponse($formatted);
    }

    public function ajoutAbsEmpMobAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $Absenceemploye = new Absenceemploye();
        $emp=$this->getDoctrine()->getRepository(Profilprof::class)->find($request->get('employe'));
        $Absenceemploye->setEmploye($emp);
        $Absenceemploye->setNbrheure($request->get('nbrheure'));
        $Absenceemploye->setDateabsence(new \DateTime('now'));
        $em->persist($Absenceemploye);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Absenceemploye);
        return new JsonResponse($formatted);
    }
    public function modifAbsEmpMobAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $Absenceemploye = $em->getRepository(Absenceemploye::class)->find($request->get('id'));
        $emp=$this->getDoctrine()->getRepository(Profilprof::class)->find($request->get('employe'));
        $Absenceemploye->setEmploye($emp);
        $Absenceemploye->setNbrheure($request->get('nbrheure'));
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($Absenceemploye) {
            return $Absenceemploye->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($Absenceemploye);
        return new JsonResponse($formatted);
    }

    function suppAbsEmpMobAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $absenceemploye=$this->getDoctrine()->getRepository(Absenceemploye::class)
            ->find($request->get('id'));
        $em->remove($absenceemploye);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($absenceemploye);
        return new JsonResponse($formatted);
    }


}
