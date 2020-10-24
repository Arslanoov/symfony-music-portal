<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201024193019 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE user_users (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, login VARCHAR(16) NOT NULL, email VARCHAR(32) NOT NULL, age INT NOT NULL, password VARCHAR(128) NOT NULL, name_first VARCHAR(32) NOT NULL, name_last VARCHAR(32) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6415EB1AA08CB10 ON user_users (login)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6415EB1E7927C74 ON user_users (email)');
        $this->addSql('COMMENT ON COLUMN user_users.id IS \'(DC2Type:user_user_id)\'');
        $this->addSql('COMMENT ON COLUMN user_users.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_users.login IS \'(DC2Type:user_user_login)\'');
        $this->addSql('COMMENT ON COLUMN user_users.email IS \'(DC2Type:user_user_email)\'');
        $this->addSql('COMMENT ON COLUMN user_users.age IS \'(DC2Type:user_user_age)\'');
        $this->addSql('COMMENT ON COLUMN user_users.password IS \'(DC2Type:user_user_password)\'');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE user_users');
    }
}
