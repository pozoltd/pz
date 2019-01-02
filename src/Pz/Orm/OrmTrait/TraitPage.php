<?php
//Last updated: 2019-01-02 17:25:30
namespace Pz\Orm\OrmTrait;

use Pz\Orm\PageTemplate;

trait TraitPage
{
    public function getIcon() {
        return '';
    }

    /**
     * @return mixed|null|string
     */
    public function getTemplate()
    {
        return $this->objPageTempalte()->getFilename(); // TODO: Change the autogenerated stub
    }

    /**
     * @return PageTemplate|null
     */
    public function objPageTempalte()
    {
        /** @var PageTemplate $pageTemplate */
        $pageTemplate = PageTemplate::getById($this->getPdo(), $this->getTemplateFile());
        return $pageTemplate;
    }

    /**
     * @return mixed
     */
    public function objContent()
    {
        return json_decode($this->getContent());
    }
}