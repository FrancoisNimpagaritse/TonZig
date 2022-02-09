<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208140903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caisse_sociale (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, meeting_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, note VARCHAR(255) DEFAULT NULL, INDEX IDX_A6CE7BD97597D3FE (member_id), INDEX IDX_A6CE7BD967433D9C (meeting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cotisation (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, meeting_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, note VARCHAR(255) DEFAULT NULL, INDEX IDX_AE64D2ED7597D3FE (member_id), INDEX IDX_AE64D2ED67433D9C (meeting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meeting_applied_sanction (id INT AUTO_INCREMENT NOT NULL, meeting_id INT NOT NULL, member_id INT NOT NULL, sanction_type VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_4A3AED8567433D9C (meeting_id), INDEX IDX_4A3AED857597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mouvement_caisse (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, transaction_date DATETIME NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_C8E3DDFE9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE caisse_sociale ADD CONSTRAINT FK_A6CE7BD97597D3FE FOREIGN KEY (member_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE caisse_sociale ADD CONSTRAINT FK_A6CE7BD967433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id)');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED7597D3FE FOREIGN KEY (member_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED67433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id)');
        $this->addSql('ALTER TABLE meeting_applied_sanction ADD CONSTRAINT FK_4A3AED8567433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id)');
        $this->addSql('ALTER TABLE meeting_applied_sanction ADD CONSTRAINT FK_4A3AED857597D3FE FOREIGN KEY (member_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mouvement_caisse ADD CONSTRAINT FK_C8E3DDFE9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mouvement_caisse DROP FOREIGN KEY FK_C8E3DDFE9B6B5FBA');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE caisse_sociale');
        $this->addSql('DROP TABLE cotisation');
        $this->addSql('DROP TABLE meeting_applied_sanction');
        $this->addSql('DROP TABLE mouvement_caisse');
    }
}
