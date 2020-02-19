<?php 
namespace VoyagerRelationSelector;

class Toolkit
{
    static public function append_js($js_file)
    {
        $config = config('voyager.additional_js');
        if(!in_array($js_file, $config)){
            $config[] = $js_file;
        }
        config(['voyager.additional_js'=> $config]);
    }

    static public function append_css($css_file)
    {
        $config = config('voyager.additional_css');
        if(!in_array($css_file, $config)){
            $config[] = $css_file;
        }
        config(['voyager.additional_css'=> $config]);
    }
}