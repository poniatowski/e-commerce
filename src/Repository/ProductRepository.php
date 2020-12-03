<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    private LoggerInterface $logger;

    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Product::class);

        $this->logger = $logger;
    }

    public function saveProduct(Product $product): Product
    {
        try {
            $this->_em->persist($product);
            $this->_em->flush();
        } catch (ORMException $e) {
            $this->logger->critical("Product couldn't be stored.", [
                'exception' => $e,
                'product'   => $product
            ]);
        }

        return $product;
    }

    public function getProductListWithPagination(Request $request, PaginatorInterface $paginator): SlidingPagination
    {
        $appointmentsRepository = $this->_em->getRepository(Product::class);
        $allAppointmentsQuery   = $appointmentsRepository
            ->createQueryBuilder('p')
            ->andWhere('p.removed IS NULL')
            ->orderBy('p.created', 'DESC')
            ->getQuery();

        return $paginator->paginate(
            $allAppointmentsQuery,
            $request->query->getInt('page', 1),
            10
        );
    }
}
