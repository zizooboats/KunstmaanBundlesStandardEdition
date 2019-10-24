<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161220181636 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_page_parts ADD thumbnail_media_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_page_parts ADD CONSTRAINT FK_24889F0CC364B086 FOREIGN KEY (thumbnail_media_id) REFERENCES kuma_media (id)');
        $this->addSql('CREATE INDEX IDX_24889F0CC364B086 ON zizoo_cms_bundle_download_page_parts (thumbnail_media_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_page_parts DROP FOREIGN KEY FK_24889F0CC364B086');
        $this->addSql('DROP INDEX IDX_24889F0CC364B086 ON zizoo_cms_bundle_download_page_parts');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_page_parts DROP thumbnail_media_id');
    }
}
