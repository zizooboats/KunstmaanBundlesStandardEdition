<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170115123147 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE zizoo_cms_bundle_icon_bullet_point_page_parts (id BIGINT AUTO_INCREMENT NOT NULL, alignment CHAR(1) DEFAULT \'h\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zizoo_cmsbundle_icon_bullet_point (id BIGINT AUTO_INCREMENT NOT NULL, icon_id BIGINT NOT NULL, icon_bullet_point_pp_id BIGINT NOT NULL, circle_color VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_C1933E1554B9D732 (icon_id), INDEX IDX_C1933E1543F50297 (icon_bullet_point_pp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_icon_bullet_point ADD CONSTRAINT FK_C1933E1554B9D732 FOREIGN KEY (icon_id) REFERENCES kuma_media (id)');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_icon_bullet_point ADD CONSTRAINT FK_C1933E1543F50297 FOREIGN KEY (icon_bullet_point_pp_id) REFERENCES zizoo_cms_bundle_icon_bullet_point_page_parts (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE zizoo_cmsbundle_icon_bullet_point DROP FOREIGN KEY FK_C1933E1543F50297');
        $this->addSql('DROP TABLE zizoo_cms_bundle_icon_bullet_point_page_parts');
        $this->addSql('DROP TABLE zizoo_cmsbundle_icon_bullet_point');
    }
}
