<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241116133216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {   
        $this->addSql('CREATE TABLE articles (
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            is_active BOOLEAN DEFAULT TRUE NOT NULL,
            views INT DEFAULT 0 NOT NULL,
            description TEXT NOT NULL,
            created_at DATETIME(0) NOT NULL
        ) DEFAULT CHARACTER SET UTF8mb4 ENGINE = InnoDB;');


        $this->addSql('INSERT INTO articles (title, slug, is_active, views, description, created_at) VALUES 
            ("Первая статья", "pervaya-statiya", 1, 0, "Описание первой статьи", NOW()),
            ("Вторая статья", "vtoraya-statiya", 1, 0, "Описание второй статьи", NOW()),
            ("Третья статья", "tretya-statiya", 1, 0, "Описание третьей статьи", NOW())');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE articles');
    }
}