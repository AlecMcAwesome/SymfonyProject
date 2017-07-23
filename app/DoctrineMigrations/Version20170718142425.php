<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170718142425 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ingrediens ADD recipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ingrediens ADD CONSTRAINT FK_F5CBEDD359D8A214 FOREIGN KEY (recipe_id) REFERENCES Recipees (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_F5CBEDD359D8A214 ON ingrediens (recipe_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ingrediens DROP FOREIGN KEY FK_F5CBEDD359D8A214');
        $this->addSql('DROP INDEX IDX_F5CBEDD359D8A214 ON ingrediens');
        $this->addSql('ALTER TABLE ingrediens DROP recipe_id');
    }
}
