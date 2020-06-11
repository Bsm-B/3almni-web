<?php

namespace ProfilBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use ProfilBundle\Entity\Profiladmin;
use ProfilBundle\Entity\Profileleve;
use ProfilBundle\Entity\Profilparent;
use ProfilBundle\Entity\Profilprof;
use ProfilBundle\Form\ProfiladminType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProfiladminController extends Controller
{

    public function AjoutAdminAction(Request $request)
    {
        $admin= new Profiladmin();


        $form = $this->createForm(ProfiladminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();
            return $this->redirectToRoute('AffAdmin');
        }

        return $this->render('@Profil/Admin/Default/AjoutAdmin.html.twig', array(
            'Profiladmin' => $admin,
            'form' => $form->createView(),
        ));
    }

    public function AffAdminAction(Request $request)
    {
        $pieChart = new PieChart();
        $em= $this->getDoctrine();

        $Profiladmin = $em->getRepository(Profiladmin::class)->findAll();

        $Profileleve = $em->getRepository(Profileleve::class)->findAll();
        $Profilprof= $em->getRepository(Profilprof::class)->findAll();
        $Profilparent= $em->getRepository(Profilparent::class)->findAll();


        $total=count($Profiladmin)+count($Profileleve)+count($Profilprof)+count($Profilparent);

        $total1=count($Profileleve);
        $total2=count($Profilprof);
        $total3=count($Profilparent);
        $total4=count($Profiladmin);


        $data= array();
        $stat=['Les Profils', '%'];
        $nb=0;
        array_push($data,$stat);

        $stat=array();
        $nb1=($total1 *100)/$total;
        array_push($stat,'Profil Eleve',($total1));
        $stat=['Profil eleve',$nb1];
        array_push($data,$stat);

        $stat=array();
        $nb2=($total2 *100)/$total;
        array_push($stat,'Profil Prof',($total2));
        $stat=['Profil Prof',$nb2];
        array_push($data,$stat);

        $stat=array();
        $nb3=($total3 *100)/$total;
        array_push($stat,'Profil Parent',($total2));
        $stat=['Profil Parent',$nb3];
        array_push($data,$stat);

        $stat=array();
        $nb4=($total4 *100)/$total;
        array_push($stat,'Profil Admin',($total2));
        $stat=['Profil Admin',$nb4];
        array_push($data,$stat);


        $pieChart->getData()->setArrayToDataTable(
            $data
        );



        $pieChart->getOptions()->setTitle('Les Profils');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        $em=$this->getDoctrine()->getRepository(Profiladmin::class)->findAll();
        return $this->render('@Profil/Admin/Default/AffAdmin.html.twig',array('Profiladmin'=> $em,'piechart' => $pieChart));
    }

    public function ModifAdminAction(Request $request,$id)
    {
        $admin=$this->getDoctrine()->getRepository(Profiladmin::class)->find($id);
        //  $deleteForm = $this->createDeleteForm($absence);
        $editForm = $this->createForm('ProfilBundle\Form\ProfiladminType', $admin);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ModifAdmin', array('id' => $admin->getId()));
        }

        return $this->render('@Profil/Admin/Default/ModifAdmin.html.twig', array(
            'Profiladmin' => $admin,
            'edit_form' => $editForm->createView(),
            // 'delete_form' => $deleteForm->createView(),
        ));
    }
    function SuppAdminAction($id){
        $em=$this->getDoctrine()->getManager();
        $admin=$this->getDoctrine()->getRepository(Profiladmin::class)
            ->find($id);
        $em->remove($admin);
        $em->flush();
        return $this->redirectToRoute('AffAdmin');
    }
    public function findUserMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(" SELECT a FROM AlmniBundle:User a WHERE a.id=:id ");
        $query->setParameter('id',$request->get('id'));
        $user = $query->getResult();        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
}
