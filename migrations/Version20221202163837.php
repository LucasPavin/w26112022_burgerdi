<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221202163837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, website VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, id_agency_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, calorie LONGTEXT DEFAULT NULL, create_at DATETIME NOT NULL, INDEX IDX_9EF68E9C4DDF670D (id_agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal_category (meal_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_625E02B3639666D6 (meal_id), INDEX IDX_625E02B312469DE2 (category_id), PRIMARY KEY(meal_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone INT NOT NULL, city VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', roles JSON NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, rating INT NOT NULL, comment LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote_user (vote_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3AF1277872DCDAFC (vote_id), INDEX IDX_3AF12778A76ED395 (user_id), PRIMARY KEY(vote_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote_meal (vote_id INT NOT NULL, meal_id INT NOT NULL, INDEX IDX_29947FAD72DCDAFC (vote_id), INDEX IDX_29947FAD639666D6 (meal_id), PRIMARY KEY(vote_id, meal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C4DDF670D FOREIGN KEY (id_agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE meal_category ADD CONSTRAINT FK_625E02B3639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_category ADD CONSTRAINT FK_625E02B312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_user ADD CONSTRAINT FK_3AF1277872DCDAFC FOREIGN KEY (vote_id) REFERENCES vote (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_user ADD CONSTRAINT FK_3AF12778A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_meal ADD CONSTRAINT FK_29947FAD72DCDAFC FOREIGN KEY (vote_id) REFERENCES vote (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_meal ADD CONSTRAINT FK_29947FAD639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C4DDF670D');
        $this->addSql('ALTER TABLE meal_category DROP FOREIGN KEY FK_625E02B3639666D6');
        $this->addSql('ALTER TABLE meal_category DROP FOREIGN KEY FK_625E02B312469DE2');
        $this->addSql('ALTER TABLE vote_user DROP FOREIGN KEY FK_3AF1277872DCDAFC');
        $this->addSql('ALTER TABLE vote_user DROP FOREIGN KEY FK_3AF12778A76ED395');
        $this->addSql('ALTER TABLE vote_meal DROP FOREIGN KEY FK_29947FAD72DCDAFC');
        $this->addSql('ALTER TABLE vote_meal DROP FOREIGN KEY FK_29947FAD639666D6');
        $this->addSql('DROP TABLE agency');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE meal_category');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE vote_user');
        $this->addSql('DROP TABLE vote_meal');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
