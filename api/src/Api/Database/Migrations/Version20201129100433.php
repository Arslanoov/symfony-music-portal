<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201129100433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE music_artists (id UUID NOT NULL, login VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN music_artists.id IS \'(DC2Type:music_artist_id)\'');
        $this->addSql('COMMENT ON COLUMN music_artists.login IS \'(DC2Type:music_artist_login)\'');
        $this->addSql('ALTER TABLE user_users ALTER role TYPE VARCHAR(12)');
        $this->addSql('ALTER TABLE user_users ALTER role DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE music_artists');
        $this->addSql('ALTER TABLE user_users ALTER role TYPE VARCHAR(12)');
        $this->addSql('ALTER TABLE user_users ALTER role DROP DEFAULT');
    }
}
