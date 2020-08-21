<?php

namespace App\DataFixtures;

use App\Entity\Label;

class LabelFixtures extends BaseFixtures
{
    protected function loadData(){

       //Créer 10 label
       $this->createMany(10,'label', function(){
           return (new Label())
           ->setName($this->faker->lastName . 'Entertainment')
           
           ;
       });
    }
}
