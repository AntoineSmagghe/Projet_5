<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200316193624 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE social_network (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, soundcloud VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_EFFF52217294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, surname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, mail VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, created_at DATETIME NOT NULL, last_log DATETIME NOT NULL, UNIQUE INDEX UNIQ_1483A5E95126AC48 (mail), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE img (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, uploaded_at DATETIME NOT NULL, cover TINYINT(1) NOT NULL, INDEX IDX_BBC2C8AC7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, modified_by_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, text LONGTEXT DEFAULT NULL, date_event DATETIME DEFAULT NULL, format VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, api_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', youtube LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_23A0E66989D9B62 (slug), INDEX IDX_23A0E66A76ED395 (user_id), INDEX IDX_23A0E6699049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, token VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date DATETIME NOT NULL, used TINYINT(1) NOT NULL, link VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5F37A13B5F37A13B (token), UNIQUE INDEX UNIQ_5F37A13BE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE social_network ADD CONSTRAINT FK_EFFF52217294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE img ADD CONSTRAINT FK_BBC2C8AC7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6699049ECE FOREIGN KEY (modified_by_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6699049ECE');
        $this->addSql('ALTER TABLE social_network DROP FOREIGN KEY FK_EFFF52217294869C');
        $this->addSql('ALTER TABLE img DROP FOREIGN KEY FK_BBC2C8AC7294869C');
        $this->addSql('DROP TABLE social_network');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE img');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE token');
    }
}
