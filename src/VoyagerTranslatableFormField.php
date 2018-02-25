<?php

namespace Mattrabe\VoyagerTranslatableFormField;

class VoyagerTranslatableFormField
{
    public $input_name_separator = '-';

    function __construct() {
        if (config('translatable.locale_separator') === '-')
            $this->input_name_separator = '_';
    }

    /**
     * Create 'translatable' DataRow for use in Voyager BREAD controllers
     *
     * @param array $params
     *  + model_data_type (string, required) - `slug` of parent model's DataType (data_types db table). Example: 'products'
     *  + field (string, required) - name of translatable field. Example: 'description'
     *  + type (string, required) - FormField type of translatable field. Example: 'text_area'
     *  + display_name (string) - Display name of section on edit view. Example: 'Description Translations'
     *  + browse (bool) - Permission to Browse? Default: true
     *  + read (bool) - Permission to Read? Default: true
     *  + edit (bool) - Permission to Edit? Default: true
     *  + add (bool) - Permission to Add? Default: true
     *  + delete (bool) - Permission to Delete? Default: true
     *  + details - Default: null
     *  + order (number) - Display order. Default: 100
     *
     * @return TCG\Voyager\Models\DataRow
     */
    public static function createTranslatableDataRow($params=[]) {
        if (!is_array($params) || !isset($params['model_data_type']) || !isset($params['field']) || !isset($params['type']))
            return null;

        // Set up vars
        $data_type_slug = $params['model_data_type'];
        $self = new self;
        $data_row_params = [
            'type' => 'translatable',
            'field' => 'translatable' .$self->input_name_separator . $params['field'],

            'field_type' => $params['type'],
            'field_name' => $params['field'],
 
            'display_name' => (isset($params['display_name']) ? $params['display_name'] : sprintf(e('%s Translations'), title_case($params['field']))),
            'details' => (isset($params['details']) ? $params['details'] : null),
            'order' => (isset($params['order']) ? $params['order'] : 100),
        ];
        foreach (['browse', 'read', 'edit', 'add', 'delete'] as $check) {
            $data_row_params[$check] = (isset($params[$check]) ? $params[$check] : true);
        }

        // Create DataRow instance
        $dataRow = new \TCG\Voyager\Models\DataRow($data_row_params);
        $dataRow->data_type_id = \TCG\Voyager\Models\DataType::where('slug', '=', $data_type_slug)->firstOrFail()->id;

        // Return DataType
        return $dataRow;
    }

    /**
     * Save 'translatable' dolumn data to model/database
     *
     * @param Illuminate\Database\Eloquent\Model $model Parent Model instance
     * @param Illuminate\Http\Request $request Request data
     *
     * @return void
     */
    public static function updateTranslations($model, $request) {
        $self = new self;
        $regexp = "/^translatable" .$self->input_name_separator. "(.*)-([^" .$self->input_name_separator. "]*)$/";
        foreach ($request->all() as $k=>$v) {
            if (preg_match($regexp, $k)) {
                $field_name = preg_replace($regexp, '$1', $k);
                $locale = preg_replace($regexp, '$2', $k);
                $model->translate($locale)->{$field_name} = $v;
            }
        }
        $model->save();
    }

}

