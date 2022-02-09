<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220209173858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meeting ADD host_one_id INT DEFAULT NULL, ADD host_two_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E139DF8D0FF8 FOREIGN KEY (host_one_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E139B4D1E837 FOREIGN KEY (host_two_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F515E139DF8D0FF8 ON meeting (host_one_id)');
        $this->addSql('CREATE INDEX IDX_F515E139B4D1E837 ON meeting (host_two_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E139DF8D0FF8');
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E139B4D1E837');
        $this->addSql('DROP INDEX IDX_F515E139DF8D0FF8 ON meeting');
        $this->addSql('DROP INDEX IDX_F515E139B4D1E837 ON meeting');
        $this->addSql('ALTER TABLE meeting DROP host_one_id, DROP host_two_id');
    }
}
