<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191218062611 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE courses_history(
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                user_id INT UNSIGNED,
                course_id INT UNSIGNED,
                words_per_minute SMALLINT UNSIGNED DEFAULT(0),
                chars_per_minute INT UNSIGNED DEFAULT(0),
                accuracy SMALLINT UNSIGNED DEFAULT(0),
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )'
        );

        $this->addSql('ALTER TABLE courses_history ADD FOREIGN KEY(user_id) REFERENCES users(id)');
        $this->addSql('ALTER TABLE courses_history ADD FOREIGN KEY(course_id) REFERENCES courses(id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE courses_history DROP FOREIGN KEY(user_id)');
        $this->addSql('ALTER TABLE courses_history DROP FOREIGN KEY(text_id)');

        $this->addSql('DROP TABLE courses_history');
    }
}
