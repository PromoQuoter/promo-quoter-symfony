<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250514131759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove invalid supplier shipping_type';
    }

    public function up(Schema $schema): void
    {
        // Remove invalid supplier shipping_type
        $this->addSql(<<<'SQL'
            UPDATE supplier SET shipping_type = NULL WHERE shipping_type NOT REGEXP '^[0-9]+$';
        SQL);
    }

    public function down(Schema $schema): void
    {

    }
}
