<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170112162824 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE zizoo_cms_bundle_map_page_parts (id BIGINT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zizoo_cms_bundle_featured_partners_page_parts (id BIGINT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zizoo_cmsbundle_map_route_location (id BIGINT AUTO_INCREMENT NOT NULL, region_id BIGINT NOT NULL, map_pp_id BIGINT DEFAULT NULL, INDEX IDX_8AD98F6B98260155 (region_id), INDEX IDX_8AD98F6B4D39E400 (map_pp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zizoo_cmsbundle_featured_partner (id BIGINT AUTO_INCREMENT NOT NULL, logo_id BIGINT NOT NULL, featured_partners_pp_id BIGINT DEFAULT NULL, INDEX IDX_B6E64D33F98F144A (logo_id), INDEX IDX_B6E64D337589144A (featured_partners_pp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_map_route_location ADD CONSTRAINT FK_8AD98F6B98260155 FOREIGN KEY (region_id) REFERENCES zizoo_cmsbundle_region (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_map_route_location ADD CONSTRAINT FK_8AD98F6B4D39E400 FOREIGN KEY (map_pp_id) REFERENCES zizoo_cms_bundle_map_page_parts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_featured_partner ADD CONSTRAINT FK_B6E64D33F98F144A FOREIGN KEY (logo_id) REFERENCES kuma_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_featured_partner ADD CONSTRAINT FK_B6E64D337589144A FOREIGN KEY (featured_partners_pp_id) REFERENCES zizoo_cms_bundle_featured_partners_page_parts (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE zizoo_cmsbundle_map_route_location DROP FOREIGN KEY FK_8AD98F6B4D39E400');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_featured_partner DROP FOREIGN KEY FK_B6E64D337589144A');
        $this->addSql('DROP TABLE zizoo_cms_bundle_map_page_parts');
        $this->addSql('DROP TABLE zizoo_cms_bundle_featured_partners_page_parts');
        $this->addSql('DROP TABLE zizoo_cmsbundle_map_route_location');
        $this->addSql('DROP TABLE zizoo_cmsbundle_featured_partner');
    }
}
