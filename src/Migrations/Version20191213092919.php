<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191213092919 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fiber_torpedo_passant (fiber_id INT NOT NULL, torpedo_passant_id INT NOT NULL, INDEX IDX_BA7947FB21505D3A (fiber_id), INDEX IDX_BA7947FBE36B5D99 (torpedo_passant_id), PRIMARY KEY(fiber_id, torpedo_passant_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fiber_torpedo_passant ADD CONSTRAINT FK_BA7947FB21505D3A FOREIGN KEY (fiber_id) REFERENCES fiber (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fiber_torpedo_passant ADD CONSTRAINT FK_BA7947FBE36B5D99 FOREIGN KEY (torpedo_passant_id) REFERENCES torpedo_passant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE torpedo_passant ADD torpedo_id INT NOT NULL');
        $this->addSql('ALTER TABLE torpedo_passant ADD CONSTRAINT FK_843035015321F134 FOREIGN KEY (torpedo_id) REFERENCES torpedo (id)');
        $this->addSql('CREATE INDEX IDX_843035015321F134 ON torpedo_passant (torpedo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE fiber_torpedo_passant');
        $this->addSql('ALTER TABLE torpedo_passant DROP FOREIGN KEY FK_843035015321F134');
        $this->addSql('DROP INDEX IDX_843035015321F134 ON torpedo_passant');
        $this->addSql('ALTER TABLE torpedo_passant DROP torpedo_id');
    }
}
