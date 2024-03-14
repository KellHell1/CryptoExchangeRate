<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314154322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE currency_pare (id INT AUTO_INCREMENT NOT NULL, currency_from_id INT NOT NULL, currency_to_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_A9081340A56723E4 (currency_from_id), INDEX IDX_A908134067D74803 (currency_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE currency_pare ADD CONSTRAINT FK_A9081340A56723E4 FOREIGN KEY (currency_from_id) REFERENCES currency (id)');
        $this->addSql('ALTER TABLE currency_pare ADD CONSTRAINT FK_A908134067D74803 FOREIGN KEY (currency_to_id) REFERENCES currency (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE currency_pare DROP FOREIGN KEY FK_A9081340A56723E4');
        $this->addSql('ALTER TABLE currency_pare DROP FOREIGN KEY FK_A908134067D74803');
        $this->addSql('DROP TABLE currency_pare');
    }
}
