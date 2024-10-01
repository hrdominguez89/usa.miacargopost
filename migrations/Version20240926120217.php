<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240926120217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO category_item (id,name) values (1,'Regalo'),(2,'Documento'),(3,'Muestra comercial'),(4,'Mercaderia devuelta'),(5,'Venta de mercaderias'),(6,'Otro')");
        $this->addSql("INSERT INTO category_document (id,name) values (1,'Licencia'),(2,'Certificado'),(3,'Factura')");
        $this->addSql('CREATE SEQUENCE category_item_s10code_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category_item_s10code (id INT NOT NULL, s10code_id INT NOT NULL, category_item_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A9309304F8C5F068 ON category_item_s10code (s10code_id)');
        $this->addSql('CREATE INDEX IDX_A9309304D5B71220 ON category_item_s10code (category_item_id)');
        $this->addSql('ALTER TABLE category_item_s10code ADD CONSTRAINT FK_A9309304F8C5F068 FOREIGN KEY (s10code_id) REFERENCES s10_code (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_item_s10code ADD CONSTRAINT FK_A9309304D5B71220 FOREIGN KEY (category_item_id) REFERENCES category_item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE s10_code DROP CONSTRAINT fk_a18157cfd5b71220');
        $this->addSql('DROP INDEX idx_a18157cfd5b71220');
        $this->addSql('ALTER TABLE s10_code DROP category_item_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE category_item_s10code_id_seq CASCADE');
        $this->addSql('ALTER TABLE category_item_s10code DROP CONSTRAINT FK_A9309304F8C5F068');
        $this->addSql('ALTER TABLE category_item_s10code DROP CONSTRAINT FK_A9309304D5B71220');
        $this->addSql('DROP TABLE category_item_s10code');
        $this->addSql('ALTER TABLE s10_code ADD category_item_id INT NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD CONSTRAINT fk_a18157cfd5b71220 FOREIGN KEY (category_item_id) REFERENCES category_item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_a18157cfd5b71220 ON s10_code (category_item_id)');
    }
}
