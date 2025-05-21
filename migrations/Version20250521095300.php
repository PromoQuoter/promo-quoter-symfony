<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521095300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add phone and is_verified to user table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD phone VARCHAR(255) DEFAULT NULL, ADD is_verified TINYINT(1) NOT NULL
        SQL);

        // Verify existing users
        $this->addSql(<<<'SQL'
            UPDATE user SET is_verified = 1
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` DROP phone, DROP is_verified
        SQL);
    }
}
