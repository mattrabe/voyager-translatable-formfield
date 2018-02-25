<?php

namespace MattRabe\VoyagerTranslatableFormField\FormFields;

class TranslatableHandler extends \TCG\Voyager\FormFields\AbstractHandler
{
    protected $codename = 'translatable';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('translatableformfield::formfields.translatable', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
            'translatable'    => new \MattRabe\VoyagerTranslatableFormField\VoyagerTranslatableFormField,
        ]);
    }
}
