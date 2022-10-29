<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221029130956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE features (id INT AUTO_INCREMENT NOT NULL, vendre_boisson INT NOT NULL, gerer_planning INT NOT NULL, envoyer_newsletter INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, features_id INT NOT NULL, username_id INT NOT NULL, name VARCHAR(255) NOT NULL, active INT NOT NULL, UNIQUE INDEX UNIQ_312B3E16CEC89005 (features_id), UNIQUE INDEX UNIQ_312B3E16ED766068 (username_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id INT AUTO_INCREMENT NOT NULL, features_id INT NOT NULL, partner_id INT NOT NULL, username_id INT NOT NULL, adress VARCHAR(255) NOT NULL, active INT NOT NULL, UNIQUE INDEX UNIQ_6F0137EACEC89005 (features_id), INDEX IDX_6F0137EA9393F8FE (partner_id), UNIQUE INDEX UNIQ_6F0137EAED766068 (username_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E16CEC89005 FOREIGN KEY (features_id) REFERENCES features (id)');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E16ED766068 FOREIGN KEY (username_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EACEC89005 FOREIGN KEY (features_id) REFERENCES features (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA9393F8FE FOREIGN KEY (partner_id) REFERENCES partner (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EAED766068 FOREIGN KEY (username_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E16CEC89005');
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E16ED766068');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EACEC89005');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA9393F8FE');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EAED766068');
        $this->addSql('DROP TABLE features');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
