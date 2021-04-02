<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

  /**
    * @return Stage[] Returns an array of Stage objects
    */
    public function findByEntreprise($nomEntreprise)
    {
        return $this->createQueryBuilder('s')
            ->join('s.entreprises','e')
            ->andWhere('e.nom = :val')
            ->setParameter('val', $nomEntreprise)
            ->getQuery()
            ->getResult()
        ;
    }


  /**
    * @return Stage[] Returns an array of Stage objects
    */
    public function findByFormation($nomFormation)
    {
        return $this->createQueryBuilder('s')
            ->join('s.formations','f')
            ->andWhere('f.nom = :val')
            ->setParameter('val', $nomFormation)
            ->getQuery()
            ->getResult()
        ;
    }



    /**
      * @return Stage[] Returns an array of Stage objects
      */
      /*
      public function findByFormation($nomFormation)
      {
          // Récupération du gestionnaire d'entité
          $gestionnaireEntite = $this->getEntityManager();

          // Construction de la requête sur mesure
          $requete = $gestionnaireEntite->createQuery('SELECT s,f
                                                       FROM App\Entity\Stage s
                                                       JOIN s.formations f
                                                       WHERE f.nom = :val');

          $requete->setParameter('val', $nomFormation);

          // Exécution de la requête et envoi des résultats
          return $requete->execute();

      }
      */



    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
