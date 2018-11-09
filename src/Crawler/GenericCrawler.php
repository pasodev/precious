<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 08/11/2018
 * Time: 11:26
 */

namespace Crawler;

include "../Network/TorCurl/UrlSourcer.php";
include "Crawler.php";


class GenericCrawler implements Crawler
{

    private $url='';
    private $html = '';
    private $dom = NULL;

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

        $sourcer = new  \src\Network\UrlSourcer($this->getUrl());
        $this->setHtml($sourcer->get());
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
}