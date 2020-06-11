<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Evenement;
use EventBundle\Form\EvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class EvenementController extends Controller
{
    public function AjoutEventAdminAction(Request $request)
    {


        $evenement = new Evenement();
        $evenement->setNom($request->get('date'));
        $form = $this->createForm(EvenementType::class, $evenement);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject("Nouveau Evennement")
                ->setFrom('wajih.mejri@esprit.tn','Mejri Wajih')
                ->setTo('wajih.mejri@esprit.tn')
                ->setBody("Nouveau Evennement Ajouter");
            $this->get('mailer')->send($message);


            $em = $this->getDoctrine()->getManager();
            $file = $evenement->getImage();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            $pathfile = $this->container->getParameter('pathmedia');


            $file->move(

                $pathfile,
                $fileName
            );
            $evenement->setImage($fileName);

            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('affEventAdmin');

        }

        return $this->render('@Event/Admin/Default/ajoutEvent.html.twig', array(
            'Evenement' => $evenement,
            'form' => $form->createView(),
        ));

    }

    public function AffEventAdminAction()
    {
        $em=$this->getDoctrine()->getRepository(Evenement::class)->findAll();
        return $this->render('@Event/Admin/Default/affEvent.html.twig',array('Evenement'=> $em));
    }
    public function AffEventAction(Request $request)
    {
        $em=$this->getDoctrine()->getRepository(Evenement::class)->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $em = $paginator->paginate($em,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 4));

        return $this->render('@Event/Front/Default/affEvent.html.twig',array('Evenement'=> $em));
    }

    public function ModifEventAdminAction(Request $request,$id)
    {
        $evenement=$this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $picture = $evenement->getImage();
        $editForm = $this->createForm('EventBundle\Form\EvenementType', $evenement);
        $editForm->handleRequest($request);
        if ($editForm->isValid()&& !is_null($evenement->getImage())) {
            $em = $this->getDoctrine()->getManager();
            $file = $evenement->getImage();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            $pathfile = $this->container->getParameter('pathmedia');


            $file->move(

                $pathfile,
                $fileName
            );
            $evenement->setImage($fileName);
        }
        else{
            $evenement->setImage($picture);
        }
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modifEventAdmin', array('id' => $evenement->getId()));
        }

        return $this->render('@Event/Admin/Default/modifEvent.html.twig', array(
            'Evenement' => $evenement,
            'edit_form' => $editForm->createView(),
            // 'delete_form' => $deleteForm->createView(),
        ));
    }
    function SuppEventAdminAction($id){
        $em=$this->getDoctrine()->getManager();
        $evenement=$this->getDoctrine()->getRepository(Evenement::class)
            ->find($id);
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('affEventAdmin');
    }
    public function AjoutEventMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Evenement = new Evenement();
        $Evenement->setImage($request->get('image'));
        $Evenement->setNom($request->get('nom'));
        $Evenement->setDescription($request->get('description'));
        dump($request->get('dateEvent'));
        $rest=substr($request->get('dateEvent'), 0, 20);
        $rest1=substr($request->get('dateEvent'), 30, 34);
        $res=$rest.$rest1;
        try {
            $date = new \DateTime($res);
            $Evenement->setDate($date);
        } catch (\Exception $e) {

        }

        $Evenement->setLieu($request->get('lieu'));
        $Evenement->setOrganizateur($request->get('organizateur'));
        $Evenement->setRating($request->get('rating'));
        $em->persist($Evenement);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Evenement);
        return new JsonResponse($formatted);
    }
    public function affEvenMobAction()
    {
        $event = $this->getDoctrine()->getManager()
            ->getRepository('EventBundle:Evenement')
            ->findAll();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($event) {
            return $event->getId();
        });
        $encoders = [new JsonEncoder()];
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers,$encoders);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
    }

    public function modifEventMobAction(Request $request){
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
    function suppEventmobAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $evenement=$this->getDoctrine()->getRepository(Evenement::class)
            ->find($request->get('id'));
        $em->remove($evenement);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($evenement);
        return new JsonResponse($formatted);
    }
    public function rateAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository("UserBundle:User")->find($request->get('user'));
        $idu=$user->getId();
        $rate=$em->getRepository("UserBundle:Rating")->findOneBy(array('idu'=>$idu,'ide'=>$request->get('idevnt')));
        $asso = $em->getRepository("UserBundle:Evenement")->find($request->get('idevnt'));
        if(!empty($rate)){
            $rate->setIde($asso);
            $rate->setIdu($user);
            $rate->setValue($request->get('star'));
            $rate->setDescription($request->get('desc'));
            $em->persist($rate);
            $em->flush();
        } else {
            $rate = new Rating();
            $rate->setIde($asso);
            $rate->setIdu($user);
            $rate->setValue($request->get('star'));
            $rate->setDescription($request->get('desc'));
            $em->persist($rate);
            $em->flush();
        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rate);
        return new JsonResponse($formatted);
    }
}
