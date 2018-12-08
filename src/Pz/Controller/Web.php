<?php

namespace Pz\Controller;


use Http\Discovery\Exception\NotFoundException;
use Pz\Axiom\Mo;
use Pz\Orm\Asset;
use Pz\Orm\AssetSize;
use Pz\Orm\Customer;
use Pz\Orm\Page;
use Pz\Router\Node;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class Web extends Mo
{
    /**
     * @route("/activate/{id}", name="activate")
     * @return Response
     */
    public function activate($id)
    {
        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();

        /** @var Customer $customer */
        $customer = Customer::getByField($pdo, 'uniqid', $id);
        if (!$customer) {
            throw new NotFoundException();
        }

        if ($customer->getIsActivated() == 1) {
            throw new NotFoundException();
        }

        $customer->setIsActivated(1);
        $customer->setStatus(1);
        $customer->save();

        $data = Customer::data($pdo, array(
            'whereSql' => 'm.title = ? AND m.id != ? AND m.status = 0',
            'params' => array($customer->getTitle(), $customer->getId()),
        ));

        foreach ($data as $itm) {
            $itm->delete();
        }


        $tokenStorage = $this->container->get('security.token_storage');
        $token = new UsernamePasswordToken($customer, $customer->getPassword(), "public", $customer->getRoles());
        $tokenStorage->setToken($token);
        $this->get('session')->set('_security_member', serialize($token));
        return new RedirectResponse('\member\dashboard');
    }

    /**
     * @route("/assets/image/{id}/{size}", name="preview")
     * @return Response
     */
    public function preview($id, $size)
    {
        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();

        $file = null;
        $fileName = 'placeholder.jpg';

        /** @var Asset $orm */
        $orm = Asset::getById($pdo, $id);
        if ($orm) {
            $fileType = $orm->getFileType();
            $fileName = $orm->getFileName();
            $file = $this->container->getParameter('kernel.project_dir') . '/uploads/' . $orm->getFileLocation();
            if ($size) {
                if ((file_exists($file) && getimagesize($file)) || ('application/pdf' == $fileType)) {
                    /** @var AssetSize $sizeOrm */
                    $sizeOrm = AssetSize::getByField($pdo, 'title', $size);
                    if (!$sizeOrm) {
                        throw new NotFoundHttpException();
                    }

                    $cache = $this->container->getParameter('kernel.project_dir') . '/cache/image/';
                    if (!file_exists($cache)) {
                        mkdir($cache, 0777, true);
                    }
                    $thumbnail = $cache . md5($orm->getId() . '-' . $sizeOrm->getId() . '-' . $sizeOrm->getWidth()) . (('application/pdf' == $fileType) ? '.jpg' : '.' . pathinfo($orm->getFileName(), PATHINFO_EXTENSION));
                    if (!file_exists($thumbnail)) {
                        if ('application/pdf' == $fileType) {
                            $image = new \Imagick($file . '[0]');
                            $image->setImageFormat('jpg');
//                        $image->setColorspace(imagick::COLORSPACE_RGB);
                            $image->setImageBackgroundColor('white');
                            $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
                            $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
                            $image->thumbnailImage($sizeOrm->getWidth(), null);
                            $image->writeImage($thumbnail);
                        } else {
                            $image = new \Imagick($file);
                            $image->adaptiveResizeImage($sizeOrm->getWidth(), 0);
                            $image->writeImage($thumbnail);
                        }
                    }
                    $file = $thumbnail;
                }
            } else {
                $stream = function () use ($file) {
                    readfile($file);
                };
                return new StreamedResponse($stream, 200, array(
                    'Content-Type' => $fileType,
                    'Content-length' => filesize($file),
                    'Content-Disposition' => 'filename="' . $fileName . '"'
                ));
            }
        }

        if (!file_exists($file) || !getimagesize($file)) {
            $file = __DIR__ . '/../../../files/placeholder.jpg';
        }
        $stream = function () use ($file) {
            readfile($file);
        };
        return new StreamedResponse($stream, 200, array(
            'Content-Type' => 'image/jpg',
            'Content-length' => filesize($file),
            'Content-Disposition' => 'filename="' . $fileName . '"'
        ));
    }

    /**
     * @route("/assets/download/{id}", name="download")
     * @return Response
     */
    public function download($id)
    {
        $connection = $this->container->get('doctrine.dbal.default_connection');
        /** @var \PDO $pdo */
        $pdo = $connection->getWrappedConnection();

        /** @var Asset $orm */
        $orm = Asset::getById($pdo, $id);
        if (!$orm) {
            throw new NotFoundHttpException();
        }
        $fileType = $orm->getFileType();
        $fileName = $orm->getFileName();
        $file = $this->container->getParameter('kernel.project_dir') . '/uploads/' . $orm->getFileLocation();
        if (!file_exists($file)) {
            throw new NotFoundHttpException();
        }
        $stream = function () use ($file) {
            readfile($file);
        };
        return new StreamedResponse($stream, 200, array(
            'Content-Type' => $fileType,
            'Content-length' => filesize($file),
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ));
    }

    /**
     * @route("/{page}", requirements={"page" = ".*"}, name="web")
     * @return Response
     */
    public function web()
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
        $nodes = array();

        /** @var \PDO $pdo */
        $pdo = $this->connection->getWrappedConnection();

        /** @var Page[] $pages */
        $pages = Page::data($pdo, array(
            'whereSql' => 'm.status != 0',
        ));
        foreach ($pages as $itm) {
            $nodes[] = new Node($itm->getId(), $itm->getTitle(), 0, $itm->getRank(), $itm->getUrl(), $itm->objPageTempalte()->getFilename(), $itm->getStatus(), $itm->getAllowExtra() ?: 0, $itm->getMaxParams());
        }

        return $nodes;
    }
}