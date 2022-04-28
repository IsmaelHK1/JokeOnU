<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428144510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE joke (id INT AUTO_INCREMENT NOT NULL, likes INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, joke_id INT NOT NULL, INDEX IDX_AC6340B3A76ED395 (user_id), INDEX IDX_AC6340B330122C15 (joke_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B330122C15 FOREIGN KEY (joke_id) REFERENCES joke (id)');
        $this->addSql('ALTER TABLE user ADD joke_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64930122C15 FOREIGN KEY (joke_id) REFERENCES joke (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64930122C15 ON user (joke_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B330122C15');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64930122C15');
        $this->addSql('DROP TABLE joke');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP INDEX UNIQ_8D93D64930122C15 ON user');
        $this->addSql('ALTER TABLE user DROP joke_id');
    }
}
