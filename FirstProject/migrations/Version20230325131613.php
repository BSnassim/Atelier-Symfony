<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230325131613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE student_club (student_nsc INT NOT NULL, club_ref INT NOT NULL, INDEX IDX_87CD43AAFBDC2049 (student_nsc), INDEX IDX_87CD43AAB70D1EBA (club_ref), PRIMARY KEY(student_nsc, club_ref)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student_club ADD CONSTRAINT FK_87CD43AAFBDC2049 FOREIGN KEY (student_nsc) REFERENCES student (nsc)');
        $this->addSql('ALTER TABLE student_club ADD CONSTRAINT FK_87CD43AAB70D1EBA FOREIGN KEY (club_ref) REFERENCES club (ref)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_club DROP FOREIGN KEY FK_87CD43AAFBDC2049');
        $this->addSql('ALTER TABLE student_club DROP FOREIGN KEY FK_87CD43AAB70D1EBA');
        $this->addSql('DROP TABLE student_club');
    }
}
