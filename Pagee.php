<?php

class Pagee
{
    protected $base_url;
    protected $total_count;
    protected $per_page;
    protected $last_page;
    protected $current_page;
    protected $records;
    protected $params;

    public static function create($setting)
    {
        return new static($setting);
    }

    protected function __construct($setting)
    {
        $setting = array_merge($this->default_setting(), $setting);

        extract($setting);

        $this->base_url = $base_url;
        $this->total_count = $total_count;
        $this->per_page = $per_page;
        $this->last_page = (int)ceil($this->total_count / $this->per_page);
        $this->set_current_page($requested_page);
    }

    /**
     * default setting
     */
    protected function default_setting()
    {
        return array(
            'base_url'       => '',
            'per_page'       => 20,
            'requested_page' => 1
        );
    }

    /**
     * set current page
     * - if requested_page is greater than last_page, current_page is set to last_page
     * - if requrested_page is invalid, current_page is set to 1
     */
    protected function set_current_page($requested_page)
    {
		if (is_numeric($requested_page) && $requested_page > $this->last_page){
			$this->current_page = ($this->last_page > 0) ? $this->last_page : 1;
		} else {
		    $this->current_page = $this->is_valid_requested_page($requested_page) ? $requested_page : 1;
        }
    }

    /**
     * is requested_page valid?
     */
    protected function is_valid_requested_page($requested_page)
    {
        if ($requested_page >= 1 && filter_var($requested_page, FILTER_VALIDATE_INT) !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * return limit value for sql
     */
    public function limit()
    {
        return $this->per_page;
    }

    /**
     * return offset value for sql
     */
    public function offset()
    {
        return ($this->current_page - 1) * $this->per_page;
    }

    /**
     * set results of sql
     */ 
    public function set_records($records)
    {
        $this->records = $records;
    }

    /**
     * return records
     */
    public function records()
    {
        return $this->records;
    }

    /**
     * current page number
     */
    public function current()
    {
        return $this->current_page;
    }

    /**
     * last page number
     */
    public function last()
    {
        return $this->last_page;
    }

    /**
     * prev page number
     */
    public function prev()
    {
        return $this->current_page - 1;
    }

    /**
     * next page number
     */
    public function next()
    {
        return $this->current_page + 1;
    }

    /**
     * current_page is first_page?
     */
    protected function is_first()
    {
        return $this->current_page === 1 ? true : false;
    }

    /**
     * current_page is last_page?
     */
    protected function is_last()
    {
        return $this->current_page === $this->last_page ? true : false;
    }

    /**
     * append params
     */
    public function append_params($params)
    {
        $this->params = $params;
    }

    /**
     * generate html link
     */
    protected function html_link($page, $content)
    {
        $html = '<a href="';
        $html .= $this->base_url;
        $html .= "?page=" . $page;

        if($this->params) {
            $html .= "&".http_build_query($this->params);
        }

        $html .= '">';
        $html .= $content;
        $html .= '</a>';

        return $html;
    }

    /**
     * prev link html
     */
    public function prev_link()
    {
        if ($this->is_first()) {
            return '';
        } else {
            $html = '<li>';
            $html .= $this->html_link($this->prev(), 'prev'); 
            $html .= '</li>';

            return $html;
        }
    }

    /**
     * first link html
     */
    public function first_link()
    {
        if ($this->is_first()) {
            return '';
        } else {
            $html = '<li>';
            $html .= $this->html_link(1, '1'); 
            $html .= '</li>';

            return $html;
        }
    }

    /**
     * around link html
     */
    public function around_link()
    {
        $url = $this->base_url . "?page=" . $this->current_page;

        $html = '<li class="active">';
        $html .= '<span>...</span>';
        $html .= '<a href="#">' . $this->current_page . '</a>';
        $html .= '<span>...</span>';
        $html .= '</li>';

        return $html;
    }

    /**
     * last link html
     */
    public function last_link()
    {
        if ($this->is_last()) {
            return '';
        } else {
            $html = '<li>';
            $html .= $this->html_link($this->last_page, $this->last_page); 
            $html .= '</li>';

            return $html;
        }
    }

    /**
     * next link html
     */
    public function next_link()
    {
        if ($this->is_last()) {
            return '';
        } else {
            $html = '<li>';
            $html .= $this->html_link($this->next(), 'next'); 
            $html .= '</li>';

            return $html;
        }
    }

    /**
     * build pagination links
     */
    public function links()
    {
        if ($this->last_page <= 1) {
            return '';
        }

        $html = '<div class="pagination">' . PHP_EOL;
        $html .= '<ul>' . PHP_EOL;

        $html .= $this->prev_link() . PHP_EOL;
        $html .= $this->first_link() . PHP_EOL;
        $html .= $this->around_link() . PHP_EOL;
        $html .= $this->last_link() . PHP_EOL;
        $html .= $this->next_link() . PHP_EOL;

        $html .= '</ul>' . PHP_EOL;
        $html .= '</div>' . PHP_EOL;

        return $html;
    }
}
