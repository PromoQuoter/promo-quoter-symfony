<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250509110927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change all uses of "timestamp" to "datetime"';
    }

    public function up(Schema $schema): void
    {
        // First, save the current SQL mode
        $originalSqlMode = $this->connection->executeQuery("SELECT @@SESSION.sql_mode")->fetchOne();
        $this->write("Original SQL Mode: " . $originalSqlMode);

        // Disable strict mode to allow working with zero dates
        $this->connection->executeStatement("SET SESSION sql_mode = ''");
        $this->write("Set SQL mode to allow invalid dates");

        // Get the database name
        $dbName = $this->connection->getDatabase();

        // Query to find all timestamp columns
        $sql = "SELECT TABLE_NAME, COLUMN_NAME 
                FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE TABLE_SCHEMA = '$dbName' 
                AND DATA_TYPE = 'timestamp'";

        $timestampColumns = $this->connection->executeQuery($sql)->fetchAllAssociative();
        $this->write(sprintf("Found %d timestamp columns to convert", count($timestampColumns)));

        foreach ($timestampColumns as $column) {
            $tableName = $column['TABLE_NAME'];
            $columnName = $column['COLUMN_NAME'];
            $this->write(sprintf("Processing column %s.%s", $tableName, $columnName));

            try {
                // Update any zero dates in all columns
                $updateSql = "UPDATE `$tableName` SET `$columnName` = '2000-01-01 00:00:00' WHERE `$columnName` = '0000-00-00 00:00:00'";
                $count = $this->connection->executeStatement($updateSql);
                $this->write(sprintf("Updated %d rows with zero dates in %s.%s", $count, $tableName, $columnName));

                // Get column definition
                $columnInfoSql = "SHOW COLUMNS FROM `$tableName` LIKE '$columnName'";
                $columnInfo = $this->connection->executeQuery($columnInfoSql)->fetchAssociative();
                $this->write(sprintf("Column info for %s.%s: Type=%s, Null=%s, Default=%s, Extra=%s",
                    $tableName, $columnName, $columnInfo['Type'], $columnInfo['Null'],
                    $columnInfo['Default'] ?? 'NULL', $columnInfo['Extra']));

                // Get create table statement to see exact definition
                $createTableSql = $this->connection->executeQuery("SHOW CREATE TABLE `$tableName`")->fetchOne(1);
                if (preg_match("/`$columnName`\s+timestamp([^,]+)/i", $createTableSql, $matches)) {
                    $columnDef = $matches[0];
                    $this->write(sprintf("Original column definition: %s", $columnDef));
                }

                $nullable = $columnInfo['Null'] === 'YES' ? 'NULL' : 'NOT NULL';

                // Handle default value
                $default = '';
                if ($columnInfo['Default'] !== null) {
                    // Fix for current_timestamp() - need to remove the parentheses and quotes
                    if (strtolower($columnInfo['Default']) === 'current_timestamp()' ||
                        strtolower($columnInfo['Default']) === 'current_timestamp') {
                        $default = "DEFAULT CURRENT_TIMESTAMP";
                    } elseif ($columnInfo['Default'] === '0000-00-00 00:00:00') {
                        $default = "DEFAULT '2000-01-01 00:00:00'";
                    } else {
                        $default = "DEFAULT '" . $columnInfo['Default'] . "'";
                    }
                }

                // Handle ON UPDATE
                $onUpdate = '';
                if (strpos($columnInfo['Extra'] ?? '', 'on update CURRENT_TIMESTAMP') !== false) {
                    $onUpdate = "ON UPDATE CURRENT_TIMESTAMP";
                }

                // Convert the column using a multi-step approach

                // Step 1: First make it nullable without default
                $step1Sql = "ALTER TABLE `$tableName` MODIFY `$columnName` TIMESTAMP NULL";
                $this->write("Step 1: " . $step1Sql);
                $this->connection->executeStatement($step1Sql);

                // Step 2: Convert to DATETIME without default
                $step2Sql = "ALTER TABLE `$tableName` MODIFY `$columnName` DATETIME NULL";
                $this->write("Step 2: " . $step2Sql);
                $this->connection->executeStatement($step2Sql);

                // Step 3: If original was NOT NULL, ensure no NULL values
                if ($columnInfo['Null'] === 'NO') {
                    $step3Sql = "UPDATE `$tableName` SET `$columnName` = CURRENT_TIMESTAMP WHERE `$columnName` IS NULL";
                    $this->write("Step 3: " . $step3Sql);
                    $this->connection->executeStatement($step3Sql);
                }

                // Step 4: Add constraints back
                $step4Sql = "ALTER TABLE `$tableName` MODIFY `$columnName` DATETIME $nullable";
                $this->write("Step 4: " . $step4Sql);
                $this->connection->executeStatement($step4Sql);

                // Step 5: Add default value in a separate step if needed
                if (!empty($default)) {
                    $step5Sql = "ALTER TABLE `$tableName` MODIFY `$columnName` DATETIME $nullable $default";
                    $this->write("Step 5: " . $step5Sql);
                    $this->connection->executeStatement($step5Sql);
                }

                // Step 6: Add ON UPDATE in a separate step if needed
                if (!empty($onUpdate)) {
                    $step6Sql = "ALTER TABLE `$tableName` MODIFY `$columnName` DATETIME $nullable $default $onUpdate";
                    $this->write("Step 6: " . $step6Sql);
                    $this->connection->executeStatement($step6Sql);
                }

                $this->write(sprintf('Completed conversion of %s.%s from TIMESTAMP to DATETIME', $tableName, $columnName));
            } catch (\Exception $e) {
                $this->write(sprintf('Error converting %s.%s: %s', $tableName, $columnName, $e->getMessage()));
                throw $e; // Re-throw to stop the migration
            }
        }

        // Restore original SQL mode
        $restoreSql = "SET SESSION sql_mode = '$originalSqlMode'";
        $this->write("Restoring SQL mode: " . $restoreSql);
        $this->connection->executeStatement($restoreSql);
        $this->write("Migration completed.");
    }

    public function down(Schema $schema): void
    {
        $this->write('Down migration not implemented. Manual intervention required to revert changes.');
    }
}