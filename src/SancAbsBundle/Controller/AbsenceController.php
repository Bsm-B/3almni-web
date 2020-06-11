<?php

namespace SancAbsBundle\Controller;

use ProfilBundle\Entity\Profileleve;
use SancAbsBundle\Entity\Absence;
use SancAbsBundle\Entity\Classe;
use SancAbsBundle\Entity\Matiere;
use SancAbsBundle\Form\AbsenceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class AbsenceController extends Controller
{
    public function AjoutAbsAdminAction(Request $request)
    {
        $absence= new absence();

        $absence->setDateabsence(new \DateTime('now'));

        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($absence);
            $em->flush();
            return $this->redirectToRoute('affAbsAdmin');
        }

        return $this->render('@SancAbs/Admin/Default/ajoutAbs.html.twig', array(
            'Absence' => $absence,
            'form' => $form->createView(),
        ));
    }

    public function AjoutAbsAction(Request $request)
    {
        $absence= new absence();

        $absence->setDateabsence(new \DateTime('now'));

        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($absence);
            $em->flush();
            return $this->redirectToRoute('affAbsprof');
        }

        return $this->render('@SancAbs/Front/Default/ajoutAbsProf.html.twig', array(
            'Absence' => $absence,
            'form' => $form->createView(),
        ));
    }

    public function affAbsAdminAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $Absence=$em->getRepository('SancAbsBundle:Absence')->findAll();
        $RAW_QUERY = 'SELECT COUNT(id) FROM absence';
        $RAW_QUERY2 = 'SELECT COUNT(id) FROM profileleve';
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
        $absence = $statement->fetchAll();
        $statement = $em->getConnection()->prepare($RAW_QUERY2);
        $statement->execute();
        $eleve = $statement->fetchAll();


        return $this->render('@SancAbs/Admin/Default/affAbs.html.twig', array(
            "Absence" =>$Absence,
            "absence" =>$absence,
            "eleve" =>$eleve
        ));
    }
    public function affAbsprofAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $Absence=$em->getRepository('SancAbsBundle:Absence')->findAll();

        return $this->render('@SancAbs/Front/Default/affAbsProf.html.twig', array(
            "Absence" =>$Absence,
        ));
    }

    public function affAbsAction(Request $request)
    {
        $id=$this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM SancAbsBundle:Absence a WHERE a.eleve=:id ");
        $query->setParameter('id',$id);
        $Absence = $query->getResult();
        return $this->render("@SancAbs/Front/Default/affAbs.html.twig",array(
            'Absence'=>$Absence,));
    }


    public function modifAbsAdminAction(Request $request,$id)
    {
        $absence=$this->getDoctrine()->getRepository(Absence::class)->find($id);
        $editForm = $this->createForm('SancAbsBundle\Form\AbsenceType', $absence);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('affAbsAdmin');
        }

        return $this->render('@SancAbs/Admin/Default/modifAbs.html.twig', array(
            'Absence' => $absence,
            'edit_form' => $editForm->createView(),
            // 'delete_form' => $deleteForm->createView(),
        ));
    }

    public function modifAbsAction(Request $request,$id)
    {
        $absence=$this->getDoctrine()->getRepository(Absence::class)->find($id);
        $editForm = $this->createForm('SancAbsBundle\Form\AbsenceType', $absence);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('affAbsprof');
        }

        return $this->render('@SancAbs/Front/Default/modifAbsProf.html.twig', array(
            'Absence' => $absence,
            'edit_form' => $editForm->createView(),
            // 'delete_form' => $deleteForm->createView(),
        ));
    }

    function suppAbsAdminAction($id){
        $em=$this->getDoctrine()->getManager();
        $absence=$this->getDoctrine()->getRepository(Absence::class)
            ->find($id);
        $em->remove($absence);
        $em->flush();
        return $this->redirectToRoute('affAbsAdmin');
    }
    function suppAbsProfAction($id){
        $em=$this->getDoctrine()->getManager();
        $absence=$this->getDoctrine()->getRepository(Absence::class)
            ->find($id);
        $em->remove($absence);
        $em->flush();
        return $this->redirectToRoute('affAbsprof');
    }

    public function affAbsMobAction()
    {
        $abs = $this->getDoctrine()->getManager()
            ->getRepository('SancAbsBundle:Absence')
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
    public function affClassesMobAction()
    {
        $classe = $this->getDoctrine()->getManager()
            ->getRepository('SancAbsBundle:Classe')
            ->findAll();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($classe) {
            return $classe->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($classe);
        return new JsonResponse($formatted);
    }
    public function affMatieresMobAction()
    {
        $matiere = $this->getDoctrine()->getManager()
            ->getRepository('SancAbsBundle:Matiere')
            ->findAll();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($matiere) {
            return $matiere->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($matiere);
        return new JsonResponse($formatted);
    }

    public function findClasseMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM SancAbsBundle:Classe a WHERE a.id=:id ");
        $query->setParameter('id',$request->get('id'));
        $Classe = $query->getResult();        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Classe);
        return new JsonResponse($formatted);
    }
    public function findClasseNomMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM SancAbsBundle:Classe a WHERE a.nom=:nom ");
        $query->setParameter('nom',$request->get('nom'));
        $Classe = $query->getResult();        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Classe);
        return new JsonResponse($formatted);
    }
    public function findMatiereMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM SancAbsBundle:Matiere a WHERE a.id=:id ");
        $query->setParameter('id',$request->get('id'));
        $Matiere = $query->getResult();        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Matiere);
        return new JsonResponse($formatted);
    }
    public function findMatiereNomMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM SancAbsBundle:Matiere a WHERE a.nom=:nom ");
        $query->setParameter('nom',$request->get('nom'));
        $Matiere = $query->getResult();        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Matiere);
        return new JsonResponse($formatted);
    }
    public function findAbsMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM SancAbsBundle:Absence a WHERE a.eleve=:id ");
        $query->setParameter('id',$request->get('id'));
        $Absence = $query->getResult();        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Absence);
        return new JsonResponse($formatted);
    }

    public function ajoutAbsMobAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $Absence = new Absence();
        $Eleve=$this->getDoctrine()->getRepository(Profileleve::class)->find($request->get('eleve'));
        $Absence->setEleve($Eleve);
        $Classe=$this->getDoctrine()->getRepository(Classe::class)->find($request->get('classe'));
        $Absence->setClasse($Classe);
        $Matiere=$this->getDoctrine()->getRepository(Matiere::class)->find($request->get('matiere'));
        $Absence->setMatiere($Matiere);
        $Absence->setDateabsence(new \DateTime('now'));
        $em->persist($Absence);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Absence);
        return new JsonResponse($formatted);
    }


    public function modifAbsMobAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $Absence = $em->getRepository(Absence::class)->find($request->get('id'));
        $Eleve=$this->getDoctrine()->getRepository(Profileleve::class)->find($request->get('eleve'));
        $Absence->setEleve($Eleve);
        $Classe=$this->getDoctrine()->getRepository(Classe::class)->find($request->get('classe'));
        $Absence->setClasse($Classe);
        $Matiere=$this->getDoctrine()->getRepository(Matiere::class)->find($request->get('matiere'));
        $Absence->setMatiere($Matiere);
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($Absence) {
            return $Absence->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($Absence);
        return new JsonResponse($formatted);
    }
    function suppAbsmobAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $absence=$this->getDoctrine()->getRepository(Absence::class)
            ->find($request->get('id'));
        $em->remove($absence);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($absence);
        return new JsonResponse($formatted);
    }

}
