<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191218123050 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE distribution_box_passant (id INT AUTO_INCREMENT NOT NULL, distribution_box_id INT NOT NULL, INDEX IDX_193ED1B7BCB0D735 (distribution_box_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiber_distribution_box_passant (distribution_box_passant_id INT NOT NULL, fiber_id INT NOT NULL, INDEX IDX_1B705829FF12C449 (distribution_box_passant_id), INDEX IDX_1B70582921505D3A (fiber_id), PRIMARY KEY(distribution_box_passant_id, fiber_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE distribution_box_passant ADD CONSTRAINT FK_193ED1B7BCB0D735 FOREIGN KEY (distribution_box_id) REFERENCES distribution_box (id)');
        $this->addSql('ALTER TABLE fiber_distribution_box_passant ADD CONSTRAINT FK_1B705829FF12C449 FOREIGN KEY (distribution_box_passant_id) REFERENCES distribution_box_passant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fiber_distribution_box_passant ADD CONSTRAINT FK_1B70582921505D3A FOREIGN KEY (fiber_id) REFERENCES fiber (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE distribution_box_port DROP FOREIGN KEY FK_907A722B21505D3A');
        $this->addSql('ALTER TABLE distribution_box_port ADD CONSTRAINT FK_907A722B21505D3A FOREIGN KEY (fiber_id) REFERENCES fiber (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fiber_distribution_box_passant DROP FOREIGN KEY FK_1B705829FF12C449');
        $this->addSql('DROP TABLE distribution_box_passant');
        $this->addSql('DROP TABLE fiber_distribution_box_passant');
        $this->addSql('ALTER TABLE distribution_box_port DROP FOREIGN KEY FK_907A722B21505D3A');
        $this->addSql('ALTER TABLE distribution_box_port ADD CONSTRAINT FK_907A722B21505D3A FOREIGN KEY (fiber_id) REFERENCES fiber (id)');
    }
}
