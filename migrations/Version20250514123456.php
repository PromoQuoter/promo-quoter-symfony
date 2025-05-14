<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250514123456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Strip invalid JSON in part_database and salesman';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            UPDATE part_database SET part_database.color = '[]' WHERE JSON_VALID(part_database.color)=0;
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salesman MODIFY address1 TEXT NULL;
        SQL);
        $this->addSql(<<<'SQL'
            UPDATE salesman SET salesman.address1 = NULL WHERE JSON_VALID(salesman.address1)=0;
        SQL);
    }

    public function down(Schema $schema): void
    {

    }
}
