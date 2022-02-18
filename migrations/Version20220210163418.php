<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220210163418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE applied_sanction (id INT AUTO_INCREMENT NOT NULL, meeting_id INT NOT NULL, member_id INT NOT NULL, sanction_type VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_EA31558767433D9C (meeting_id), INDEX IDX_EA3155877597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assistance (id INT AUTO_INCREMENT NOT NULL, beneficiary_id INT NOT NULL, distributed_date DATE NOT NULL, amount DOUBLE PRECISION NOT NULL, reason VARCHAR(255) NOT NULL, INDEX IDX_1B4F85F2ECCAAFA0 (beneficiary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meeting_lot_distribution (id INT AUTO_INCREMENT NOT NULL, meeting_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, beneficiaires VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C6C1049267433D9C (meeting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE applied_sanction ADD CONSTRAINT FK_EA31558767433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id)');
        $this->addSql('ALTER TABLE applied_sanction ADD CONSTRAINT FK_EA3155877597D3FE FOREIGN KEY (member_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE assistance ADD CONSTRAINT FK_1B4F85F2ECCAAFA0 FOREIGN KEY (beneficiary_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE meeting_lot_distribution ADD CONSTRAINT FK_C6C1049267433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE applied_sanction');
        $this->addSql('DROP TABLE assistance');
        $this->addSql('DROP TABLE meeting_lot_distribution');
    }
}
