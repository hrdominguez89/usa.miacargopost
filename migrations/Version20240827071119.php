<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240827071119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE postal_product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE postal_service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE postal_service_range_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE postal_product (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE postal_service (id INT NOT NULL, postal_product_id INT NOT NULL, name VARCHAR(255) NOT NULL, requires_bilateral_agreement BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7BFD0EA44D675C64 ON postal_service (postal_product_id)');
        $this->addSql('CREATE TABLE postal_service_range (id INT NOT NULL, postal_service_id INT NOT NULL, principal_character VARCHAR(1) NOT NULL, second_character_from VARCHAR(1) NOT NULL, second_character_to VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8AA1287E5BF93D8 ON postal_service_range (postal_service_id)');
        $this->addSql('ALTER TABLE postal_service ADD CONSTRAINT FK_7BFD0EA44D675C64 FOREIGN KEY (postal_product_id) REFERENCES postal_product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE postal_service_range ADD CONSTRAINT FK_8AA1287E5BF93D8 FOREIGN KEY (postal_service_id) REFERENCES postal_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql("INSERT INTO postal_product (id,name) VALUES (1,'Unassigned'),(2,'Reserved'),(3,'EMS (Express Mail Service)'),(4,'Letter Post'),(5,'Parcel Post'),(6,'Domestic/bilateral/multilateral use only')");
        $this->addSql("INSERT INTO postal_service (id,postal_product_id,name,requires_bilateral_agreement) values
            (1,3,'EMS (Express Mail Service)',FALSE),
            (2,3,'EMS requires bilateral agreement (Express Mail Service)',TRUE),
            (3,4,'Letter post tracked',FALSE),
            (4,4,'Letter post tracked requires bilateral agreement',TRUE),
            (5,4,'M bags',FALSE),
            (6,4,'IBRS (International Business Reply Service)',FALSE),
            (7,4,'Letter post registered',FALSE),
            (8,4,'Letter post registered requires bilateral agreement',TRUE),
            (9,4,'Letter post insured',FALSE),
            (10,4,'Letter post insured requires bilateral agreement',TRUE),
            (11,4,'Letter-post items containing goods other than tracked, M bags, IBRS, registered, insured',FALSE),
            (12,4,'Letter-post items containing goods other than tracked, M bags, IBRS, registered, insured requires bilateral agreement',TRUE),
            (13,5,'Parcel post',FALSE),
            (14,5,'Parcel post requires bilateral agreement',TRUE),
            (15,5,'Parcel post (preferrably for insured parcels)',FALSE),
            (16,5,'ECOMPRO parcels',FALSE),
            (17,5,'ECOMPRO parcels requires multilateral agreement',TRUE),
            (18,5,'ECOMPRO parcels requires bilateral agreement',TRUE),
            (19,6,'domestic, bilateral, multilateral use only identify RFID-tracked items',FALSE),
            (20,6,'domestic, domestic, bilateral, multilateral use only',TRUE),
            (21,1,'Unassigned',FALSE),
            (22,2,'Reserved',FALSE)
        ");
        $this->addSql("INSERT INTO postal_service_range (id,postal_service_id,principal_character,second_character_from,second_character_to) VALUES 
            (1,1,'E','A','W'),
            (2,2,'E','X','Z'),
            (3,3,'L','A','Y'),
            (4,4,'L','Z','Z'),
            (5,5,'M','A','Z'),
            (6,6,'Q','A','M'),
            (7,21,'Q','N','Z'),
            (8,7,'R','A','Y'),
            (9,8,'R','Z','Z'),
            (10,9,'V','A','Y'),
            (11,10,'V','Z','Z'),
            (12,11,'U','A','Y'),
            (13,12,'U','Z','Z'),
            (14,13,'C','A','U'),
            (15,15,'C','V','V'),
            (16,13,'C','W','Y'),
            (17,14,'C','Z','Z'),
            (18,16,'H','A','W'),
            (19,17,'H','X','Y'),
            (20,18,'H','Z','Z'),
            (21,19,'A','A','Z'),
            (22,20,'B','A','Z'),
            (23,20,'D','A','Z'),
            (24,20,'G','A','A'),
            (25,21,'G','B','C'),
            (26,20,'G','D','D'),
            (27,21,'G','E','Z'),
            (28,20,'N','A','Z'),
            (29,20,'P','A','Z'),
            (30,20,'Z','A','Z'),
            (31,22,'J','A','Z'),
            (32,22,'K','A','Z'),
            (33,22,'S','A','Z'),
            (34,22,'T','A','Z'),
            (35,22,'W','A','Z'),
            (36,21,'F','A','Z'),
            (37,21,'I','A','Z'),
            (38,21,'O','A','Z'),
            (39,21,'X','A','Z'),
            (40,21,'Y','A','Z')
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE postal_product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE postal_service_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE postal_service_range_id_seq CASCADE');
        $this->addSql('ALTER TABLE postal_service DROP CONSTRAINT FK_7BFD0EA44D675C64');
        $this->addSql('ALTER TABLE postal_service_range DROP CONSTRAINT FK_8AA1287E5BF93D8');
        $this->addSql('DROP TABLE postal_product');
        $this->addSql('DROP TABLE postal_service');
        $this->addSql('DROP TABLE postal_service_range');
    }
}
