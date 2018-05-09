<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180508164046 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('
            SET FOREIGN_KEY_CHECKS=0;
            
            DROP TABLE IF EXISTS `time`;
            CREATE TABLE `time` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int(10) unsigned NOT NULL,
              `date_finished` datetime NOT NULL,
              `time_tracked` bigint(20) NOT NULL COMMENT \'Time tracked in seconds\',
              `time_tracked_formatted` time NOT NULL COMMENT \'Time tracked in time format hh:ii:ss\',
              `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
              `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `time_user_id_foreign` (`user_id`),
              CONSTRAINT `time_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            
            DROP TABLE IF EXISTS `users`;
            CREATE TABLE `users` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
              `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
              `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
              `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              UNIQUE KEY `users_email_unique` (`email`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            -- ----------------------------
            -- Records of users, test use account
            -- ----------------------------
            INSERT INTO `users` VALUES (\'1\', \'admin\', \'admin@gmail.com\', \'$2y$10$S4VLfWm7gRSHcgPXOwqH/eD7W1WvrcPk0CnV/96Rdee4WMFrY84om\', null, \'2018-05-08 18:22:15\');
            
        ');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('
            DROP TABLE IF EXISTS `time`;
            DROP TABLE IF EXISTS `users`;
        ');
    }
}