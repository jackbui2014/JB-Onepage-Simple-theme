<?php 
class JB_Section_About extends JB_Section
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
        $this->order = 3;
        $this->status = 1;
        $this->data_type = 'jb_about';
        $this->template_url = '/includes/modules/about/template-section-about';
        $this->name = 'about';
        $this->description = __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae orci nec sapien posuere tincidunt ut sit amet magna.
Ut a enim in orci feugiat fringilla id in ipsum. Integer condimentum viverra nunc vitae sodales. Nunc viverra iaculis bibendum.
Pellentesque scelerisque eleifend diam at convallis. Duis quis justo pretium, sagittis nisi a, viverra ligula.
Curabitur interdum augue elit, sit amet accumsan eros efficitur a. Integer venenatis ligula at lobortis lacinia.', JB_DOMAIN);
        $this->init();
    }
    /**
     * Init of action class
     *
     * @param void
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public function  init(){
        global $jb_post_factory;
        $jb_post_factory->set($this->data_type, new JB_Data_Section_About() );
    }
}
$class = JB_Section_About::get_instance();
$class = serialize($class);
JB_Section_Manager()->save_section('about', $class);