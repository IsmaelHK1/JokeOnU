<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426125800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `like` ADD user_id INT NOT NULL, ADD joke_id INT NOT NULL');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B330122C15 FOREIGN KEY (joke_id) REFERENCES joke (id)');
        $this->addSql('CREATE INDEX IDX_AC6340B3A76ED395 ON `like` (user_id)');
        $this->addSql('CREATE INDEX IDX_AC6340B330122C15 ON `like` (joke_id)');
        $this->addSql('ALTER TABLE user ADD joke_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64930122C15 FOREIGN KEY (joke_id) REFERENCES joke (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64930122C15 ON user (joke_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3A76ED395');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B330122C15');
        $this->addSql('DROP INDEX IDX_AC6340B3A76ED395 ON `like`');
        $this->addSql('DROP INDEX IDX_AC6340B330122C15 ON `like`');
        $this->addSql('ALTER TABLE `like` DROP user_id, DROP joke_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64930122C15');
        $this->addSql('DROP INDEX UNIQ_8D93D64930122C15 ON user');
        $this->addSql('ALTER TABLE user DROP joke_id');
    }
}
