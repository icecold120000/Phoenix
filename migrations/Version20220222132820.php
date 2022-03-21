<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222132820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budget (id INT AUTO_INCREMENT NOT NULL, initial_budget INT NOT NULL, budget_used INT NOT NULL, quantity_left_budget INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fact (id INT AUTO_INCREMENT NOT NULL, milestone_fact_id INT DEFAULT NULL, project_id INT DEFAULT NULL, date_fact DATE NOT NULL, name_fact VARCHAR(255) NOT NULL, description_fact LONGTEXT NOT NULL, INDEX IDX_6FA45B957DB8D192 (milestone_fact_id), INDEX IDX_6FA45B95166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE milestone (id INT AUTO_INCREMENT NOT NULL, name_milstone VARCHAR(255) NOT NULL, value_milstone INT NOT NULL, is_required TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio (id INT AUTO_INCREMENT NOT NULL, responsable_portfolio_id INT NOT NULL, name_portfolio VARCHAR(255) NOT NULL, INDEX IDX_A9ED10629DDF01CC (responsable_portfolio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE risk (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, name_risk VARCHAR(255) NOT NULL, identification_date_risk DATE NOT NULL, resolution_date_risk DATE NOT NULL, severity_risk VARCHAR(255) NOT NULL, probability_risk INT NOT NULL, INDEX IDX_7906D541166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, team_leader_id INT DEFAULT NULL, team_id INT DEFAULT NULL, team_name VARCHAR(255) NOT NULL, INDEX IDX_C4E0A61FC4105033 (team_leader_id), INDEX IDX_C4E0A61F296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fact ADD CONSTRAINT FK_6FA45B957DB8D192 FOREIGN KEY (milestone_fact_id) REFERENCES milestone (id)');
        $this->addSql('ALTER TABLE fact ADD CONSTRAINT FK_6FA45B95166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE portfolio ADD CONSTRAINT FK_A9ED10629DDF01CC FOREIGN KEY (responsable_portfolio_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE risk ADD CONSTRAINT FK_7906D541166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FC4105033 FOREIGN KEY (team_leader_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE project ADD team_client_id INT DEFAULT NULL, ADD production_team_id INT DEFAULT NULL, ADD project_budget_id INT DEFAULT NULL, ADD code_project VARCHAR(255) NOT NULL, ADD archive_project TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEAEEE77C6 FOREIGN KEY (team_client_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE3C795573 FOREIGN KEY (production_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE2797E36F FOREIGN KEY (project_budget_id) REFERENCES budget (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEAEEE77C6 ON project (team_client_id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE3C795573 ON project (production_team_id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE2797E36F ON project (project_budget_id)');
        $this->addSql('ALTER TABLE status ADD color_status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649296CD8AE ON user (team_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE2797E36F');
        $this->addSql('ALTER TABLE fact DROP FOREIGN KEY FK_6FA45B957DB8D192');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEAEEE77C6');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE3C795573');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F296CD8AE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649296CD8AE');
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP TABLE fact');
        $this->addSql('DROP TABLE milestone');
        $this->addSql('DROP TABLE portfolio');
        $this->addSql('DROP TABLE risk');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP INDEX IDX_2FB3D0EEAEEE77C6 ON project');
        $this->addSql('DROP INDEX IDX_2FB3D0EE3C795573 ON project');
        $this->addSql('DROP INDEX IDX_2FB3D0EE2797E36F ON project');
        $this->addSql('ALTER TABLE project DROP team_client_id, DROP production_team_id, DROP project_budget_id, DROP code_project, DROP archive_project, CHANGE name_project name_project VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description_project description_project LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE status DROP color_status, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE slug slug VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX IDX_8D93D649296CD8AE ON user');
        $this->addSql('ALTER TABLE user DROP team_id, CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE firstname_user firstname_user VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname_user lastname_user VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
