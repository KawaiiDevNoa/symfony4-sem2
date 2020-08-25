<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200825073005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // Etapes pour ajouter une colonne NOT NULL et unique
        // sur unee table avec des lignes deja existantes

        //1.ajouter la colonne en acceptant la valur Null
        $this->addSql('ALTER TABLE user ADD pseudo VARCHAR(30) DEFAULT NULL');
       
        // 2.def une valeur a la nouvelle col pour toutes les lignes
        // la valeur va se baser sur la clé primaire pour être unique
        $this->addSql('UPDATE user SET pseudo = CONCAT("user_",id)');

        //3.remettre la col en not null
        $this->addSql('ALTER TABLE user  MODIFY pseudo VARCHAR(30) NOT NULL');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64986CC499D ON user (pseudo)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D64986CC499D ON user');
        $this->addSql('ALTER TABLE user DROP pseudo');
    }
}
