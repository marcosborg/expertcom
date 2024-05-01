@foreach ($form_inputs as $form_input)
@switch($form_input->type)
@case('text')
<div class="form-group item" data-position="{{ $form_input->position }}" data-form_input_id="{{ $form_input->id }}">
    <label>{{ $form_input->label }}{{ $form_input->required ? ' *' : '' }}<a onclick="return confirm('Are you sure?')"
            href="{{ route("admin.form-assemblies.delete-form-input", ['form_input_id'=> $form_input->id]) }}"
            class="btn btn-sm btn-link pull-right"><span class="glyphicon glyphicon-trash"
                aria-hidden="true"></span></a></label>
    <input type="text" class="form-control" name="{{ $form_input->name }}" {{ $form_input->required ? 'required' : ''
    }}>
</div>
@break
@case('number')
<div class="form-group item" data-position="{{ $form_input->position }}" data-form_input_id="{{ $form_input->id }}">
    <label>{{ $form_input->label }}{{ $form_input->required ? ' *' : '' }}<a onclick="return confirm('Are you sure?')"
            href="{{ route("admin.form-assemblies.delete-form-input", ['form_input_id'=> $form_input->id]) }}"
            class="btn btn-sm btn-link pull-right"><span class="glyphicon glyphicon-trash"
                aria-hidden="true"></span></a></label>
    <input type="number" class="form-control" name="{{ $form_input->name }}" {{ $form_input->required ? 'required' : ''
    }}>
</div>
@break
@case('date')
<div class="form-group item" data-position="{{ $form_input->position }}" data-form_input_id="{{ $form_input->id }}">
    <label>{{ $form_input->label }}{{ $form_input->required ? ' *' : '' }}<a onclick="return confirm('Are you sure?')"
            href="{{ route("admin.form-assemblies.delete-form-input", ['form_input_id'=> $form_input->id]) }}"
            class="btn btn-sm btn-link pull-right"><span class="glyphicon glyphicon-trash"
                aria-hidden="true"></span></a></label>
    <input type="date" class="form-control" name="{{ $form_input->name }}" {{ $form_input->required ? 'required' : ''
    }}>
</div>
@break
@case('textarea')
<div class="form-group item" data-position="{{ $form_input->position }}" data-form_input_id="{{ $form_input->id }}">
    <label>{{ $form_input->label }}{{ $form_input->required ? ' *' : '' }}<a onclick="return confirm('Are you sure?')"
            href="{{ route("admin.form-assemblies.delete-form-input", ['form_input_id'=> $form_input->id]) }}"
            class="btn btn-sm btn-link pull-right"><span class="glyphicon glyphicon-trash"
                aria-hidden="true"></span></a></label>
    <textarea class="form-control" name="{{ $form_input->name }}" {{
        $form_input->required ? 'required' : '' }}></textarea>
</div>
@break
@case('checkbox')
<div class="checkbox item" data-position="{{ $form_input->position }}" data-form_input_id="{{ $form_input->id }}">
    <label>
        <input type="checkbox" name="{{ $form_input->name }}" {{ $form_input->required ?
        'required' : '' }}> {{ $form_input->label }}{{ $form_input->required ? ' *' : '' }}<a
            onclick="return confirm('Are you sure?')" href="{{ route("admin.form-assemblies.delete-form-input", ['form_input_id'=> $form_input->id]) }}"
            class="btn btn-sm btn-link pull-right"><span class="glyphicon glyphicon-trash"
                aria-hidden="true"></span></a>
    </label>
</div>
@break
@case('radio')
<div class="row item" data-position="{{ $form_input->position }}" data-form_input_id="{{ $form_input->id }}">
    <div class="col-md-12">
        <label>{{ $form_input->label }}</label>
    </div>
    <div class="col-md-8">
        <div class="radio">
            <label>
                <input type="radio" name="{{ $form_input->name }}" id="{{ $form_input->name }}_1" value="Sim" checked>
                Sim
            </label>
        </div>
        <div class="radio disabled">
            <label>
                <input type="radio" name="{{ $form_input->name }}" id="{{ $form_input->name }}_2" value="Não">
                Não
            </label>
        </div>
    </div>
    <div class="col-md-4">
        <a onclick="return confirm('Are you sure?')" href="{{ route("admin.form-assemblies.delete-form-input", ['form_input_id'=> $form_input->id]) }}"
            class="btn btn-sm btn-link pull-right"><span class="glyphicon glyphicon-trash"
                aria-hidden="true"></span></a>
    </div>
</div>
@break
@default
@endswitch
@endforeach