<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116151950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE car_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE car_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE garage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE car (id INT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, fuel VARCHAR(20) NOT NULL, power INT DEFAULT NULL, weight INT NOT NULL, speeding DOUBLE PRECISION NOT NULL, consumption DOUBLE PRECISION DEFAULT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_773DE69D12469DE2 ON car (category_id)');
        $this->addSql('CREATE TABLE car_category (id INT NOT NULL, name VARCHAR(50) NOT NULL, slug VARCHAR(80) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE garage (id INT NOT NULL, name VARCHAR(255) NOT NULL, coordinates TEXT NOT NULL, is_open BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN garage.coordinates IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE garage_car (garage_id INT NOT NULL, car_id INT NOT NULL, PRIMARY KEY(garage_id, car_id))');
        $this->addSql('CREATE INDEX IDX_72CD480C4FFF555 ON garage_car (garage_id)');
        $this->addSql('CREATE INDEX IDX_72CD480C3C6F69F ON garage_car (car_id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D12469DE2 FOREIGN KEY (category_id) REFERENCES car_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE garage_car ADD CONSTRAINT FK_72CD480C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE garage_car ADD CONSTRAINT FK_72CD480C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE car_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE car_category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE garage_id_seq CASCADE');
        $this->addSql('ALTER TABLE car DROP CONSTRAINT FK_773DE69D12469DE2');
        $this->addSql('ALTER TABLE garage_car DROP CONSTRAINT FK_72CD480C4FFF555');
        $this->addSql('ALTER TABLE garage_car DROP CONSTRAINT FK_72CD480C3C6F69F');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_category');
        $this->addSql('DROP TABLE garage');
        $this->addSql('DROP TABLE garage_car');
    }
}
