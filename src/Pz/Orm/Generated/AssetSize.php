<?php
//Last updated: 2018-09-04 15:03:08
namespace Pz\Orm\Generated;

use Pz\Axiom\Walle;

class AssetSize extends Walle
{
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $title;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $width;
    
    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @param mixed title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }
    
    /**
     * @param mixed width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }
    

    /**
     * @return string
     */
    function getSerializedModel(): string
    {
//        return O:13:"Pz\Orm\_Model":17:{s:30:" Pz\Orm\Generated\_Model title";s:11:"Asset Sizes";s:34:" Pz\Orm\Generated\_Model className";s:9:"AssetSize";s:34:" Pz\Orm\Generated\_Model namespace";s:6:"Pz\Orm";s:34:" Pz\Orm\Generated\_Model modelType";i:1;s:33:" Pz\Orm\Generated\_Model dataType";i:1;s:33:" Pz\Orm\Generated\_Model listType";i:0;s:38:" Pz\Orm\Generated\_Model numberPerPage";s:2:"50";s:38:" Pz\Orm\Generated\_Model defaultSortBy";s:2:"id";s:37:" Pz\Orm\Generated\_Model defaultOrder";i:1;s:36:" Pz\Orm\Generated\_Model columnsJson";s:338:"[{"id":"z1535960623556","column":"title","widget":"\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType","label":"Title:","field":"title","required":1,"sql":""},{"id":"z1535962076537","column":"latitude","widget":"\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType","label":"Width:","field":"width","required":1,"sql":""}]";s:19:" Pz\Axiom\Walle pdo";N;s:18:" Pz\Axiom\Walle id";s:1:"3";s:20:" Pz\Axiom\Walle slug";s:11:"asset-sizes";s:20:" Pz\Axiom\Walle rank";s:1:"0";s:21:" Pz\Axiom\Walle added";s:19:"2018-09-03 19:44:02";s:24:" Pz\Axiom\Walle modified";s:19:"2018-09-03 21:10:55";s:22:" Pz\Axiom\Walle active";s:1:"1";};
    }
}