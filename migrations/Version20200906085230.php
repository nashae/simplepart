<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906085230 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_comment (id INT AUTO_INCREMENT NOT NULL, blog_article_id INT NOT NULL, author_id INT NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_7882EFEF9452A475 (blog_article_id), INDEX IDX_7882EFEFF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_comment ADD CONSTRAINT FK_7882EFEF9452A475 FOREIGN KEY (blog_article_id) REFERENCES blog_article (id)');
        $this->addSql('ALTER TABLE blog_comment ADD CONSTRAINT FK_7882EFEFF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE blog_comment');
    }
}
