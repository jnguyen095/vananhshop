<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function getAllUrls()
    {
        $urls = array();
        $urls[] = $this->createUrlEntry('', null, 'daily', '1.0');
        $urls = array_merge($urls, $this->getCategoryUrls());
        $urls = array_merge($urls, $this->getProductUrls());
        return $urls;
    }

    public function getCategoryUrls()
    {
        $categories = $this->db
            ->select('CategoryID, CatName')
            ->from('category')
            ->where('Active', 1)
            ->get()
            ->result();

        $urls = array();
        foreach ($categories as $category) {
            $path = seo_url($category->CatName) . '-c' . $category->CategoryID.'.html';
            $urls[] = $this->createUrlEntry($path, null, 'weekly', '0.8');
        }

        return $urls;
    }

    public function getProductUrls()
    {
        $products = $this->db
            ->select('ProductID, Title, ModifiedDate, PostDate')
            ->from('product')
            ->where('Status', 1)
            ->order_by('ModifiedDate', 'desc')
            ->get()
            ->result();

        $urls = array();
        foreach ($products as $product) {
            if (empty($product->Title)) {
                continue;
            }
            $path = seo_url($product->Title) . '-p' . $product->ProductID. '.html';
            $urls[] = $this->createUrlEntry($path, $product->ModifiedDate ?: $product->PostDate, 'weekly', '0.6');
        }

        return $urls;
    }

    protected function createUrlEntry($path, $lastmod = null, $changefreq = 'weekly', $priority = '0.5')
    {
        $url = rtrim(base_url($path), '/');
        return array(
            'loc' => $url,
            'lastmod' => $this->formatLastMod($lastmod),
            'changefreq' => $changefreq,
            'priority' => $priority,
        );
    }

    protected function formatLastMod($date)
    {
        if (empty($date)) {
            return date('Y-m-d');
        }

        $timestamp = strtotime($date);
        if ($timestamp === false || $timestamp === -1) {
            return date('Y-m-d');
        }

        return gmdate('Y-m-d\TH:i:s\Z', $timestamp);
    }
}
