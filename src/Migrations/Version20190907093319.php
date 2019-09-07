<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190907093319 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, type VARCHAR(50) NOT NULL, address_label VARCHAR(150) NOT NULL, address VARCHAR(250) NOT NULL, postal_code VARCHAR(5) NOT NULL, city VARCHAR(250) NOT NULL, closed TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(20) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense_event (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, user_id INT NOT NULL, nb_km_go INT DEFAULT NULL, nb_km_return INT DEFAULT NULL, toll_go DOUBLE PRECISION DEFAULT NULL, toll_return DOUBLE PRECISION DEFAULT NULL, refund_km_go DOUBLE PRECISION DEFAULT NULL, refund_km_return DOUBLE PRECISION DEFAULT NULL, refund_toll_go DOUBLE PRECISION DEFAULT NULL, refund_toll_return DOUBLE PRECISION DEFAULT NULL, INDEX IDX_98A6AD9D71F7E88B (event_id), INDEX IDX_98A6AD9DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expense_event ADD CONSTRAINT FK_98A6AD9D71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE expense_event ADD CONSTRAINT FK_98A6AD9DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE expense_event DROP FOREIGN KEY FK_98A6AD9D71F7E88B');
        $this->addSql('ALTER TABLE expense_event DROP FOREIGN KEY FK_98A6AD9DA76ED395');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE expense_event');
    }
}
