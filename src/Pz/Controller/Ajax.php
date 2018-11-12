<?php

namespace Pz\Controller;


use Doctrine\DBAL\Connection;
use Pz\Axiom\Mo;
use Pz\Orm\Asset;
use Pz\Orm\Page;
use Pz\Orm\PageCategory;
use Pz\Router\Node;
use Pz\Router\Tree;
use Pz\Service\Db;
use Pz\Twig\Extension;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class Ajax extends Controller
{

    /**
     * @route("/pz/ajax/column/sort", name="pzAjaxColumnSort")
     * @return Response
     */
    public function pzAjaxColumnSort()
    {
        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();

        $request = Request::createFromGlobals();
        $data = json_decode($request->get('data'));
        $className = $request->get('className');

        $fullClassName = Db::fullClassName($className);
        foreach ($data as $idx => $itm) {
            $orm = $fullClassName::getById($pdo, $itm);
            if ($orm) {
                $orm->setRank($idx);
                $orm->save();
            }
        }
        return new Response('OK');
    }

    /**
     * @route("/pz/ajax/nestable/sort", name="pzAjaxNestableSort")
     * @return Response
     */
    public function pzAjaxNestableSort()
    {
        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();

        $request = Request::createFromGlobals();
        $data = json_decode($request->get('data'));
        $className = $request->get('model');

        $fullClassName = Db::fullClassName($className);
        foreach ($data as $idx => $itm) {
            $orm = $fullClassName::getById($pdo, $itm->id);
            if ($orm) {
                $orm->setRank($itm->rank);
                $orm->setParentId($itm->parentId);
                $orm->save();
            }
        }
        return new Response('OK');
    }

    /**
     * @route("/pz/ajax/nestable/closed", name="pzAjaxNestableClosed")
     * @return Response
     */
    public function pzAjaxNestableClosed()
    {
        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();

        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $closed = $request->get('closed') ?: 0;
        $className = $request->get('model');

        $fullClassName = Db::fullClassName($className);
        $orm = $fullClassName::getById($pdo, $id);
        if (!$orm) {
            throw new NotFoundHttpException();
        }

        $orm->setClosed($closed);
        $orm->save();

        return new Response('OK');
    }

    /**
     * @route("/pz/ajax/status", name="pzAjaxStatus")
     * @return Response
     */
    public function pzAjaxStatus()
    {
        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();

        $request = Request::createFromGlobals();
        $status = $request->get('status');
        $id = $request->get('id');
        $className = $request->get('className');

        $fullClassName = Db::fullClassName($className);
        $orm = $fullClassName::getById($pdo, $id);
        if ($orm) {
            $orm->setStatus($status);
            $orm->save();
        }
        return new Response('OK');
    }

    /**
     * @route("/pz/ajax/delete", name="pzAjaxDelete")
     * @return Response
     */
    public function pzAjaxDelete()
    {
        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();

        $request = Request::createFromGlobals();
        $status = $request->get('status');
        $id = $request->get('id');
        $className = $request->get('className');

        $fullClassName = Db::fullClassName($className);
        $orm = $fullClassName::getById($pdo, $id);
        if ($orm) {
            $orm->delete();
        }
        return new Response('OK');
    }

    /**
     * @route("/pz/ajax/cat/count", name="pzAjaxCatCount")
     * @return Response
     */
    public function pzAjaxCatCount()
    {
        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();

        $pageCategories = PageCategory::active($pdo);
        $pages = Page::data($pdo);

        $result = array();
        foreach ($pageCategories as $pageCategory) {
            $result["cat{$pageCategory->getId()}"] = 0;
            foreach ($pages as $page) {
                $category = json_decode($page->getCategory());
                if (in_array($pageCategory->getId(), $category)) {
                    $result["cat{$pageCategory->getId()}"]++;
                }
            }
        }

        $result["cat0"] = 0;
        foreach ($pages as $page) {
            $category = json_decode($page->getCategory());
            if (count($category) == 0) {
                $result["cat0"]++;
            }
        }

        return new JsonResponse($result);
    }

    /**
     * @route("/pz/ajax/pages/sort", name="pzAjaxPagesSort")
     * @return Response
     */
    public function pzAjaxPagesSort()
    {
        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();

        $request = Request::createFromGlobals();
        $cat = $request->get('cat');
        $data = (array)json_decode($request->get('data'));

        foreach ($data as $itm) {
            /** @var Page $orm */
            $orm = Page::getById($pdo, $itm->id);

            $category = $orm->getCategory() ? (array)json_decode($orm->getCategory()) : array();
            if (!in_array($cat, $category)) {
                $category[] = $cat;
            }

            $categoryRank = $orm->getCategoryRank() ? (array)json_decode($orm->getCategoryRank()) : array();
            $categoryParent = $orm->getCategoryParent() ? (array)json_decode($orm->getCategoryParent()) : array();

            $categoryRank["cat{$cat}"] = $itm->rank;
            $categoryParent["cat{$cat}"] = $itm->parentId;

            $orm->setCategory(json_encode($category));
            $orm->setCategoryRank(json_encode($categoryRank));
            $orm->setCategoryParent(json_encode($categoryParent));
            $orm->save();
        }

        return new Response('OK');
    }

    /**
     * @route("/pz/ajax/page/change", name="pzAjaxPageChange")
     * @return Response
     */
    public function pzAjaxPageChange()
    {
        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();

        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $oldCat = $request->get('oldCat');
        $newCat = $request->get('newCat') ?: 0;

        $root = Extension::nestablePges(Page::data($pdo), $oldCat);
        $nodes = Tree::getChildrenAndSelfAsArray($root, $id);
        foreach ($nodes as $node) {
            /** @var Page $orm */
            $orm = $node->getExtras()['orm'];

            $category = $orm->getCategory() ? (array)json_decode($orm->getCategory()) : array();
            $category = array_filter($category, function ($itm) use ($oldCat) {
                return $oldCat != $itm;
            });
            if ($newCat != 0) {
                $category[] = $newCat;
            }

            $categoryRank = $orm->getCategoryRank() ? (array)json_decode($orm->getCategoryRank()) : array();
            $categoryParent = $orm->getCategoryParent() ? (array)json_decode($orm->getCategoryParent()) : array();

            $categoryRank["cat{$newCat}"] = $orm->getId() == $id ? 0 : $categoryRank["cat{$oldCat}"];
            $categoryParent["cat{$newCat}"] = $orm->getId() == $id ? 0 : $categoryParent["cat{$oldCat}"];

            unset($categoryRank["cat{$oldCat}"]);
            unset($categoryParent["cat{$oldCat}"]);

            $orm->setCategory(json_encode($category));
            $orm->setCategoryRank(json_encode($categoryRank));
            $orm->setCategoryParent(json_encode($categoryParent));
            $orm->save();
        }

        return new Response('OK');
    }

    /**
     * @route("/pz/ajax/page/closed", name="pzAjaxPageClosed")
     * @return Response
     */
    public function pzAjaxPageClosed()
    {
        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();

        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $cat = $request->get('cat');
        $closed = $request->get('closed') ?: 0;

        /** @var Page $orm */
        $orm = Page::getById($pdo, $id);
        if (!$orm) {
            throw new NotFoundHttpException();
        }

        $categoryClosed = $orm->getCategoryClosed() ? (array)json_decode($orm->getCategoryClosed()) : array();
        $categoryClosed["cat{$cat}"] = $closed;
        $orm->setCategoryClosed(json_encode($categoryClosed));
        $orm->save();

        return new Response('OK');
    }
}