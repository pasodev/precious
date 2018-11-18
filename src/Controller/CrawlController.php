<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Crawler;

class CrawlController extends AbstractController
{
    /**
     * @Route("/crawl", name="crawl")
     */
    public function index()
    {
        return $this->render('crawl/index.html.twig', [
            'controller_name' => 'CrawlController',
        ]);
    }

    /**
     * @Route("/crawl/launch/{site}", name="crawl_site")
     */
    public function launch( $site )
    {
        $status = 'class not found';
        $crawlerName   = '\App\Crawler\\' . ucfirst($site) . 'Crawler';
        if (class_exists($crawlerName)) {
            $status = $crawlerName;
            $crawler = new $crawlerName();

            var_dump($crawler->getProducts());
        }

        return $this->render('crawl/index.html.twig', [
            'controller_name' => 'CrawlController',
            'status' => $status,
            'crawler_name' => $crawlerName,
        ]);
    }
}
