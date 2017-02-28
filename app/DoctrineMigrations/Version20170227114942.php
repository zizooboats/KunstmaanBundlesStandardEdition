<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170227114942 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE zizoo_cmsbundle_instagram_media (id INT AUTO_INCREMENT NOT NULL, instagram_id VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, thumbnail_url VARCHAR(1000) NOT NULL, small_image_url VARCHAR(1000) NOT NULL, standard_image_url VARCHAR(1000) NOT NULL, created_at DATETIME NOT NULL, inserted_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8A3A39A29C19920F (instagram_id), UNIQUE INDEX UNIQ_8A3A39A236AC99F1 (link), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_gallery_page_part_media DROP INDEX UNIQ_23293385EA9FDD75, ADD INDEX IDX_23293385EA9FDD75 (media_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE zizoo_cmsbundle_instagram_media');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_gallery_page_part_media DROP INDEX IDX_23293385EA9FDD75, ADD UNIQUE INDEX UNIQ_23293385EA9FDD75 (media_id)');
    }
}
