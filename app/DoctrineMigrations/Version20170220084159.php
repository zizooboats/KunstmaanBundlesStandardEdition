<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170220084159 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE zizoo_cmsbundle_testimonial (id INT AUTO_INCREMENT NOT NULL, image_id BIGINT DEFAULT NULL, testimonial_pp_id BIGINT NOT NULL, content LONGTEXT NOT NULL, image_alt_text VARCHAR(255) DEFAULT NULL, INDEX IDX_29D060E33DA5256D (image_id), INDEX IDX_29D060E31C92786E (testimonial_pp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zizoo_cms_bundle_testimonials_page_parts (id BIGINT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_testimonial ADD CONSTRAINT FK_29D060E33DA5256D FOREIGN KEY (image_id) REFERENCES kuma_media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_testimonial ADD CONSTRAINT FK_29D060E31C92786E FOREIGN KEY (testimonial_pp_id) REFERENCES zizoo_cms_bundle_testimonials_page_parts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_with_email_page_parts DROP FOREIGN KEY FK_FFDE2583DA5256D');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_with_email_page_parts DROP FOREIGN KEY FK_FFDE258EA9FDD75');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_with_email_page_parts ADD CONSTRAINT FK_FFDE2583DA5256D FOREIGN KEY (image_id) REFERENCES kuma_media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_with_email_page_parts ADD CONSTRAINT FK_FFDE258EA9FDD75 FOREIGN KEY (media_id) REFERENCES kuma_media (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE zizoo_cmsbundle_testimonial DROP FOREIGN KEY FK_29D060E31C92786E');
        $this->addSql('DROP TABLE zizoo_cmsbundle_testimonial');
        $this->addSql('DROP TABLE zizoo_cms_bundle_testimonials_page_parts');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_with_email_page_parts DROP FOREIGN KEY FK_FFDE258EA9FDD75');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_with_email_page_parts DROP FOREIGN KEY FK_FFDE2583DA5256D');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_with_email_page_parts ADD CONSTRAINT FK_FFDE258EA9FDD75 FOREIGN KEY (media_id) REFERENCES kuma_media (id)');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_download_with_email_page_parts ADD CONSTRAINT FK_FFDE2583DA5256D FOREIGN KEY (image_id) REFERENCES kuma_media (id)');
    }
}
