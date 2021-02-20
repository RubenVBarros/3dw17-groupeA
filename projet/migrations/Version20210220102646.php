<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210220102646 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE signalement ADD auteur_id INT DEFAULT NULL, ADD sujet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B5511460BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B551147C4D497E FOREIGN KEY (sujet_id) REFERENCES sujet (id)');
        $this->addSql('CREATE INDEX IDX_F4B5511460BB6FE6 ON signalement (auteur_id)');
        $this->addSql('CREATE INDEX IDX_F4B551147C4D497E ON signalement (sujet_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE signalement DROP FOREIGN KEY FK_F4B5511460BB6FE6');
        $this->addSql('ALTER TABLE signalement DROP FOREIGN KEY FK_F4B551147C4D497E');
        $this->addSql('DROP INDEX IDX_F4B5511460BB6FE6 ON signalement');
        $this->addSql('DROP INDEX IDX_F4B551147C4D497E ON signalement');
        $this->addSql('ALTER TABLE signalement DROP auteur_id, DROP sujet_id');
    }
}
