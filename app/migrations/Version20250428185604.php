<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250428185604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create account and authtoken';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE account (uuid UUID NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_7D3656A4F85E0677 ON account (username)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN account.uuid IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE account_refresh_token (uuid UUID NOT NULL, account_uuid UUID NOT NULL, refresh_token VARCHAR(255) NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_58691D265DECD70C ON account_refresh_token (account_uuid)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN account_refresh_token.uuid IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN account_refresh_token.account_uuid IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE account_refresh_token ADD CONSTRAINT FK_58691D265DECD70C FOREIGN KEY (account_uuid) REFERENCES account (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE account_refresh_token DROP CONSTRAINT FK_58691D265DECD70C
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE account
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE account_refresh_token
        SQL);
    }
}
