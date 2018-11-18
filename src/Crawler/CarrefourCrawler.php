<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 17/11/2018
 * Time: 11:03
 */

namespace App\Crawler;

use Symfony\Component\DomCrawler\Crawler;

class CarrefourCrawler extends GenericCrawler
{
    private $current = '';

    public function __construct()
    {
        $this->home = 'https://www.carrefour.es';
        $this->current = $this->home;
        parent::__construct( $this->home);
    }


    public function getSections()
    {
        if (!empty($this->sections)) {
            return $this->sections;
        }


    }

    public function obtainSections( $html = false )
    {
        if ( !$html ) {
            $html =  $this->setUrl($this->home)->setHtml()->getHtml();
        }
        $crawler = new Crawler( $html );
        $crawler
            ->filter('body > div.innerbody > header > div.wrap > div.left-content > nav > div > div > div  > ul > li >label')
            ->reduce(function (Crawler $node) {
                $this->sections[] = str_replace('"', '', strtolower( $node->text()));
            });
        return $this;

    }

    public function setSections( $sections = [])
    {
        if (!empty($sections)){
            return parent::setSections();
        }

        $this->sections = $this->obtainSections();

        return $this;
    }

    private function setSubsections( \App\Crawler\Section $section, $sectionName)
    {

        return $this;
    }

    public function getProducts ( $sectionName = false )
    {
        if ($sectionName) {

                $this->setUrl($this->home . '/' . $sectionName)->setHtml();
                $section = new \App\Crawler\Section( $this->getHtml() );
                $this->setSubsections( $section, $sectionName);


        } elseif (empty( $this->sections)) {
            {
                $this->setSections();
            }

            foreach ($this->sections as $sectionName) {

                $this->setUrl($this->home . '/' . $sectionName)->setHtml();
                $section = new \App\Crawler\Section( $this->getHtml() );
                $this->setSubsections( $section, $sectionName);

            }
        }



        return $this;
    }

    public function getProduct($productName = false)
    {

    }
}