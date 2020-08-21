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
     * @var array liste des références connues 
     */
    private $reference =[];

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
       * @param string $groupName nom du groupe de références
       * @param callable $factory    focntion qui génère  1 entité
       */
      protected function createMany(int $count, string $groupName,callable $factory){
          for ($i = 0; $i < $count; $i++){
              // on exécute $factory qui doit retouner l'entité générée
              $entity = $factory();

              // vrif que l'ntité ait été retournée
              if($entity === null){
                     throw new\LogicException('l\'entité doit être retournée, auriez-vous oublié un "return"');
              }
              
              //on prépare l'enregistrement de l'netité
              $this->manager->persist($entity);

              // on enregistre une référence a l'entité
              $reference = sprintf('%s_%d',$groupName,$i);
              $this->addReference($reference,$entity);
          }

      }
    /**
     * Récup  d'une entité par son groupe de référence
     * @param string $groupName nom de groupe de références
     */

     protected function getRandomReference(string $groupName)
     {
         //verif si on a déja enregisté les references du groupe demandé
         if(!isset($this->references[$groupName])){
             //si non, on va rechercher les références
             $this->references[$groupName] = [];

             //on parcourt la liste de ttes les réferences (toutes classes confondues)
             foreach($this->referenceRepository->getReferences() as $key => $ref){
                 //la clé $key correspond  à nos références 
                 // si $key commnce par $groupName, on le sauvegarge

                 if(strpos($key,$groupName)===0){
                     $this->references[$groupName][]=$key;
                 }
             }
         }

         //verif que l'on a récupéré des références
         if($this->references[$groupName]===[]){
             throw new \Exception(sprintf('Aucune référence trouvée pour le groupe "%s"',$groupName));
         }

         //retourner une entité correspondant  à une réf aléatoire
         $randomReference =$this->faker->randomElement($this->references[$groupName]);
         return $this->getReference($randomReference);
     }
}