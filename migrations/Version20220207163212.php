<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207163212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE meeting (id INT AUTO_INCREMENT NOT NULL, round_id INT NOT NULL, meeting_at DATE NOT NULL, status VARCHAR(255) NOT NULL, remaining_meetings INT NOT NULL, INDEX IDX_F515E139A6005CA0 (round_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE round (id INT AUTO_INCREMENT NOT NULL, round_number INT NOT NULL, round_start_date DATE NOT NULL, monthly_cotisation DOUBLE PRECISION NOT NULL, monthly_caisse_sociale DOUBLE PRECISION NOT NULL, loan_months_duration INT NOT NULL, loan_monthly_interest_percentage DOUBLE PRECISION NOT NULL, loan_principal_grace_period INT NOT NULL, loan_interest_grace_period INT NOT NULL, principal_late_penality_percentage DOUBLE PRECISION NOT NULL, interest_late_penality_percentage DOUBLE PRECISION NOT NULL, meeting_late_penality_amount DOUBLE PRECISION NOT NULL, meeting_absence_penality_amount DOUBLE PRECISION NOT NULL, meeting_frequency VARCHAR(255) NOT NULL, meeting_start_hour VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tontine (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATE NOT NULL, address_siege_social VARCHAR(255) NOT NULL, currency VARCHAR(255) NOT NULL, slogan VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E139A6005CA0 FOREIGN KEY (round_id) REFERENCES round (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E139A6005CA0');
        $this->addSql('DROP TABLE meeting');
        $this->addSql('DROP TABLE round');
        $this->addSql('DROP TABLE tontine');
    }
}
