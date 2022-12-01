<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221130151456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_meal (category_id INT NOT NULL, meal_id INT NOT NULL, INDEX IDX_156DF4DB12469DE2 (category_id), INDEX IDX_156DF4DB639666D6 (meal_id), PRIMARY KEY(category_id, meal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal_category (meal_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_625E02B3639666D6 (meal_id), INDEX IDX_625E02B312469DE2 (category_id), PRIMARY KEY(meal_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_meal ADD CONSTRAINT FK_156DF4DB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_meal ADD CONSTRAINT FK_156DF4DB639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_category ADD CONSTRAINT FK_625E02B3639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_category ADD CONSTRAINT FK_625E02B312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_meal DROP FOREIGN KEY FK_156DF4DB12469DE2');
        $this->addSql('ALTER TABLE category_meal DROP FOREIGN KEY FK_156DF4DB639666D6');
        $this->addSql('ALTER TABLE meal_category DROP FOREIGN KEY FK_625E02B3639666D6');
        $this->addSql('ALTER TABLE meal_category DROP FOREIGN KEY FK_625E02B312469DE2');
        $this->addSql('DROP TABLE category_meal');
        $this->addSql('DROP TABLE meal_category');
    }
}
