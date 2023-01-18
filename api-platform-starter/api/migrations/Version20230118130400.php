<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118130400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE car_identity_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE car_identity (id INT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E5A3DCC012469DE2 ON car_identity (category_id)');
        $this->addSql('ALTER TABLE car_identity ADD CONSTRAINT FK_E5A3DCC012469DE2 FOREIGN KEY (category_id) REFERENCES car_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE car_identity_id_seq CASCADE');
        $this->addSql('ALTER TABLE car_identity DROP CONSTRAINT FK_E5A3DCC012469DE2');
        $this->addSql('DROP TABLE car_identity');
    }
}
