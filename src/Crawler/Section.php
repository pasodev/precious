<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 17/11/2018
 * Time: 11:31
 */

namespace App\Crawler;

use Symfony\Component\DomCrawler\Crawler;


class Section
{
    private $subsections = [];
    private $html;

    public function __construct( $html = '')
    {
        $this->html = $html;
        return $this;
    }


    public function setSubsections ( $subsections = [] )
    {
        $this->subsections = $subsections;
        return $this;
    }

    public function getSubsections()
    {
        return $this->subsections;
    }

    public function scanSubSections()
    {
       $subsections = [];

       $crawler = new Crawler( $this->html );
       $crawler = $crawler->filter('a')
           ->reduce( function (Crawler $node){
              if (strstr( $node->attr('title'), 'Ir a la catego')) {
                  return $node;
              }
           });

       $subsections = $crawler->each( function (Crawler $node) {
           return $node->attr('href');
        });

       $this->subsections = $subsections;

    }

}