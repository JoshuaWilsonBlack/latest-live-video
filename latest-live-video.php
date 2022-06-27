<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use Grav\Common\Page\Collection;
use Grav\Common\Uri;
use Grav\Common\GPM\Response;
use Grav\Common\Taxonomy;

/**
 * Class LatestLiveVideoPlugin
 * @package Grav\Plugin
 */
class LatestLiveVideoPlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onPluginsInitialized' => [
                // Uncomment following line when plugin requires Grav < 1.7
                // ['autoload', 100000],
                ['onPluginsInitialized', 0]
            ]
        ];
    }

    /**
     * Composer autoload
     *
     * @return ClassLoader
     */
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized(): void
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        $this->enable([
                'onTwigInitialized' => ['onTwigInitialized', 0]
            ]);
    }

    /**
     * @param Event $e
     */
     public function onTwigInitialized()
     {
         $this->grav['twig']->twig()->addFunction(
             new \Twig_SimpleFunction('chunker', [$this, 'chunkString'])
         );
         $this->grav['twig']->twig->addFunction(new \Twig_SimpleFunction('get_latest_video',
             [$this, 'getLatestVideo']));
     }

     /**
     * Break a string up into chunks
     */
     public function chunkString($string, $chunksize = 4, $delimiter = '-')
     {
         return (trim(chunk_split($string, $chunksize, $delimiter), $delimiter));
     }

// Get embed code for most recent facebook live video.
     public function getLatestVideo() {
       $config = $this->config();
       $page_id = $config['page_id'];
       $page_access = $config['page_access_id'];

       $url =
          'https://graph.facebook.com/v12.0/' . $page_id
          . '/?fields=live_videos.limit(1)%7Bembed_html%2Cbroadcast_start_time%2Cdescription%7D&access_token='. $page_access;
       $results = Response::get($url);
       $obj = json_decode($results);
       $data = $obj->{'live_videos'}->{'data'};
       $embed = $data[0] -> {'embed_html'};
       $title = $data[0] -> {'description'};
       $formatted = "<h3>" . $title . "</h3>" . '<div class="video-responsive">' . $embed . '</div>';
       return $formatted;
     }
}
