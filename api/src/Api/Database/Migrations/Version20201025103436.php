<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201025103436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_users ALTER sign_up_confirm_token_value DROP NOT NULL');
        $this->addSql('ALTER TABLE user_users ALTER sign_up_confirm_token_expire_date DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_users ALTER sign_up_confirm_token_value SET NOT NULL');
        $this->addSql('ALTER TABLE user_users ALTER sign_up_confirm_token_expire_date SET NOT NULL');
    }
}
