<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250509101030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename tables from CodeIgniter to match the new naming convention.';
    }

    public function up(Schema $schema): void
    {
        // Rename all tables prefixed with pq_
        // Example: pq_assign_salesman to assign_salesman
        $old_tables = [
            'assign_salesman',
            'auth_groups_users',
            'auth_identities',
            'auth_logins',
            'auth_permissions_users',
            'auth_remember_tokens',
            'auth_token_logins',
            'auth_users',
            'book_demo',
            'business_source',
            'ci_sessions',
            'ci_settings',
            'cities',
            'clients_feedback',
            'company',
            'company_invites',
            'contact_us',
            'countries',
            'customer',
            'customer_business_source',
            'faq',
            'invoices',
            'job_status',
            'job_tracking',
            'job_tracking_part_artwork',
            'migrations',
            'newsletter',
            'options',
            'part_category',
            'part_sub_category',
            'part_xero_key',
            // special: 'partsdatabase',
            'product_supplier_link',
            // special: promodata_parts
            // special: promodata_suppliers
            'quote_layout_setting',
            'quote_line_items',
            'quote_status',
            'quotes',
            'quotes_email_tracker',
            'salesman',
            'shipping_type',
            'states',
            'subscriptions',
            'supplier',
            'supplier_xero_key',
            'users_to_do'
        ];

        foreach ($old_tables as $old_table) {
            $this->addSql("RENAME TABLE pq_$old_table TO $old_table");
        }

        // Rename special tables
        $this->addSql("RENAME TABLE pq_partsdatabase TO part_database");
        $this->addSql("RENAME TABLE pq_promodata_parts TO promo_data_parts");
        $this->addSql("RENAME TABLE pq_promodata_suppliers TO promo_data_suppliers");
    }

    public function down(Schema $schema): void
    {
        // Down unsupported
    }
}
