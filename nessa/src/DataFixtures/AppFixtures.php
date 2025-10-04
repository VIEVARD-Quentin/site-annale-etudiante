<?php

namespace App\DataFixtures;

use App\Entity\Annale;
use App\Entity\Formation;
use App\Entity\Matiere;
use App\Entity\Niveau;
use App\Entity\Type;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
// Créer les utilisateurs
        $user1 = new User();
        $user1->setNom('VIEVARD')
            ->setPrenom('Quentin')
            ->setEmail('quentin.vvd@gmail.com')
            ->setPassword($this->passwordHasher->hashPassword(new User(), 'test2025'))
            ->setRoles(['ROLE_ADMIN'])
            ->setUniversite('Université de La Rochelle')
            ->setFormation('Droit')
            ->setNiveau('Master')
            ->setPseudo('Lyght')
            ->setTelephone('0652065220');
        $manager->persist($user1);

        $user2 = new User();
        $user2->setNom('WEITHER')
            ->setPrenom('Matthias')
            ->setEmail('mathias@gmail.com')
            ->setPassword($this->passwordHasher->hashPassword(new User(), 'test2025'))
            ->setRoles(['ROLE_USER'])
            ->setUniversite('Université de La Rochelle')
            ->setFormation('IAE')
            ->setNiveau('Master')
            ->setPseudo('Matt')
            ->setTelephone('0652065220');
        $manager->persist($user2);

// Créer les formations
        $droit = new Formation();
        $droit->setNom('Droit');
        $manager->persist($droit);

        $iae = new Formation();
        $iae->setNom('IAE');
        $manager->persist($iae);

// Créer les niveaux
        $droitLicence = new Niveau();
        $droitLicence->setNom('Licence')
            ->setFormation($droit);
        $manager->persist($droitLicence);

        $droitMaster = new Niveau();
        $droitMaster->setNom('Master')
            ->setFormation($droit);
        $manager->persist($droitMaster);

        $iaeLicence = new Niveau();
        $iaeLicence->setNom('Licence')
            ->setFormation($iae);
        $manager->persist($iaeLicence);

        $iaeMaster = new Niveau();
        $iaeMaster->setNom('Master')
            ->setFormation($iae);
        $manager->persist($iaeMaster);

// Créer les matières pour Droit Licence
        $civil = new Matiere();
        $civil->setNom('Civil')
            ->setNiveau($droitLicence);
        $manager->persist($civil);

        $constitutionnel = new Matiere();
        $constitutionnel->setNom('Constitutionnel')
            ->setNiveau($droitLicence);
        $manager->persist($constitutionnel);

        $penal = new Matiere();
        $penal->setNom('Penal')
            ->setNiveau($droitLicence);
        $manager->persist($penal);

// Créer les matières pour Droit Master
        $affaires = new Matiere();
        $affaires->setNom('Affaires')
            ->setNiveau($droitMaster);
        $manager->persist($affaires);

        $international = new Matiere();
        $international->setNom('International')
            ->setNiveau($droitMaster);
        $manager->persist($international);

        $procedure = new Matiere();
        $procedure->setNom('Procedure')
            ->setNiveau($droitMaster);
        $manager->persist($procedure);

//Crée type pour DROIT Licence Civil
        $typeExamenCivil = new Type();
        $typeExamenCivil->setNom('Examen')->setMatiere($civil);
        $manager->persist($typeExamenCivil);

        $typeFicheRevisionCivil = new Type();
        $typeFicheRevisionCivil->setNom('Fiche_Revision')->setMatiere($civil);
        $manager->persist($typeFicheRevisionCivil);

        $typeTDCivil = new Type();
        $typeTDCivil->setNom('TD')->setMatiere($civil);
        $manager->persist($typeTDCivil);

//Crée type pour Droit Licence Constitutionnel
        $typeExamenConstit = new Type();
        $typeExamenConstit->setNom('Examen')->setMatiere($constitutionnel);
        $manager->persist($typeExamenConstit);

        $typeFicheRevisionConstit = new Type();
        $typeFicheRevisionConstit->setNom('Fiche_Revision')->setMatiere($constitutionnel);
        $manager->persist($typeFicheRevisionConstit);

        $typeTDConstit = new Type();
        $typeTDConstit->setNom('TD')->setMatiere($constitutionnel);
        $manager->persist($typeTDConstit);

//Crée type pour Droit Licence Penal
        $typeExamenPenal = new Type();
        $typeExamenPenal->setNom('Examen')->setMatiere($penal);
        $manager->persist($typeExamenPenal);

        $typeFicheRevisionPenal = new Type();
        $typeFicheRevisionPenal->setNom('Fiche_Revision')->setMatiere($penal);
        $manager->persist($typeFicheRevisionPenal);

        $typeTDPenal = new Type();
        $typeTDPenal->setNom('TD')->setMatiere($penal);
        $manager->persist($typeTDPenal);

//Crée type pour Droit Master Affaire
        $typeExamenAffaires = new Type();
        $typeExamenAffaires->setNom('Examen')->setMatiere($affaires);
        $manager->persist($typeExamenAffaires);

        $typeFicheRevisionAffaires = new Type();
        $typeFicheRevisionAffaires->setNom('Fiche_Revision')->setMatiere($affaires);
        $manager->persist($typeFicheRevisionAffaires);

        $typeTDAffaires = new Type();
        $typeTDAffaires->setNom('TD')->setMatiere($affaires);
        $manager->persist($typeTDAffaires);

//Crée type pour Droit Master International
        $typeExamenInternational = new Type();
        $typeExamenInternational->setNom('Examen')->setMatiere($international);
        $manager->persist($typeExamenInternational);

        $typeFicheRevisionInternational = new Type();
        $typeFicheRevisionInternational->setNom('Fiche_Revision')->setMatiere($international);
        $manager->persist($typeFicheRevisionInternational);

        $typeTDInternational = new Type();
        $typeTDInternational->setNom('TD')->setMatiere($international);
        $manager->persist($typeTDInternational);

//Crée type pour Droit Master Procedure
        $typeExamenProcedure = new Type();
        $typeExamenProcedure->setNom('Examen')->setMatiere($procedure);
        $manager->persist($typeExamenProcedure);

        $typeFicheRevisionProcedure = new Type();
        $typeFicheRevisionProcedure->setNom('Fiche_Revision')->setMatiere($procedure);
        $manager->persist($typeFicheRevisionProcedure);

        $typeTDProcedure = new Type();
        $typeTDProcedure->setNom('TD')->setMatiere($procedure);
        $manager->persist($typeTDProcedure);

// Créer les matières pour IAE Licence
        $biologieCellulaire = new Matiere();
        $biologieCellulaire->setNom('Biologie_Cellulaire')
            ->setNiveau($iaeLicence);
        $manager->persist($biologieCellulaire);

        $mathematiques = new Matiere();
        $mathematiques->setNom('Mathematiques')
            ->setNiveau($iaeLicence);
        $manager->persist($mathematiques);

        $physique = new Matiere();
        $physique->setNom('Physique')
            ->setNiveau($iaeLicence);
        $manager->persist($physique);

// Créer les matières pour IAE Master
        $physiologie = new Matiere();
        $physiologie->setNom('Physiologie')
            ->setNiveau($iaeMaster);
        $manager->persist($physiologie);

        $informatique = new Matiere();
        $informatique->setNom('Informatique')
            ->setNiveau($iaeMaster);
        $manager->persist($informatique);

        $chimie = new Matiere();
        $chimie->setNom('Chimie')
            ->setNiveau($iaeMaster);
        $manager->persist($chimie);

//Crée type pour IAE Licence BioCell
        $typeExamenBioCell = new Type();
        $typeExamenBioCell->setNom('Examen')->setMatiere($biologieCellulaire);
        $manager->persist($typeExamenBioCell);

        $typeFicheRevisionBioCell = new Type();
        $typeFicheRevisionBioCell->setNom('Fiche_Revision')->setMatiere($biologieCellulaire);
        $manager->persist($typeFicheRevisionBioCell);

        $typeTDBioCell = new Type();
        $typeTDBioCell->setNom('TD')->setMatiere($biologieCellulaire);
        $manager->persist($typeTDBioCell);

//Crée type pour IAE Licence Mathematiques
        $typeExamenMath = new Type();
        $typeExamenMath->setNom('Examen')->setMatiere($mathematiques);
        $manager->persist($typeExamenMath);

        $typeFicheRevisionMath = new Type();
        $typeFicheRevisionMath->setNom('Fiche_Revision')->setMatiere($mathematiques);
        $manager->persist($typeFicheRevisionMath);

        $typeTDMath= new Type();
        $typeTDMath->setNom('TD')->setMatiere($mathematiques);
        $manager->persist($typeTDMath);

//Crée type pour IAE Licence Physique
        $typeExamenPhysique = new Type();
        $typeExamenPhysique->setNom('Examen')->setMatiere($physique);
        $manager->persist($typeExamenPhysique);

        $typeFicheRevisionPhysique = new Type();
        $typeFicheRevisionPhysique->setNom('Fiche_Revision')->setMatiere($physique);
        $manager->persist($typeFicheRevisionPhysique);

        $typeTDPhysique= new Type();
        $typeTDPhysique->setNom('TD')->setMatiere($physique);
        $manager->persist($typeTDPhysique);

//Crée type pour IAE Master Chimie
        $typeExamenChimie = new Type();
        $typeExamenChimie->setNom('Examen')->setMatiere($chimie);
        $manager->persist($typeExamenChimie);

        $typeFicheRevisionChimie = new Type();
        $typeFicheRevisionChimie->setNom('Fiche_Revision')->setMatiere($chimie);
        $manager->persist($typeFicheRevisionChimie);

        $typeTDChimie= new Type();
        $typeTDChimie->setNom('TD')->setMatiere($chimie);
        $manager->persist($typeTDChimie);

//Crée type pour IAE Master Info
        $typeExamenInfo = new Type();
        $typeExamenInfo->setNom('Examen')->setMatiere($informatique);
        $manager->persist($typeExamenInfo);

        $typeFicheRevisionInfo = new Type();
        $typeFicheRevisionInfo->setNom('Fiche_Revision')->setMatiere($informatique);
        $manager->persist($typeFicheRevisionInfo);

        $typeTDInfo= new Type();
        $typeTDInfo->setNom('TD')->setMatiere($informatique);
        $manager->persist($typeTDInfo);

//Crée type pour IAE Master Physiologie
        $typeExamenPhysiologie = new Type();
        $typeExamenPhysiologie->setNom('Examen')->setMatiere($physiologie);
        $manager->persist($typeExamenPhysiologie);

        $typeFicheRevisionPhysiologie = new Type();
        $typeFicheRevisionPhysiologie->setNom('Fiche_Revision')->setMatiere($physiologie);
        $manager->persist($typeFicheRevisionPhysiologie);

        $typeTDPhysiologie= new Type();
        $typeTDPhysiologie->setNom('TD')->setMatiere($physiologie);
        $manager->persist($typeTDPhysiologie);


// Créer les annales manuellement pour chaque matière

        // Droit Licence - Civil - Examen
        $this->createAnnale($manager, $civil, $typeExamenCivil, 1, $user1);
        $this->createAnnale($manager, $civil, $typeExamenCivil, 2, $user1);
        $this->createAnnale($manager, $civil, $typeExamenCivil, 3, $user1);
        $this->createAnnale($manager, $civil, $typeExamenCivil, 4, $user1);
        // Droit Licence - Civil - Fiche Revision
        $this->createAnnale($manager, $civil, $typeFicheRevisionCivil, 1, $user1);
        $this->createAnnale($manager, $civil, $typeFicheRevisionCivil, 2, $user1);
        $this->createAnnale($manager, $civil, $typeFicheRevisionCivil, 3, $user1);
        $this->createAnnale($manager, $civil, $typeFicheRevisionCivil, 4, $user1);
        // Droit Licence - Civil - TD
        $this->createAnnale($manager, $civil, $typeTDCivil, 1, $user1);
        $this->createAnnale($manager, $civil, $typeTDCivil, 2, $user1);
        $this->createAnnale($manager, $civil, $typeTDCivil, 3, $user1);
        $this->createAnnale($manager, $civil, $typeTDCivil, 4, $user1);


        // Droit Licence - Constitutionnel - Examen
        $this->createAnnale($manager, $constitutionnel, $typeExamenConstit, 1, $user1);
        $this->createAnnale($manager, $constitutionnel, $typeExamenConstit, 2, $user1);
        $this->createAnnale($manager, $constitutionnel, $typeExamenConstit, 3, $user1);
        $this->createAnnale($manager, $constitutionnel, $typeExamenConstit, 4, $user1);
        // Droit Licence - Constitutionnel - Fiche Revision
        $this->createAnnale($manager, $constitutionnel, $typeFicheRevisionConstit, 1, $user1);
        $this->createAnnale($manager, $constitutionnel, $typeFicheRevisionConstit, 2, $user1);
        $this->createAnnale($manager, $constitutionnel, $typeFicheRevisionConstit, 3, $user1);
        $this->createAnnale($manager, $constitutionnel, $typeFicheRevisionConstit, 4, $user1);
        // Droit Licence - Constitutionnel - TD
        $this->createAnnale($manager, $constitutionnel, $typeTDConstit, 1, $user1);
        $this->createAnnale($manager, $constitutionnel, $typeTDConstit, 2, $user1);
        $this->createAnnale($manager, $constitutionnel, $typeTDConstit, 3, $user1);
        $this->createAnnale($manager, $constitutionnel, $typeTDConstit, 4, $user1);

        // Droit Licence - Penal - Examen
        $this->createAnnale($manager, $penal, $typeExamenPenal, 1, $user1);
        $this->createAnnale($manager, $penal, $typeExamenPenal, 2, $user1);
        $this->createAnnale($manager, $penal, $typeExamenPenal, 3, $user1);
        $this->createAnnale($manager, $penal, $typeExamenPenal, 4, $user1);
        // Droit Licence - Penal - Fiche Revision
        $this->createAnnale($manager, $penal, $typeFicheRevisionPenal, 1, $user1);
        $this->createAnnale($manager, $penal, $typeFicheRevisionPenal, 2, $user1);
        $this->createAnnale($manager, $penal, $typeFicheRevisionPenal, 3, $user1);
        $this->createAnnale($manager, $penal, $typeFicheRevisionPenal, 4, $user1);
        // Droit Licence - Penal - TD
        $this->createAnnale($manager, $penal, $typeTDPenal, 1, $user1);
        $this->createAnnale($manager, $penal, $typeTDPenal, 2, $user1);
        $this->createAnnale($manager, $penal, $typeTDPenal, 3, $user1);
        $this->createAnnale($manager, $penal, $typeTDPenal, 4, $user1);

        // Droit Master - Affaires - Examen
        $this->createAnnale($manager, $affaires, $typeExamenAffaires, 1, $user1);
        $this->createAnnale($manager, $affaires, $typeExamenAffaires, 2, $user1);
        $this->createAnnale($manager, $affaires, $typeExamenAffaires, 3, $user1);
        $this->createAnnale($manager, $affaires, $typeExamenAffaires, 4, $user1);
        // Droit Master - Affaires - Fiche Revision
        $this->createAnnale($manager, $affaires, $typeFicheRevisionAffaires, 1, $user1);
        $this->createAnnale($manager, $affaires, $typeFicheRevisionAffaires, 2, $user1);
        $this->createAnnale($manager, $affaires, $typeFicheRevisionAffaires, 3, $user1);
        $this->createAnnale($manager, $affaires, $typeFicheRevisionAffaires, 4, $user1);
        // Droit Master - Affaires - TD
        $this->createAnnale($manager, $affaires, $typeTDAffaires, 1, $user1);
        $this->createAnnale($manager, $affaires, $typeTDAffaires, 2, $user1);
        $this->createAnnale($manager, $affaires, $typeTDAffaires, 3, $user1);
        $this->createAnnale($manager, $affaires, $typeTDAffaires, 4, $user1);

        // Droit Master - International - Examen
        $this->createAnnale($manager, $international, $typeExamenInternational, 1, $user1);
        $this->createAnnale($manager, $international, $typeExamenInternational, 2, $user1);
        $this->createAnnale($manager, $international, $typeExamenInternational, 3, $user1);
        $this->createAnnale($manager, $international, $typeExamenInternational, 4, $user1);
        // Droit Master - International - Fiche Revision
        $this->createAnnale($manager, $international, $typeFicheRevisionInternational, 1, $user1);
        $this->createAnnale($manager, $international, $typeFicheRevisionInternational, 2, $user1);
        $this->createAnnale($manager, $international, $typeFicheRevisionInternational, 3, $user1);
        $this->createAnnale($manager, $international, $typeFicheRevisionInternational, 4, $user1);
        // Droit Master - International - TD
        $this->createAnnale($manager, $international, $typeTDInternational, 1, $user1);
        $this->createAnnale($manager, $international, $typeTDInternational, 2, $user1);
        $this->createAnnale($manager, $international, $typeTDInternational, 3, $user1);
        $this->createAnnale($manager, $international, $typeTDInternational, 4, $user1);

        // Droit Master - Procedure - Examen
        $this->createAnnale($manager, $procedure, $typeExamenProcedure, 1, $user1);
        $this->createAnnale($manager, $procedure, $typeExamenProcedure, 2, $user1);
        $this->createAnnale($manager, $procedure, $typeExamenProcedure, 3, $user1);
        $this->createAnnale($manager, $procedure, $typeExamenProcedure, 4, $user1);
        // Droit Master - Procedure - Fiche Revision
        $this->createAnnale($manager, $procedure, $typeFicheRevisionProcedure, 1, $user1);
        $this->createAnnale($manager, $procedure, $typeFicheRevisionProcedure, 2, $user1);
        $this->createAnnale($manager, $procedure, $typeFicheRevisionProcedure, 3, $user1);
        $this->createAnnale($manager, $procedure, $typeFicheRevisionProcedure, 4, $user1);
        // Droit Master - Procedure - TD
        $this->createAnnale($manager, $procedure, $typeTDProcedure, 1, $user1);
        $this->createAnnale($manager, $procedure, $typeTDProcedure, 2, $user1);
        $this->createAnnale($manager, $procedure, $typeTDProcedure, 3, $user1);
        $this->createAnnale($manager, $procedure, $typeTDProcedure, 4, $user1);

        // IAE Licence - Biologie Cellulaire - Examen
        $this->createAnnale($manager, $biologieCellulaire, $typeExamenBioCell, 1, $user1);
        $this->createAnnale($manager, $biologieCellulaire, $typeExamenBioCell, 2, $user1);
        $this->createAnnale($manager, $biologieCellulaire, $typeExamenBioCell, 3, $user1);
        $this->createAnnale($manager, $biologieCellulaire, $typeExamenBioCell, 4, $user1);
        // IAE Licence - Biologie Cellulaire - Fiche Revision
        $this->createAnnale($manager, $biologieCellulaire, $typeFicheRevisionBioCell, 1, $user1);
        $this->createAnnale($manager, $biologieCellulaire, $typeFicheRevisionBioCell, 2, $user1);
        $this->createAnnale($manager, $biologieCellulaire, $typeFicheRevisionBioCell, 3, $user1);
        $this->createAnnale($manager, $biologieCellulaire, $typeFicheRevisionBioCell, 4, $user1);
        // IAE Licence - Biologie Cellulaire - TD
        $this->createAnnale($manager, $biologieCellulaire, $typeTDBioCell, 1, $user1);
        $this->createAnnale($manager, $biologieCellulaire, $typeTDBioCell, 2, $user1);
        $this->createAnnale($manager, $biologieCellulaire, $typeTDBioCell, 3, $user1);
        $this->createAnnale($manager, $biologieCellulaire, $typeTDBioCell, 4, $user1);

        // IAE Licence - Mathematiques - Examen
        $this->createAnnale($manager, $mathematiques, $typeExamenMath, 1, $user1);
        $this->createAnnale($manager, $mathematiques, $typeExamenMath, 2, $user1);
        $this->createAnnale($manager, $mathematiques, $typeExamenMath, 3, $user1);
        $this->createAnnale($manager, $mathematiques, $typeExamenMath, 4, $user1);
        // IAE Licence - Mathematiques - Fiche Revision
        $this->createAnnale($manager, $mathematiques, $typeFicheRevisionMath, 1, $user1);
        $this->createAnnale($manager, $mathematiques, $typeFicheRevisionMath, 2, $user1);
        $this->createAnnale($manager, $mathematiques, $typeFicheRevisionMath, 3, $user1);
        $this->createAnnale($manager, $mathematiques, $typeFicheRevisionMath, 4, $user1);
        // IAE Licence - Mathematiques - TD
        $this->createAnnale($manager, $mathematiques, $typeTDMath, 1, $user1);
        $this->createAnnale($manager, $mathematiques, $typeTDMath, 2, $user1);
        $this->createAnnale($manager, $mathematiques, $typeTDMath, 3, $user1);
        $this->createAnnale($manager, $mathematiques, $typeTDMath, 4, $user1);

        // IAE Licence - Physique
        $this->createAnnale($manager, $physique, $typeExamenPhysique, 1, $user1);
        $this->createAnnale($manager, $physique, $typeExamenPhysique, 2, $user1);
        $this->createAnnale($manager, $physique, $typeExamenPhysique, 3, $user1);
        $this->createAnnale($manager, $physique, $typeExamenPhysique, 4, $user1);
        // IAE Licence - Physique - Fiche Revision
        $this->createAnnale($manager, $physique, $typeFicheRevisionPhysique, 1, $user1);
        $this->createAnnale($manager, $physique, $typeFicheRevisionPhysique, 2, $user1);
        $this->createAnnale($manager, $physique, $typeFicheRevisionPhysique, 3, $user1);
        $this->createAnnale($manager, $physique, $typeFicheRevisionPhysique, 4, $user1);
        // IAE Licence - Physique - TD
        $this->createAnnale($manager, $physique, $typeTDPhysique, 1, $user1);
        $this->createAnnale($manager, $physique, $typeTDPhysique, 2, $user1);
        $this->createAnnale($manager, $physique, $typeTDPhysique, 3, $user1);
        $this->createAnnale($manager, $physique, $typeTDPhysique, 4, $user1);

        // IAE Master - Physiologie - Examen
        $this->createAnnale($manager, $physiologie, $typeExamenPhysiologie, 1, $user1);
        $this->createAnnale($manager, $physiologie, $typeExamenPhysiologie, 2, $user1);
        $this->createAnnale($manager, $physiologie, $typeExamenPhysiologie, 3, $user1);
        $this->createAnnale($manager, $physiologie, $typeExamenPhysiologie, 4, $user1);
        // IAE Master - Physiologie - Fiche Revision
        $this->createAnnale($manager, $physiologie, $typeFicheRevisionPhysiologie, 1, $user1);
        $this->createAnnale($manager, $physiologie, $typeFicheRevisionPhysiologie, 2, $user1);
        $this->createAnnale($manager, $physiologie, $typeFicheRevisionPhysiologie, 3, $user1);
        $this->createAnnale($manager, $physiologie, $typeFicheRevisionPhysiologie, 4, $user1);
        // IAE Master - Physiologie - TD
        $this->createAnnale($manager, $physiologie, $typeTDPhysiologie, 1, $user1);
        $this->createAnnale($manager, $physiologie, $typeTDPhysiologie, 2, $user1);
        $this->createAnnale($manager, $physiologie, $typeTDPhysiologie, 3, $user1);
        $this->createAnnale($manager, $physiologie, $typeTDPhysiologie, 4, $user1);

        // IAE Master - Informatique - Examen
        $this->createAnnale($manager, $informatique, $typeExamenInfo, 1, $user1);
        $this->createAnnale($manager, $informatique, $typeExamenInfo, 2, $user1);
        $this->createAnnale($manager, $informatique, $typeExamenInfo, 3, $user1);
        $this->createAnnale($manager, $informatique, $typeExamenInfo, 4, $user1);
        // IAE Master - Informatique - Fiche Revision
        $this->createAnnale($manager, $informatique, $typeFicheRevisionInfo, 1, $user1);
        $this->createAnnale($manager, $informatique, $typeFicheRevisionInfo, 2, $user1);
        $this->createAnnale($manager, $informatique, $typeFicheRevisionInfo, 3, $user1);
        $this->createAnnale($manager, $informatique, $typeFicheRevisionInfo, 4, $user1);
        // IAE Master - Informatique - TD
        $this->createAnnale($manager, $informatique, $typeTDInfo, 1, $user1);
        $this->createAnnale($manager, $informatique, $typeTDInfo, 2, $user1);
        $this->createAnnale($manager, $informatique, $typeTDInfo, 3, $user1);
        $this->createAnnale($manager, $informatique, $typeTDInfo, 4, $user1);

        // IAE Master - Chimie - Examen
        $this->createAnnale($manager, $chimie, $typeExamenChimie, 1, $user1);
        $this->createAnnale($manager, $chimie, $typeExamenChimie, 2, $user1);
        $this->createAnnale($manager, $chimie, $typeExamenChimie, 3, $user1);
        $this->createAnnale($manager, $chimie, $typeExamenChimie, 4, $user1);
        // IAE Master - Chimie - Fiche Revision
        $this->createAnnale($manager, $chimie, $typeFicheRevisionChimie, 1, $user1);
        $this->createAnnale($manager, $chimie, $typeFicheRevisionChimie, 2, $user1);
        $this->createAnnale($manager, $chimie, $typeFicheRevisionChimie, 3, $user1);
        $this->createAnnale($manager, $chimie, $typeFicheRevisionChimie, 4, $user1);
        // IAE Master - Chimie - TD
        $this->createAnnale($manager, $chimie, $typeTDChimie, 1, $user1);
        $this->createAnnale($manager, $chimie, $typeTDChimie, 2, $user1);
        $this->createAnnale($manager, $chimie, $typeTDChimie, 3, $user1);
        $this->createAnnale($manager, $chimie, $typeTDChimie, 4, $user1);

        $manager->flush();

        /*
        // Créer les annales pour chaque combinaison
        $this->createAnnales($manager, $droitLicence, $civil, $user1);
        $this->createAnnales($manager, $droitLicence, $civil, $user1);
        $this->createAnnales($manager, $droitLicence, $constitutionnel, $user1);
        $this->createAnnales($manager, $droitLicence, $penal, $user1);

        $this->createAnnales($manager, $droitMaster, $affaires, $user1);
        $this->createAnnales($manager, $droitMaster, $international, $user1);
        $this->createAnnales($manager, $droitMaster, $procedure, $user1);

        $this->createAnnales($manager, $iaeLicence, $biologieCellulaire, $user1);
        $this->createAnnales($manager, $iaeLicence, $mathematiques, $user1);
        $this->createAnnales($manager, $iaeLicence, $physique, $user1);

        $this->createAnnales($manager, $iaeMaster, $physiologie, $user1);
        $this->createAnnales($manager, $iaeMaster, $informatique, $user1);
        $this->createAnnales($manager, $iaeMaster, $chimie, $user1);

        $manager->flush();
        */


    }

    private function createAnnale(ObjectManager $manager, Matiere $matiere, Type $type, int $index, User $auteur)
    {

        // Créer le chemin relatif à partir de 'public/fiche'
        $formation = $matiere->getNiveau()->getFormation()->getNom();
        $niveau = $matiere->getNiveau()->getNom();
        $matiereNom = $matiere->getNom();
        $typeNom = $type->getNom();

        $cheminFichier = "/fiche/{$formation}/{$niveau}/{$matiereNom}/{$typeNom}/Annale_{$typeNom}_{$matiereNom}_{$index}.pdf";


        $annale = new Annale();
        $annale->setNom($type->getNom() . "_" . $matiere->getNom()."_".$index)
            ->setStyle($typeNom)
            ->setCheminFichier($cheminFichier)
            ->setAnnee(2025)
            ->setDateUpload(new \DateTime())
            ->setAuteur($auteur)
            ->setType($type);

        $manager->persist($annale);
    }


    /*
    private function createAnnales(ObjectManager $manager, Niveau $niveau, Matiere $matiere, User $auteur)
    {
        // Vérification si la Matiere existe en base
        $existingMatiere = $manager->getRepository(Matiere::class)->findOneBy(['nom' => $matiere->getNom(), 'niveau' => $niveau]);

        if (!$existingMatiere) {
            // Si la Matiere n'existe pas, on la persiste et flush
            $matiere->setNiveau($niveau);  // Assure-toi que la matière est associée au niveau
            $manager->persist($matiere);
            $manager->flush();  // Ici on force l'enregistrement pour avoir un identifiant
            $existingMatiere = $matiere; // Maintenant on peut l'utiliser après flush
        } else {
            // Si la Matiere existe déjà, on l'utilise
            $matiere = $existingMatiere;
        }

        // Compter le nombre d'annales existantes pour cette matière
        $existingAnnales = $manager->getRepository(Annale::class)
            ->createQueryBuilder('a')
            ->where('a.matiere = :matiere')
            ->setParameter('matiere', $matiere)
            ->select('COUNT(a.id)')  // Compte le nombre d'annales existantes pour cette matière
            ->getQuery()
            ->getSingleScalarResult();  // Récupère un seul résultat (nombre)

        // Le numéro de l'annale sera celui après le dernier existant
        $nextAnnaleNumber = (int)$existingAnnales + 1;

        // Créer l'annale avec un nom dynamique basé sur le nombre d'annales existantes
        $annale = new Annale();
        $annale->setType('Annales')
            ->setNom($matiere->getNom() . '_' . $nextAnnaleNumber)  // Utilise le numéro calculé
            ->setCheminFichier("Public/Fiche/{$niveau->getFormation()->getNom()}/{$niveau->getNom()}/{$matiere->getNom()}/Annales_{$niveau->getFormation()->getNom()}_{$matiere->getNom()}_{$nextAnnaleNumber}.pdf")
            ->setAnnee(2023)
            ->setDateUpload(new \DateTime())
            ->setAuteur($auteur)
            ->setMatiere($matiere);

        // Persiste l'annale
        $manager->persist($annale);

        // Applique les changements en base de données
        $manager->flush();
    }
    */

}
