<?php

namespace App\Controller;

use App\Entity\Annale;
use App\Repository\MatiereRepository;
use App\Repository\NiveauRepository;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormationRepository;
use Symfony\Component\HttpFoundation\Request;


final class EditionController extends AbstractController
{
    #[Route('/edition', name: 'app_edition')]
    public function index(
        FormationRepository $formationRepository,
        NiveauRepository $niveauRepository,
        MatiereRepository $matiereRepository,
        TypeRepository $typeRepository
    ): Response {
        $formations = $formationRepository->findAll();

        $niveaux = $niveauRepository->findAll();
        $niveauxArray = array_map(function($niveau) {
            return [
                'id' => $niveau->getId(),
                'nom' => $niveau->getNom(),
                'formation' => [
                    'id' => $niveau->getFormation()->getId(),
                ],
            ];
        }, $niveaux);

        $matieres = $matiereRepository->findAll();
        $matieresArray = array_map(function($matiere) {
            return [
                'id' => $matiere->getId(),
                'nom' => $matiere->getNom(),
                'niveau' => [
                    'id' => $matiere->getNiveau()->getId(),
                ],
            ];
        }, $matieres);

        $types = $typeRepository->findAll();
        $typesArray = array_map(function($type) {
            return [
                'id' => $type->getId(),
                'nom' => $type->getNom(),
                'matiere' => [
                    'id' => $type->getMatiere()->getId(),
                ],
            ];
        }, $types);

        return $this->render('edition/edition.html.twig', [
            'formations' => $formations,
            'niveaux' => $niveauxArray,
            'matieres' => $matieresArray,
            'types' => $typesArray,
        ]);
    }

    #[Route('/upload', name: 'app_edition_upload', methods: ['POST'])]
    public function upload(
        Request $request,
        FormationRepository $formationRepository,
        NiveauRepository $niveauRepository,
        MatiereRepository $matiereRepository,
        TypeRepository $typeRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $formationId = $request->request->get('formation');
        $niveauId = $request->request->get('niveau');
        $matiereId = $request->request->get('matiere');
        $typeId = $request->request->get('type');
        $file = $request->files->get('pdfFile');

        if (!$formationId || !$niveauId || !$matiereId || !$typeId || !$file) {
            $this->addFlash('danger', 'Tous les champs sont obligatoires.');
            return $this->redirectToRoute('app_edition');
        }

        $formation = $formationRepository->find($formationId);
        $niveau = $niveauRepository->find($niveauId);
        $matiere = $matiereRepository->find($matiereId);
        $type = $typeRepository->find($typeId);

        if (!$formation || !$niveau || !$matiere || !$type) {
            $this->addFlash('danger', 'Données invalides.');
            return $this->redirectToRoute('app_edition');
        }

        // Ici tu utilises les noms pour créer le chemin
        $folderPath = 'fiche/' . $formation->getNom() . '/' . $niveau->getNom() . '/' . $matiere->getNom() . '/' . $type->getNom();
        $fullPath = $this->getParameter('kernel.project_dir') . '/public/' . $folderPath;

        $filesystem = new Filesystem();
        if (!$filesystem->exists($fullPath)) {
            $filesystem->mkdir($fullPath, 0775);
        }

        // Pour compter les fichiers existants
        $existingFiles = glob($fullPath . '/Annale_' . $type->getNom() . '_' . $matiere->getNom() . '_*.pdf');
        $count = count($existingFiles) + 1;

        $newFilename = 'Annale_' . $type->getNom() . '_' . $matiere->getNom() . '_' . $count . '.pdf';
        $newname = $type->getNom() . '_' . $matiere->getNom() . '_' . $count . '.pdf';

        try {
            $file->move($fullPath, $newFilename);

            $annale = new Annale();
            $annale->setNom($newname);
            $annale->setType($type);
            $annale->setStyle($type->getNom());
            $annale->setCheminFichier('/'.$folderPath . '/' . $newFilename);
            $annale->setAnnee((int)date('Y')); // par exemple l'année courante
            $annale->setDateUpload(new \DateTime());
            $annale->setAuteur($this->getUser());

            $entityManager->persist($annale);
            $entityManager->flush();
            $this->addFlash('success', 'Fichier uploadé avec succès sous le nom : ' . $newFilename);
        } catch (FileException $e) {
            $this->addFlash('danger', 'Erreur lors du téléchargement : ' . $e->getMessage());
            return $this->redirectToRoute('app_edition');
        }

        return $this->redirectToRoute('app_home');
    }

    private function slugify(string $text): string
    {
        return ucfirst(trim(preg_replace('/[^a-z0-9]+/i', '_', $text), '_'));
    }

}
