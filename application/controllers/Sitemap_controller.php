<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap_controller extends CI_Controller
{
    const MAX_URLS_PER_FILE = 45000;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'seo_url'));
        $this->load->model('Sitemap_Model');
    }

    public function index()
    {
        $urls = $this->Sitemap_Model->getAllUrls();
        $urlCount = count($urls);

        if ($urlCount === 0) {
            show_404();
            return;
        }

        header('Content-Type: application/xml; charset=utf-8');

        if ($urlCount > self::MAX_URLS_PER_FILE) {
            $chunks = array_chunk($urls, self::MAX_URLS_PER_FILE);
            $sitemaps = array();
            foreach ($chunks as $index => $chunk) {
                $sitemaps[] = array(
                    'loc' => rtrim(base_url('sitemap_' . ($index + 1) . '.xml'), '/'),
                    'lastmod' => gmdate('Y-m-d\TH:i:s\Z'),
                );
            }
            echo $this->renderSitemapIndex($sitemaps);
            return;
        }

        echo $this->renderUrlset($urls);
    }

    public function viewItems($page = 1)
    {
        $page = max(1, intval($page));
        $urls = $this->Sitemap_Model->getAllUrls();
        $chunks = array_chunk($urls, self::MAX_URLS_PER_FILE);

        if (!isset($chunks[$page - 1])) {
            show_404();
            return;
        }

        header('Content-Type: application/xml; charset=utf-8');
        echo $this->renderUrlset($chunks[$page - 1]);
    }

    public function publish2SearchEngine()
    {
        $isProductionServer = strpos(base_url(), 'vananhshop') !== false;
        if (!$isProductionServer) {
            echo 'Publish skipped: not production server.';
            return;
        }

        $sitemapUrl = urlencode(rtrim(base_url('sitemap.xml'), '/'));
        $endpoints = array(
            'Google' => "https://www.google.com/ping?sitemap={$sitemapUrl}",
            'Bing' => "https://www.bing.com/webmasters/ping.aspx?siteMap={$sitemapUrl}",
        );

        foreach ($endpoints as $name => $endpoint) {
            $code = $this->submit($endpoint);
            if ($code !== 200) {
                echo "Error {$code}: {$name} ping failed: {$endpoint} <br/>";
            } else {
                echo "Submitted {$code}: {$name} ping succeeded: {$endpoint} <br/>";
            }
        }
    }

    private function renderSitemapIndex(array $sitemaps)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($sitemaps as $item) {
            $xml .= "  <sitemap>\n";
            $xml .= '    <loc>' . $this->xmlEscape($item['loc']) . '</loc>\n';
            $xml .= '    <lastmod>' . $this->xmlEscape($item['lastmod']) . '</lastmod>\n';
            $xml .= "  </sitemap>\n";
        }

        $xml .= '</sitemapindex>';
        return $xml;
    }

    private function renderUrlset(array $urls)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $entry) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . $this->xmlEscape($entry['loc']) . '</loc>';
            if (!empty($entry['lastmod'])) {
                $xml .= '    <lastmod>' . $this->xmlEscape($entry['lastmod']) . '</lastmod>';
            }
            if (!empty($entry['changefreq'])) {
                $xml .= '    <changefreq>' . $this->xmlEscape($entry['changefreq']) . '</changefreq>';
            }
            if (!empty($entry['priority'])) {
                $xml .= '    <priority>' . $this->xmlEscape($entry['priority']) . '</priority>';
            }
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';
        return $xml;
    }

    private function xmlEscape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }

    private function submit($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpCode;
    }
}
