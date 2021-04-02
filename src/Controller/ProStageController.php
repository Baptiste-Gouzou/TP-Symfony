<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EntrepriseType;
use App\Form\StageType;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage")
     */
    public function index(): Response
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
        $stages = $repositoryStage->findAll();
        return $this->render('pro_stage/index.html.twig',['stages'=>$stages]);
    }

    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function afficherEntreprises(): Response
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
        $stages = $repositoryStage->findAll();
        return $this->render('pro_stage/afficherEntreprises.html.twig',['stages'=>$stages]);
    }

    /**
     * @Route("/stageE/{nomEntreprise}", name="stagesParEntreprise")
     */
    public function afficherStagesParEntreprises($nomEntreprise): Response
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
        $stages = $repositoryStage->findByEntreprise($nomEntreprise);
        return $this->render('pro_stage/afficherStagesParEntreprises.html.twig',['stages'=>$stages]);
    }

    /**
     * @Route("/Formations", name="formations")
     */
    public function afficherFormations(): Response
    {
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);
        $formations = $repositoryFormation->findAll();
        return $this->render('pro_stage/afficherFormations.html.twig',['formations' => $formations]);
    }

    /**
     * @Route("/stageF/{nomFormation}", name="stagesParFormation")
     */
    public function afficherStagesParFormation($nomFormation): Response
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
        $stages = $repositoryStage->findByFormation($nomFormation);
        return $this->render('pro_stage/afficherStagesParFormation.html.twig',['stages'=>$stages]);
    }

    /**
     * @Route("/stage/{id}", name="descriptionStage")
     */
    public function afficherDescriptifStage($id): Response
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
        $stage = $repositoryStage->find($id);
        return $this->render('pro_stage/afficherDescriptifStage.html.twig',
      ['stage' => $stage]);
    }

    /**
     * @Route("/admin/entreprise/ajouter", name="ajouterEntreprise")
     */
    public function ajouterEntreprise(Request $requeteHttp, EntityManagerInterface $entityManager): Response
    {
    $entreprise = new Entreprise ();

    $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

    $formulaireEntreprise->handleRequest($requeteHttp);

    if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entreprise);
        $entityManager->flush();

        return $this->redirectToRoute('pro_stage');
    }

      return $this->render('pro_stage/ajouterModifierEntreprise.html.twig',['vueFormulaireEntreprise' => $formulaireEntreprise->createView(),
      'action' => "ajouter"]);
  }


  /**
   * @Route("/entreprise/modifier/{id}", name="modifierEntreprise")
   */
  public function modifierEntreprise(Request $requeteHttp, EntityManagerInterface $entityManager, Entreprise $entreprise): Response
  {
  $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

  $formulaireEntreprise->handleRequest($requeteHttp);

  if($formulaireEntreprise->isSubmitted())
  {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($entreprise);
      $entityManager->flush();

      return $this->redirectToRoute('pro_stage');
  }

    return $this->render('pro_stage/ajouterModifierEntreprise.html.twig',['vueFormulaireEntreprise' => $formulaireEntreprise->createView(),
    'action' => "modifier"]);
}


/**
 * @Route("/ajouterStage", name="ajouterStage")
 */
public function ajouterStage(Request $requeteHttp, EntityManagerInterface $entityManager): Response
{
$stage = new Stage();

$formulaireStage = $this->createForm(StageType::class, $stage);

$formulaireStage->handleRequest($requeteHttp);

if($formulaireStage->isSubmitted() && $formulaireStage->isValid())
{
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($stage);
    $entityManager->flush();

    return $this->redirectToRoute('pro_stage');
}

  return $this->render('pro_stage/ajouterModifierStage.html.twig',['vueFormulaireStage' => $formulaireStage->createView(),
  'action' => "ajouter"]);
}

}
