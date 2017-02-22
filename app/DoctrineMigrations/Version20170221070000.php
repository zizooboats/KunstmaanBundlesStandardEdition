<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170221070000 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE zizoo_cms_bundle_gallery_page_parts (id BIGINT AUTO_INCREMENT NOT NULL, gallery_alt_text LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zizoo_cms_bundle_gallery_page_part_media (gallery_page_part_id BIGINT NOT NULL, media_id BIGINT NOT NULL, INDEX IDX_232933852A63AA99 (gallery_page_part_id), UNIQUE INDEX UNIQ_23293385EA9FDD75 (media_id), PRIMARY KEY(gallery_page_part_id, media_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_gallery_page_part_media ADD CONSTRAINT FK_232933852A63AA99 FOREIGN KEY (gallery_page_part_id) REFERENCES zizoo_cms_bundle_gallery_page_parts (id)');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_gallery_page_part_media ADD CONSTRAINT FK_23293385EA9FDD75 FOREIGN KEY (media_id) REFERENCES kuma_media (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE zizoo_cms_bundle_gallery_page_part_media DROP FOREIGN KEY FK_232933852A63AA99');
        $this->addSql('DROP TABLE zizoo_cms_bundle_gallery_page_parts');
        $this->addSql('DROP TABLE zizoo_cms_bundle_gallery_page_part_media');
    }
}
