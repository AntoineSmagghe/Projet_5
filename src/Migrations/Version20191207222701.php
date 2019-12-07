<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191207222701 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE img_article');
        $this->addSql('ALTER TABLE img ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE img ADD CONSTRAINT FK_BBC2C8AC7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_BBC2C8AC7294869C ON img (article_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE img_article (img_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_4F554A8EC06A9F55 (img_id), INDEX IDX_4F554A8E7294869C (article_id), PRIMARY KEY(img_id, article_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE img_article ADD CONSTRAINT FK_4F554A8E7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE img_article ADD CONSTRAINT FK_4F554A8EC06A9F55 FOREIGN KEY (img_id) REFERENCES img (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE img DROP FOREIGN KEY FK_BBC2C8AC7294869C');
        $this->addSql('DROP INDEX IDX_BBC2C8AC7294869C ON img');
        $this->addSql('ALTER TABLE img DROP article_id');
    }
}
