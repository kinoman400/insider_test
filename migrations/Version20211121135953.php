<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211121135953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE football_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE football_match (id INT AUTO_INCREMENT NOT NULL, home_team_id INT NOT NULL, guest_team_id INT NOT NULL, home_result INT NOT NULL, guest_result INT NOT NULL, week INT NOT NULL, INDEX IDX_8CE33ACE9C4C13F6 (home_team_id), INDEX IDX_8CE33ACE69A91CE2 (guest_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE football_team (id INT AUTO_INCREMENT NOT NULL, football_group_id INT NOT NULL, name VARCHAR(255) NOT NULL, power INT NOT NULL, INDEX IDX_C53936CA353066DC (football_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE football_match ADD CONSTRAINT FK_8CE33ACE9C4C13F6 FOREIGN KEY (home_team_id) REFERENCES football_team (id)');
        $this->addSql('ALTER TABLE football_match ADD CONSTRAINT FK_8CE33ACE69A91CE2 FOREIGN KEY (guest_team_id) REFERENCES football_team (id)');
        $this->addSql('ALTER TABLE football_team ADD CONSTRAINT FK_C53936CA353066DC FOREIGN KEY (football_group_id) REFERENCES football_group (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE football_team DROP FOREIGN KEY FK_C53936CA353066DC');
        $this->addSql('ALTER TABLE football_match DROP FOREIGN KEY FK_8CE33ACE9C4C13F6');
        $this->addSql('ALTER TABLE football_match DROP FOREIGN KEY FK_8CE33ACE69A91CE2');
        $this->addSql('DROP TABLE football_group');
        $this->addSql('DROP TABLE football_match');
        $this->addSql('DROP TABLE football_team');
    }
}
