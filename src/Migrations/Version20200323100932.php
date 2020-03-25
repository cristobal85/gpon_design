<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200323100932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE map (id INT AUTO_INCREMENT NOT NULL, cpd_id INT NOT NULL, name VARCHAR(255) NOT NULL, display_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, min_zoom INT NOT NULL, max_zoom INT NOT NULL, UNIQUE INDEX UNIQ_93ADAABBEB3440EE (cpd_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE map ADD CONSTRAINT FK_93ADAABBEB3440EE FOREIGN KEY (cpd_id) REFERENCES cpd (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE map');
    }
}
