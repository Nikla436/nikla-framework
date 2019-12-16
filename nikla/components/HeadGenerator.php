<?php

namespace nikla\components;


class HeadGenerator
{
    private $title = '';
    private $charset = 'utf-8';
    private $robots = "index,follow";
    private $baseURL = null;

    private $aScripts = [];
    private $aStylesheets = [];
    private $aMetaTags = [];

    // Personal message comment at top of <head>
    private $useMessage = false;
    private $messageTitle = '';
    private $message = '';

    // Twitter Related Tags
    private $useTwitter = false;
    private $twitter_card = '';
    private $twitter_site = '';
    private $twitter_creator = '';
    private $twitter_url = '';
    private $twitter_title = '';
    private $twitter_description = '';
    private $twitter_image = '';
    private $twitter_image_alt = '';


    /**
     * HeadGenerator constructor.
     * @param string $title
     */
    public function __construct($title)
    {
        $this->title = trim($title);
    }

    /**
     * Generate your head element and returns the finished string
     * @return string - <head> HTML
     */
    public function create()
    {
        $html  = "<head>\n";

        if ($this->useMessage) {
            $html .= "\t<!--\n";
            $html .= empty($this->messageTitle) ? '' : "\t\t{$this->messageTitle}\n\n";
            $html .= "\t\t{$this->message}\n";
            $html .= "\t-->\n";
        }

        $html .= "\t<title>{$this->title}</title>\n";
        $html .= "\t<meta charset='{$this->charset}'>\n";
        $html .= "\t<meta name='robots' content='{$this->robots}'>\n";
        $html .= is_null($this->baseURL) ? '' : "<base href='{$this->baseURL}'>\n";

        if (!empty($this->aScripts)) {
            $html .= "\n\t<!-- Scripts -->\n";
            foreach ($this->aScripts as $scriptURL) {
                $html .= "\t<script src='{$scriptURL}'></script>\n";
            }
        }

        if (!empty($this->aStylesheets)) {
            $html .= "\n\t<!-- StyleSheets -->\n";
            foreach ($this->aStylesheets as $stylesheetURL) {
                $html .= "\t<link rel='stylesheet' href='{$stylesheetURL}'>\n";
            }
        }

        if (!empty($this->aMetaTags)) {
            $html .= "\n\t<!-- Meta Tags -->\n";
            foreach ($this->aMetaTags as $name => $content) {
                $html .= "\t<meta name='{$name}' content='{$content}'>\n";
            }
        }

        if ($this->useTwitter) {
            $html .= "\n\t<!-- Twitter Tags -->\n";
            $html .= empty($this->twitter_card)        ? '' : "\t<meta name='twitter:card'        content='{$this->twitter_card}'>\n";
            $html .= empty($this->twitter_site)        ? '' : "\t<meta name='twitter:site'        content='{$this->twitter_site}'>\n";
            $html .= empty($this->twitter_creator)     ? '' : "\t<meta name='twitter:creator'     content='{$this->twitter_creator}'>\n";
            $html .= empty($this->twitter_url)         ? '' : "\t<meta name='twitter:url'         content='{$this->twitter_url}'>\n";
            $html .= empty($this->twitter_title)       ? '' : "\t<meta name='twitter:title'       content='{$this->twitter_title}'>\n";
            $html .= empty($this->twitter_description) ? '' : "\t<meta name='twitter:description' content='{$this->twitter_description}'>\n";
            $html .= empty($this->twitterImage)        ? '' : "\t<meta name='twitter:image'       content='{$this->twitter_image}'>\n";
            $html .= empty($this->twitter_image_alt)   ? '' : "\t<meta name='twitter:image:alt'   content='{$this->twitter_image_alt}'>\n";
        }

        $html .= "</head>\n\n";
        return $html;
    }

    //--------------------------------------------------------------------------------------------------------------
    // Setter Functions
    // Each return $this and can be chained together
    //--------------------------------------------------------------------------------------------------------------

    /**
     * @param string $value
     * @return $this
     */
    public function setCharset($value)
    {
        $this->charset = trim($value);
        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setBaseURL($url)
    {
        $this->baseURL = trim($url);
        return $this;
    }

    public function setRobots($value)
    {
        $this->robots = trim($value);
    }

    /**
     * @param string $name
     * @param string $content
     * @return $this
     */
    public function addMetaTag($name, $content)
    {
        if (!array_key_exists($name, $this->aMetaTags)) {
            $this->aMetaTags[$name] = $content;
        }
        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function addStylesheet($url)
    {
        if (!in_array($url, $this->aStylesheets)) {
            $this->aStylesheets[] = $url;
        }
        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function addScript($url)
    {
        if (!in_array($url, $this->aScripts)) {
            $this->aScripts[] = $url;
        }
        return $this;
    }

    // Add Twitter related tags
    public function addTwitter($card = '', $site = '', $creator = '', $url = '', $title = '', $description = '', $image = '', $imageALT = '')
    {
        $this->twitter_card = $card;
        $this->twitter_site = $site;
        $this->twitter_creator = $creator;
        $this->twitter_url = $url;
        $this->twitter_title = $title;
        $this->twitter_description = $description;
        $this->twitter_image = $image;
        $this->twitter_image_alt = $imageALT;
        $this->useTwitter = true;
        return $this;
    }

    public function addFaceBook()
    {
        // TODO: Add these tags.
        //<meta property="fb:app_id" content="123456789">
        //<meta property="og:url" content="https://example.com/page.html">
        //<meta property="og:type" content="website">
        //<meta property="og:title" content="Content Title">
        //<meta property="og:image" content="https://example.com/image.jpg">
        //<meta property="og:image:alt" content="A description of what is in the image (not a caption)">
        //<meta property="og:description" content="Description Here">
        //<meta property="og:site_name" content="Site Name">
        //<meta property="og:locale" content="en_US">
        //<meta property="article:author" content="">
        return $this;
    }

    public function addPersonalMessage($messageTitle = '', $message = '')
    {
        $this->message = $message;
        $this->messageTitle = $messageTitle;
        $this->useMessage = true;
        return $this;
    }
}