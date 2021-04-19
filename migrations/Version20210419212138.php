<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419212138 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE expense_event CHANGE refund_km_go refund_km_go DOUBLE PRECISION DEFAULT \'0\' NOT NULL, CHANGE refund_km_return refund_km_return DOUBLE PRECISION DEFAULT \'0\' NOT NULL, CHANGE refund_toll_go refund_toll_go DOUBLE PRECISION DEFAULT \'0\' NOT NULL, CHANGE refund_toll_return refund_toll_return DOUBLE PRECISION DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE expense_event CHANGE refund_km_go refund_km_go DOUBLE PRECISION DEFAULT NULL, CHANGE refund_km_return refund_km_return DOUBLE PRECISION DEFAULT NULL, CHANGE refund_toll_go refund_toll_go DOUBLE PRECISION DEFAULT NULL, CHANGE refund_toll_return refund_toll_return DOUBLE PRECISION DEFAULT NULL');
    }

    public function preUp(Schema $schema): void {
        $this->connection->executeQuery('UPDATE expense_event SET refund_km_go = 0 WHERE refund_km_go IS NULL');
        $this->connection->executeQuery('UPDATE expense_event SET refund_km_return = 0 WHERE refund_km_go IS NULL');
        $this->connection->executeQuery('UPDATE expense_event SET refund_toll_go = 0 WHERE refund_toll_go IS NULL');
        $this->connection->executeQuery('UPDATE expense_event SET refund_toll_return = 0 WHERE refund_toll_return IS NULL');
    }
}
