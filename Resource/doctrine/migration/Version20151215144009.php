<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\Tools\SchemaTool;
use Eccube\Application;
use Plugin\Point\Entity;

/**
 * Class Version20151215144009
 * @package DoctrineMigrations
 */
class Version20151215144009 extends AbstractMigration
{
    protected $tables = array();

    protected $sequences = array();

    public function __construct()
    {
        $this->entities = array(
            'Plugin\Point\Entity\Point',
            'Plugin\Point\Entity\PointCustomer',
            'Plugin\Point\Entity\PointInfo',
            'Plugin\Point\Entity\PointProductRate',
            'Plugin\Point\Entity\PointSnapshot',
        );

        $this->sequences = array(
            'plg_point_point_id_seq',
            'plg_point_customer_point_customer_id_seq',
            'plg_point_info_point_info_id_seq',
            'plg_point_productrate_point_productrate_id_seq',
            'plg_point_snapshot_id_seq',
        );
    }

    /**
     * インストール時処理
     * @param Schema $schema
     * @return bool
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function up(Schema $schema)
    {
        $app = Application::getInstance();
        $em = $app['orm.em'];
        $classes = array();
        foreach ($this->entities as $entity) {
            $classes[] = $em->getMetadataFactory()->getMetadataFor($entity);
        }

        $tool = new SchemaTool($em);
        $tool->createSchema($classes);
    }

    /**
     * アンインストール時処理
     * @param Schema $schema
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function down(Schema $schema)
    {
        $app = Application::getInstance();
        $em = $app['orm.em'];
        $classes = array();
        foreach ($this->entities as $entity) {
            $classes[] = $em->getMetadataFactory()->getMetadataFor($entity);
        }

        $tool = new SchemaTool($em);
        $tool->dropSchema($classes);

//        foreach ($this->sequences as $sequence) {
//            if ($schema->hasSequence($sequence)) {
//                $schema->dropSequence($sequence);
//            }
//        }
    }
}
