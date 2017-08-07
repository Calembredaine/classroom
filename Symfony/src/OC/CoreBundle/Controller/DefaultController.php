<?php

namespace OC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('OCCoreBundle:Default:index.html.twig');
    }
    /**
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function contactAction(Request $request)
    {
        $request->getSession()
        ->getFlashBag()
        ->add('warning', "La page de contact n'est pas encore disponible. Merci de revenir plus tard.")
        ;
        return $this->redirectToRoute('homepage');
        //return $this->render('OCCoreBundle:Default:contact.html.twig');
    }
}
