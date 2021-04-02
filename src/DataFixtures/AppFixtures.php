<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //création de deux users
        $Lagouz = new User();
        $Lagouz->setNom("baptiste");
        $Lagouz->setPrenom("Gouzou");
        $Lagouz->setEmail("baptgouz64@gmail.com");
        $Lagouz->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $Lagouz->setPassword('$2y$10$OLEufZjWc6d3v5Fx1ORRN.iBSHOfQ7y2ucZqCvFblW/2/J5Cbsx1K');
        $manager->persist($Lagouz);

        $LaBarb = new User();
        $LaBarb->setNom("La");
        $LaBarb->setPrenom("Barb");
        $LaBarb->setEmail("labarbe3348@gmail.com");
        $LaBarb->setRoles(['ROLE_USER']);
        $LaBarb->setPassword('$2y$10$nx9vxYnnfSZF3DkgnEpQ..5A6EiFh2qukAbvVencfyJPffDcG20OG');
        $manager->persist($LaBarb);

        //creation d'un generateur de donnée
        $faker = \Faker\Factory::create('fr_FR'); // create a French faker


            //création des getEntreprises
            $entreprise1 = new Entreprise();
            $entreprise1->setNom($faker->company());
            $entreprise1->setActivite($faker->realText($maxNbChars = 25, $indexSize = 2));
            $entreprise1->setAdresse($faker->address());
            $entreprise1->setSite($faker->url());

            $entreprise2 = new Entreprise();
            $entreprise2->setNom($faker->company());
            $entreprise2->setActivite($faker->realText($maxNbChars = 25, $indexSize = 2));
            $entreprise2->setAdresse($faker->address());
            $entreprise2->setSite($faker->url());

            $entreprise3 = new Entreprise();
            $entreprise3->setNom($faker->company());
            $entreprise3->setActivite($faker->realText($maxNbChars = 25, $indexSize = 2));
            $entreprise3->setAdresse($faker->address());
            $entreprise3->setSite($faker->url());

            $entreprise4 = new Entreprise();
            $entreprise4->setNom($faker->company());
            $entreprise4->setActivite($faker->realText($maxNbChars = 25, $indexSize = 2));
            $entreprise4->setAdresse($faker->address());
            $entreprise4->setSite($faker->url());



            // Enregistrement du module créé
            /* On regroupe les objets "types de stages" dans un tableau
            pour pouvoir s'y référer au moment de la création d'une ressource particulière */
            $tableauEntreprise = array($entreprise1,$entreprise2,$entreprise3,$entreprise3);

            // Mise en persistance des objets typeRessource
            foreach ($tableauEntreprise as $entreprise) {
                $manager->persist($entreprise);
            }


            $formations = array(
                     "1" => "DUT informatique",
                     "2" => "LP multimédia",
                     "3" => "LP programmation avancée"
                   );

            foreach ($formations as $codeFormation => $nomFormation) {

            //creation des formations
            $formation = new Formation();
            $formation -> setNom($nomFormation);
            $formation -> setDescription($faker->realText($maxNbChars = 150, $indexSize = 2));

            $manager->persist($formation);

            $nbStageAGenerer = $faker->numberBetween($min = 0, $max = 7);
            for ($numStage=0; $numStage < $nbStageAGenerer; $numStage++) {
            // Création d'un nouveau stage
            $stage = new Stage();
            // Génération d'un intitulé de stage
            $stage->setIntitule($faker->realText($maxNbChars = 20, $indexSize = 2));
            // Définition du'une mission
            $stage->setMission($faker->realText($maxNbChars = 300, $indexSize = 2));
            // Définition d'une adresse mail
            $stage->setAdresseMail($faker->email());

            $stage->addFormation($formation);


            $numEntreprise = $faker->numberBetween($min = 0, $max = 3);

            $stage -> setEntreprises($tableauEntreprise[$numEntreprise]);

            $tableauEntreprise[$numEntreprise] -> addStage($stage);

            // Persister les objets modifiés
            $manager->persist($stage);
            $manager->persist($tableauEntreprise[$numEntreprise]);

        }
        }

        // Envoyer en BD tous les objets persistés
        $manager->flush();
    }
}
