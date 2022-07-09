<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Users;
use App\Entity\Cycles;
use App\Entity\Niveaux;
use App\Entity\Categories;
use App\Entity\Publications;
use App\Entity\Enseignements;
use App\Entity\Etablissements;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i < 2; $i++) {
            $etablissement = new Etablissements();
            $etablissement->setDesignation("Ecole Privée Mamadou TRAORE");
            $etablissement->setForme("Unipersonnel");
            $etablissement->setAdresse("Bacco Djicoroni");
            $etablissement->setNumDecisionCreation("1256/MEBALN");
            $etablissement->setNumDecisionOuverture("1256/MEBALN");
            $etablissement->setEmail("ecole.privee.mamadou.traore@gmail.com");
            $etablissement->setTelephone("76-16-69-91");

            $manager->persist($etablissement);
            $this->addReference("etablissement_" . $i, $etablissement);
        }
        for ($a = 1; $a <= 2; $a++) {
            $enseignement = new Enseignements();
            $etablissement = $this->getReference("etablissement_" . $faker->numberBetween(1, 1));
            $enseignement->setType("type" . $a);
            $enseignement->setEtablissement($etablissement);

            $manager->persist($enseignement);
            $this->addReference("enseignement_" . $a, $enseignement);
        }

        for ($b = 1; $b <= 3; $b++) {
            $cycle = new Cycles();
            $enseignement = $this->getReference("enseignement_" . $faker->numberBetween(1, 2));
            $cycle->setDesignation("Cycle" . $b);
            $cycle->setEnseignement($enseignement);

            $manager->persist($cycle);
            $this->addReference("cycle_" . $b, $cycle);
        }

        for ($c = 0; $c <= 9; $c++) {
            if ($c < 1) {
                $niveau = new Niveaux();
                $cycle = $this->getReference("cycle_" . $faker->numberBetween(1, 1));
                $niveau->setDesignation("Maternelle");
                $niveau->setCycle($cycle);
            } elseif ($c < 7) {
                $niveau = new Niveaux();
                $cycle = $this->getReference("cycle_" . $faker->numberBetween(2, 2));
                $niveau->setDesignation("Niveau" . $c);
                $niveau->setCycle($cycle);
            } else {
                $niveau = new Niveaux();
                $cycle = $this->getReference("cycle_" . $faker->numberBetween(3, 3));
                $niveau->setDesignation("Niveau" . $c);
                $niveau->setCycle($cycle);
            }

            $manager->persist($niveau);
            $this->addReference("niveau_" . $c, $niveau);
        }
        for ($i = 1; $i <= 10; $i++) {
            if ($i === 1) {
                $etablissement = $this->getReference('etablissement_' . $faker->numberBetween(1, 1));
                $user = new Users();
                $password = 'superadmin';
                $password = $this->encoder->hashPassword($user, 'password');
                $user->setIsActif($faker->numberBetween(1, 1));
                $user->setEmail($faker->email);
                $user->setEtablissement($etablissement);
                $user->setIsVerified($faker->numberBetween(1, 1));
                $user->setFullName("SIDIBE Pape Samba");
                $user->setPassword($password);
                $user->setTelephone("76 16 69 91");
                $user->setUsername('superadmin');
                $user->setRoles(["ROLE_SUPERADMIN"]);
            } elseif ($i === 2) {
                $etablissement = $this->getReference('etablissement_' . $faker->numberBetween(1, 1));
                $user = new Users();
                $password = 'azerty';
                $password = $this->encoder->hashPassword($user, 'password');
                $user->setIsActif($faker->numberBetween(1, 1));
                $user->setEmail($faker->email);
                $user->setEtablissement($etablissement);
                $user->setIsVerified($faker->numberBetween(0, 1));
                $user->setFullName("COULIBALY Jean dit M'Bampie");
                $user->setPassword($password);
                $user->setTelephone($faker->e164PhoneNumber);
                $user->setUsername('jean');
                $user->setRoles(["ROLE_ADMIN"]);
            } elseif ($i === 3) {
                $etablissement = $this->getReference('etablissement_' . $faker->numberBetween(1, 1));
                $user = new Users();
                $password = 'azerty';
                $password = $this->encoder->hashPassword($user, 'password');
                $user->setIsActif($faker->numberBetween(1, 1));
                $user->setEmail($faker->email);
                $user->setEtablissement($etablissement);
                $user->setIsVerified($faker->numberBetween(0, 1));
                $user->setFullName("SIDIBE Alassane");
                $user->setPassword($password);
                $user->setTelephone($faker->e164PhoneNumber);
                $user->setUsername('junior');
                $user->setRoles(["ROLE_ADMIN"]);
            } elseif ($i <= 5) {
                $etablissement = $this->getReference('etablissement_' . $faker->numberBetween(1, 1));
                $user = new Users();
                $password = 'azerty';
                $password = $this->encoder->hashPassword($user, 'password');
                $user->setIsActif($faker->numberBetween(0, 1));
                $user->setEmail($faker->email);
                $user->setEtablissement($etablissement);
                $user->setIsVerified($faker->numberBetween(0, 1));
                $user->setFullName($faker->lastName);
                $user->setPassword($password);
                $user->setTelephone($faker->e164PhoneNumber);
                $user->setUsername('educ' . $i);
                $user->setRoles(["ROLE_EDUCAT"]);
            } else {
                $etablissement = $this->getReference('etablissement_' . $faker->numberBetween(1, 1));
                $user = new Users();
                $password = 'azerty';
                $password = $this->encoder->hashPassword($user, 'password');
                $user->setIsActif($faker->numberBetween(0, 1));
                $user->setEmail($faker->email);
                $user->setEtablissement($etablissement);
                $user->setIsVerified($faker->numberBetween(0, 1));
                $user->setPassword($password);
                $user->setFullName($faker->lastName);
                $user->setTelephone($faker->e164PhoneNumber);
                $user->setUsername($faker->userName);
            }
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }
        for ($i = 1; $i <= 5; $i++) {
            if ($i === 1) {
                $niveau = $this->getReference('niveau_' . $faker->numberBetween(0, 0));
                $categorie = new Categories();
                $categorie->setNom("Français");
                $categorie->setDescription($faker->word(5));
                $categorie->setCouleur('#007FFF');
                $categorie->setNiveau($niveau);
            } elseif ($i === 2) {
                $niveau = $this->getReference('niveau_' . $faker->numberBetween(1, 3));
                $categorie = new Categories();
                $categorie->setNom("Histoire");
                $categorie->setDescription($faker->word(5));
                $categorie->setCouleur('#77B5FE');
                $categorie->setNiveau($niveau);
            } elseif ($i === 3) {
                $niveau = $this->getReference('niveau_' . $faker->numberBetween(4, 6));
                $categorie = new Categories();
                $categorie->setNom("Géographie");
                $categorie->setDescription($faker->word(5));
                $categorie->setCouleur('#FD6C9E');
                $categorie->setNiveau($niveau);
            } elseif ($i === 4) {
                $niveau = $this->getReference('niveau_' . $faker->numberBetween(7, 8));
                $categorie = new Categories();
                $categorie->setNom("Mathe");
                $categorie->setDescription($faker->word(5));
                $categorie->setCouleur('#BB0B0B');
                $categorie->setNiveau($niveau);
            } else {
                $niveau = $this->getReference('niveau_' . $faker->numberBetween(8, 9));
                $categorie = new Categories();
                $categorie->setNom("Connaissances Générale");
                $categorie->setDescription($faker->word(5));
                $categorie->setCouleur('#16B84E');
                $categorie->setNiveau($niveau);
            }
            $manager->persist($categorie);
            $this->addReference('categorie_' . $i, $categorie);
        }


        for ($i = 1; $i <= 30; $i++) {
            if ($i <= 6) {
                $user = $this->getReference('user_' . $faker->numberBetween(3, 5));
                $categorie = $this->getReference('categorie_' . $faker->numberBetween(1, 5));
                $niveau = $this->getReference('niveau_' . $faker->numberBetween(0, 0));
                $publication = new Publications();
                $publication->setIsActive($faker->randomElement([true, false]));
                $publication->setIsPublished($faker->randomElement([true, false]));
                $publication->setIsFavorit($faker->randomElement([true, false]));
                $publication->setCategorie($categorie);
                $publication->setContenu($faker->realText(750));
                $publication->setTitre($faker->realText(15));
                $publication->setUser($user);
            } elseif ($i <= 12) {
                $user = $this->getReference('user_' . $faker->numberBetween(3, 5));
                $categorie = $this->getReference('categorie_' . $faker->numberBetween(1, 5));
                $niveau = $this->getReference('niveau_' . $faker->numberBetween(1, 3));
                $publication = new Publications();
                $publication->setIsActive($faker->randomElement([true, false]));
                $publication->setIsPublished($faker->randomElement([true, false]));
                $publication->setIsFavorit($faker->randomElement([true, false]));
                $publication->setCategorie($categorie);
                $publication->setContenu($faker->realText(750));
                $publication->setTitre($faker->realText(15));
                $publication->setUser($user);
            } elseif ($i <= 18) {
                $user = $this->getReference('user_' . $faker->numberBetween(1, 5));
                $categorie = $this->getReference('categorie_' . $faker->numberBetween(1, 5));
                $niveau = $this->getReference('niveau_' . $faker->numberBetween(4, 6));
                $publication = new Publications();
                $publication->setIsActive($faker->randomElement([true, false]));
                $publication->setIsPublished($faker->randomElement([true, false]));
                $publication->setIsFavorit($faker->randomElement([true, false]));
                $publication->setCategorie($categorie);
                $publication->setContenu($faker->realText(750));
                $publication->setTitre($faker->realText(15));
                $publication->setUser($user);
            } elseif ($i <= 24) {
                $user = $this->getReference('user_' . $faker->numberBetween(1, 3));
                $categorie = $this->getReference('categorie_' . $faker->numberBetween(1, 5));
                $niveau = $this->getReference('niveau_' . $faker->numberBetween(7, 8));
                $publication = new Publications();
                $publication->setIsActive($faker->randomElement([true, false]));
                $publication->setIsPublished($faker->randomElement([true, false]));
                $publication->setIsFavorit($faker->randomElement([true, false]));
                $publication->setCategorie($categorie);
                $publication->setContenu($faker->realText(750));
                $publication->setTitre($faker->realText(15));
                $publication->setUser($user);
            } else {
                $user = $this->getReference('user_' . $faker->numberBetween(1, 2));
                $categorie = $this->getReference('categorie_' . $faker->numberBetween(1, 5));
                $niveau = $this->getReference('niveau_' . $faker->numberBetween(8, 9));
                $publication = new Publications();
                $publication->setIsActive($faker->randomElement([true, false]));
                $publication->setIsPublished($faker->randomElement([true, false]));
                $publication->setIsFavorit($faker->randomElement([true, false]));
                $publication->setCategorie($categorie);
                $publication->setContenu($faker->realText(750));
                $publication->setTitre($faker->realText(15));
                $publication->setUser($user);
            }
            $manager->persist($publication);
            $this->addReference('publications_' . $i, $publication);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
