<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250509124224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migrate all users from CodeIgniter Shield to Symfony Security.';
    }

    public function up(Schema $schema): void
    {
        // Create new Symfony user table if it doesn't exist
        $this->connection->executeQuery(<<<'SQL'
            CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, company_id INT DEFAULT NULL, stripe_customer_id VARCHAR(255) DEFAULT NULL, invite_limit INT NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);

        // Check if Shield tables exist
        $usersTableExists = $this->connection->executeQuery("
            SHOW TABLES LIKE 'auth_users'
        ")->fetchOne();

        $identitiesTableExists = $this->connection->executeQuery("
            SHOW TABLES LIKE 'auth_identities'
        ")->fetchOne();

        if ($usersTableExists && $identitiesTableExists) {
            $this->write('Found CodeIgniter Shield tables');

            // Check required columns in auth_identities
            $identitiesColumns = $this->connection->executeQuery("DESCRIBE auth_identities")->fetchAllAssociative();
            $identitiesColumnsNames = array_column($identitiesColumns, 'Field');
            $this->write('Shield identities table columns: ' . implode(', ', $identitiesColumnsNames));

            if (!in_array('secret', $identitiesColumnsNames) || !in_array('secret2', $identitiesColumnsNames) || !in_array('user_id', $identitiesColumnsNames)) {
                $this->write('Error: Required columns not found in auth_identities table. Migration aborted.');
                return;
            }

            // Count shield users
            $userCount = $this->connection->executeQuery("SELECT COUNT(*) FROM auth_users")->fetchOne();
            $this->write(sprintf('Found %d users to migrate', $userCount));

            // First, create a temporary table to store user groups
            $this->addSql('DROP TABLE IF EXISTS temp_user_groups');
            $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE temp_user_groups AS
            SELECT 
                user_id,
                JSON_ARRAYAGG(CONCAT('ROLE_', UPPER(`group`))) as roles
            FROM auth_groups_users
            GROUP BY user_id
            SQL);

            $this->write('Created temporary mapping of user groups');

            // Map shield users to Symfony users
            $this->write('Starting migration of users...');

            // Insert users with their specific roles and passwords from auth_identities
            $this->addSql(<<<'SQL'
            INSERT INTO user (
                username, email, roles, password, company_id, invite_limit
            )
            SELECT 
                au.username,
                ai.secret as email,
                COALESCE(tug.roles, JSON_ARRAY('ROLE_USER')) as roles,
                ai.secret2 as password,
                au.company_id as company_id,
                10 as invite_limit
            FROM auth_users au
            LEFT JOIN temp_user_groups tug ON au.id = tug.user_id
            JOIN auth_identities ai ON au.id = ai.user_id AND ai.type = 'email_password'
            SQL);

            $migratedCount = $this->connection->executeQuery("SELECT COUNT(*) FROM user")->fetchOne();
            $this->write(sprintf('Successfully migrated %d users', $migratedCount));

            // Clean up
            $this->addSql('DROP TABLE IF EXISTS temp_user_groups');

            // Backup original tables
            $this->addSql('CREATE TABLE ci_auth_users_backup LIKE auth_users');
            $this->addSql('INSERT INTO ci_auth_users_backup SELECT * FROM auth_users');
            $this->write('Created backup of CodeIgniter users table (ci_auth_users_backup)');

            $this->addSql('CREATE TABLE ci_auth_groups_users_backup LIKE auth_groups_users');
            $this->addSql('INSERT INTO ci_auth_groups_users_backup SELECT * FROM auth_groups_users');
            $this->write('Created backup of CodeIgniter groups table (ci_auth_groups_users_backup)');

            $this->addSql('CREATE TABLE ci_auth_identities_backup LIKE auth_identities');
            $this->addSql('INSERT INTO ci_auth_identities_backup SELECT * FROM auth_identities');
            $this->write('Created backup of CodeIgniter identities table (ci_auth_identities_backup)');

            $this->addSql('CREATE TABLE ci_auth_permissions_users_backup LIKE auth_permissions_users');
            $this->addSql('INSERT INTO ci_auth_permissions_users_backup SELECT * FROM auth_permissions_users');
            $this->write('Created backup of CodeIgniter permissions table (ci_auth_permissions_users_backup)');

            // Output a sample of the migrated users for verification
            $userSamples = $this->connection->executeQuery("
                SELECT username, roles, LEFT(password, 10) as password_preview FROM user LIMIT 5
            ")->fetchAllAssociative();

            foreach ($userSamples as $sample) {
                $this->write(sprintf('User %s has roles: %s, password preview: %s...',
                    $sample['username'],
                    $sample['roles'],
                    $sample['password_preview']
                ));
            }
        } else {
            $this->write('Required CodeIgniter Shield tables not found, skipping migration');
        }
    }

    public function down(Schema $schema): void
    {
        // Check if backups exist
        $tables = ['ci_auth_users_backup', 'ci_auth_groups_users_backup', 'ci_auth_identities_backup', 'ci_auth_permissions_users_backup'];
        $allBackupsExist = true;

        foreach ($tables as $table) {
            $exists = $this->connection->executeQuery("SHOW TABLES LIKE '$table'")->fetchOne();
            $allBackupsExist = $allBackupsExist && $exists;
        }

        if ($allBackupsExist) {
            $this->write('Backup tables exist, but we will not automatically restore them to avoid data loss');
            $this->write('To manually restore:');
            $this->write('1. DROP TABLE IF EXISTS auth_users; RENAME TABLE ci_auth_users_backup TO auth_users;');
            $this->write('2. DROP TABLE IF EXISTS auth_groups_users; RENAME TABLE ci_auth_groups_users_backup TO auth_groups_users;');
            $this->write('3. DROP TABLE IF EXISTS auth_identities; RENAME TABLE ci_auth_identities_backup TO auth_identities;');
        } else {
            $this->write('Warning: Not all backup tables were found. Manual restoration may not be possible.');
        }

        // We don't drop the user table as it might contain new users
        $this->write('Migration reversed. Please review user data as needed.');
    }
}