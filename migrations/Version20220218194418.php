<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220218194418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loan_due ADD principal DOUBLE PRECISION NOT NULL, ADD interest DOUBLE PRECISION NOT NULL, ADD penality DOUBLE PRECISION NOT NULL, DROP principal_due, DROP interest_due, DROP penality_due');
        $this->addSql('ALTER TABLE loan_payment ADD principal DOUBLE PRECISION NOT NULL, ADD interest DOUBLE PRECISION NOT NULL, ADD penality DOUBLE PRECISION NOT NULL, DROP principal_paid, DROP interest_paid, DROP penality_paid');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loan_due ADD principal_due DOUBLE PRECISION NOT NULL, ADD interest_due DOUBLE PRECISION NOT NULL, ADD penality_due DOUBLE PRECISION NOT NULL, DROP principal, DROP interest, DROP penality');
        $this->addSql('ALTER TABLE loan_payment ADD principal_paid DOUBLE PRECISION NOT NULL, ADD interest_paid DOUBLE PRECISION NOT NULL, ADD penality_paid DOUBLE PRECISION NOT NULL, DROP principal, DROP interest, DROP penality');
    }
}
