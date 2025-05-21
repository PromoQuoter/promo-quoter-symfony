<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250514134513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Sync database state with Symfony Entities';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE auth_groups_users DROP FOREIGN KEY pq_auth_groups_users_user_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE auth_permissions_users DROP FOREIGN KEY pq_auth_permissions_users_user_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE auth_identities DROP FOREIGN KEY pq_auth_identities_user_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE auth_remember_tokens DROP FOREIGN KEY pq_auth_remember_tokens_user_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE auth_groups_users
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ci_sessions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ci_settings
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE auth_logins
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE auth_permissions_users
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE auth_token_logins
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE migrations
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE auth_remember_tokens
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE auth_identities
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE book_demo CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE cuid cuid VARCHAR(255) NOT NULL, CHANGE full_name full_name VARCHAR(255) NOT NULL, CHANGE organization organization VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE date date DATETIME NOT NULL, CHANGE platform platform VARCHAR(255) NOT NULL, CHANGE platform_username platform_username VARCHAR(255) NOT NULL, CHANGE notes notes VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE business_source CHANGE name name VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cities CHANGE name name VARCHAR(255) NOT NULL, CHANGE postcode postcode VARCHAR(10) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE clients_feedback CHANGE image image VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE place place VARCHAR(255) NOT NULL, CHANGE star star INT NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE delete_flag delete_flag VARCHAR(255) NOT NULL, CHANGE is_active is_active VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE company CHANGE name name VARCHAR(255) NOT NULL, CHANGE contact_person contact_person VARCHAR(255) NOT NULL, CHANGE website website VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE address1 address1 VARCHAR(255) NOT NULL, CHANGE address2 address2 VARCHAR(255) NOT NULL, CHANGE post_code post_code VARCHAR(255) DEFAULT NULL, CHANGE logo logo VARCHAR(255) DEFAULT NULL, CHANGE xero_invoice_account_code xero_invoice_account_code VARCHAR(255) DEFAULT NULL, CHANGE xero_purchase_account_code xero_purchase_account_code VARCHAR(255) DEFAULT NULL, CHANGE account_type account_type VARCHAR(255) DEFAULT NULL, CHANGE company_plan_id company_plan_id INT NOT NULL, CHANGE total_sub_user_allotment total_sub_user_allotment INT NOT NULL, CHANGE total_sub_user_allotment_with_plan total_sub_user_allotment_with_plan INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE additional_addresses additional_addresses LONGTEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE company_invites CHANGE company_id company_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_us CHANGE name name VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE subject subject VARCHAR(255) NOT NULL, CHANGE msg msg VARCHAR(255) NOT NULL, CHANGE delete_flag delete_flag VARCHAR(255) NOT NULL, CHANGE is_active is_active VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE countries CHANGE sortname sortname VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE company_id company_id INT NOT NULL, CHANGE company company VARCHAR(255) DEFAULT NULL, CHANGE salutation salutation VARCHAR(255) DEFAULT NULL, CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL, CHANGE reference reference VARCHAR(255) DEFAULT NULL, CHANGE address1 address1 VARCHAR(255) DEFAULT NULL, CHANGE address2 address2 VARCHAR(255) DEFAULT NULL, CHANGE country_id country_id INT DEFAULT NULL, CHANGE state_id state_id INT DEFAULT NULL, CHANGE city_id city_id INT DEFAULT NULL, CHANGE post_code post_code VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE mobile mobile VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE profile_image profile_image VARCHAR(255) DEFAULT NULL, CHANGE company_note company_note VARCHAR(255) DEFAULT NULL, CHANGE address11 address11 VARCHAR(255) DEFAULT NULL, CHANGE address21 address21 VARCHAR(255) DEFAULT NULL, CHANGE post_code1 post_code1 VARCHAR(255) DEFAULT NULL, CHANGE phone1 phone1 VARCHAR(255) DEFAULT NULL, CHANGE company_website company_website VARCHAR(255) DEFAULT NULL, CHANGE xeroKey xeroKey VARCHAR(255) DEFAULT NULL, CHANGE delete_flag delete_flag VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE faq CHANGE question question VARCHAR(255) NOT NULL, CHANGE answer answer LONGTEXT NOT NULL, CHANGE delete_flag delete_flag VARCHAR(255) NOT NULL, CHANGE is_active is_active VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE invoices DROP FOREIGN KEY pq_invoices_subscription_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX pq_invoices_subscription_id_foreign ON invoices
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE invoices CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE subscription_id subscription_id VARCHAR(255) DEFAULT NULL, CHANGE stripe_id stripe_id VARCHAR(255) NOT NULL, CHANGE stripe_status stripe_status VARCHAR(255) NOT NULL, CHANGE amount_due amount_due INT NOT NULL, CHANGE amount_paid amount_paid INT NOT NULL, CHANGE attempt_count attempt_count INT NOT NULL, CHANGE next_payment_attempt next_payment_attempt DATETIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_status CHANGE job_status_short job_status_short VARCHAR(255) NOT NULL, CHANGE job_status_long job_status_long VARCHAR(255) NOT NULL, CHANGE job_order job_order INT NOT NULL, CHANGE job_color job_color VARCHAR(7) NOT NULL, CHANGE delete_flag delete_flag VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_tracking CHANGE quote_no quote_no VARCHAR(255) NOT NULL, CHANGE quote_title quote_title VARCHAR(255) NOT NULL, CHANGE quote_company quote_company VARCHAR(255) NOT NULL, CHANGE freight freight DOUBLE PRECISION NOT NULL, CHANGE adjust_profit adjust_profit DOUBLE PRECISION NOT NULL, CHANGE total_part total_part DOUBLE PRECISION NOT NULL, CHANGE profit_amt profit_amt DOUBLE PRECISION NOT NULL, CHANGE cost_amt cost_amt DOUBLE PRECISION NOT NULL, CHANGE profit_per profit_per DOUBLE PRECISION NOT NULL, CHANGE total_10 total_10 DOUBLE PRECISION NOT NULL, CHANGE total_w_tax total_w_tax DOUBLE PRECISION NOT NULL, CHANGE job_note job_note LONGTEXT DEFAULT NULL, CHANGE job_status job_status INT NOT NULL, CHANGE cust_p_o cust_p_o VARCHAR(255) DEFAULT NULL, CHANGE call_back_complete call_back_complete VARCHAR(1) NOT NULL, CHANGE urgent urgent VARCHAR(1) NOT NULL, CHANGE job_billed job_billed VARCHAR(1) NOT NULL, CHANGE delete_flag delete_flag VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_tracking_part_artwork CHANGE image image VARCHAR(255) NOT NULL, CHANGE reject_reason reject_reason VARCHAR(255) DEFAULT NULL, CHANGE approved_rejected approved_rejected VARCHAR(1) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE newsletter CHANGE email email VARCHAR(255) NOT NULL, CHANGE delete_flag delete_flag VARCHAR(255) NOT NULL, CHANGE is_active is_active VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE options CHANGE option_id option_id INT NOT NULL, CHANGE date_format date_format JSON DEFAULT '[{"example":"2019-12-06 09:43","format":"Y-m-d h:i","is_active":0,"uniq_id":"1"},{"example":"06-12-2019 09:44","format":"d-m-Y h:i","is_active":1,"uniq_id":"2"},{"example":"2019\\/12\\/06 09:44","format":"Y\\/m\\/d h:i","is_active":0,"uniq_id":"3"},{"example":"06\\/12\\/2019 09:43","format":"d\\/m\\/Y h:i","is_active":0,"uniq_id":"4"}]' NOT NULL, CHANGE profit profit DOUBLE PRECISION NOT NULL, CHANGE price_decimal_place price_decimal_place INT NOT NULL, CHANGE part_weight part_weight VARCHAR(255) NOT NULL, CHANGE additional_price_column additional_price_column INT NOT NULL, CHANGE tax_rate tax_rate INT NOT NULL, CHANGE quote_no_format quote_no_format INT NOT NULL, CHANGE font_family font_family VARCHAR(255) NOT NULL, CHANGE font_size font_size INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE custom_quote_number custom_quote_number INT NOT NULL, CHANGE artwork_email_body_footer_reject artwork_email_body_reject_accept LONGTEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_category CHANGE name name VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_category RENAME INDEX promodata_id TO UNIQ_911E9CBED74359F2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_database DROP FOREIGN KEY pq_partsdatabase_company_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_database DROP FOREIGN KEY pq_partsdatabase_promodata_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX search_color_brand_ft ON part_database
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_database CHANGE component_type component_type VARCHAR(255) DEFAULT NULL, CHANGE setup setup INT NOT NULL, CHANGE costs costs JSON NOT NULL, CHANGE cost_taxable cost_taxable INT NOT NULL, CHANGE setup_taxable setup_taxable INT NOT NULL, CHANGE color color JSON DEFAULT 'JSON_ARRAY()' NOT NULL, CHANGE images images JSON DEFAULT 'JSON_ARRAY()' NOT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE sub_category_id sub_category_id INT DEFAULT NULL, CHANGE promodata_id promodata_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_database RENAME INDEX promodata_id TO UNIQ_5E018351D74359F2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_sub_category CHANGE name name VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_sub_category RENAME INDEX promodata_id TO UNIQ_8EA7A708D74359F2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_supplier_link DROP FOREIGN KEY pq_product_supplier_link_supplier_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_supplier_link DROP FOREIGN KEY product_supplier_link_company_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_supplier_link DROP FOREIGN KEY product_supplier_link_part_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX pq_product_supplier_link_supplier_id_foreign ON product_supplier_link
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX product_supplier_link_part_id_foreign ON product_supplier_link
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE promo_data_parts CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE data data JSON NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE promo_data_suppliers CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE data data JSON NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quote_layout_setting CHANGE with_picture with_picture VARCHAR(255) NOT NULL, CHANGE with_product_link with_product_link TINYINT(1) NOT NULL, CHANGE layout layout VARCHAR(255) NOT NULL, CHANGE preview_footer preview_footer LONGTEXT NOT NULL, CHANGE preview_introduction preview_introduction LONGTEXT NOT NULL, CHANGE preview_header_color preview_header_color VARCHAR(7) NOT NULL, CHANGE preview_header_bg_color preview_header_bg_color VARCHAR(7) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quote_line_items CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE quote_id quote_id INT NOT NULL, CHANGE part_id part_id INT NOT NULL, CHANGE line_item_index line_item_index INT NOT NULL, CHANGE details details LONGTEXT NOT NULL, CHANGE costs_json costs_json JSON NOT NULL, CHANGE gst_exempt gst_exempt TINYINT(1) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quote_status CHANGE name name VARCHAR(255) NOT NULL, CHANGE order_no order_no INT NOT NULL, CHANGE default_when_add_new_quotes default_when_add_new_quotes TINYINT(1) NOT NULL, CHANGE default_when_creating_job_quote default_when_creating_job_quote TINYINT(1) NOT NULL, CHANGE default_when_job_from_quote_id_completed default_when_job_from_quote_id_completed TINYINT(1) NOT NULL, CHANGE default_when_ordering_p_o_form default_when_ordering_p_o_form TINYINT(1) NOT NULL, CHANGE default_when_invoice_is_complete default_when_invoice_is_complete TINYINT(1) NOT NULL, CHANGE default_when_quote_has_been_sent default_when_quote_has_been_sent TINYINT(1) NOT NULL, CHANGE default_when_quote_not_proceeding default_when_quote_not_proceeding TINYINT(1) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quotes ADD quotes_email_tracker INT NOT NULL, CHANGE unique_id unique_id VARCHAR(255) NOT NULL, CHANGE quote_no quote_no INT NOT NULL, CHANGE quote_no_format quote_no_format VARCHAR(255) NOT NULL, CHANGE quote_company quote_company VARCHAR(255) NOT NULL, CHANGE quote_title quote_title VARCHAR(255) NOT NULL, CHANGE tax tax INT NOT NULL, CHANGE freight freight INT NOT NULL, CHANGE total_part total_part DOUBLE PRECISION NOT NULL, CHANGE profit_amt profit_amt DOUBLE PRECISION NOT NULL, CHANGE cost_amt cost_amt DOUBLE PRECISION NOT NULL, CHANGE note note LONGTEXT NOT NULL, CHANGE internal_note internal_note LONGTEXT DEFAULT NULL, CHANGE profit_per profit_per DOUBLE PRECISION NOT NULL, CHANGE total_10 total_10 DOUBLE PRECISION NOT NULL, CHANGE total_w_tax total_w_tax DOUBLE PRECISION NOT NULL, CHANGE xero_api xero_api VARCHAR(255) NOT NULL, CHANGE invoice_xero_id invoice_xero_id VARCHAR(255) DEFAULT NULL, CHANGE invoice_xero_no invoice_xero_no VARCHAR(255) DEFAULT NULL, CHANGE AmountDue AmountDue VARCHAR(255) DEFAULT NULL, CHANGE delete_flag delete_flag VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE email_sent email_sent TINYINT(1) NOT NULL, CHANGE quote_status_accepted quote_status_accepted VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quotes_email_tracker CHANGE email_to email_to VARCHAR(255) NOT NULL, CHANGE email_from email_from VARCHAR(255) DEFAULT NULL, CHANGE email_send_date email_send_date DATE NOT NULL, CHANGE track_code track_code VARCHAR(255) NOT NULL, CHANGE email_read_status email_read_status VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salesman CHANGE initial initial VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE address1 address1 JSON DEFAULT NULL, CHANGE postcode postcode VARCHAR(255) DEFAULT NULL, CHANGE from_date from_date VARCHAR(255) NOT NULL, CHANGE to_date to_date VARCHAR(255) NOT NULL, CHANGE date_quote_heading date_quote_heading VARCHAR(255) DEFAULT NULL, CHANGE date_quote_ending date_quote_ending VARCHAR(255) DEFAULT NULL, CHANGE is_active is_active TINYINT(1) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shipping_type CHANGE name name VARCHAR(255) NOT NULL, CHANGE is_default is_default TINYINT(1) NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE states CHANGE name name VARCHAR(255) NOT NULL, CHANGE code code VARCHAR(255) NOT NULL, CHANGE country_id country_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subscriptions DROP FOREIGN KEY pq_subscriptions_company_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subscriptions DROP FOREIGN KEY pq_subscriptions_user_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX pq_subscriptions_company_id_foreign ON subscriptions
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX stripe_id ON subscriptions
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX pq_subscriptions_user_id_foreign ON subscriptions
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subscriptions CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE user_id user_id INT NOT NULL, CHANGE company_id company_id INT NOT NULL, CHANGE stripe_id stripe_id VARCHAR(255) NOT NULL, CHANGE stripe_price_id stripe_price_id VARCHAR(255) NOT NULL, CHANGE stripe_subscription_item_id stripe_subscription_item_id VARCHAR(255) NOT NULL, CHANGE stripe_status stripe_status VARCHAR(255) NOT NULL, CHANGE quantity quantity INT NOT NULL, CHANGE ends_at ends_at DATETIME NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE supplier DROP FOREIGN KEY supplier_company_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE supplier DROP FOREIGN KEY supplier_promodata_id_foreign
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX supplier_promodata_id_foreign ON supplier
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX company_id ON supplier
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX supplier_company_id_foreign ON supplier
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE supplier ADD isActivesSupplier VARCHAR(255) NOT NULL, DROP isActiveSupplier, CHANGE company_id company_id INT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE contact contact VARCHAR(255) NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE mobile mobile VARCHAR(255) DEFAULT NULL, CHANGE address1 address1 VARCHAR(255) DEFAULT NULL, CHANGE address2 address2 VARCHAR(255) DEFAULT NULL, CHANGE postcode postcode VARCHAR(255) DEFAULT NULL, CHANGE note note LONGTEXT NOT NULL, CHANGE shipping_type shipping_type INT DEFAULT NULL, CHANGE trading_terms trading_terms LONGTEXT DEFAULT NULL, CHANGE modified modified TINYINT(1) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE supplier_xero_key CHANGE supplier_id supplier_id INT NOT NULL, CHANGE company_id company_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users_to_do CHANGE todo todo LONGTEXT NOT NULL, CHANGE delete_flag delete_flag VARCHAR(255) NOT NULL, CHANGE is_active is_active VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE auth_users
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE auth_groups_users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED NOT NULL, `group` VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, created_at DATETIME NOT NULL, INDEX pq_auth_groups_users_user_id_foreign (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE auth_users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, company_id INT UNSIGNED DEFAULT NULL, username VARCHAR(30) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, stripe_customer_id VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, status VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, status_message VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, active TINYINT(1) DEFAULT 0 NOT NULL, last_active DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, invite_limit INT DEFAULT 2 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ci_sessions (session_id VARCHAR(40) CHARACTER SET utf8mb3 DEFAULT '0' NOT NULL COLLATE `utf8mb3_bin`, ip_address VARCHAR(16) CHARACTER SET utf8mb3 DEFAULT '0' NOT NULL COLLATE `utf8mb3_bin`, user_agent VARCHAR(150) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, last_activity INT UNSIGNED DEFAULT 0 NOT NULL, user_data TEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`, PRIMARY KEY(session_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_bin` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ci_settings (id INT AUTO_INCREMENT NOT NULL, class VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, `key` VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, value TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, type VARCHAR(31) CHARACTER SET utf8mb3 DEFAULT 'string' NOT NULL COLLATE `utf8mb3_general_ci`, context VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE auth_logins (id INT UNSIGNED AUTO_INCREMENT NOT NULL, ip_address VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, user_agent VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, id_type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, identifier VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, user_id INT UNSIGNED DEFAULT NULL, date DATETIME NOT NULL, success TINYINT(1) NOT NULL, INDEX id_type_identifier (id_type, identifier), INDEX user_id (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE auth_permissions_users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED NOT NULL, permission VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, created_at DATETIME NOT NULL, INDEX pq_auth_permissions_users_user_id_foreign (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE auth_identities (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, secret VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, secret2 VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, expires DATETIME DEFAULT NULL, extra TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, force_reset TINYINT(1) DEFAULT 0 NOT NULL, last_used_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX user_id (user_id), UNIQUE INDEX type_secret (type, secret), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE auth_token_logins (id INT UNSIGNED AUTO_INCREMENT NOT NULL, ip_address VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, user_agent VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, id_type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, identifier VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, user_id INT UNSIGNED DEFAULT NULL, date DATETIME NOT NULL, success TINYINT(1) NOT NULL, INDEX user_id (user_id), INDEX id_type_identifier (id_type, identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE migrations (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, version VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, class VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, `group` VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, namespace VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, time INT NOT NULL, batch INT UNSIGNED NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE auth_remember_tokens (id INT UNSIGNED AUTO_INCREMENT NOT NULL, selector VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, hashedValidator VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, user_id INT UNSIGNED NOT NULL, expires DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX selector (selector), INDEX pq_auth_remember_tokens_user_id_foreign (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE auth_groups_users ADD CONSTRAINT pq_auth_groups_users_user_id_foreign FOREIGN KEY (user_id) REFERENCES auth_users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE auth_permissions_users ADD CONSTRAINT pq_auth_permissions_users_user_id_foreign FOREIGN KEY (user_id) REFERENCES auth_users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE auth_identities ADD CONSTRAINT pq_auth_identities_user_id_foreign FOREIGN KEY (user_id) REFERENCES auth_users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE auth_remember_tokens ADD CONSTRAINT pq_auth_remember_tokens_user_id_foreign FOREIGN KEY (user_id) REFERENCES auth_users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_tracking_part_artwork CHANGE image image VARCHAR(225) DEFAULT NULL, CHANGE reject_reason reject_reason TEXT DEFAULT NULL, CHANGE approved_rejected approved_rejected VARCHAR(0) DEFAULT '0' NOT NULL COMMENT '0=pending,1=approved,2=rejected', CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE countries CHANGE sortname sortname VARCHAR(3) NOT NULL, CHANGE name name VARCHAR(150) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE salesman CHANGE initial initial VARCHAR(350) NOT NULL, CHANGE name name VARCHAR(350) NOT NULL, CHANGE address1 address1 TEXT DEFAULT NULL, CHANGE postcode postcode VARCHAR(100) NOT NULL, CHANGE from_date from_date VARCHAR(100) NOT NULL, CHANGE to_date to_date VARCHAR(100) NOT NULL, CHANGE date_quote_heading date_quote_heading VARCHAR(350) DEFAULT NULL, CHANGE date_quote_ending date_quote_ending VARCHAR(350) DEFAULT NULL, CHANGE is_active is_active INT NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_database CHANGE component_type component_type VARCHAR(255) DEFAULT NULL COMMENT 'The type of component this is, or null if it is not a component', CHANGE setup setup INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE costs costs LONGTEXT NOT NULL COMMENT 'JSON array of costs', CHANGE cost_taxable cost_taxable TINYINT(1) DEFAULT 1 NOT NULL COMMENT 'Whether or not the cost is taxable', CHANGE setup_taxable setup_taxable TINYINT(1) DEFAULT 1 NOT NULL COMMENT 'Whether or not the setup is taxable', CHANGE color color VARCHAR(255) DEFAULT '[]', CHANGE images images TEXT DEFAULT '[]', CHANGE category_id category_id INT DEFAULT NULL COMMENT 'The category ID', CHANGE sub_category_id sub_category_id INT DEFAULT NULL COMMENT 'The sub category ID', CHANGE promodata_id promodata_id INT DEFAULT NULL COMMENT 'The product ID on PromoData'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_database ADD CONSTRAINT pq_partsdatabase_company_id_foreign FOREIGN KEY (company_id) REFERENCES company (id) ON UPDATE CASCADE ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_database ADD CONSTRAINT pq_partsdatabase_promodata_id_foreign FOREIGN KEY (promodata_id) REFERENCES promo_data_parts (id) ON UPDATE CASCADE ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE FULLTEXT INDEX search_color_brand_ft ON part_database (part_number, part_name, color, brand)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_database RENAME INDEX uniq_5e018351d74359f2 TO promodata_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_sub_category CHANGE name name VARCHAR(350) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_sub_category RENAME INDEX uniq_8ea7a708d74359f2 TO promodata_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE invoices CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE subscription_id subscription_id VARCHAR(255) DEFAULT NULL COMMENT 'The subscription''s Stripe ID', CHANGE stripe_id stripe_id VARCHAR(255) NOT NULL COMMENT 'The invoice''s Stripe ID', CHANGE stripe_status stripe_status VARCHAR(255) NOT NULL COMMENT 'The invoice''s Stripe status', CHANGE amount_due amount_due INT UNSIGNED NOT NULL COMMENT 'The invoice''s amount due', CHANGE amount_paid amount_paid INT UNSIGNED NOT NULL COMMENT 'The invoice''s amount paid', CHANGE attempt_count attempt_count INT UNSIGNED NOT NULL COMMENT 'The invoice''s attempt count', CHANGE next_payment_attempt next_payment_attempt DATETIME DEFAULT NULL COMMENT 'The invoice''s next payment attempt'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE invoices ADD CONSTRAINT pq_invoices_subscription_id_foreign FOREIGN KEY (subscription_id) REFERENCES subscriptions (stripe_id) ON UPDATE CASCADE ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX pq_invoices_subscription_id_foreign ON invoices (subscription_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shipping_type CHANGE name name VARCHAR(350) NOT NULL, CHANGE is_default is_default INT NOT NULL, CHANGE description description TEXT NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_us CHANGE name name VARCHAR(225) NOT NULL, CHANGE email email VARCHAR(225) NOT NULL, CHANGE phone phone VARCHAR(225) NOT NULL, CHANGE subject subject VARCHAR(225) NOT NULL, CHANGE msg msg LONGTEXT DEFAULT NULL, CHANGE delete_flag delete_flag VARCHAR(0) DEFAULT 'N' NOT NULL COMMENT 'Y=>''Yes'',N=>''No''', CHANGE is_active is_active VARCHAR(0) DEFAULT 'Y' NOT NULL COMMENT 'Y=>''Yes'',N=>''No'''
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE faq CHANGE question question TEXT DEFAULT NULL, CHANGE answer answer LONGTEXT DEFAULT NULL, CHANGE delete_flag delete_flag VARCHAR(0) DEFAULT 'N' NOT NULL COMMENT 'Y=>''Yes'',N=>''No''', CHANGE is_active is_active VARCHAR(0) DEFAULT 'Y' NOT NULL COMMENT 'Y=>''Yes'',N=>''No'''
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE options CHANGE option_id option_id INT AUTO_INCREMENT NOT NULL, CHANGE date_format date_format LONGTEXT NOT NULL, CHANGE profit profit INT DEFAULT 50 NOT NULL, CHANGE price_decimal_place price_decimal_place INT DEFAULT 2 NOT NULL, CHANGE part_weight part_weight VARCHAR(10) DEFAULT 'kg' NOT NULL, CHANGE additional_price_column additional_price_column INT DEFAULT 0 NOT NULL, CHANGE tax_rate tax_rate INT DEFAULT 0 NOT NULL, CHANGE quote_no_format quote_no_format INT DEFAULT 0 NOT NULL, CHANGE font_family font_family VARCHAR(100) DEFAULT 'Tahoma' NOT NULL, CHANGE font_size font_size INT DEFAULT 12 NOT NULL, CHANGE custom_quote_number custom_quote_number INT UNSIGNED DEFAULT 0, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE artwork_email_body_reject_accept artwork_email_body_footer_reject LONGTEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quotes_email_tracker CHANGE email_to email_to VARCHAR(225) NOT NULL, CHANGE email_from email_from VARCHAR(225) DEFAULT NULL, CHANGE email_send_date email_send_date DATE DEFAULT NULL, CHANGE track_code track_code VARCHAR(100) NOT NULL, CHANGE email_read_status email_read_status VARCHAR(100) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_category CHANGE name name VARCHAR(350) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE part_category RENAME INDEX uniq_911e9cbed74359f2 TO promodata_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE supplier ADD isActiveSupplier VARCHAR(0) DEFAULT 'yes' NOT NULL, DROP isActivesSupplier, CHANGE company_id company_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE contact contact VARCHAR(255) DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE email email VARCHAR(320) DEFAULT NULL, CHANGE mobile mobile VARCHAR(32) DEFAULT NULL, CHANGE address1 address1 TEXT DEFAULT NULL, CHANGE address2 address2 TEXT DEFAULT NULL, CHANGE postcode postcode VARCHAR(200) DEFAULT NULL, CHANGE note note TEXT NOT NULL, CHANGE shipping_type shipping_type VARCHAR(255) DEFAULT NULL, CHANGE trading_terms trading_terms VARCHAR(255) DEFAULT NULL, CHANGE modified modified TINYINT(1) DEFAULT 0 COMMENT 'Whether or not the supplier has been modified from the original data, if true, sync will not update the supplier', CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE supplier ADD CONSTRAINT supplier_company_id_foreign FOREIGN KEY (company_id) REFERENCES company (id) ON UPDATE CASCADE ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE supplier ADD CONSTRAINT supplier_promodata_id_foreign FOREIGN KEY (promodata_id) REFERENCES promo_data_suppliers (id) ON UPDATE CASCADE ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX supplier_promodata_id_foreign ON supplier (promodata_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX company_id ON supplier (company_id, name, isActiveSupplier)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX supplier_company_id_foreign ON supplier (company_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE promo_data_suppliers CHANGE id id INT NOT NULL COMMENT 'The supplier ID on PromoData', CHANGE data data LONGTEXT NOT NULL COMMENT 'JSON data from PromoData'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE company CHANGE name name VARCHAR(350) NOT NULL, CHANGE contact_person contact_person VARCHAR(350) NOT NULL, CHANGE website website VARCHAR(350) NOT NULL, CHANGE email email VARCHAR(350) NOT NULL, CHANGE phone phone VARCHAR(100) NOT NULL, CHANGE address1 address1 TEXT NOT NULL, CHANGE address2 address2 TEXT NOT NULL, CHANGE post_code post_code VARCHAR(50) NOT NULL, CHANGE logo logo VARCHAR(150) NOT NULL, CHANGE xero_invoice_account_code xero_invoice_account_code VARCHAR(225) DEFAULT NULL, CHANGE xero_purchase_account_code xero_purchase_account_code VARCHAR(225) DEFAULT NULL, CHANGE additional_addresses additional_addresses JSON DEFAULT NULL COMMENT 'Stores additional addresses in JSON format', CHANGE account_type account_type VARCHAR(0) DEFAULT NULL, CHANGE company_plan_id company_plan_id INT DEFAULT 0 NOT NULL COMMENT 'company plans table it, to check current active plan', CHANGE total_sub_user_allotment total_sub_user_allotment INT DEFAULT 0 NOT NULL, CHANGE total_sub_user_allotment_with_plan total_sub_user_allotment_with_plan INT DEFAULT 0 NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quote_layout_setting CHANGE with_picture with_picture VARCHAR(50) DEFAULT NULL, CHANGE with_product_link with_product_link TINYINT(1) DEFAULT 1, CHANGE layout layout VARCHAR(255) DEFAULT 'default' NOT NULL, CHANGE preview_footer preview_footer LONGTEXT DEFAULT NULL, CHANGE preview_introduction preview_introduction LONGTEXT DEFAULT NULL, CHANGE preview_header_color preview_header_color VARCHAR(100) DEFAULT NULL, CHANGE preview_header_bg_color preview_header_bg_color VARCHAR(100) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quote_line_items CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE quote_id quote_id INT UNSIGNED NOT NULL, CHANGE part_id part_id INT UNSIGNED NOT NULL, CHANGE line_item_index line_item_index INT UNSIGNED NOT NULL, CHANGE details details TEXT NOT NULL, CHANGE costs_json costs_json LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE gst_exempt gst_exempt TINYINT(1) DEFAULT 0 NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer CHANGE parent_id parent_id INT DEFAULT 0 NOT NULL, CHANGE company_id company_id INT DEFAULT 0 NOT NULL, CHANGE company company VARCHAR(225) DEFAULT NULL, CHANGE salutation salutation VARCHAR(100) DEFAULT NULL, CHANGE first_name first_name VARCHAR(350) NOT NULL, CHANGE last_name last_name VARCHAR(350) DEFAULT NULL, CHANGE reference reference VARCHAR(350) DEFAULT NULL, CHANGE address1 address1 VARCHAR(350) DEFAULT NULL, CHANGE address2 address2 VARCHAR(350) DEFAULT NULL, CHANGE country_id country_id INT NOT NULL, CHANGE state_id state_id INT NOT NULL, CHANGE city_id city_id INT NOT NULL, CHANGE post_code post_code VARCHAR(100) NOT NULL, CHANGE phone phone VARCHAR(100) NOT NULL, CHANGE mobile mobile VARCHAR(20) DEFAULT NULL, CHANGE email email VARCHAR(350) NOT NULL, CHANGE profile_image profile_image VARCHAR(350) NOT NULL, CHANGE company_note company_note TEXT DEFAULT NULL, CHANGE address11 address11 VARCHAR(225) DEFAULT NULL, CHANGE address21 address21 VARCHAR(225) DEFAULT NULL, CHANGE post_code1 post_code1 VARCHAR(225) DEFAULT NULL, CHANGE phone1 phone1 VARCHAR(225) DEFAULT NULL, CHANGE company_website company_website VARCHAR(225) DEFAULT NULL, CHANGE xeroKey xeroKey VARCHAR(225) DEFAULT NULL, CHANGE delete_flag delete_flag VARCHAR(0) DEFAULT 'No' NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quotes DROP quotes_email_tracker, CHANGE unique_id unique_id VARCHAR(225) NOT NULL, CHANGE quote_no quote_no INT UNSIGNED NOT NULL, CHANGE quote_no_format quote_no_format VARCHAR(100) NOT NULL, CHANGE quote_company quote_company VARCHAR(225) NOT NULL, CHANGE quote_title quote_title VARCHAR(225) NOT NULL, CHANGE tax tax INT DEFAULT 0 NOT NULL, CHANGE freight freight FLOAT DEFAULT '0.00' NOT NULL, CHANGE total_part total_part FLOAT DEFAULT '0.00' NOT NULL, CHANGE profit_amt profit_amt FLOAT DEFAULT '0.00' NOT NULL, CHANGE cost_amt cost_amt FLOAT DEFAULT '0.00' NOT NULL, CHANGE note note TEXT DEFAULT NULL, CHANGE internal_note internal_note TEXT DEFAULT NULL, CHANGE profit_per profit_per FLOAT DEFAULT '0.00' NOT NULL, CHANGE total_10 total_10 FLOAT DEFAULT '0.00' NOT NULL, CHANGE total_w_tax total_w_tax FLOAT DEFAULT '0.00' NOT NULL, CHANGE xero_api xero_api VARCHAR(0) DEFAULT 'No' NOT NULL, CHANGE invoice_xero_id invoice_xero_id VARCHAR(225) DEFAULT NULL, CHANGE invoice_xero_no invoice_xero_no VARCHAR(225) DEFAULT NULL, CHANGE AmountDue AmountDue VARCHAR(225) DEFAULT NULL, CHANGE delete_flag delete_flag VARCHAR(0) DEFAULT 'N' NOT NULL, CHANGE email_sent email_sent TINYINT(1) DEFAULT 0, CHANGE quote_status_accepted quote_status_accepted VARCHAR(0) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_supplier_link ADD CONSTRAINT pq_product_supplier_link_supplier_id_foreign FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON UPDATE CASCADE ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_supplier_link ADD CONSTRAINT product_supplier_link_company_id_foreign FOREIGN KEY (company_id) REFERENCES company (id) ON UPDATE CASCADE ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_supplier_link ADD CONSTRAINT product_supplier_link_part_id_foreign FOREIGN KEY (part_id) REFERENCES part_database (id) ON UPDATE CASCADE ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX pq_product_supplier_link_supplier_id_foreign ON product_supplier_link (supplier_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX product_supplier_link_part_id_foreign ON product_supplier_link (part_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users_to_do CHANGE todo todo TEXT NOT NULL, CHANGE delete_flag delete_flag VARCHAR(0) DEFAULT 'N' NOT NULL COMMENT 'Y=>''Yes'',N=>''No''', CHANGE is_active is_active VARCHAR(0) DEFAULT 'Y' NOT NULL COMMENT 'Y=>''Yes'',N=>''No'''
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE business_source CHANGE name name VARCHAR(350) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE promo_data_parts CHANGE id id INT NOT NULL COMMENT 'The product ID on PromoData', CHANGE data data LONGTEXT NOT NULL COMMENT 'JSON data from PromoData'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cities CHANGE name name VARCHAR(30) NOT NULL, CHANGE postcode postcode VARCHAR(100) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE clients_feedback CHANGE image image VARCHAR(225) DEFAULT NULL, CHANGE name name VARCHAR(225) NOT NULL, CHANGE place place VARCHAR(225) NOT NULL, CHANGE star star INT DEFAULT 0 NOT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE delete_flag delete_flag VARCHAR(0) DEFAULT 'N' NOT NULL COMMENT 'Y=>''Yes'',N=>''No''', CHANGE is_active is_active VARCHAR(0) DEFAULT 'Y' NOT NULL COMMENT 'Y=>''Yes'',N=>''No'''
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quote_status CHANGE name name VARCHAR(350) NOT NULL, CHANGE order_no order_no INT DEFAULT 0 NOT NULL, CHANGE default_when_add_new_quotes default_when_add_new_quotes INT NOT NULL, CHANGE default_when_creating_job_quote default_when_creating_job_quote INT NOT NULL, CHANGE default_when_job_from_quote_id_completed default_when_job_from_quote_id_completed INT NOT NULL, CHANGE default_when_ordering_p_o_form default_when_ordering_p_o_form INT NOT NULL, CHANGE default_when_invoice_is_complete default_when_invoice_is_complete INT NOT NULL, CHANGE default_when_quote_has_been_sent default_when_quote_has_been_sent INT DEFAULT 0 NOT NULL, CHANGE default_when_quote_not_proceeding default_when_quote_not_proceeding INT DEFAULT 0 NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE states CHANGE name name VARCHAR(30) NOT NULL, CHANGE code code VARCHAR(50) NOT NULL, CHANGE country_id country_id INT DEFAULT 1 NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_tracking CHANGE quote_no quote_no VARCHAR(100) NOT NULL, CHANGE quote_title quote_title VARCHAR(225) NOT NULL, CHANGE quote_company quote_company VARCHAR(225) NOT NULL, CHANGE freight freight FLOAT DEFAULT '0.00' NOT NULL, CHANGE adjust_profit adjust_profit FLOAT DEFAULT '0.00' NOT NULL, CHANGE total_part total_part FLOAT DEFAULT '0.00' NOT NULL, CHANGE profit_amt profit_amt FLOAT DEFAULT '0.00' NOT NULL, CHANGE cost_amt cost_amt FLOAT DEFAULT '0.00' NOT NULL, CHANGE profit_per profit_per FLOAT DEFAULT '0.00' NOT NULL, CHANGE total_10 total_10 FLOAT DEFAULT '0.00' NOT NULL, CHANGE total_w_tax total_w_tax FLOAT DEFAULT '0.00' NOT NULL, CHANGE job_note job_note TEXT DEFAULT NULL, CHANGE job_status job_status INT DEFAULT 0 NOT NULL, CHANGE cust_p_o cust_p_o VARCHAR(100) DEFAULT NULL, CHANGE call_back_complete call_back_complete VARCHAR(0) DEFAULT '0' NOT NULL, CHANGE urgent urgent VARCHAR(0) DEFAULT '0' NOT NULL, CHANGE job_billed job_billed VARCHAR(0) DEFAULT '0' NOT NULL, CHANGE delete_flag delete_flag VARCHAR(0) DEFAULT 'N' NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE newsletter CHANGE email email VARCHAR(225) NOT NULL, CHANGE delete_flag delete_flag VARCHAR(0) DEFAULT 'N' NOT NULL COMMENT 'Y=>''Yes'',N=>''No''', CHANGE is_active is_active VARCHAR(0) DEFAULT 'Y' NOT NULL COMMENT 'Y=>''Yes'',N=>''No'''
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE company_invites CHANGE company_id company_id INT UNSIGNED NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE book_demo CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL COMMENT 'Primary Key', CHANGE cuid cuid VARCHAR(255) DEFAULT NULL, CHANGE full_name full_name VARCHAR(255) NOT NULL COMMENT 'Full Name', CHANGE organization organization VARCHAR(255) NOT NULL COMMENT 'Organization', CHANGE email email VARCHAR(255) NOT NULL COMMENT 'Email', CHANGE phone phone VARCHAR(255) NOT NULL COMMENT 'Phone', CHANGE date date DATETIME NOT NULL COMMENT 'Date', CHANGE platform platform VARCHAR(255) NOT NULL COMMENT 'Platform', CHANGE platform_username platform_username VARCHAR(255) NOT NULL COMMENT 'Platform Username', CHANGE notes notes TEXT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT 'Created At', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT 'Updated At'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subscriptions CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL COMMENT 'The subscription''s ID', CHANGE user_id user_id INT UNSIGNED NOT NULL COMMENT 'The user''s ID', CHANGE company_id company_id INT NOT NULL COMMENT 'The company''s ID', CHANGE stripe_id stripe_id VARCHAR(255) NOT NULL COMMENT 'The subscription''s Stripe ID', CHANGE stripe_price_id stripe_price_id VARCHAR(255) DEFAULT NULL, CHANGE stripe_subscription_item_id stripe_subscription_item_id VARCHAR(255) DEFAULT NULL, CHANGE stripe_status stripe_status VARCHAR(255) NOT NULL COMMENT 'The subscription''s Stripe status', CHANGE quantity quantity INT UNSIGNED NOT NULL COMMENT 'The subscription''s quantity', CHANGE ends_at ends_at DATETIME DEFAULT NULL COMMENT 'The subscription''s end date', CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT 'The subscription''s creation date', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT 'The subscription''s last update date'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subscriptions ADD CONSTRAINT pq_subscriptions_company_id_foreign FOREIGN KEY (company_id) REFERENCES company (id) ON UPDATE CASCADE ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subscriptions ADD CONSTRAINT pq_subscriptions_user_id_foreign FOREIGN KEY (user_id) REFERENCES auth_users (id) ON UPDATE CASCADE ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX pq_subscriptions_company_id_foreign ON subscriptions (company_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX stripe_id ON subscriptions (stripe_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX pq_subscriptions_user_id_foreign ON subscriptions (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE supplier_xero_key CHANGE supplier_id supplier_id INT UNSIGNED NOT NULL, CHANGE company_id company_id INT UNSIGNED NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_status CHANGE job_status_short job_status_short VARCHAR(225) DEFAULT NULL, CHANGE job_status_long job_status_long TEXT DEFAULT NULL, CHANGE job_order job_order INT DEFAULT 0 NOT NULL, CHANGE job_color job_color VARCHAR(225) DEFAULT NULL, CHANGE delete_flag delete_flag VARCHAR(0) DEFAULT 'No' NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATE NOT NULL
        SQL);
    }
}
