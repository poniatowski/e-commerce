<?php declare(strict_types=1);

namespace App\Controller\Product;

use App\Entity\Product;
use App\Form\Type\ProductForm;
use App\Notification\NewProductNotification;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/product/add", name="product_add")
     */
    public function add(
        Request $request,
        ValidatorInterface $validator,
        NewProductNotification $newProductNotification
    ): Response
    {
        $form = $this->createForm(ProductForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $product = new Product();
            $product->setName($formData['name']);
            $product->setDescription($formData['description']);
            $product->setPrice($formData['price']);
            $product->setCurrency($formData['currency']);
            $product->setCreated(new \DateTimeImmutable());

            if (count($errors = $validator->validate($product, null, ['create']))) {
                return $this->render('product/product_list/add.html.twig', [
                    'form'   => $form->createView(),
                    'errors' => $errors,
                ]);
            }

            $this->productRepository->saveProduct($product);
            $newProductNotification->sendNotifications($product);

            $this->addFlash('success', 'Product has been added.');
            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/product_list/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/list", name="product_list")
     */
    public function list(Request $request, PaginatorInterface $paginator): Response
    {
        return $this->render('product/product_list/index.html.twig', [
            'products' => $this->productRepository->getProductListWithPagination($request, $paginator),
        ]);
    }
}
