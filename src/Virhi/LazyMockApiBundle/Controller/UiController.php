<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 02/02/15
 * Time: 09:03
 */

namespace Virhi\LazyMockApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Query\ListMockContext;
use Virhi\LazyMockApiBundle\Mock\Application\Context\Query\MockContext;
use Virhi\LazyMockApiBundle\Mock\Infrastructure\Entity\Mock;
use Virhi\AdminBundle\DTO\MenuItem;
use Virhi\AdminBundle\DTO\User;

class UiController extends Controller
{
    public function indexAction()
    {
        return $this->render('VirhiLazyMockApiBundle:Mock:index.html.twig', array('mock' => new Mock()));
    }

    public function listMockAction()
    {
        $context = new ListMockContext();
        $result  = $this->get('virhi_lazy_mock_api.application.query.list')->execute($context);

        return $this->render('VirhiLazyMockApiBundle:Mock:list.html.twig', array('list' => $result));
    }

    public function mockAction($key)
    {
        $context = new MockContext($key);
        $result  = $this->get('virhi_lazy_mock_api.application.query.mock')->execute($context);

        return $this->render('VirhiLazyMockApiBundle:Mock:index.html.twig', array('mock' => $result));
    }

    public function sidebarAction()
    {
        $menu = array(
            new MenuItem("Generale"),
            new MenuItem("Home", $this->get('router')->generate('virhi_lazy_mock_api_ui_homepage')),
            new MenuItem("List", $this->get('router')->generate('virhi_lazy_mock_api_ui_list')),
        );

        $viewParams = array(
            'menu_item_list' => $menu,
        );

        return $this->render('VirhiAdminBundle:Theme:sidebar.html.twig', $viewParams);
    }

    public function headerAction()
    {
        $viewParams = array(
            'user' =>  new User('vincent', 'rhino', 'developpeur', true),
        );
        return $this->render('VirhiAdminBundle:Theme:header.html.twig', $viewParams);
    }

    public function footerAction()
    {
        $viewParams = array(
        );
        return $this->render('VirhiAdminBundle:Theme:footer.html.twig', $viewParams);
    }
}