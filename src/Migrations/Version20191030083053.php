<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191030083053 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE courses(
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                group_id INT DEFAULT 0,
                title VARCHAR(100) DEFAULT NULL,
                language_id INT(10) UNSIGNED,
                text_body TEXT,
                parsed_text LONGTEXT,
                created_at DATETIME DEFAULT NOW(),
                updated_at DATETIME DEFAULT NOW() ON UPDATE NOW()
            )'
        );

        $this->addSql('ALTER TABLE courses ADD FOREIGN KEY(language_id) REFERENCES languages(id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY(language_id)');

        $this->addSql('DROP TABLE courses');
    }
}
