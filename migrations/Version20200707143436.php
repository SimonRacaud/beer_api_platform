<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200707143436 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beer ADD brasserie_id INT NOT NULL');
        $this->addSql('ALTER TABLE beer ADD CONSTRAINT FK_58F666AD52981840 FOREIGN KEY (brasserie_id) REFERENCES brasserie (id)');
        $this->addSql('CREATE INDEX IDX_58F666AD52981840 ON beer (brasserie_id)');
        $this->addSql('ALTER TABLE brasserie DROP FOREIGN KEY FK_B6867776D0989053');
        $this->addSql('DROP INDEX IDX_B6867776D0989053 ON brasserie');
        $this->addSql('ALTER TABLE brasserie DROP beer_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beer DROP FOREIGN KEY FK_58F666AD52981840');
        $this->addSql('DROP INDEX IDX_58F666AD52981840 ON beer');
        $this->addSql('ALTER TABLE beer DROP brasserie_id');
        $this->addSql('ALTER TABLE brasserie ADD beer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE brasserie ADD CONSTRAINT FK_B6867776D0989053 FOREIGN KEY (beer_id) REFERENCES beer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B6867776D0989053 ON brasserie (beer_id)');
    }
}
