<?php

namespace App\DataFixtures;

use App\Entity\Stagiaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;

class StagiaireFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i<50; $i++)
        {
            $stagiaire=  new Stagiaire();
            $stagiaire
                -> setLastname($faker->lastName)
                -> setFirstname($faker->firstName('male'|'female'))
                -> setSexe($faker->numberBetween(0,count(Stagiaire::SEXE)-1))
                -> setBorn($faker->dateTimeThisCentury($max = 'now'))
                -> setTown($faker->city)
                -> setEmail($faker->freeEmail)
                -> setPhone($faker->PhoneNumber('##########'));
            $manager->persist($stagiaire);
        }
        $manager->flush();
    }
}
