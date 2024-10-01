<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241001164953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE s10_code DROP CONSTRAINT fk_a18157cff92f3e70');
        $this->addSql('DROP INDEX idx_a18157cff92f3e70');
        $this->addSql('ALTER TABLE s10_code DROP country_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE s10_code ADD country_id INT NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD CONSTRAINT fk_a18157cff92f3e70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_a18157cff92f3e70 ON s10_code (country_id)');
    }
}
