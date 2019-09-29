<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190929125657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->createLanguagesTable();
        $this->addSql('ALTER TABLE texts ADD language_id INT UNSIGNED');
        $this->addSql('ALTER TABLE texts ADD FOREIGN KEY(language_id) REFERENCES languages(id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE texts DROP FOREIGN KEY(language_id)');
        $this->addSql('ALTER TABLE texts DROP language_id');
        $this->dropLanguagesTable();
    }

    private function createLanguagesTable()
    {
        $this->addSql('CREATE TABLE languages(id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, title VARCHAR(10) NOT NULL)');
    }

    private function dropLanguagesTable()
    {
        $this->addSql('DROP TABLE languages');
    }
}
