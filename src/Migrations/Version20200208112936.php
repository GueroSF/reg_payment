<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200208112936 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'add additional type for category "Заем"';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('UPDATE category SET additional_type = \'credit\' WHERE name = \'Заём\'');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('UPDATE category SET additional_type = credit WHERE name = null');
    }
}
