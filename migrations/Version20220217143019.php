<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220217143019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', suspended_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrator ADD user_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', DROP user_email, DROP user_password, DROP user_roles, DROP user_created_at, DROP user_updated_at, DROP user_suspended_at');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_58DF0651A76ED395 ON administrator (user_id)');
        $this->addSql('ALTER TABLE customer ADD user_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', DROP user_email, DROP user_password, DROP user_roles, DROP user_created_at, DROP user_updated_at, DROP user_suspended_at');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09A76ED395 ON customer (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651A76ED395');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09A76ED395');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX UNIQ_58DF0651A76ED395 ON administrator');
        $this->addSql('ALTER TABLE administrator ADD user_email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD user_password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD user_roles JSON NOT NULL, ADD user_created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD user_updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD user_suspended_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP user_id');
        $this->addSql('DROP INDEX UNIQ_81398E09A76ED395 ON customer');
        $this->addSql('ALTER TABLE customer ADD user_email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD user_password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD user_roles JSON NOT NULL, ADD user_created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD user_updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD user_suspended_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP user_id');
    }
}
