<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 08/11/2018
 * Time: 11:26
 */

namespace App\Crawler;

use Symfony\Component\DomCrawler\Crawler;

class GenericCrawler implements CrawlerInterface
{

    private $url='';
    private $html = '';
    private $dom = NULL;
    protected $home = '';
    protected $sections = [];

    public function __construct( $url=NULL )
    {
        if (!is_null($url)) {
            $this->setUrl($url);
        }
        return $this;
    }
    public function setUrl( $url )
    {
        $this->url = $url;
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setHtml( $html = false )
    {
        if ($html) {
            $this->html = $html;
            return $this;
        }

        $sourcer = new  \App\Network\UrlSourcer($this->getUrl());
        $this->html = $sourcer->get();
        return $this;
    }

    public function getHtml()
    {
        return $this->html;
    }

    public function setDom()
    {
        $this->dom = new \DOMDocument( $this->html );
    }

    public function getDom()
    {
        return $this->dom;
    }

    public function getProducts()
    {
        return $this;
    }

    public function getProduct($productName = false)
    {
        return $this;
    }

    public function setSections( $sections = [] )
    {
        $this->sections = $sections;
        return $this;
    }

    public function getSections()
    {
        return $this->sections;
    }
}