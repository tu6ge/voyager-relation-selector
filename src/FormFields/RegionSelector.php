<?php 
/**
 * 省市区选择器
 */
namespace VoyagerRelationSelector\FormFields;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\FormFields\AbstractHandler;
use VoyagerRelationSelector\Exceptions\RelationSelectorException;
use VoyagerRelationSelector\Toolkit;
use VoyagerRelationSelector\Models\Region;

class RegionSelector extends AbstractHandler
{
    protected $name = 'Region Selector';
    protected $codename = 'region-selector';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        if(empty($options->resources_url)){
            $options->resources_url = '/vrs/region/__pid__';
        }
        
        if(!empty($options->relation)){
            $level = count($options->relation) + 1;
        }elseif($options->level){
            $level = $options->level;
        }else{
            $level = 3;
        }

        $value = [];
        if($dataTypeContent->exists){
            
            if(!empty($options->relation)){
                foreach($options->relation as $key=>$val){
                    if(isset($dataTypeContent->{$val})){
                        $value[] = $dataTypeContent->{$val};
                    }
                }
                $value[] = $dataTypeContent->{$row->field};
            }else{

                $model = new Region;

                $value = $model->getParents($dataTypeContent->{$row->field});
            }
        }

        Toolkit::append_js(sprintf('vrs/main.js?id=%s&value=%s', $row->id, implode(',', $value)));

        return view('voyager_relation_selector::formfields.relation_selector', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent,
            'level' => $level,
        ]);
    }
}