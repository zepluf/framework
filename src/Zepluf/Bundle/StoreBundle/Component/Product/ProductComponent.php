<?php
/**
 * Created by Rubikin Team.
 * Date: 3/4/13
 * Time: 5:41 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Product;

use Zepluf\Bundle\StoreBundle\Entity\Product as ProductEntity;

class ProductComponent
{
    /**
     * @var \Zepluf\Bundle\StoreBundle\Entity\Product
     */
    protected $product;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Set product
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\Product $product
     */
    public function setProduct(ProductEntity $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Check if the product belongs to certain category
     *
     * This method will loop through each product's category then check if
     * that category belongs to the given category and will return false if
     * it doesn't find any result
     *
     * @param $categoryId
     * @return bool
     */
    public function isChildOf($categoryId)
    {
        foreach($this->product->getProductCategory() as $productCategory)
        {

            if(1 == $this->entityManager->createQuery("
              SELECT COUNT(child.id) FROM Zepluf\Bundle\StoreBundle\Entity\ProductCategory child
              JOIN Zepluf\Bundle\StoreBundle\Entity\ProductCategory ancestor
              WITH child.lft BETWEEN ancestor.lft AND ancestor.rgt
              WHERE child.id = :categoryId AND ancestor.id = :parentCategoryId")
                ->setParameters(array('categoryId' => $productCategory->getId(), 'parentCategoryId' => $categoryId))
                ->getSingleScalarResult()) {
              return true;
            }
        }

        return false;
    }
}
