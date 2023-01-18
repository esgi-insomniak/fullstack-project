<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117133233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD year INT NOT NULL');
        $this->addSql('ALTER TABLE car ADD options TEXT DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN car.options IS \'(DC2Type:array)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_897A2CC5989D9B62 ON car_category (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_897A2CC5989D9B62');
        $this->addSql('ALTER TABLE car DROP year');
        $this->addSql('ALTER TABLE car DROP options');
    }
}
