<?php
/**
 * 级联选择器.
 */
namespace VoyagerRelationSelector\FormFields;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\FormFields\AbstractHandler;
use VoyagerRelationSelector\Exceptions\RelationSelectorException;
use VoyagerRelationSelector\Toolkit;

class RelationSelector extends AbstractHandler
{
    protected $name = 'Relation Selector';
    protected $codename = 'relation-selector';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        if (empty($options->relation) && empty($options->model)) {
            throw new RelationSelectorException('relation and model is not found');
        }

        if (empty($options->resources_url)) {
            throw new RelationSelectorException('option resources_url is not found');
        }

        if (!empty($options->relation)) {
            $level = count($options->relation) + 1;
        } elseif ($options->level) {
            $level = $options->level;
        } else {
            throw new RelationSelectorException('option level is not found');
        }

        $value = [];
        if ($dataTypeContent->exists) {
            if (!empty($options->relation)) {
                foreach ($options->relation as $key=>$val) {
                    if (isset($dataTypeContent->{$val})) {
                        $value[] = $dataTypeContent->{$val};
                    }
                }
                $value[] = $dataTypeContent->{$row->field};
            } else {
                if (!class_exists($options->model)) {
                    throw new RelationSelectorException(sprintf('options model : %s is not a class', $options->model));
                }

                $model = new $options->model();
                if (!($model instanceof Model)) {
                    throw new RelationSelectorException(sprintf('options model : %s is not instance of Illuminate\Database\Eloquent\Model', $options->model));
                }

                if (!method_exists($model, 'getParents')) {
                    throw new RelationSelectorException(sprintf('options model : %s have not getParents method', $options->model));
                }

                $value = $model->getParents($dataTypeContent->{$row->field});
            }
        }

        Toolkit::append_js(sprintf('vrs/main.js?id=%s&value=%s', $row->id, implode(',', $value)));

        return view('voyager_relation_selector::formfields.relation_selector', [
            'row'               => $row,
            'options'           => $options,
            'dataType'          => $dataType,
            'dataTypeContent'   => $dataTypeContent,
            'level'             => $level,
        ]);
    }
}
