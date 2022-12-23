<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221223084718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote_meal DROP FOREIGN KEY FK_29947FAD639666D6');
        $this->addSql('ALTER TABLE vote_meal DROP FOREIGN KEY FK_29947FAD72DCDAFC');
        $this->addSql('ALTER TABLE vote_user DROP FOREIGN KEY FK_3AF12778A76ED395');
        $this->addSql('ALTER TABLE vote_user DROP FOREIGN KEY FK_3AF1277872DCDAFC');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE vote_meal');
        $this->addSql('DROP TABLE vote_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, rating INT NOT NULL, comment LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE vote_meal (vote_id INT NOT NULL, meal_id INT NOT NULL, INDEX IDX_29947FAD72DCDAFC (vote_id), INDEX IDX_29947FAD639666D6 (meal_id), PRIMARY KEY(vote_id, meal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE vote_user (vote_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3AF12778A76ED395 (user_id), INDEX IDX_3AF1277872DCDAFC (vote_id), PRIMARY KEY(vote_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE vote_meal ADD CONSTRAINT FK_29947FAD639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_meal ADD CONSTRAINT FK_29947FAD72DCDAFC FOREIGN KEY (vote_id) REFERENCES vote (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_user ADD CONSTRAINT FK_3AF12778A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_user ADD CONSTRAINT FK_3AF1277872DCDAFC FOREIGN KEY (vote_id) REFERENCES vote (id) ON DELETE CASCADE');
    }
}
