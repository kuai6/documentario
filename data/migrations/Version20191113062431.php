<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113062431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
        create table document
        (
            id VARCHAR (36) not null,
            payload text null,
            owner_id VARCHAR(36) not null,
            create_at datetime default now() not null,
            modify_at datetime null,
            status enum("draft", "published") not null

        );
        
        create unique index table_name_id_uindex
            on table_name (id);
        
        alter table table_name
            add constraint table_name_pk
                primary key (id);
        
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
