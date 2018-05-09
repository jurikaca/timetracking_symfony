<?php

namespace App\Repository;

use App\Entity\Time;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Time|null find($id, $lockMode = null, $lockVersion = null)
 * @method Time|null findOneBy(array $criteria, array $orderBy = null)
 * @method Time[]    findAll()
 * @method Time[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Time::class);
    }

    /**
     * function to filter, order, paginate the time logged history
     *
     * @param Request $request, request data from client
     * @param bool $count, if this argument is true then number of records is returned as output otherwise the records object is returned
     * @return \Doctrine\ORM\QueryBuilder|int|mixed
     */
    public function filter(Request $request, $count = false){
        $field      = $request->query->get('field'); // field to order by
        $asc        = $request->query->get('asc'); // whether order type is asc or desc
        $search     = $request->query->get('search'); // search value for logged time description
        $start      = $request->query->get('start'); // offset of records to get
        $limit      = $request->query->get('limit'); // number of records per page
        $start = is_numeric($start) ? $start : 0;
        $limit = is_numeric($limit) ? $limit : 10;

        $items = $this->createQueryBuilder('time')
            ->select('time.id, time.date_finished, time.time_tracked_formatted, time.description')
        ;
        if($search){
            $items->where('time.description LIKE :val')
            ->setParameter('val', '%'.$search.'%');
        }
        if($count === false){
            $items->setMaxResults($limit)->setFirstResult($start);
        }
        if($field){
            $items = $items->orderBy('time.'.$field, $asc === true || $asc === 'true' ? 'ASC' : 'DESC');
        }
        $items = $items->getQuery()->getResult();
        if($count === true){
            return count($items);
        }else{
            return $items;
        }
    }
}
