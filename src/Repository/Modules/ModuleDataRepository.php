<?php

namespace App\Repository\Modules;

use App\Entity\Modules\ModuleData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ModuleData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleData[]    findAll()
 * @method ModuleData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModuleData::class);
    }

    /**
     * Will return single module data for given parameters, or null if nothing is found
     *
     * @param string $record_type
     * @param string $module
     * @param string $record_identifier
     * @return ModuleData|null
     */
    public function getOneByRecordTypeModuleAndRecordIdentifier(string $record_type, string $module, string $record_identifier): ?ModuleData
    {
        $results = $this->findBy([
           ModuleData::FIELD_NAME_MODULE            => $module,
           ModuleData::FIELD_NAME_RECORD_IDENTIFIER => $record_identifier,
           ModuleData::FIELD_NAME_RECORD_TYPE       => $record_type,
        ]);

        if( empty($results) ){
            return null;
        }

        return $results[0];
    }

    /**
     * Will save the entity in DB
     *
     * @param ModuleData $module_data
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveEntity(ModuleData $module_data): void
    {
        $this->_em->persist($module_data);;
        $this->_em->flush();
    }

    /**
     * Will return one entity for given id, if such does not exist then null will be returned
     *
     * @param int $id
     * @return ModuleData|null
     */
    public function findOneById(int $id): ?ModuleData
    {
        return $this->find($id);
    }

}
