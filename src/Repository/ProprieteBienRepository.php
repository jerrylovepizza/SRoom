<?php

namespace App\Repository;

use App\Entity\ProprieteBien;
use App\Entity\ProprieteBienSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProprieteBien|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProprieteBien|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProprieteBien[]    findAll()
 * @method ProprieteBien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProprieteBienRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProprieteBien::class);
    }

	/**
	 * See 3 latest property
	 * @return ProprieteBien[]
	 */
	public function latestBien()
    {
        return $this->createQueryBuilder('b')
			->where('b.sold = false')
            ->orderBy('b.make_at', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

	/**
	 * @return \Doctrine\ORM\QueryBuilder
	 */
	public function findVisibleBien(): QueryBuilder
	{
		return $this->createQueryBuilder('b')
			->where('b.sold = false');
	}

	/**
	 * @param ProprieteBienSearch $search
	 * @return Query
	 */
	public function findAllVisibleBien(ProprieteBienSearch $search): Query
	{
		$query = $this->findVisibleBien();

		if ($search->getMaxPrice())
		{
			$query = $query
				->andWhere('b.price <= :maxprice')
				->setParameter('maxprice', $search->getMaxPrice());
		}

		if ($search->getMinSurface())
		{
			$query = $query
				->andWhere('b.surface >= :minsurface')
				->setParameter('minsurface', $search->getMinSurface());
		}

		if ($search->getMinRooms())
		{
			$query = $query
				->andWhere('b.nbr_rooms >= :minrooms')
				->setParameter('minrooms', $search->getMinRooms());
		}

		if ($search->getMinBedrooms())
		{
			$query = $query
				->andWhere('b.nbr_bedrooms >= :minbedrooms')
				->setParameter('minbedrooms', $search->getMinBedrooms());
		}

		return $query->getQuery();
	}

    // /**
    //  * @return ProprieteBien[] Returns an array of ProprieteBien objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProprieteBien
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
