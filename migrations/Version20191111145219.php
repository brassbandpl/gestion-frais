<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191111145219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE period (id INT AUTO_INCREMENT NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $eventMin = $this->connection->fetchAssociative('SELECT min(date) as date FROM event');
        $eventMax = $this->connection->fetchAssociative('SELECT max(date) as date FROM event');
        if ($eventMin['date'] !== null && $eventMax['date'] !== null) {
            $this->addSql('INSERT INTO period (date_start, date_end) VALUES (\''.$eventMin['date'].'\', \''.$eventMax['date'].'\')');
            $this->addSql('ALTER TABLE event ADD period_id INT NULL');
            $this->addSql('UPDATE event SET period_id = 1');
            $this->addSql('ALTER TABLE event MODIFY period_id INT NOT NULL');
        } else {
            $this->addSql('ALTER TABLE event ADD period_id INT NOT NULL');
        }
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7EC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7EC8B7ADE ON event (period_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7EC8B7ADE');
        $this->addSql('DROP TABLE period');
        $this->addSql('DROP INDEX IDX_3BAE0AA7EC8B7ADE ON event');
        $this->addSql('ALTER TABLE event DROP period_id');
    }
}
