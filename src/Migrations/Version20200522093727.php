<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200522093727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE distribution_box_fusion (id INT AUTO_INCREMENT NOT NULL, distribution_box_id INT NOT NULL, signal_loss DOUBLE PRECISION NOT NULL, INDEX IDX_92506D28BCB0D735 (distribution_box_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE distribution_box_fusion_fiber (distribution_box_fusion_id INT NOT NULL, fiber_id INT NOT NULL, INDEX IDX_4E53E6C2EB2796E4 (distribution_box_fusion_id), INDEX IDX_4E53E6C221505D3A (fiber_id), PRIMARY KEY(distribution_box_fusion_id, fiber_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE distribution_box_fusion ADD CONSTRAINT FK_92506D28BCB0D735 FOREIGN KEY (distribution_box_id) REFERENCES distribution_box (id)');
        $this->addSql('ALTER TABLE distribution_box_fusion_fiber ADD CONSTRAINT FK_4E53E6C2EB2796E4 FOREIGN KEY (distribution_box_fusion_id) REFERENCES distribution_box_fusion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE distribution_box_fusion_fiber ADD CONSTRAINT FK_4E53E6C221505D3A FOREIGN KEY (fiber_id) REFERENCES fiber (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE distribution_box_fusion_fiber DROP FOREIGN KEY FK_4E53E6C2EB2796E4');
        $this->addSql('DROP TABLE distribution_box_fusion');
        $this->addSql('DROP TABLE distribution_box_fusion_fiber');
    }
}
