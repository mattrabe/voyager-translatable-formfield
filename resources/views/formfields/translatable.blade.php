
<ul>
@foreach ($dataTypeContent->translations as $translation)
    <li style="list-style-type: none;">
        <label for="{{ $row->field }}-{{ $translation->locale }}">{{ $translation->locale }}</label>

        @include('voyager::formfields.' .$row->field_type, [
            'dataTypeContent' => (object)[
                $row->field . $translatable->input_name_separator . $translation->locale => $translation->{$row->field_name},
            ],
            'row' => (object)[
                'required' => $row->required,
                'display_name' => $row->field_name . $translatable->input_name_separator . $translation->locale,
                'field' => $row->field . $translatable->input_name_separator . $translation->locale,
            ],
            'options' => $options,
        ])
    </li>
@endforeach
</ul>
