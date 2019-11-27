<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191117104641 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_requests(
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                user_id INT(10) UNSIGNED NOT NULL,
                hash VARCHAR(32) DEFAULT NULL,
                status TINYINT(1) DEFAULT 0,
                created_at DATETIME DEFAULT NOW(),
                valid_to DATETIME DEFAULT NOW(),
                updated_at DATETIME DEFAULT NOW() ON UPDATE NOW()
            )'
        );

        $this->addSql('ALTER TABLE reset_password_requests ADD FOREIGN KEY(user_id) REFERENCES users(id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_requests DROP FOREIGN KEY(user_id)');

        $this->addSql('DROP TABLE reset_password_requests');
    }
}
