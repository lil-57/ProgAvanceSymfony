<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250918073238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oignon_oignon (oignon_source INT NOT NULL, oignon_target INT NOT NULL, INDEX IDX_77BC77BE58A3137A (oignon_source), INDEX IDX_77BC77BE414643F5 (oignon_target), PRIMARY KEY(oignon_source, oignon_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sauce_sauce (sauce_source INT NOT NULL, sauce_target INT NOT NULL, INDEX IDX_EEBE1F836F0BC67F (sauce_source), INDEX IDX_EEBE1F8376EE96F0 (sauce_target), PRIMARY KEY(sauce_source, sauce_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oignon_oignon ADD CONSTRAINT FK_77BC77BE58A3137A FOREIGN KEY (oignon_source) REFERENCES oignon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oignon_oignon ADD CONSTRAINT FK_77BC77BE414643F5 FOREIGN KEY (oignon_target) REFERENCES oignon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sauce_sauce ADD CONSTRAINT FK_EEBE1F836F0BC67F FOREIGN KEY (sauce_source) REFERENCES sauce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sauce_sauce ADD CONSTRAINT FK_EEBE1F8376EE96F0 FOREIGN KEY (sauce_target) REFERENCES sauce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burger ADD pain_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0D64775A84 FOREIGN KEY (pain_id) REFERENCES pain (id)');
        $this->addSql('CREATE INDEX IDX_EFE35A0D64775A84 ON burger (pain_id)');
        $this->addSql('ALTER TABLE commentaire ADD burger_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC17CE5090 FOREIGN KEY (burger_id) REFERENCES commentaire (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC17CE5090 ON commentaire (burger_id)');
        $this->addSql('ALTER TABLE image ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045F3DA5256D ON image (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oignon_oignon DROP FOREIGN KEY FK_77BC77BE58A3137A');
        $this->addSql('ALTER TABLE oignon_oignon DROP FOREIGN KEY FK_77BC77BE414643F5');
        $this->addSql('ALTER TABLE sauce_sauce DROP FOREIGN KEY FK_EEBE1F836F0BC67F');
        $this->addSql('ALTER TABLE sauce_sauce DROP FOREIGN KEY FK_EEBE1F8376EE96F0');
        $this->addSql('DROP TABLE oignon_oignon');
        $this->addSql('DROP TABLE sauce_sauce');
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0D64775A84');
        $this->addSql('DROP INDEX IDX_EFE35A0D64775A84 ON burger');
        $this->addSql('ALTER TABLE burger DROP pain_id');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC17CE5090');
        $this->addSql('DROP INDEX IDX_67F068BC17CE5090 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP burger_id');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F3DA5256D');
        $this->addSql('DROP INDEX UNIQ_C53D045F3DA5256D ON image');
        $this->addSql('ALTER TABLE image DROP image_id');
    }
}
