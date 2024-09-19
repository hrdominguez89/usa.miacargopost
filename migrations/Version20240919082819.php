<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240919082819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("TRUNCATE TABLE s10_code");
        $this->addSql('CREATE SEQUENCE category_document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE item_detail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category_document (id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE category_item (id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE item_detail (id INT NOT NULL, s10code_id INT NOT NULL, detailed_contents VARCHAR(255) NOT NULL, quantity INT NOT NULL, net_weight DOUBLE PRECISION NOT NULL, value DOUBLE PRECISION NOT NULL, hs_tarif_number VARCHAR(255) DEFAULT NULL, country_of_origin_of_goods VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A8FF0A5CF8C5F068 ON item_detail (s10code_id)');
        $this->addSql('ALTER TABLE item_detail ADD CONSTRAINT FK_A8FF0A5CF8C5F068 FOREIGN KEY (s10code_id) REFERENCES s10_code (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE s10_code ADD from_country_id INT NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD to_country_id INT NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD category_item_id INT NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD category_document_id INT NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD from_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD from_street VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD from_city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD from_postcode VARCHAR(25) NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD from_tel VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD from_email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD to_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD to_street VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD to_postcode VARCHAR(25) NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD to_city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD to_tel VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD to_email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD name_designated_operator VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD senders_customs_reference VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD importers_reference VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD importers_tel VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD declaration_identity VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD total_gross_weight DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD total_value DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD acceptance_inf_item_weight DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD acceptance_inf_postal_charges_fees DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD acceptance_inf_insurance DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD acceptance_inf_total DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD acceptance_inf_office VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE s10_code ADD acceptance_inf_date_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD delivery_information_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD delivery_information_person_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD delivery_information_signature VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD category_item_explanation VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD comments TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE s10_code ADD CONSTRAINT FK_A18157CFD28BF877 FOREIGN KEY (from_country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE s10_code ADD CONSTRAINT FK_A18157CFDE1CDC0D FOREIGN KEY (to_country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE s10_code ADD CONSTRAINT FK_A18157CFD5B71220 FOREIGN KEY (category_item_id) REFERENCES category_item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE s10_code ADD CONSTRAINT FK_A18157CF74A43A5C FOREIGN KEY (category_document_id) REFERENCES category_document (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A18157CFD28BF877 ON s10_code (from_country_id)');
        $this->addSql('CREATE INDEX IDX_A18157CFDE1CDC0D ON s10_code (to_country_id)');
        $this->addSql('CREATE INDEX IDX_A18157CFD5B71220 ON s10_code (category_item_id)');
        $this->addSql('CREATE INDEX IDX_A18157CF74A43A5C ON s10_code (category_document_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE s10_code DROP CONSTRAINT FK_A18157CF74A43A5C');
        $this->addSql('ALTER TABLE s10_code DROP CONSTRAINT FK_A18157CFD5B71220');
        $this->addSql('DROP SEQUENCE category_document_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE item_detail_id_seq CASCADE');
        $this->addSql('ALTER TABLE item_detail DROP CONSTRAINT FK_A8FF0A5CF8C5F068');
        $this->addSql('DROP TABLE category_document');
        $this->addSql('DROP TABLE category_item');
        $this->addSql('DROP TABLE item_detail');
        $this->addSql('ALTER TABLE s10_code DROP CONSTRAINT FK_A18157CFD28BF877');
        $this->addSql('ALTER TABLE s10_code DROP CONSTRAINT FK_A18157CFDE1CDC0D');
        $this->addSql('DROP INDEX IDX_A18157CFD28BF877');
        $this->addSql('DROP INDEX IDX_A18157CFDE1CDC0D');
        $this->addSql('DROP INDEX IDX_A18157CFD5B71220');
        $this->addSql('DROP INDEX IDX_A18157CF74A43A5C');
        $this->addSql('ALTER TABLE s10_code DROP from_country_id');
        $this->addSql('ALTER TABLE s10_code DROP to_country_id');
        $this->addSql('ALTER TABLE s10_code DROP category_item_id');
        $this->addSql('ALTER TABLE s10_code DROP category_document_id');
        $this->addSql('ALTER TABLE s10_code DROP from_name');
        $this->addSql('ALTER TABLE s10_code DROP from_street');
        $this->addSql('ALTER TABLE s10_code DROP from_city');
        $this->addSql('ALTER TABLE s10_code DROP from_postcode');
        $this->addSql('ALTER TABLE s10_code DROP from_tel');
        $this->addSql('ALTER TABLE s10_code DROP from_email');
        $this->addSql('ALTER TABLE s10_code DROP to_name');
        $this->addSql('ALTER TABLE s10_code DROP to_street');
        $this->addSql('ALTER TABLE s10_code DROP to_postcode');
        $this->addSql('ALTER TABLE s10_code DROP to_city');
        $this->addSql('ALTER TABLE s10_code DROP to_tel');
        $this->addSql('ALTER TABLE s10_code DROP to_email');
        $this->addSql('ALTER TABLE s10_code DROP created_at');
        $this->addSql('ALTER TABLE s10_code DROP name_designated_operator');
        $this->addSql('ALTER TABLE s10_code DROP senders_customs_reference');
        $this->addSql('ALTER TABLE s10_code DROP importers_reference');
        $this->addSql('ALTER TABLE s10_code DROP importers_tel');
        $this->addSql('ALTER TABLE s10_code DROP declaration_identity');
        $this->addSql('ALTER TABLE s10_code DROP total_gross_weight');
        $this->addSql('ALTER TABLE s10_code DROP total_value');
        $this->addSql('ALTER TABLE s10_code DROP acceptance_inf_item_weight');
        $this->addSql('ALTER TABLE s10_code DROP acceptance_inf_postal_charges_fees');
        $this->addSql('ALTER TABLE s10_code DROP acceptance_inf_insurance');
        $this->addSql('ALTER TABLE s10_code DROP acceptance_inf_total');
        $this->addSql('ALTER TABLE s10_code DROP acceptance_inf_office');
        $this->addSql('ALTER TABLE s10_code DROP acceptance_inf_date_time');
        $this->addSql('ALTER TABLE s10_code DROP delivery_information_date');
        $this->addSql('ALTER TABLE s10_code DROP delivery_information_person_name');
        $this->addSql('ALTER TABLE s10_code DROP delivery_information_signature');
        $this->addSql('ALTER TABLE s10_code DROP category_item_explanation');
        $this->addSql('ALTER TABLE s10_code DROP comments');
    }
}
