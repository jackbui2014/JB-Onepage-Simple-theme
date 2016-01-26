<?php 
class JB_Section_Blog extends JB_Section
{
    private static $instance = NULL;

    /**
     * Get class instance.
     *
     * @since  1.0
     * @return JB_Lib instance
     * @author JACK BUI
     */
    public static function get_instance()
    {
        if (NULL == static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function __construct($order = 0, $status = 1, $data_type = "", $template_url = '', $name = '', $description = '')
    {
        parent::__construct($order, $data_type, $template_url);
        $this->order = 4;
        $this->status = 1;
        $this->data_type = 'jb_slider';
        $this->template_url = '/includes/modules/blog/template-section-blog';
        $this->name = 'blog';
        $this->description = '';
    }
}
$class = JB_Section_Blog::get_instance();
$class = serialize($class);
JB_Section_Manager()->save_section('blog', $class);