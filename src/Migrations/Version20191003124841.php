<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191003124841 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories(
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            parent_category INT UNSIGNED DEFAULT NULL,
            title VARCHAR(60) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )');

        $this->addSql('ALTER TABLE categories ADD FOREIGN KEY(parent_category) REFERENCES categories(id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY(parent_category');
        $this->addSql('DROP TABLE categories');
    }
}
