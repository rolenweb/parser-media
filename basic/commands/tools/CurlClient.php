<?php
namespace app\commands\tools;

use app\commands\tools\ClientInterface;
use app\commands\tools\SymfonyParser;
use Symfony\Component\DomCrawler\Link;
use yii\base\InvalidConfigException;

class CurlClient implements ClientInterface
{
	private $curl;
	private $url;
	private $result;
	private $request_info;
	protected $max_redirects = 5;
	protected $timeout = 10;

	public function __construct()
	{
		$this->curl = curl_init();
	}

	/**
	 * @inheritdoc
	 */
	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getContent()
	{
		$this->applySettings();
		$this->result = curl_exec($this->curl);
		$this->request_info = curl_getinfo($this->curl);

		return $this->result;
	}

	/**
	 * @inheritdoc
	 */
	public function getContentWithInfo()
	{
		$this->applySettings();
		$this->result = curl_exec($this->curl);
		$this->request_info = curl_getinfo($this->curl);

		return [
			'result' => $this->result,
			'info' => $this->request_info,
			];
	}

	public function getContentWithInfo2($type = null,$ip = null, $port = null,$reffer = null,$post = 'no')
	{
		$this->applySettings2($type,$ip,$port,$reffer,$post);
		$this->result = curl_exec($this->curl);
		$this->request_info = curl_getinfo($this->curl);

		return [
			'result' => $this->result,
			'info' => $this->request_info,
			];
	}

	/**
	 * @inheritdoc
	 */
	public function getResponse()
	{
		// @todo implement
	}

	public function getContentType()
	{
		if (isset($this->request_info['content_type'])) {
			return $this->request_info['content_type'];
		}
	}

	protected function applySettings()
	{
		if (empty($this->url)) {
			throw new InvalidConfigException('URL should be specified');
		}
		curl_setopt($this->curl, CURLOPT_URL, $this->url);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl, CURLOPT_MAXREDIRS, $this->max_redirects);
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, ['Expect:']);
		curl_setopt($this->curl, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
	}

	protected function applySettings2($type = null,$ip = null, $port = null,$reffer = null,$post = 'no')
	{
		if (empty($this->url)) {
			throw new InvalidConfigException('URL should be specified');
		}

		array_map('unlink', glob("cookiefile/*"));
		$ckfile = tempnam("cookiefile", "CURLCOOKIE");
        $useragent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.2 (KHTML, like Gecko) Chrome/5.0.342.3 Safari/533.2';

        //$f = fopen('cookiefile/log.txt', 'w'); // file to write request 

		curl_setopt($this->curl, CURLOPT_URL, $this->url);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl, CURLOPT_MAXREDIRS, $this->max_redirects);
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, ['Expect:']);
		curl_setopt($this->curl, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $ckfile);
		curl_setopt($this->curl, CURLOPT_USERAGENT, $useragent);
		if ($type === 'socks5') {

			curl_setopt ($this->curl, CURLOPT_PROXY, $ip.':'.$port); 
         	curl_setopt ($this->curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); 
		}
		if ($type === 'socks4') {
			curl_setopt ($this->curl, CURLOPT_PROXY, $ip.':'.$port); 
         	curl_setopt ($this->curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4); 
		}
		if ($reffer !== null) {
			curl_setopt ($this->curl, CURLOPT_REFERER, $reffer); 	
		}
		if ($post === 'yes') {
			curl_setopt($this->curl, CURLOPT_POST, 1);
			curl_setopt($this->curl, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8"));
		}
	}

	public function parsePage($url)
	{	
		$content = $this->setUrl($url)->getContentWithInfo();
		if (empty($content['info']['http_code']) === false) {
			if ($content['info']['http_code'] === 200) {
				if (empty($content['result']) === false) {
					return $content['result'];
				}
			}
		}
		return;
	}

	public function parsePage2($url,$type = null,$ip = null, $port = null,$reffer = null,$post = 'no')
	{	
		$content = $this->setUrl($url)->getContentWithInfo2();
		if (empty($content['info']['http_code']) === false) {
			if ($content['info']['http_code'] === 200) {
				if (empty($content['result']) === false) {
					return $content['result'];
				}
			}
		}
		return;
	}

	public function parseProperty($content,$type,$pattern,$url = null,$attr = null)
	{
		$parser = (new SymfonyParser)->in($content, $this->getContentType());
		$result = [];
		if ($type === 'link') {
			$nodes = $parser->find($pattern);
			if (empty($nodes) === false) {
				foreach ($nodes as $node) {
					$link = new Link($node, $url, 'GET');
					$result[] = $link->getUri();
				}		
			}
		}
		if ($type === 'string') {
			$nodes = $parser->find($pattern);

			if (empty($nodes) === false) {
				foreach ($nodes as $node) {
					$result[] = $node->textContent;
				}
			}
		}

		if ($type === 'attribute') {
			$result = $parser->filter($pattern)->extract(array($attr));
		}
		return $result;
	}

	public function __destruct()
	{
		curl_close($this->curl);
	}
}