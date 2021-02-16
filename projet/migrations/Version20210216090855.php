<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210216090855 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC60BB6FE6');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC7C4D497E');
        $this->addSql('DROP INDEX IDX_67F068BC60BB6FE6 ON commentaire');
        $this->addSql('DROP INDEX IDX_67F068BC7C4D497E ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP sujet_id, DROP auteur_id');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F760BB6FE6');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F77C4D497E');
        $this->addSql('DROP INDEX IDX_A4D707F760BB6FE6 ON reaction');
        $this->addSql('DROP INDEX IDX_A4D707F77C4D497E ON reaction');
        $this->addSql('ALTER TABLE reaction DROP sujet_id, DROP auteur_id');
        $this->addSql('ALTER TABLE signalement DROP FOREIGN KEY FK_F4B5511460BB6FE6');
        $this->addSql('DROP INDEX IDX_F4B5511460BB6FE6 ON signalement');
        $this->addSql('ALTER TABLE signalement DROP auteur_id');
        $this->addSql('ALTER TABLE sujet DROP FOREIGN KEY FK_2E13599D60BB6FE6');
        $this->addSql('DROP INDEX IDX_2E13599D60BB6FE6 ON sujet');
        $this->addSql('ALTER TABLE sujet DROP auteur_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD sujet_id INT DEFAULT NULL, ADD auteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC7C4D497E FOREIGN KEY (sujet_id) REFERENCES sujet (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC60BB6FE6 ON commentaire (auteur_id)');
        $this->addSql('CREATE INDEX IDX_67F068BC7C4D497E ON commentaire (sujet_id)');
        $this->addSql('ALTER TABLE reaction ADD sujet_id INT DEFAULT NULL, ADD auteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F760BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F77C4D497E FOREIGN KEY (sujet_id) REFERENCES sujet (id)');
        $this->addSql('CREATE INDEX IDX_A4D707F760BB6FE6 ON reaction (auteur_id)');
        $this->addSql('CREATE INDEX IDX_A4D707F77C4D497E ON reaction (sujet_id)');
        $this->addSql('ALTER TABLE signalement ADD auteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B5511460BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F4B5511460BB6FE6 ON signalement (auteur_id)');
        $this->addSql('ALTER TABLE sujet ADD auteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sujet ADD CONSTRAINT FK_2E13599D60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2E13599D60BB6FE6 ON sujet (auteur_id)');
    }
}
