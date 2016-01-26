<?php 
class JB_Section_Work extends JB_Section
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

    public function __construct($order = 0, $status = 1, $data_type = "", $template_url = '', $name = '', $description= '')
    {
        parent::__construct($order, $data_type, $template_url, $name, $description);
        $this->order = 2;
        $this->status = 1;
        $this->data_type = 'jb_work';
        $this->template_url = '/includes/modules/work/template-section-work';
        $this->name = 'our work';
        $this->description = __('Lorem ipsum dolor sit amet, consectetur adipiscing elit,printing and typesetting', JB_DOMAIN);
        $this->init();
    }
    /**
     * init of section work class
     *
     * @param void
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public  function init(){
        global $jb_post_factory;
        $jb_post_factory->set($this->data_type, new JB_Data_Section_Work('jb_work', array('work_category')));
    }
}
$class = JB_Section_Work::get_instance();
$class = serialize($class);
JB_Section_Manager()->save_section('work', $class);