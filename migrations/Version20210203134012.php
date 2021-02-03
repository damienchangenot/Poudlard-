<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203134012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE director ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE director ADD CONSTRAINT FK_1E90D3F0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1E90D3F0A76ED395 ON director (user_id)');
        $this->addSql('ALTER TABLE teacher ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B0F6A6D5A76ED395 ON teacher (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE director DROP FOREIGN KEY FK_1E90D3F0A76ED395');
        $this->addSql('DROP INDEX UNIQ_1E90D3F0A76ED395 ON director');
        $this->addSql('ALTER TABLE director DROP user_id');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D5A76ED395');
        $this->addSql('DROP INDEX UNIQ_B0F6A6D5A76ED395 ON teacher');
        $this->addSql('ALTER TABLE teacher DROP user_id');
    }
}
