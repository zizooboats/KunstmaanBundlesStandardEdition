<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170215083303 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE zizoo_cms_bundle_download_with_email_page_parts (id BIGINT AUTO_INCREMENT NOT NULL, media_id BIGINT NOT NULL, image_id BIGINT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, button_text VARCHAR(100) DEFAULT NULL, success_msg VARCHAR(255) DEFAULT NULL, overlay_text VARCHAR(255) DEFAULT NULL, INDEX IDX_FFDE258EA9FDD75 (media_id), INDEX IDX_FFDE2583DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zizoo_cms_bundle_download_email (id INT AUTO_INCREMENT NOT NULL, downloaded_media_id BIGINT NOT NULL, email VARCHAR(255) NOT NULL, downloaded_at DATETIME NOT NULL, INDEX IDX_EC8E0AB6EAD76A22 (downloaded_media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_with_email_page_parts ADD CONSTRAINT FK_FFDE258EA9FDD75 FOREIGN KEY (media_id) REFERENCES kuma_media (id)');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_with_email_page_parts ADD CONSTRAINT FK_FFDE2583DA5256D FOREIGN KEY (image_id) REFERENCES kuma_media (id)');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_email ADD CONSTRAINT FK_EC8E0AB6EAD76A22 FOREIGN KEY (downloaded_media_id) REFERENCES kuma_media (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE zizoo_cms_bundle_download_with_email_page_parts');
        $this->addSql('DROP TABLE zizoo_cms_bundle_download_email');
    }
}
