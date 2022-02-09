<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220209191231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE loan_due (id INT AUTO_INCREMENT NOT NULL, loan_id INT NOT NULL, due_date DATE NOT NULL, principal_due DOUBLE PRECISION NOT NULL, interest_due DOUBLE PRECISION NOT NULL, penality_due DOUBLE PRECISION NOT NULL, INDEX IDX_C912272ECE73868F (loan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loan_payment (id INT AUTO_INCREMENT NOT NULL, loan_id INT NOT NULL, paid_date DATETIME NOT NULL, principal_paid DOUBLE PRECISION NOT NULL, interest_paid DOUBLE PRECISION NOT NULL, penality_paid DOUBLE PRECISION NOT NULL, INDEX IDX_43670A79CE73868F (loan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE loan_due ADD CONSTRAINT FK_C912272ECE73868F FOREIGN KEY (loan_id) REFERENCES loan (id)');
        $this->addSql('ALTER TABLE loan_payment ADD CONSTRAINT FK_43670A79CE73868F FOREIGN KEY (loan_id) REFERENCES loan (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE loan_due');
        $this->addSql('DROP TABLE loan_payment');
    }
}
