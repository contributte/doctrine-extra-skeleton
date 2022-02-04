<?php declare(strict_types = 1);

namespace DB\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210818092657 extends AbstractMigration
{
	public function getDescription(): string
	{
		return '';
	}

	public function up(Schema $schema): void
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

		$this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE SEQUENCE article_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE SEQUENCE book_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE SEQUENCE ext_log_entries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE TABLE article (id INT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(128) NOT NULL, slug VARCHAR(128) NOT NULL, content TEXT NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, content_changed TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deletedAt TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
		$this->addSql('CREATE INDEX IDX_23A0E6612469DE2 ON article (category_id)');
		$this->addSql('CREATE TABLE article_category (id INT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, title VARCHAR(64) NOT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE INDEX IDX_53A4EDAAA977936C ON article_category (tree_root)');
		$this->addSql('CREATE INDEX IDX_53A4EDAA727ACA70 ON article_category (parent_id)');
		$this->addSql('CREATE TABLE book (id INT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, already_read BOOLEAN NOT NULL, created_at VARCHAR(255) NOT NULL, updated_at VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE INDEX IDX_CBE5A33112469DE2 ON book (category_id)');
		$this->addSql('CREATE TABLE category (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE TABLE ext_log_entries (id INT NOT NULL, action VARCHAR(8) NOT NULL, logged_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(191) NOT NULL, version INT NOT NULL, data TEXT DEFAULT NULL, username VARCHAR(191) DEFAULT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class)');
		$this->addSql('CREATE INDEX log_date_lookup_idx ON ext_log_entries (logged_at)');
		$this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username)');
		$this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class, version)');
		$this->addSql('COMMENT ON COLUMN ext_log_entries.data IS \'(DC2Type:array)\'');
		$this->addSql('CREATE TABLE ext_translations (id SERIAL NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(191) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE INDEX translations_lookup_idx ON ext_translations (locale, object_class, foreign_key)');
		$this->addSql('CREATE UNIQUE INDEX lookup_unique_idx ON ext_translations (locale, object_class, field, foreign_key)');
		$this->addSql('CREATE TABLE tag (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE TABLE tag_book (tag_id INT NOT NULL, book_id INT NOT NULL, PRIMARY KEY(tag_id, book_id))');
		$this->addSql('CREATE INDEX IDX_25EA1C87BAD26311 ON tag_book (tag_id)');
		$this->addSql('CREATE INDEX IDX_25EA1C8716A2B381 ON tag_book (book_id)');
		$this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES article_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE article_category ADD CONSTRAINT FK_53A4EDAAA977936C FOREIGN KEY (tree_root) REFERENCES article_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE article_category ADD CONSTRAINT FK_53A4EDAA727ACA70 FOREIGN KEY (parent_id) REFERENCES article_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE tag_book ADD CONSTRAINT FK_25EA1C87BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE tag_book ADD CONSTRAINT FK_25EA1C8716A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('CREATE INDEX general_translations_lookup_idx ON ext_translations (object_class, foreign_key);');
	}

	public function down(Schema $schema): void
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

		$this->addSql('CREATE SCHEMA public');
		$this->addSql('ALTER TABLE article DROP CONSTRAINT FK_23A0E6612469DE2');
		$this->addSql('ALTER TABLE article_category DROP CONSTRAINT FK_53A4EDAAA977936C');
		$this->addSql('ALTER TABLE article_category DROP CONSTRAINT FK_53A4EDAA727ACA70');
		$this->addSql('ALTER TABLE tag_book DROP CONSTRAINT FK_25EA1C8716A2B381');
		$this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A33112469DE2');
		$this->addSql('ALTER TABLE tag_book DROP CONSTRAINT FK_25EA1C87BAD26311');
		$this->addSql('DROP SEQUENCE article_id_seq CASCADE');
		$this->addSql('DROP SEQUENCE article_category_id_seq CASCADE');
		$this->addSql('DROP SEQUENCE book_id_seq CASCADE');
		$this->addSql('DROP SEQUENCE category_id_seq CASCADE');
		$this->addSql('DROP SEQUENCE ext_log_entries_id_seq CASCADE');
		$this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
		$this->addSql('DROP TABLE article');
		$this->addSql('DROP TABLE article_category');
		$this->addSql('DROP TABLE book');
		$this->addSql('DROP TABLE category');
		$this->addSql('DROP TABLE ext_log_entries');
		$this->addSql('DROP TABLE ext_translations');
		$this->addSql('DROP TABLE tag');
		$this->addSql('DROP TABLE tag_book');
	}
}
