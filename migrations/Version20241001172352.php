<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241001172352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_detail ADD country_of_origin_of_goods_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE item_detail DROP country_of_origin_of_goods');
        $this->addSql('ALTER TABLE item_detail ADD CONSTRAINT FK_A8FF0A5C3BD51706 FOREIGN KEY (country_of_origin_of_goods_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A8FF0A5C3BD51706 ON item_detail (country_of_origin_of_goods_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE item_detail DROP CONSTRAINT FK_A8FF0A5C3BD51706');
        $this->addSql('DROP INDEX IDX_A8FF0A5C3BD51706');
        $this->addSql('ALTER TABLE item_detail ADD country_of_origin_of_goods VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE item_detail DROP country_of_origin_of_goods_id');
    }
}
