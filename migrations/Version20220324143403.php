<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324143403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F296CD8AE');
        $this->addSql('DROP INDEX IDX_C4E0A61F296CD8AE ON team');
        $this->addSql('ALTER TABLE team CHANGE team_id team_child_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F65201E65 FOREIGN KEY (team_child_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61F65201E65 ON team (team_child_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fact CHANGE name_fact name_fact VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description_fact description_fact LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE milestone CHANGE name_milestone name_milestone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE portfolio CHANGE name_portfolio name_portfolio VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE project CHANGE name_project name_project VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description_project description_project LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE code_project code_project VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE risk CHANGE name_risk name_risk VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE severity_risk severity_risk VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE status CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE slug slug VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE color_status color_status VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F65201E65');
        $this->addSql('DROP INDEX IDX_C4E0A61F65201E65 ON team');
        $this->addSql('ALTER TABLE team CHANGE team_name team_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE team_child_id team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61F296CD8AE ON team (team_id)');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE firstname_user firstname_user VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname_user lastname_user VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
