<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
    
    var $obj;
    var $layout;
    var $data = array(
        'page_content' => '',
        'page_title' => 'untitled',
        'page_navigation' => array()
    );
    
    function Layout ($layout = "default")
    {
        $this->obj =& get_instance();
        $this->layout = $layout;
    }

    function set_layout ($layout)
    {
      $this->layout = "layouts/$layout/index.php";
    }

    function set_title ($title)
    {
        $this->data['page_title'] = $title;
    }

    function set_content ($content)
    {
        $this->data['page_content'] = $content;
    }

    function process_navigation ()
    {
        foreach ($this->data['page_navigation'] as $index => $element)
        {
            $this->data['page_navigation'][$index]['selected'] = false;
        }
    }

    function navigation_select ($index)
    {
        if (isset($this->data['page_navigation'][$index]))
        {
            $this->data['page_navigation'][$index]['selected'] = true;
        }
    }

    function set_navigation ($navigation, $selection = null)
    {
        $this->data['page_navigation'] = $navigation;
        $this->process_navigation();
        if ($selection != null)
        {
            $this->navigation_select($selection);
        }
    }

    function add_content ($content)
    {
        $this->data['page_content'] .= $content;
    }
    
    function add_view ($view, $data = array())
    {
        $this->data = array_merge($data, $this->data);
        $this->add_content($this->obj->load->view($view, $this->data, true));
    }

    function render_view ($view, $data = array(), $settings = array())
    {
        if (isset($settings['page_title']))
        {
            $this->set_title($settings['page_title']);
        }
        if (isset($settings['layout']))
        {
            $this->set_layout($settings['layout']);
        }
        $this->data = array_merge($data, $this->data);
        $this->set_content($this->obj->load->view($view, $this->data, true));
        return $this->obj->load->view($this->layout, $this->data, false);
    }

    function render ()
    {
        return $this->obj->load->view($this->layout, $this->data, false);
    }

    function hard_render ()
    {
        echo $this->obj->load->view($this->layout, $this->data, true);
    }
}
?>