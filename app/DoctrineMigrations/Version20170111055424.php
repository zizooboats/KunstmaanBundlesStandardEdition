<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170111055424 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE zizoo_cms_bundle_map_page_parts (id BIGINT AUTO_INCREMENT NOT NULL, map_route_id BIGINT DEFAULT NULL, INDEX IDX_3ED8E758561E82C1 (map_route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zizoo_cmsbundle_map_route (id BIGINT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zizoo_cmsbundle_map_route_map_route_location (map_route_id BIGINT NOT NULL, map_route_location_id BIGINT NOT NULL, INDEX IDX_55D0E7D3561E82C1 (map_route_id), UNIQUE INDEX UNIQ_55D0E7D32BC211AE (map_route_location_id), PRIMARY KEY(map_route_id, map_route_location_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zizoo_cmsbundle_map_route_location (id BIGINT AUTO_INCREMENT NOT NULL, region_id BIGINT NOT NULL, day_number INT NOT NULL, INDEX IDX_8AD98F6B98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE zizoo_cms_bundle_map_page_parts ADD CONSTRAINT FK_3ED8E758561E82C1 FOREIGN KEY (map_route_id) REFERENCES zizoo_cmsbundle_map_route (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_map_route_map_route_location ADD CONSTRAINT FK_55D0E7D3561E82C1 FOREIGN KEY (map_route_id) REFERENCES zizoo_cmsbundle_map_route (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_map_route_map_route_location ADD CONSTRAINT FK_55D0E7D32BC211AE FOREIGN KEY (map_route_location_id) REFERENCES zizoo_cmsbundle_map_route_location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_map_route_location ADD CONSTRAINT FK_8AD98F6B98260155 FOREIGN KEY (region_id) REFERENCES zizoo_cmsbundle_region (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE zizoo_cms_bundle_map_page_parts DROP FOREIGN KEY FK_3ED8E758561E82C1');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_map_route_map_route_location DROP FOREIGN KEY FK_55D0E7D3561E82C1');
        $this->addSql('ALTER TABLE zizoo_cmsbundle_map_route_map_route_location DROP FOREIGN KEY FK_55D0E7D32BC211AE');
        $this->addSql('DROP TABLE zizoo_cms_bundle_map_page_parts');
        $this->addSql('DROP TABLE zizoo_cmsbundle_map_route');
        $this->addSql('DROP TABLE zizoo_cmsbundle_map_route_map_route_location');
        $this->addSql('DROP TABLE zizoo_cmsbundle_map_route_location');
    }
}
