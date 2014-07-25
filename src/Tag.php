<?php namespace Watson\Taggly;

class Tag {

    /**
     * The tag.
     * 
     * @var string
     */    
    protected $tag;

    /**
     * The tag count.
     *
     * @var int
     */
    protected $count;

    /**
     * The tag URL.
     *
     * @var string
     */
    protected $url;

    /**
     * Initialize the tag, using an associative array as a convenience helper if
     * one is provided.
     *
     * @param  array  $tag
     * @return void
     */
    public function __construct(array $tag = null, $count = null, $url = null)
    {
        if (is_array($tag))
        {
            $this->fillFromArray($tag);
        }
        else
        {
            $this->setTag($tag);
            $this->setCount($count);
            $this->setUrl($url);
        }
    }

    public function fillFromArray(array $tag)
    {
        $this->setTag(array_get($tag, 'tag'));
        $this->setCount(array_get($tag, 'count'));
        $this->setUrl(array_get($tag, 'url'));
    }

    /**
     * Get the tag.
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set the tag.
     *
     * @param  string  $tag
     * @return void
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get the tag count.
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set the tag count.
     *
     * @param  int  $count
     * @return void
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * Get the tag URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the tag URL.
     *
     * @param  string  $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

}
