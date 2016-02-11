<?php namespace Watson\Taggly;


class Taggly {

	/**
     * The tags for the cloud.
     *
     * @var array
     */
    protected $tags;

    /**
     *  Array Result from tagSize
     *
     * @var array
     */
    protected $sizes = array();

    /**
     * Tag usage less than the threshold is excluded from
     *
     * @var int
     */
    protected $threshold;

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
     * The font class
     *
     * @var int
     */
    protected $fontClass;

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
    protected $maximumFontSize = 50;

    /**
     * font unit.
     *
     * @var int
     */
    protected $fontUnit = 'px';

    /**
     * The maximum font size.
     *
     * @var int
     */
    protected $addSpace = false;

    /**
     * Whether to shuffle the tags.
     *
     * @var bool
     */
    protected $shuffleTags = true;

    /**
     * output style/type
     *
     * @var string
     */
    protected $htmlTags = [
    		'parent' => [
    			'name' => 'div',
    			'attributes' => [
    				'class' => 'tags'
    			]
    		],
    		'child' => []
    ];

    public function __construct()
    {
        /**
         * Add Laravel 5 Config
         */
        if (is_numeric(config('taggly.font_size.max')))
        {
            $this->setMaximumFontSize(config('taggly.font_size.max'));
        }

    	if (is_numeric(config('taggly.font_size.min')))
        {
            $this->setMinimumFontSize(config('taggly.font_size.min'));
        }

    	if (is_array(config('taggly.font_size.class')) && count(config('taggly.font_size.class')))
        {
            $this->setFontClass(config('taggly.font_size.class'));
        }

        if ((string)config('taggly.font_unit'))
        {
            $this->setFontUnit((string)config('taggly.font_unit'));
        }

        if (config('taggly.add_spaces') === false || config('taggly.add_spaces') === true)
        {
            $this->setAddSpace((bool)config('taggly.add_spaces'));
        }

        if (config('taggly.shuffle_tags') === false || config('taggly.shuffle_tags') === true)
        {
            $this->setShuffleTags((bool)config('taggly.shuffle_tags'));
        }

        if (is_array(config('taggly.html_tags')) && count(config('taggly.html_tags')) && !empty(config('taggly.html_tags')))
        {
    		$this->setHtmlTags(array_replace_recursive ($this->htmlTags, config('taggly.html_tags')));
    	}
        if (is_numeric(config('threshold')) && !empty(config('threshold')))
        {
            $this->setThreshold(config('threshold'));
        }
    }

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
        foreach($tags as $tag)
        {
            $this->tags[] = $tag instanceof Tag ? $tag : new Tag($tag);
        }
    }

    /**
     * set font unit.
     *
     * @return string
     */
    public function getFontUnit()
    {
        return $this->fontUnit;
    }

    public function setFontUnit($fontUnit)
    {
        $this->fontUnit = $fontUnit;
        return $this->fontUnit;
    }

    /**
     * Get the lowest count of the tags.
     *
     * @return int
     */
    public function getMinimumCount()
    {
        $counts = array_map(
        function ($tag)
        {
            return $tag->getCount();
        }

        , $this->tags);
        $minCount = min($counts);
        return $minCount;
    }

    /**
     * Get the lowest count of the tags.
     *
     * @return bool
     */
    public function getAddSpace()
    {
        return $this->addSpace;
    }

    /**
     * Get the lowest count of the tags.
     *
     * @return bool
     */
    public function setAddSpace($addSpace)
    {
        $this->addSpace = (bool)$addSpace;
        return $this->addSpace;
    }

    /**
     * @return array
     */
    public function getSizes()
    {
        return $this->sizes;
    }

    /**
     * @param array $sizes
     */
    public function setSizes($sizes)
    {
        $this->sizes = $sizes;
    }

    /**
     * @return int
     */
    public function getThreshold()
    {
        return $this->threshold;
    }

    /**
     * @param int $threshold
     */
    public function setThreshold($threshold)
    {
        $this->threshold = $threshold;
    }


    /**
     * Get the highest count of the tags.
     *
     * @return int
     */
    public function getMaximumCount()
    {
        $counts = array_map(
        function ($tag)
        {
            return $tag->getCount();
        }

        , $this->getTags());
        $maxCount = max($counts);
        return $maxCount;
    }

    /**
     * Get the sum count of all tags.
     *
     * @return int
     */
    public function getSumCount()
    {
        $counts = array_map(
        function ($tag)
        {
            return $tag->getCount();
        }

        , $this->getTags());
        return array_sum($counts);
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
        $this->minimumFontSize = $value;
    }

	/**
     * Get the minimum font size.
     *
     * @return int
     */
    public function getFontClass()
    {
        return $this->fontClass;
    }

    /**
     * Set the minimum font size.
     *
     * @param  int  $value
     * @return void
     */
    public function setFontClass($fontClass)
    {
        $this->fontClass = $fontClass;
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
        $this->maximumFontSize = $value;
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
        $this->shuffleTags = (bool)$value;
    }

	/**
     * Get whether the tags are being shuffled.
     *
     * @return bool
     */
    public function getHtmlTags()
    {
        return $this->htmlTags;
    }

    /**
     * Set whether the tags are being shuffled.
     *
     * @param  bool  $value
     * @return void
     */
    public function setHtmlTags($htmlTags)
    {
        $this->htmlTags = $htmlTags;
    }

    public function tagSizes($tags, $threshold=0, $maxsize, $minsize) {
        //ref: http://dburke.info/blog/logarithmic-tag-clouds/

        /* usage:
            $tags -an array of tags and their corresponding counts
                   format: $tags = array(
                                         array('tag'   => tagname,
                                               'count' => tagcount),
                                   );
            $threshold -Tag usage less than the threshold is excluded from
                being displayed.  A value of 0 displays all tags.
            -maxsize: max desired CSS font-size in em units
            -minsize: min desired CSS font-size in em units
           Returns an array of the tag, its count and calculated font size.
        **/
        $counts = $tagcount = $tagcloud = array();
        foreach($tags as $tag) {
            if($tag['count'] >= $threshold) {

                $tagcount += array($tag['tag'] => $tag['count']);
            }
        }


        $maxcount = $this->getMaximumCount();
        $mincount = $this->getMinimumCount();
        $constant = log($maxcount - ($mincount - 1))/(($maxsize - $minsize)==0 ? 1 : ($maxsize - $minsize));
        foreach($tagcount as $tag => $count) {

            $size = log($count - ($mincount - 1)) / (($constant) == 0 ? 1 : ($constant)) + $minsize;

            if((is_array($this->fontClass) && count($this->fontClass)) || $this->getFontUnit() == 'px') {
                $tagcloud[] = array('tag' => $tag, 'count' => $count, 'size' => round($size, 0));
            }
            else{
                $tagcloud[] = array('tag' => $tag, 'count' => $count, 'size' => round($size, 2));
            }
        }
        return $tagcloud;
    }


    /**
     * Generate a tag cloud using either the tags provided or tags
     * that have already been registered.
     *
     * @param  array  $tags
     * @return string
     */
    public function cloud(array $tags = null, array $config = [])
    {
        foreach($tags as $key => $value){

            if(!isset($value['tag']) || (!isset($value['count']) || !is_numeric($value['count']))){

                unset($tags[$key]);
            }
        }

        if(count($tags) != 0) {

            if (isset($config['html_tags']) && !empty($config['html_tags']) && count($config['html_tags'])) {
                $this->htmlTags = array_replace_recursive($this->htmlTags, $config['html_tags']);
            }

            if (isset($config['threshold']) && !empty($config['threshold'])) {
                $this->threshold = $config['threshold'];
            }
            if ($tags) {
                $this->setTags($tags);
            }
            if (is_array($this->fontClass) && count($this->fontClass)) {

                $this->sizes = $this->tagSizes($tags, $this->threshold, (count($this->fontClass) - 1), 0);
            } else {
                $this->sizes = $this->tagSizes($tags, $this->threshold, $this->getMaximumFontSize(), $this->getMinimumFontSize());
            }
            $tags = $this->getTags() ?: [];

            $output = '';
            $endString = '';

            /* set parent html tag */
            if (isset($this->htmlTags['parent']['name']) && !empty($this->htmlTags['parent']['name'])) {
                /* add attributes  */
                $attributes = '';
                if (isset($this->htmlTags['parent']['attributes']) && !empty($this->htmlTags['parent']['attributes'])) {
                    $attributes = $this->htmlTags['parent']['attributes'];
                    array_walk($attributes, function (&$value, $key) {
                        $value = $key . '="' . $value . '"';
                    });

                    $attributes = implode(' ', $attributes);
                }

                $output .= '<' . $this->htmlTags['parent']['name'] . ' ' . $attributes . '>';
                $endString = '</' . $this->htmlTags['parent']['name'] . '>';
            }
            if ($this->getShuffleTags()) {
                shuffle($tags);
            }

            foreach ($tags as $tag) {

                $output .= $this->getTagElement($tag);
            }

            return $output . $endString;
        }
    }


    /**
     * Get the font size in units for a given tag.
     *
     * @param  Tag  $tag
     * @return int
     */
    public function getFontSize(Tag $tag)    {

        if(is_array($this->fontClass) && count($this->fontClass))
    	{

            $fontSize = 0;
            foreach($this->sizes as $size) {

               if($tag->getTag() == $size['tag']){

                   $fontSize = $size['size'];
               }
            }
    		$fontClass = $this->fontClass[$fontSize];
    		return [
    				'class' => $fontClass,
    				'style' => '',
    		];
    	}
    	else
    	{

            $fontSize = 0;
            foreach($this->sizes as $size) {

                if($tag->getTag() == $size['tag']){

                    $fontSize = $size['size'];

                    if($fontSize > $this->getMaximumFontSize()){

                        $fontSize = $this->getMaximumFontSize();
                    }
                    if($fontSize < $this->getMinimumFontSize()){

                        $fontSize = $this->getMaximumFontSize();
                    }
                }
            }

            return [
    				'class' => '',
    				//'style' => 'font-size:'.($this->getFontUnit() == 'px' ? floor($fontSize) : round($fontSize, 2).$this->getFontUnit()),
                'style' => 'font-size:'.$fontSize.$this->getFontUnit()
            ];
    	}
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
        $tagString = '';
        $endString = '';
        $attributes = '';

        $setClass = true;

   		 /* set parent html tag */
        if(isset($this->htmlTags['child']['name']) && !empty($this->htmlTags['child']['name']))
        {

        	/* add attributes  */
        	if(isset($this->htmlTags['child']['attributes']) && !empty($this->htmlTags['child']['attributes']))
        	{
        		$attributes = $this->htmlTags['child']['attributes'];
        		array_walk($attributes, function (&$value, $key) use ($fontSize) {
        			if($key == 'class'){
        				$setClass = false;
        				$value .= ' '.$fontSize['class'];
        			}
        			$value = $key.'="'.$value.'"';
        		});

        		$attributes = implode(' ', $attributes);
        	}

        	if($setClass == true){
        		$attributes .= ' class="'.$fontSize['class'].'" ';
        	}


        	$tagString .= '<'.$this->htmlTags['child']['name'].' '.$attributes.'>';
        	$endString = '</'.$this->htmlTags['child']['name'].'>';
        }

        if ($tag->getUrl())
        {
            $tagString .= '<a href="' . $tag->getUrl() . '" title="' . $tag->getTag() . '" style="' . $fontSize['style'].'"" ><span>' . e($tag->getTag()) . '</span></a>';
        }
        else
        {
            $tagString .= '<span title="' . $tag->getTag() . '" style="' . $fontSize['style'].'" >' . e($tag->getTag()) . '</span>';
        }

        if ($this->getAddSpace())
        {
            $tagString .= ' ';
        }

        return $tagString.$endString;
    }
}
