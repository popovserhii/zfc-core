<?php
/**
 * Trait for general domain methods
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 06.04.15 14:07
 */
namespace Popov\ZfcCore\Controller;

use Zend\Mvc\Router\RouteMatch;
use Zend\View\Model\ViewModel;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class DeleteActionAwareTrait
 *
 * @package Popov\ZfcCore\Controller
 * @method \Zend\Stdlib\RequestInterface getRequest()
 * @method \Zend\Mvc\Controller\Plugin\FlashMessenger flashMessenger()
 * @method \Zend\Mvc\Controller\Plugin\Forward forward()
 * @method \Zend\Mvc\Controller\Plugin\Redirect redirect()
 * @method \Popov\Current\Plugin\Current current($name = null, $context = null)
 */
trait DeleteActionAwareTrait
{
    public function deleteClosure($entity)
    {
    }

    public function deleteAction()
    {
        /** @var RouteMatch $route */
        $request = $this->getRequest();
        $route = $this->getEvent()->getRouteMatch();
        $service = $this->getService();
        $om = $service->getObjectManager();

        if ($request->isPost()) {
            /** @var ObjectManager $om */
            $entityName = $service->getRepository()->getClassName();
            foreach ($request->getPost('ids') as $id) {
                //\Zend\Debug\Debug::dump([$entityName/*, get_class($entity)*/, $id]); die(__METHOD__);
                $entity = $om->find($entityName, $id);
                // Може бути null у випадках, коли видаляється сутність із ще не збереженої зв'язки
                // наприклад, якщо в реалізації додати дані про доручення,
                // але не зберігаючи заявку одразу спробувати її (інфу про доручення) видалити
                // в такому випадку зв'язка ще не створювалась, тому тут буде null
                if ($entity) {
                    $this->deleteClosure($entity);
                    $om->remove($entity);
                }
            }
            $om->flush();

            if ($request->isXmlHttpRequest()) {
                $response = $this->getResponse();
                $response->setContent((string) true);

                return $response;
            }

            $this->flashMessenger()->addSuccessMessage('Items has been removed successfully');
        }

        return $this->redirect()->toRoute('default', [
            'controller' => $route->getParam('controller'),
            //'lang' => $route->getParam('lang')
        ]);
    }

    public function deleteLiteAction()
    {
        /** @var RouteMatch $route */
        $request = $this->getRequest();
        $route = $this->getEvent()->getRouteMatch();
        $service = $this->getService();
        $om = $service->getObjectManager();

        if ($request->isPost()) {
            /** @var ObjectManager $om */
            $entityName = $service->getRepository()->getClassName();
            /** @var Builder $qb */
            $qb = $om->createQueryBuilder($entityName);
            $isDeleted = $qb->remove()
                ->field('id')->in($request->getPost('ids'))
                ->getQuery()
                ->execute();

            $isDeleted
                ? $this->flashMessenger()->addSuccessMessage('Items has been removed successfully')
                : $this->flashMessenger()->addErrorMessage('Removing ended in failure');
        }

        return $this->redirect()->toRoute('default', [
            'controller' => $route->getParam('controller'),
            //'lang' => $route->getParam('lang')
        ]);
    }
}
