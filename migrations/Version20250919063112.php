<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250919063112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE burger_oignon (burger_id INT NOT NULL, oignon_id INT NOT NULL, INDEX IDX_A40C5A0417CE5090 (burger_id), INDEX IDX_A40C5A048F038184 (oignon_id), PRIMARY KEY(burger_id, oignon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE burger_sauce (burger_id INT NOT NULL, sauce_id INT NOT NULL, INDEX IDX_F889AB0F17CE5090 (burger_id), INDEX IDX_F889AB0F7AB984B7 (sauce_id), PRIMARY KEY(burger_id, sauce_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE burger_oignon ADD CONSTRAINT FK_A40C5A0417CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burger_oignon ADD CONSTRAINT FK_A40C5A048F038184 FOREIGN KEY (oignon_id) REFERENCES oignon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burger_sauce ADD CONSTRAINT FK_F889AB0F17CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burger_sauce ADD CONSTRAINT FK_F889AB0F7AB984B7 FOREIGN KEY (sauce_id) REFERENCES sauce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sauce_sauce DROP FOREIGN KEY FK_EEBE1F836F0BC67F');
        $this->addSql('ALTER TABLE sauce_sauce DROP FOREIGN KEY FK_EEBE1F8376EE96F0');
        $this->addSql('ALTER TABLE oignon_oignon DROP FOREIGN KEY FK_77BC77BE414643F5');
        $this->addSql('ALTER TABLE oignon_oignon DROP FOREIGN KEY FK_77BC77BE58A3137A');
        $this->addSql('DROP TABLE sauce_sauce');
        $this->addSql('DROP TABLE oignon_oignon');
        $this->addSql('ALTER TABLE burger ADD image_id INT DEFAULT NULL, CHANGE pain_id pain_id INT NOT NULL');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0D3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFE35A0D3DA5256D ON burger (image_id)');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC17CE5090');
        $this->addSql('ALTER TABLE commentaire CHANGE burger_id burger_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC17CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id)');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F3DA5256D');
        $this->addSql('DROP INDEX UNIQ_C53D045F3DA5256D ON image');
        $this->addSql('ALTER TABLE image DROP image_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sauce_sauce (sauce_source INT NOT NULL, sauce_target INT NOT NULL, INDEX IDX_EEBE1F836F0BC67F (sauce_source), INDEX IDX_EEBE1F8376EE96F0 (sauce_target), PRIMARY KEY(sauce_source, sauce_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oignon_oignon (oignon_source INT NOT NULL, oignon_target INT NOT NULL, INDEX IDX_77BC77BE58A3137A (oignon_source), INDEX IDX_77BC77BE414643F5 (oignon_target), PRIMARY KEY(oignon_source, oignon_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sauce_sauce ADD CONSTRAINT FK_EEBE1F836F0BC67F FOREIGN KEY (sauce_source) REFERENCES sauce (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sauce_sauce ADD CONSTRAINT FK_EEBE1F8376EE96F0 FOREIGN KEY (sauce_target) REFERENCES sauce (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oignon_oignon ADD CONSTRAINT FK_77BC77BE414643F5 FOREIGN KEY (oignon_target) REFERENCES oignon (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oignon_oignon ADD CONSTRAINT FK_77BC77BE58A3137A FOREIGN KEY (oignon_source) REFERENCES oignon (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burger_oignon DROP FOREIGN KEY FK_A40C5A0417CE5090');
        $this->addSql('ALTER TABLE burger_oignon DROP FOREIGN KEY FK_A40C5A048F038184');
        $this->addSql('ALTER TABLE burger_sauce DROP FOREIGN KEY FK_F889AB0F17CE5090');
        $this->addSql('ALTER TABLE burger_sauce DROP FOREIGN KEY FK_F889AB0F7AB984B7');
        $this->addSql('DROP TABLE burger_oignon');
        $this->addSql('DROP TABLE burger_sauce');
        $this->addSql('ALTER TABLE image ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045F3DA5256D ON image (image_id)');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC17CE5090');
        $this->addSql('ALTER TABLE commentaire CHANGE burger_id burger_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC17CE5090 FOREIGN KEY (burger_id) REFERENCES commentaire (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0D3DA5256D');
        $this->addSql('DROP INDEX UNIQ_EFE35A0D3DA5256D ON burger');
        $this->addSql('ALTER TABLE burger DROP image_id, CHANGE pain_id pain_id INT DEFAULT NULL');
    }
}
