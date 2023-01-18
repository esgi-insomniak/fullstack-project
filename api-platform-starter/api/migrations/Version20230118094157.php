<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118094157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ALTER src TYPE VARCHAR(1000)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045F6044248D ON image (src)');
        $this->addSql('ALTER TABLE "user" ADD first_name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD last_name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD verified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN "user".verified_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP first_name');
        $this->addSql('ALTER TABLE "user" DROP last_name');
        $this->addSql('ALTER TABLE "user" DROP verified_at');
        $this->addSql('DROP INDEX UNIQ_C53D045F6044248D');
        $this->addSql('ALTER TABLE image ALTER src TYPE VARCHAR(255)');
    }
}
