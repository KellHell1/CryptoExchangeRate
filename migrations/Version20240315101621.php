<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240315101621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rate_history (id INT AUTO_INCREMENT NOT NULL, currency_pair_id INT NOT NULL, rate DOUBLE PRECISION NOT NULL, datetime DATETIME NOT NULL, INDEX IDX_FD783FAAA311484C (currency_pair_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rate_history ADD CONSTRAINT FK_FD783FAAA311484C FOREIGN KEY (currency_pair_id) REFERENCES currency_pair (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rate_history DROP FOREIGN KEY FK_FD783FAAA311484C');
        $this->addSql('DROP TABLE rate_history');
    }
}
