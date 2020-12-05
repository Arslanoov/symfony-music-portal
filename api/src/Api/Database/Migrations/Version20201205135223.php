<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201205135223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE music_songs (id UUID NOT NULL, artist_id UUID NOT NULL, uploaded_at DATE NOT NULL, name VARCHAR(32) NOT NULL, file VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, info_length INT NOT NULL, info_bitrate INT NOT NULL, info_year INT NOT NULL, info_format VARCHAR(6) NOT NULL, statistic_listens_count INT NOT NULL, statistic_downloads_count INT NOT NULL, statistic_month_listens_count INT NOT NULL, statistic_month_downloads_count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DD65CA53B7970CF8 ON music_songs (artist_id)');
        $this->addSql('COMMENT ON COLUMN music_songs.id IS \'(DC2Type:music_song_id)\'');
        $this->addSql('COMMENT ON COLUMN music_songs.artist_id IS \'(DC2Type:music_artist_id)\'');
        $this->addSql('COMMENT ON COLUMN music_songs.uploaded_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE music_songs ADD CONSTRAINT FK_DD65CA53B7970CF8 FOREIGN KEY (artist_id) REFERENCES music_artists (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_users ALTER role TYPE VARCHAR(12)');
        $this->addSql('ALTER TABLE user_users ALTER role DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE music_songs');
        $this->addSql('ALTER TABLE user_users ALTER role TYPE VARCHAR(12)');
        $this->addSql('ALTER TABLE user_users ALTER role DROP DEFAULT');
    }
}
