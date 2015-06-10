<?php namespace Watson\Taggly;

class Taggly {

    /**
     * The tags for the cloud.
     *
     * @var array
     */
    protected $tags;

    /**
     * The minimum tag count.
     *
     * @var int
     */
    protected $minimumCount;

    /**
     * The maximum tag count.
     *
     * @var int
     */
    protected $maximumCount;

    /**
     * The minimum font size.
     *
     * @var int
     */
    protected $minimumFontSize = 12;

    /**
     * The maximum font size.
     *
     * @var int
     */
    protected $maximumFontSize = 24;

    /**
     * Whether to shuffle the tags.
     *
     * @var bool
     */
    protected $shuffleTags = true;

    /**
     * Get the tags.
     *
     * @return array
     */
    public function getTags()
    {
        return is_array($this->tags) ? $this->tags : [];
    }

    public function setTags(array $tags = [])
    {
        $this->tags = [];

        foreach ($tags as $tag)
        {
            $this->tags[] = $tag instanceof Tag ? $tag : new Tag($tag);
        }
    }

    /**
     * Get the lowest count of the tags.
     *
     * @return int
     */
    public function getMinimumCount()
    {
        $minimumCount = 0;

        foreach ($this->getTags() as $tag)
        {
            if ( ! $minimumCount)
            {
                $minimumCount = $tag->getCount();
            } 
            else if ($minimumCount > $tag->getCount()) 
            {
                $minimumCount = $tag->getCount();
            }
        }

        return $minimumCount;
    }

    /**
     * Get the highest count of the tags.
     *
     * @return int
     */
    public function getMaximumCount()
    {
        $maximumCount = null;

        foreach ($this->getTags() as $tag)
        {
            if ( ! $maximumCount)
            {
                $maximumCount = $tag->getCount();
            }
            else if ($maximumCount < $tag->getCount())
            {
                $maximumCount = $tag->getCount();
            }
        }

        return $maximumCount;
    }

    /**
     * Get the offset between the highest and lowest tag count.
     *
     * @return int
     */
    public function getOffset()
    {
        $offset = $this->getMaximumCount() - $this->getMinimumCount();

        return ($offset < 1) ? 1 : $offset;
    }

    /**
     * Get the minimum font size.
     *
     * @return int
     */
    public function getMinimumFontSize()
    {
        return $this->minimumFontSize;
    }

    /**
     * Set the minimum font size.
     *
     * @param  int  $value
     * @return void
     */
    public function setMinimumFontSize($value)
    {
        $this->minimumFontSize = (int) $value;
    }

    /**
     * Get the maximum font size.
     *
     * @return int
     */
    public function getMaximumFontSize()
    {
        return $this->maximumFontSize;
    }

    /**
     * Set the maximum font size.
     *
     * @param  int  $value
     * @return void
     */
    public function setMaximumFontSize($value)
    {
        $this->maximumFontSize = (int) $value;
    }

    /**
     * Get whether the tags are being shuffled.
     *
     * @return bool
     */
    public function getShuffleTags()
    {
        return $this->shuffleTags;
    }

    /**
     * Set whether the tags are being shuffled.
     *
     * @param  bool  $value
     * @return void
     */
    public function setShuffleTags($value)
    {
        $this->shuffleTags = (bool) $value;
    }

    /**
     * Generate a tag cloud using either the tags provided or tags
     * that have already been registered.
     *
     * @param  array  $tags
     * @return string
     */
    public function cloud(array $tags = null)
    {
        if ($tags) $this->setTags($tags);

        $tags = $this->getTags() ?: [];

        $output = '';

        if ($this->getShuffleTags()) shuffle($tags);

        foreach ($tags as $tag)
        {
            $output .= $this->getTagElement($tag);
        }

        return '<div class="tags">'.$output.'</div>';
    }

    /**
     * Get the font size in units for a given tag.
     *
     * @param  Tag  $tag
     * @return int
     */
    public function getFontSize(Tag $tag)
    {
        return $this->getMinimumFontSize() + ($tag->getCount() - $this->getMinimumCount()) 
            + ($this->getMaximumFontSize() - $this->getMinimumFontSize()) / $this->getOffset();
    }

    /**
     * Get the element for a given tag.
     *
     * @param  Tag  $tag
     * @return string
     */
    public function getTagElement(Tag $tag)
    {
        $fontSize = $this->getFontSize($tag);

        if ($tag->getUrl())
        {
            return '<a href="'.$tag->getUrl().'" class="tag" title="'.$tag->getTag().'" '
                .'style="font-size: '.floor($fontSize).'px">'.e($tag->getTag()).'</a>';
        }

        return '<span class="tag" title="'.$tag->getTag().'" style="font-size: '
            .floor($fontSize).'px">'.e($tag->getTag()).'</span>';
    }

}
