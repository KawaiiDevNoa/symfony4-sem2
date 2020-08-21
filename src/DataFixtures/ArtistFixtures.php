<?php

namespace App\DataFixtures;

use App\Entity\Artist;


class ArtistFixtures extends BaseFixtures
{
     protected function loadData(){

        //Créer 50 artistes
        $this->createMany(50,'artist', function(){
            return (new Artist())
            ->setName($this->faker->name)
            ->setDescrisption($this->faker->optional()->realText())
            ;
        });
     }
}
