<?php
namespace App\Services;

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv as Dotenv;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
class EntityManagerFactory
{
    public static function create(): EntityManager
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../', 'local.env');
        $dotenv->load();
        $isDevMode = true;
        $paths = [__DIR__."/../Entity"];

        $dbParams = [
            'driver'    =>  $_ENV['DB_DRIVER'],
            'user'      =>  $_ENV['DB_USER'],
            'password'  =>  $_ENV['DB_PASSWORD'],
            'dbname'    =>  $_ENV['DB_NAME'],
        ];

        $config = ORMSetup::createAttributeMetadataConfiguration($paths,$isDevMode);
        
        $conn = DriverManager::getConnection($dbParams,$config);

        return new EntityManager($conn,$config);
    }
    
    
}
