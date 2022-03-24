<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220321130340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE milestone CHANGE date_obtained date_obtained DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fact CHANGE name_fact name_fact VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description_fact description_fact LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE milestone CHANGE name_milestone name_milestone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_obtained date_obtained DATE NOT NULL');
        $this->addSql('ALTER TABLE portfolio CHANGE name_portfolio name_portfolio VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE project CHANGE name_project name_project VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description_project description_project LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE code_project code_project VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE risk CHANGE name_risk name_risk VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE severity_risk severity_risk VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE status CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE slug slug VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE color_status color_status VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE team CHANGE team_name team_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE firstname_user firstname_user VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname_user lastname_user VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
