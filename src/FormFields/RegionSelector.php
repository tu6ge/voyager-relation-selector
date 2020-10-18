<?php
/**
 * 省市区选择器.
 */

namespace VoyagerRelationSelector\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;
use VoyagerRelationSelector\Models\Region;
use VoyagerRelationSelector\Toolkit;

class RegionSelector extends AbstractHandler
{
    protected $name = 'Region Selector';
    protected $codename = 'region-selector';
    protected $region;

    public function __construct(
        Region $region
    ) {
        $this->region = $region;
    }

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        if (empty($options->resources_url)) {
            $options->resources_url = '/vrs/region/__pid__';
        }

        $level = $this->getLevel($options);

        $values = $this->getActiveValues($row, $dataTypeContent, $options);

        Toolkit::append_js(sprintf('vrs/main.js?id=%s&value=%s', $row->id, implode(',', $values)));

        return view('voyager_relation_selector::formfields.relation_selector', [
            'row'               => $row,
            'options'           => $options,
            'dataType'          => $dataType,
            'dataTypeContent'   => $dataTypeContent,
            'level'             => $level,
        ]);
    }

    protected function getLevel($options)
    {
        if (!empty($options->relation)) {
            $level = count($options->relation) + 1;
        } else {
            $level = $options->level ?? 3;
        }

        return $level;
    }

    protected function getActiveValues($row, $dataTypeContent, $options)
    {
        $value = [];

        if ($dataTypeContent->exists == false) {
            return $value;
        }

        if (!empty($options->relation)) {
            foreach ($options->relation as $key=>$val) {
                if (isset($dataTypeContent->{$val})) {
                    $value[] = $dataTypeContent->{$val};
                }
            }
            $value[] = $dataTypeContent->{$row->field};
        } else {
            $value = $this->region->getParents($dataTypeContent->{$row->field});
        }

        return $value;
    }
}
