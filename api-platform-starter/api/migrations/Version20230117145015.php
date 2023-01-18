<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117145015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car_image (car_id INT NOT NULL, image_id INT NOT NULL, PRIMARY KEY(car_id, image_id))');
        $this->addSql('CREATE INDEX IDX_1A968188C3C6F69F ON car_image (car_id)');
        $this->addSql('CREATE INDEX IDX_1A9681883DA5256D ON car_image (image_id)');
        $this->addSql('ALTER TABLE car_image ADD CONSTRAINT FK_1A968188C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE car_image ADD CONSTRAINT FK_1A9681883DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE car_image DROP CONSTRAINT FK_1A968188C3C6F69F');
        $this->addSql('ALTER TABLE car_image DROP CONSTRAINT FK_1A9681883DA5256D');
        $this->addSql('DROP TABLE car_image');
    }
}
