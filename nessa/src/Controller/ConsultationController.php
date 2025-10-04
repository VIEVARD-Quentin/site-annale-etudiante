<?php

namespace App\Controller;

use App\Entity\Annale;
use App\Entity\Formation;
use App\Entity\Matiere;
use App\Entity\Niveau;
use App\Repository\AnnaleRepository;
use App\Repository\FormationRepository;
use App\Repository\MatiereRepository;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ConsultationController extends AbstractController
{
    // Route pour afficher la liste des formations
    #[Route('/consultation', name: 'app_consult_formation')]
    public function formations(EntityManagerInterface $entityManager)
    {
        // Récupérer toutes les formations
        $formations = $entityManager->getRepository(Formation::class)->findAll();

        return $this->render('consultation/formations.html.twig', [
            'formations' => $formations,
        ]);
    }

    // Route pour afficher les niveaux d'une formation
    #[Route('/consultation/formation/{id}', name: 'app_consult_niveau')]
    public function niveaux(Formation $formation, EntityManagerInterface $entityManager)
    {
        // Récupérer les niveaux de cette formation
        $niveaux = $entityManager->getRepository(Niveau::class)->findBy(['formation' => $formation]);

        return $this->render('consultation/niveaux.html.twig', [
            'formation' => $formation,
            'niveaux' => $niveaux,
        ]);
    }

    // Route pour afficher les matières d'un niveau
    #[Route('/consultation/niveau/{id}', name: 'app_consult_matiere')]
    public function matieres(Niveau $niveau, EntityManagerInterface $entityManager)
    {
        // Récupérer les matières de ce niveau
        $matieres = $entityManager->getRepository(Matiere::class)->findBy(['niveau' => $niveau]);

        return $this->render('consultation/matieres.html.twig', [
            'niveau' => $niveau,
            'matieres' => $matieres,
        ]);
    }

    // Route pour afficher les types d'une matière
    #[Route('/consultation/matiere/{id}/types', name: 'app_consult_matiere_types')]
    public function types(Matiere $matiere, EntityManagerInterface $entityManager): Response
    {
        $types = $entityManager->getRepository(\App\Entity\Type::class)->findBy(['matiere' => $matiere]);

        return $this->render('consultation/types.html.twig', [
            'matiere' => $matiere,
            'types' => $types,
        ]);
    }


    // Route pour afficher les annales d'un type
    #[Route('/consultation/type/{id}/annales', name: 'app_consult_type_annales')]
    public function annalesFromType(
        \App\Entity\Type $type,
        AnnaleRepository $annaleRepository
    ): Response {
        $matiere = $type->getMatiere();
        $niveau = $matiere->getNiveau();
        $formation = $niveau->getFormation();

        $baseDir = $this->getParameter('kernel.project_dir') . '/public/fiche';
        $folderPath = $baseDir . '/' . $formation->getNom() . '/' . $niveau->getNom() . '/' . $matiere->getNom() . '/' . $type->getNom();

        $annales = [];
        if (is_dir($folderPath)) {
            foreach (scandir($folderPath) as $file) {
                if ($file !== '.' && $file !== '..') {
                    $relativePath = '/fiche/' . $formation->getNom() . '/' . $niveau->getNom() . '/' . $matiere->getNom() . '/' . $type->getNom() . '/' . $file;

                    $annale = $annaleRepository->findOneBy(['cheminFichier' => $relativePath]);

                    if($annale){
                        $annales[] = $annale;
                    }
                }
            }
        }

        return $this->render('consultation/annales.html.twig', [
            'formation' => $formation,
            'niveau' => $niveau,
            'matiere' => $matiere,
            'type' => $type,
            'annales' => $annales,
        ]);
    }


    // Route pour afficher une annale spécifique
    #[Route('/consultation/annale/{id}', name: 'app_consult_annale')]
    public function showAnnale(Annale $annale): Response
    {

        $type = $annale->getType();

        return $this->render('consultation/show_annale.html.twig', [
            'annale' => $annale,
            'type' => $type,
        ]);
    }

}
