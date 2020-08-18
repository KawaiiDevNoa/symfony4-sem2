<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Classe " modèle" pour les fixtures
 * On ne peut pas instancier une abstraction
 */

abstract class BaseFixtures extends Fixture{
    
    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var Generator
     */
    protected $faker;

    /**
     * Méthode à implémenter par des classes qui heritent
     * pour générer des fausses données
     */

     abstract protected function loadData();

     /**
      * Méthode appelée par le système de fixtures
      */

      public function load(ObjectManager $manager){

        // $on enregiste le ObjectManager
        $this->manager = $manager;
        //on instancie faker
        $this->faker = Factory::create('fr_FR');

        //on appelle loadData pour avoir les fausses données
        $this->loadData();
        //On exécute l'enregistrement en base
        $this->manager->flush();
      }

      /**
       * Enregistrer plusieurs entités
       * @param int $count           nombre d'entités
       * @param callable $factory    focntion qui génère  1 entité
       */
      protected function createMany(int $count, callable $factory){
          for ($i = 0; $i < $count; $i++){
              // on exécute $factory qui doit retouner l'entité générée
              $entity = $factory();

              // vrif que l'ntité ait été retournée
              if($entity === null){
                     throw new\LogicException('l\'entité doit être retournée, auriez-vous oublié un "return"');
              }
              
              //on prépare l'enregistrement de l'netité
              $this->manager->persist($entity);
          }

      }

}