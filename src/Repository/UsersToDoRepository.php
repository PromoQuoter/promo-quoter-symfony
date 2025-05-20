<?php

namespace App\Repository;

use App\Entity\UsersToDo;
use App\Type\YesNoShort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsersToDo>
 */
class UsersToDoRepository extends ServiceEntityRepository
{
    private array $columnOrder = [null, 'u.todo'];
    private array $columnSearch = ['u.todo'];
    private array $defaultOrder = ['u.id' => 'ASC'];

    private readonly UserRepository $userRepository;

    public function __construct(ManagerRegistry $registry, UserRepository $userRepository)
    {
        parent::__construct($registry, UsersToDo::class);
        $this->userRepository = $userRepository;
    }

    private function getDataTablesQueryBuilder(array $params, int $userId): QueryBuilder
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.userId = :userId')
            ->andWhere('u.deleteFlag = :deleteFlag')
            ->setParameter('userId', $userId)
            ->setParameter('deleteFlag', 'N');

        // Handle search
        if (!empty($params['search']['value'])) {
            $searchValue = $params['search']['value'];
            $orX = $qb->expr()->orX();

            foreach ($this->columnSearch as $column) {
                $orX->add($qb->expr()->like($column, ':searchValue'));
            }

            $qb->andWhere($orX)
                ->setParameter('searchValue', '%' . $searchValue . '%');
        }

        // Handle ordering
        if (isset($params['order'])) {
            $columnIndex = $params['order'][0]['column'];
            $columnName = $this->columnOrder[$columnIndex] ?? null;
            
            if ($columnName) {
                $qb->orderBy($columnName, $params['order'][0]['dir']);
            }
        } else {
            foreach ($this->defaultOrder as $column => $direction) {
                $qb->orderBy($column, $direction);
            }
        }

        return $qb;
    }

    public function getDatatables(array $params, int $userId): array
    {
        $qb = $this->getDataTablesQueryBuilder($params, $userId);

        if ($params['length'] != -1) {
            $qb->setFirstResult($params['start'])
                ->setMaxResults($params['length']);
        }

        return $qb->getQuery()->getResult();
    }

    public function toggleActive(int $checkboxId, int $userId): bool
    {
        $todo = $this->findOneBy([
            'id' => $checkboxId,
            'userId' => $userId
        ]);

        if (!$todo) {
            return false;
        }

        $todo->setIsActive($todo->getIsActive() === YesNoShort::Yes ? YesNoShort::No : YesNoShort::Yes);
        $this->getEntityManager()->flush();

        return true;
    }

    public function getToDo(int $userId): array
    {
        return $this->createQueryBuilder('u')
            ->where('u.userId = :userId')
            ->andWhere('u.deleteFlag = :deleteFlag')
            ->setParameter('userId', $userId)
            ->setParameter('deleteFlag', 'N')
            ->getQuery()
            ->getResult();
    }

    public function countFiltered(array $params, int $userId): int
    {
        $qb = $this->getDataTablesQueryBuilder($params, $userId);
        
        return count($qb->getQuery()->getResult());
    }

    public function countAll(int $userId): int
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.userId = :userId')
            ->andWhere('u.deleteFlag = :deleteFlag')
            ->setParameter('userId', $userId)
            ->setParameter('deleteFlag', 'N')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function insertTodo(string $todoName, int $userId): bool
    {
        // Retrieve user id
        // TODO: Validate
        $user = $this->userRepository->findOneBy(['id' => $userId]);

        $todo = new UsersToDo();
        $todo->setUserId($user);
        $todo->setTodo($todoName);
        $todo->setIsActive(YesNoShort::No);
        $todo->setDeleteFlag(YesNoShort::No);

        $this->getEntityManager()->persist($todo);
        $this->getEntityManager()->flush();

        return true;
    }

    public function deleteTodoById(int $id, int $userId): bool
    {
        $todo = $this->findOneBy([
            'id' => $id,
            'userId' => $userId
        ]);

        if (!$todo) {
            return false;
        }

        $todo->setDeleteFlag(YesNoShort::Yes);
        $this->getEntityManager()->flush();

        return true;
    }
}
