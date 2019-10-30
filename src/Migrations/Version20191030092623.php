<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191030092623 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses ADD COLUMN words_count INT DEFAULT 0 AFTER language_id');
        $this->addSql('ALTER TABLE courses ADD COLUMN letter_count INT DEFAULT 0 AFTER words_count');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses DROP COLUMN words_count');
        $this->addSql('ALTER TABLE courses DROP COLUMN letter_count');
    }
}
