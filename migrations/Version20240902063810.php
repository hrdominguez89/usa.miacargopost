<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240902063810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE s10_code_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE s10_code (id INT NOT NULL, postal_service_range_id INT NOT NULL, country_id INT NOT NULL, service_code VARCHAR(2) NOT NULL, numbercode BIGINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A18157CFCCCCF218 ON s10_code (postal_service_range_id)');
        $this->addSql('CREATE INDEX IDX_A18157CFF92F3E70 ON s10_code (country_id)');
        $this->addSql('ALTER TABLE s10_code ADD CONSTRAINT FK_A18157CFCCCCF218 FOREIGN KEY (postal_service_range_id) REFERENCES postal_service_range (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE s10_code ADD CONSTRAINT FK_A18157CFF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE s10_code_id_seq CASCADE');
        $this->addSql('ALTER TABLE s10_code DROP CONSTRAINT FK_A18157CFCCCCF218');
        $this->addSql('ALTER TABLE s10_code DROP CONSTRAINT FK_A18157CFF92F3E70');
        $this->addSql('DROP TABLE s10_code');
    }
}
