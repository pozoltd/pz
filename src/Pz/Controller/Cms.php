<?php

namespace Pz\Controller;

use Pz\Orm\_Model;
use Pz\Axiom\Mo;
use Pz\Orm\DataGroup;
use Pz\Router\Node;
use Pz\Service\Db;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class Cms extends Mo
{
    /**
     * @route("/pz/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('pz/login.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @route("/pz/admin/models/{type}/copy/{modelId}", requirements={"type" = "customised|built-in"}, name="copyModel")
     * @return Response
     */
    public function copyModel($modelId)
    {
        $request = Request::createFromGlobals();
        $requestUri = rtrim($request->getPathInfo(), '/');
        $requestUri = str_replace('/copy/', '/detail/', $requestUri);
        $params = $this->getParams($requestUri);

        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();
        /** @var _Model $model */
        $model = _Model::getById($pdo, $modelId);
        $model->setTitle('New ' . $model->getTitle());
        $model->setClassName('New' . $model->getClassName());
        $model->setId(null);
        $params['model'] = $model;

        return $this->render($params['node']->getTemplate(), $params);
    }

    /**
     * @route("/pz/{section}/{modelId}/copy/{ormId}", requirements={"section" = "database|admin"}, name="copyOrm")
     * @return Response
     */
    public function copyOrm($modelId, $ormId)
    {
        $request = Request::createFromGlobals();
        $requestUri = rtrim($request->getPathInfo(), '/');
        $requestUri = str_replace('/copy/', '/detail/', $requestUri);
        $params = $this->getParams($requestUri);

        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();
        /** @var _Model $model */
        $model = _Model::getById($pdo, $modelId);
        $fullClassName = Db::fullClassName($model->getClassName());
        $orm = $fullClassName::getById($pdo, $ormId);
        $orm->setId(null);
//        $orm->setTitle('New ' . $orm->getTitle());
        $params['orm'] = $orm;

        return $this->render($params['node']->getTemplate(), $params);
    }

    /**
     * @route("/pz/{page}", requirements={"page" = ".*"}, name="cms")
     * @return Response
     */
    public function cms()
    {
        $request = Request::createFromGlobals();
        $requestUri = rtrim($request->getPathInfo(), '/');
        $params = $this->getParams($requestUri);
        return $this->render($params['node']->getTemplate(), $params);
    }

    /**
     * @return array
     */
    public function getNodes()
    {
        /** @var \PDO $pdo */
        $pdo = $this->connection->getWrappedConnection();
        $nodes = array();

        $node = new Node(1, 'Pages', 0, 0, '/pz/pages', 'pz/pages.twig');
        $node->addExtra('icon', 'fa fa-sitemap');
        $nodes[] = $node;

        $node = new Node(11, 'Page', 1, 0, '/pz/admin/6/detail', 'pz/orm.twig', 2, 1, 1);
        $nodes[] = $node;


        /** @var DataGroup[] $dataGroups */
        $dataGroups = DataGroup::active($pdo);
        foreach ($dataGroups as $dgIdx => $dataGroup) {
            $dgId = 2 + $dgIdx;

            $dgNode = new Node($dgId, $dataGroup->getTitle(), 0, $dgId);
            $dgNode->addExtra('icon', $dataGroup->getIcon());

            $result = _Model::active($pdo, array(
                'whereSql' => 'm.dataGroups LIKE ? AND m.dataType = 0',
                'params' => array('%"' . $dataGroup->getId() . '"%'),
            ));

            if (count($result)) {
                $nodes[] = $dgNode;

                foreach ($result as $idx => $itm) {
                    $ormTwigFile = 'pz/orm.twig';
                    if ($itm->getClassName() == 'FragmentBlock') {
                        $ormTwigFile = 'pz/orm-fragmentblock.twig';
                    } elseif ($itm->getClassName() == 'FragmentDefault') {
                        $ormTwigFile = 'pz/orm-fragmentdefault.twig';
                    }

                    $node = new Node($dgId . '-' . $itm->getId(), $itm->getTitle(), $dgId, $idx, "/pz/database/" . $itm->getId(), 'pz/orms.twig');
                    $nodes[] = $node;

                    $node = new Node($dgId . '-' . $itm->getId() . '-1', $itm->getTitle(), $dgId . '-' . $itm->getId(), 0, "/pz/database/" . $itm->getId() . '/detail', $ormTwigFile, 2, 1, 1);
                    $nodes[] = $node;
                }
            }
        }

        $node = new Node(30, 'Files', 0, 30, '/pz/files', 'pz/files.twig');
        $node->addExtra('icon', 'fa fa-file-image-o');
        $nodes[] = $node;

        $node = new Node(40, 'Admin', 0, 40);
        $node->addExtra('icon', 'fa fa-cogs');
        $nodes[] = $node;

        $node = new Node(41, 'Customised Models', 40, 998, '/pz/admin/models/customised', 'pz/models.twig');
        $nodes[] = $node;

        $node = new Node(411, 'Customised Model', 41, 0, '/pz/admin/models/customised/detail', 'pz/model.twig', 2, 1, 1);;
        $nodes[] = $node;

        $node = new Node(42, 'Built-in Models', 40, 999, '/pz/admin/models/built-in', 'pz/models.twig');
        $nodes[] = $node;

        $node = new Node(421, 'Built-in Model', 42, 0, '/pz/admin/models/built-in/detail', 'pz/model.twig', 2, 1, 1);
        $nodes[] = $node;


        $node = new Node(412, 'Sync Model', 41, 0, '/pz/admin/models/customised/sync', 'pz/model-sync.twig', 2, 1, 1);
        $nodes[] = $node;

        $node = new Node(422, 'Sync Model', 42, 0, '/pz/admin/models/built-in/sync', 'pz/model-sync.twig', 2, 1, 1);
        $nodes[] = $node;

        /** @var _Model[] $modelDatabase */
        $modelDatabase = _Model::active($pdo);
        foreach ($modelDatabase as $idx => $itm) {
            $ormTwigFile = 'pz/orm.twig';
            if ($itm->getClassName() == 'FragmentBlock') {
                $ormTwigFile = 'pz/orm-fragmentblock.twig';
            } elseif ($itm->getClassName() == 'FragmentDefault') {
                $ormTwigFile = 'pz/orm-fragmentdefault.twig';
            }

            if ($itm->getDataType() == 1) {
                $node = new Node('40-' . $itm->getId(), $itm->getTitle(), 40, $idx, "/pz/admin/" . $itm->getId(), 'pz/orms.twig');
                $nodes[] = $node;

                $node = new Node('40-' . $itm->getId() . '-1', $itm->getTitle(), '40-' . $itm->getId(), 0, "/pz/admin/" . $itm->getId() . '/detail', $ormTwigFile, 2, 1, 1);
                $nodes[] = $node;
            }
        }

        return $nodes;
    }
}