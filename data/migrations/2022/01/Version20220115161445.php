<?php

declare(strict_types=1);

namespace MyProject\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220115161445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add sample feature flags';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
INSERT INTO `pheature_toggles` (
    feature_id, name, enabled, strategies, created_at
) VALUES
('feature','feature',0,'[]', NOW()),
('show_contact_info','show_contact_info',1,'[{\"segments\": [{\"criteria\": {\"location\": \"barcelona\"}, \"segment_id\": \"barcelona\", \"segment_type\": \"strict_matching_segment\"}], \"strategy_id\": \"enable_for_location\", \"strategy_type\": \"enable_by_matching_segment\"}]', NOW()),
('show_home_dynamic_catalog','show_home_dynamic_catalog',1,'[{\"segments\": [{\"criteria\": [{\"role\": \"developer\"}], \"segment_id\": \"developer_role\", \"segment_type\": \"strict_matching_segment\"}], \"strategy_id\": \"rollout_for_developers\", \"strategy_type\": \"enable_by_matching_segment\"}]', NOW());
;
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $sql = <<<SQL
DELETE FROM `pheature_toggles`
WHERE
    feature_id IN ('feature', 'show_contact_info', 'show_home_dynamic_catalog')
SQL;
        $this->addSql($sql);
    }
}
