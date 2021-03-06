<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201102091640 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_users ADD reset_password_confirm_token_value VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_users ADD reset_password_confirm_token_expire_date TIMESTAMP(0) WITHOUT ' .
            'TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE user_users ALTER role TYPE VARCHAR(12)');
        $this->addSql('ALTER TABLE user_users ALTER role DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN user_users.reset_password_confirm_token_expire_date ' .
            'IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_users DROP reset_password_confirm_token_value');
        $this->addSql('ALTER TABLE user_users DROP reset_password_confirm_token_expire_date');
        $this->addSql('ALTER TABLE user_users ALTER role TYPE VARCHAR(12)');
        $this->addSql('ALTER TABLE user_users ALTER role DROP DEFAULT');
    }
}
