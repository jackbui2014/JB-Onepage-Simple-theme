<?php 
class JB_Section_Slider extends JB_Section
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
        parent::__construct($order, $data_type, $template_url, $name, $description);
        $this->order = 0;
        $this->status = 1;
        $this->data_type = 'jb_slider';
        $this->template_url = '/includes/modules/slider/template-section-slider';
        $this->name = 'slider';
        $this->description = '';
        $this->init();
    }
    /**
     * init
     * @param void
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public  function init(){
        global $jb_post_factory;
        $jb_post_factory->set('jb_slider', new JB_Data_Section_Slider());
    }
}
$class = JB_Section_Slider::get_instance();
$class = serialize($class);
JB_Section_Manager()->save_section('slider', $class);