<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201025091931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_users ADD sign_up_confirm_token_value VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_users ADD sign_up_confirm_token_expire_date TIMESTAMP(0) WITHOUT ' .
            'TIME ZONE NOT NULL');
        $this->addSql('COMMENT ON COLUMN user_users.sign_up_confirm_token_expire_date ' .
            'IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_users DROP sign_up_confirm_token_value');
        $this->addSql('ALTER TABLE user_users DROP sign_up_confirm_token_expire_date');
    }
}
