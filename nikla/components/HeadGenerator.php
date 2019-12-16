<?php

namespace nikla\components;


class HeadGenerator
{
    private $title = '';
    private $charset = 'utf-8';
    private $robots = "index,follow";

    private $aScripts = [];
    private $aStylesheets = [];
    private $aMetaTags = [];

    // Optional Values
    private $baseURL = null;


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
        $html  = "<head>";
        $html .= "<title>{$this->title}</title>";
        $html .= "<meta charset='{$this->charset}'>";
        $html .= "<meta name='robots' content='{$this->robots}'>";
        $html .= is_null($this->baseURL) ? '' : "<base href='{$this->baseURL}'>";

        if (!empty($this->aScripts)) {
            $html .= "<!-- Scripts -->";
            foreach ($this->aScripts as $scriptURL) {
                $html .= "<script src='{$scriptURL}'></script>";
            }
        }

        if (!empty($this->aStylesheets)) {
            $html .= "<!-- StyleSheets -->";
            foreach ($this->aStylesheets as $stylesheetURL) {
                $html .= "<link rel='stylesheet' href='{$stylesheetURL}'>";
            }
        }

        if (!empty($this->aMetaTags)) {
            $html .= "<!-- Meta Tags -->";
            foreach ($this->aMetaTags as $name => $content) {
                $html .= "<meta name='{$name}' content='{$content}'>";
            }
        }

        if ($this->useTwitter) {
            $html .= "<!-- Twitter Tags -->";
            $html .= empty($this->twitter_card)        ? '' : "<meta name='twitter:card'        content='{$this->twitter_card}'>";
            $html .= empty($this->twitter_site)        ? '' : "<meta name='twitter:site'        content='{$this->twitter_site}'>";
            $html .= empty($this->twitter_creator)     ? '' : "<meta name='twitter:creator'     content='{$this->twitter_creator}'>";
            $html .= empty($this->twitter_url)         ? '' : "<meta name='twitter:url'         content='{$this->twitter_url}'>";
            $html .= empty($this->twitter_title)       ? '' : "<meta name='twitter:title'       content='{$this->twitter_title}'>";
            $html .= empty($this->twitter_description) ? '' : "<meta name='twitter:description' content='{$this->twitter_description}'>";
            $html .= empty($this->twitterImage)        ? '' : "<meta name='twitter:image'       content='{$this->twitter_image}'>";
            $html .= empty($this->twitter_image_alt)   ? '' : "<meta name='twitter:image:alt'   content='{$this->twitter_image_alt}'>";
        }

        $html .= "</head>";
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
}