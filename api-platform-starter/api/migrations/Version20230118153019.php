<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118153019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garage_car DROP CONSTRAINT fk_72cd480c4fff555');
        $this->addSql('ALTER TABLE garage_car DROP CONSTRAINT fk_72cd480c3c6f69f');
        $this->addSql('DROP TABLE garage_car');
        $this->addSql('ALTER TABLE car DROP CONSTRAINT fk_773de69d12469de2');
        $this->addSql('DROP INDEX idx_773de69d12469de2');
        $this->addSql('ALTER TABLE car DROP category_id');
        $this->addSql('ALTER TABLE car DROP name');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_773DE69D989D9B62 ON car (slug)');
        $this->addSql('ALTER TABLE image ALTER src TYPE VARCHAR(1500)');
        $this->addSql('ALTER TABLE "order" DROP stripe_id');
        $this->addSql('ALTER TABLE "order" ALTER total_price DROP NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5299398D17F50A6 ON "order" (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE garage_car (garage_id INT NOT NULL, car_id INT NOT NULL, PRIMARY KEY(garage_id, car_id))');
        $this->addSql('CREATE INDEX idx_72cd480c3c6f69f ON garage_car (car_id)');
        $this->addSql('CREATE INDEX idx_72cd480c4fff555 ON garage_car (garage_id)');
        $this->addSql('ALTER TABLE garage_car ADD CONSTRAINT fk_72cd480c4fff555 FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE garage_car ADD CONSTRAINT fk_72cd480c3c6f69f FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP INDEX UNIQ_F5299398D17F50A6');
        $this->addSql('ALTER TABLE "order" ADD stripe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "order" ALTER total_price SET NOT NULL');
        $this->addSql('DROP INDEX UNIQ_773DE69D989D9B62');
        $this->addSql('ALTER TABLE car ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE car ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT fk_773de69d12469de2 FOREIGN KEY (category_id) REFERENCES car_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_773de69d12469de2 ON car (category_id)');
        $this->addSql('ALTER TABLE image ALTER src TYPE VARCHAR(1000)');
    }
}
