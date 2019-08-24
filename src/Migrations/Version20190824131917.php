<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190824131917 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE my_job_afterhours CHANGE date DATE NOT NULL');
        $this->addSql("UPDATE my_car SET `date` = STR_TO_DATE(`date`, '%d-%m-%Y')");
        $this->addSql('ALTER TABLE my_car CHANGE date DATE NOT NULL');

        $this->addSql('ALTER TABLE my_goals_payments CHANGE deadline DATE NOT NULL');
        $this->addSql('ALTER TABLE my_goals_payments CHANGE collection_start_date DATE NOT NULL');

        $this->addSql("UPDATE my_payments_monthly SET `date` = STR_TO_DATE(`date`, '%d-%m-%Y')");
        $this->addSql('ALTER TABLE my_payments_monthly CHANGE date DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE my_job_afterhours CHANGE date VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE my_car CHANGE date VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql("UPDATE my_car SET `date` = DATE_FORMAT(`date`,'%d-%m-%Y')");

        $this->addSql('ALTER TABLE my_goals_payments CHANGE deadline VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE my_goals_payments CHANGE collection_start_date VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');

        $this->addSql('ALTER TABLE my_payments_monthly CHANGE date VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql("UPDATE my_payments_monthly SET `date` = DATE_FORMAT(`date`,'%d-%m-%Y')");

    }
}