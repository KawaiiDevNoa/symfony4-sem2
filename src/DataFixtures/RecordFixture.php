<?php

namespace App\DataFixtures;

use App\Entity\Record;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class RecordFixture extends BaseFixtures implements DependentFixtureInterface
{
    protected function loadData()
    {
        $this->createMany(100,'record', function () {
            return (new Record())
                ->setTitle($this->faker->catchPhrase)
                ->setDescription($this->faker->optional()->realText())
                ->setReleaseAt($this->faker->dateTimeBetween('-2 years'))
                ->setArtist($this->getRandomReference('artist'))
                
            ;
        });
    }

    public function getDependencies()
    {
        return[
            ArtistFixtures::class
        ];
    }
    

}