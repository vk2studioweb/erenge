@extends('Admin.Layouts.app')

@section('content')
    <!-- Inclui identificação da pag. -->
    @include('Admin.Layouts.identification')

    <section class="main-content">

        <!-- Inclui html do alerta na página -->
        @include('Admin.Layouts.mainAlert')

        <!-- Inclui os botões de ações Permitidos para o usuário -->
        <section id="main-form">
            {!! Form::open([
                'url' => route('csvDownload'),
                'method' => 'POST',
                'target' => '_blank',
            ]) !!}
            <ul id="main-form-list">
                <li class="size-col-4 size-content-1">
                    {!! Form::label('model', 'Tipo de Contato', ['class' => 'control-label']) !!}
                    {!! Form::select('model', $thisdata->models, null, ['class' => 'form-control']) !!}
                </li>
                <li class="size-col-4 size-content-1">
                    {!! Form::label('onlyNewRegisters', 'Filtro de Cadastros', ['class' => 'control-label']) !!}
                    {!! Form::select('onlyNewRegisters', [0 => 'Todos os Cadastros', 1 => 'Somente Cadastros Novos'], null, [
                        'class' => 'form-control',
                    ]) !!}
                </li>
                <hr>
                <li class="size-col-2 size-content-1">
                    {!! Form::checkbox('dateCheck', 1, false) !!}
                    {!! Form::label('dateCheck', 'Filtrar por Data', ['class' => 'control-label']) !!}
                </li>
                <li class="size-col-1 size-content-2 size-heigt4">
                    <div class="exportContactDatePicker" style="display: none">

                        <p>Contatos entre : </p>
                        {!! Form::date('contacts_start', Carbon::now()->subDays(30), [
                            'class' => 'form-control',
                            'autocomplete' => 'off',
                            'value' => '',
                            'disabled' => true,
                        ]) !!}
                        <p> E </p>
                        {!! Form::date('contacts_end', Carbon::now(), [
                            'class' => 'form-control',
                            'autocomplete' => 'off',
                            'value' => '',
                            'disabled' => true,
                        ]) !!}
                    </div>

                    {!! Form::button('EXPORTAR TODOS', [
                        'id' => 'button-insert',
                        'name' => 'exportType',
                        'class' => 'main-button-list',
                        'value' => 'all',
                        'type' => 'submit',
                    ]) !!}
                    {!! Form::button('ÚLTIMOS 7 DIAS', [
                        'id' => 'button-insert',
                        'name' => 'exportType',
                        'class' => 'main-button-list sevenDaysBtn',
                        'value' => 'last7Days',
                        'type' => 'submit',
                    ]) !!}
                </li>
            </ul>
            {!! Form::close() !!}
        </section>
        <script type="text/javascript">
        
            jQuery("[name='dateCheck']").on('click', function() {
                let datePicker = jQuery('.exportContactDatePicker');
                let sevenDaysBtn = jQuery('.sevenDaysBtn');
                if (jQuery(this).is(':checked') === true) {
                    datePicker.show();
                    datePicker.find('input').each(function() {
                        jQuery(this).attr('disabled', false);
                    })
                    sevenDaysBtn.attr('disabled', true)
                } else {
                    datePicker.hide();
                    datePicker.find('input').each(function() {
                        jQuery(this).attr('disabled', true)
                    })
                    sevenDaysBtn.attr('disabled', false);
                }
            })
        </script>

    </section>
@endsection
