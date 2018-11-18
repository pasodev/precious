<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 17/7/17
 * Time: 15:36
 */

namespace App\Network;

class UrlSourcer implements Sourcer
{
    protected $crawlTime = "";
    protected $url = "";
    protected $tor = "";
    protected $proxy = "";

    private $userAgents = [
        "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2226.0 Safari/537.36",
        "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2224.3 Safari/537.36",
        "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.67 Safari/537.36",
        "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.16 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1",
        "Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0",
        "Mozilla/5.0 (Windows NT 6.0; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0",
        "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20130331 Firefox/21.0",
        "Mozilla/5.0 (Windows; U; Windows NT 6.1; tr-TR) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A",
        ];

    public function __construct($url = null, $useTor = true, $useProxy = false)
    {
        $this->url = $url;
        $this->tor = $useTor;
        $this->proxy = $useProxy;

        $this->crawlTime = new \DateTime();
    }

    public function get()
    {
        if (!is_null($this->url)) {
            $url = $this->url;
        } else {
            return false;
        }
        if ($ch = \curl_init()) {

            if ($this->tor) {
                $this->tor_new_identity();
                $proxy = "127.0.0.1:9050";
                curl_setopt($ch, CURLOPT_PROXY, $proxy);
                curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            } elseif ($this->proxy) {
                $proxy = $this->getProxy();
                curl_setopt($ch, CURLOPT_PROXY, $proxy);
            }

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgents[array_rand($this->userAgents)]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $response = curl_exec($ch);
            if ($response === false) {
                echo 'Curl error ' . curl_error($ch) . PHP_EOL;
                return false;
            }
            curl_close($ch);
            return $response;

        }
        return false;

    }

    /**
     * Switch TOR to a new identity.
     *
     * To use this function you have to edit /etc/tor/torrc and set
     *
     * ControlPort 9051
     * HashedControlPassword 16:B79933CEA03B81CC6014D852A9697CCBD2A9338565ACF794CC4559D663
     *
     * The hashedcontrolpassword is generated executing this from command line
     * tor --hash-password
     *
     **/
    public function tor_new_identity($tor_ip='127.0.0.1', $control_port='9051', $auth_code='')
    {
        $fp = fsockopen($tor_ip, $control_port, $errno, $errstr, 30);
        if (!$fp) {
            echo "\n *****************************************************************************\n";
            echo "CURL WONT WORK!!\n\n";
            echo "You are trying to reset tor identity, but your config is not properly set.\n";
            echo "Edit your /etc/tor/torrc file with: \n";
            echo "ControlPort 9051\n";
            echo "HashedControlPassword 16:xxx # this value is the result of executing `tor --hash-password`\n";
            echo "\n *****************************************************************************\n";
            return false; //can't connect to the control port
        }


        fputs($fp, "AUTHENTICATE $auth_code\r\n");
        $response = fread($fp, 1024);
        list($code, $text) = explode(' ', $response, 2);
        if ($code != '250') return false; //authentication failed

        //send the request to for new identity
        fputs($fp, "signal NEWNYM\r\n");
        $response = fread($fp, 1024);

        list($code) = explode(' ', $response, 2);
        if ($code != '250') return false; //signal failed

        fclose($fp);
        return true;
    }


    private function getProxy()
    {
        return "45.55.192.102:8118";

        $proxies = [];
        $html = $this->getUrl("https://free-proxy-list.net/anonymous-proxy.html");
        var_dump($html);
        $crawler = new Symfony\Component\DomCrawler\Crawler($html);

        $crawler->filterXPath('//*[@id="proxylisttable"]/tbody/tr')->each(function ($node, $i) {
            var_dump($node);
            //$proxy = $node->filterXPath('//td[1]')->text() . ":" . $node->filterXPath('//td[2]')->text();
            echo $proxy .PHP_EOL;
            $proxies[] = $proxy;
        });
        $proxyNumber = rand(0, sizeof($proxies) - 1);
        die;
        return $proxies[$proxyNumber];
    }
}
