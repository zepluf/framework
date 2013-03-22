<?php
/**
 * Created by Rubikin Team.
 * Date: 3/19/13
 * Time: 4:21 PM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Entity;

/**
 *
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    public function isChildOf($categoryId)
    {
        foreach($this->getProductCategory() as $productCategory)
        {
            var_dump($this->_em->createQuery(
                'SELECT COUNT(*) FROM Zepluf\Bundle\StoreBundle\Entity\ProductCategory child
             JOIN Zepluf\Bundle\StoreBundle\Entity\ProductCategory ancestor ON child.lft BETWEEN ancestor.lft AND ancestor.rgt
             WHERE child.id = :categoryId and ancestor.id = :parentCategoryId')
                ->setParameters(array('categoryId' => $productCategory->getId(), 'parentCategoryId' => $categoryId))->getResult());
        };die();
    }
}
