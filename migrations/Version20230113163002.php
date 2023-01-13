<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230113163002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE post_user');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4B89032C');
        $this->addSql('DROP INDEX UNIQ_9474526C4B89032C ON comment');
        $this->addSql('ALTER TABLE comment ADD message LONGTEXT NOT NULL, DROP post_id, DROP content, CHANGE author_id author_id INT NOT NULL, CHANGE published_at posted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE post ADD liked_by_id INT DEFAULT NULL, ADD comment_id INT DEFAULT NULL, CHANGE content content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DB4622EC2 FOREIGN KEY (liked_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DB4622EC2 ON post (liked_by_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF8697D13 ON post (comment_id)');
        $this->addSql('ALTER TABLE user ADD post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494B89032C ON user (post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_user (post_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_44C6B1424B89032C (post_id), INDEX IDX_44C6B142A76ED395 (user_id), PRIMARY KEY(post_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE post_user ADD CONSTRAINT FK_44C6B1424B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_user ADD CONSTRAINT FK_44C6B142A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD post_id INT DEFAULT NULL, ADD content VARCHAR(255) NOT NULL, DROP message, CHANGE author_id author_id INT DEFAULT NULL, CHANGE posted_at published_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9474526C4B89032C ON comment (post_id)');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DB4622EC2');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DF8697D13');
        $this->addSql('DROP INDEX IDX_5A8A6C8DB4622EC2 ON post');
        $this->addSql('DROP INDEX IDX_5A8A6C8DF8697D13 ON post');
        $this->addSql('ALTER TABLE post DROP liked_by_id, DROP comment_id, CHANGE content content VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494B89032C');
        $this->addSql('DROP INDEX IDX_8D93D6494B89032C ON user');
        $this->addSql('ALTER TABLE user DROP post_id');
    }
}
