<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 19.02.17.
     * Time: 17:39
     */

    namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;


    use Doctrine\ORM\EntityRepository;
    use Zizoo\Bundle\CmsBundle\Model\InstagramPagePartRepositoryInterface;

    class InstagramPagePartRepository extends EntityRepository implements InstagramPagePartRepositoryInterface
    {

    }