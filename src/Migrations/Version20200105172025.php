<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200105172025 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liqpay_subscriptions(
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                user_id INT UNSIGNED,
                order_id VARCHAR(40),
                status TINYINT UNSIGNED DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                expired_at DATETIME DEFAULT NULL
            )'
        );

        $this->addSql('ALTER TABLE liqpay_subscriptions ADD FOREIGN KEY(user_id) REFERENCES users(id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liqpay_subscriptions DROP FOREIGN KEY(user_id)');

        $this->addSql('DROP TABLE liqpay_subscriptions');
    }
}
