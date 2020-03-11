<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200311093111 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(
            'CREATE TABLE `events` (
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `aggregate_id` bigint(20) NOT NULL,
            `event_name` varchar(100) COLLATE utf8_bin NOT NULL,
            `payload` json NOT NULL,
            `created_at` datetime(6) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `aggregate_idx` (`aggregate_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
        );

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE IF EXISTS `events`');
    }
}
