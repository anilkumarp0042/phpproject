<?php

namespace AppBundle\Controller;

use AppBundle\Controller\Traits\CanaryControllerTrait;
use AppBundle\Entity\SocialShare;
use AppBundle\Entity\SocialShareCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SocialShareController extends Controller
{
    use CanaryControllerTrait;

    /**
     * @Route("/jepartage", name="app_social_share_list")
     * @Method("GET")
     */
    public function listAction(): Response
    {
        $manager = $this->getDoctrine();

        return $this->render('social_share/wall.html.twig', [
            'currentCategory' => null,
            'socialShareCategories' => $manager->getRepository(SocialShareCategory::class)->findForWall(),
            'socialShares' => $manager->getRepository(SocialShare::class)->findForWall(),
        ]);
    }

    /**
     * @Route("/jepartage/{slug}", name="app_social_share_show")
     * @Method("GET")
     */
    public function showAction(SocialShareCategory $category): Response
    {
        $manager = $this->getDoctrine();

        return $this->render('social_share/wall.html.twig', [
            'currentCategory' => $category,
            'socialShareCategories' => $manager->getRepository(SocialShareCategory::class)->findForWall(),
            'socialShares' => $this->getDoctrine()->getRepository(SocialShare::class)->findForWall($category),
        ]);
    }

    /**
     * @Route("/je-partage")
     * @Method("GET")
     */
    public function redirectAction(): Response
    {
        return $this->redirectToRoute('app_social_share_list', [], Response::HTTP_MOVED_PERMANENTLY);
    }
}
