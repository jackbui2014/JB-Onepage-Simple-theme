<?php 
class JB_Section_Services extends JB_Section
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
        $this->order = 1;
        $this->status = 1;
        $this->data_type = 'jb_services';
        $this->template_url = '/includes/modules/services/template-section-services';
        $this->name = 'services';
        $this->description = __('Lorem ipsum dolor sit amet, consectetur adipiscing elit,<br/>printing and typesetting', JB_DOMAIN);
        $this->init();
    }
    /**
     * Init function for this class
     *
     * @param void
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public  function  init(){
        global $jb_post_factory;
        $jb_post_factory->set($this->data_type, new JB_Data_Section_Services());
    }
}
$class = JB_Section_Services::get_instance();
$class = serialize($class);
JB_Section_Manager()->save_section('services', $class);