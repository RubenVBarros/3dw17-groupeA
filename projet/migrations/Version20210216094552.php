<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210216094552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sujet ADD auteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sujet ADD CONSTRAINT FK_2E13599D60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2E13599D60BB6FE6 ON sujet (auteur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sujet DROP FOREIGN KEY FK_2E13599D60BB6FE6');
        $this->addSql('DROP INDEX IDX_2E13599D60BB6FE6 ON sujet');
        $this->addSql('ALTER TABLE sujet DROP auteur_id');
    }
}
