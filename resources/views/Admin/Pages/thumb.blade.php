<section id="main-form">
        <div class="main-form-info-wrapper">
                <p class="main-form-info">
                    Deixe "Cortar em" com valor 0 até o mesmo ser implementado.
                </p>
                <p class="main-form-info">
                    A padronização geral do nome da pasta de armazenamento é:<b> thumb[largura]x[altura] </b>| ex: thumb450x200
                </p>
            </div>
    {{--  Abrir formulário --}}
    {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' =>
    'mainFormInsert']) !!}
    {!! Form::hidden('id_menu', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->id_menu :
    $thisdata->idfather, ['class' => 'form-control', 'readonly' => 'true']) !!}

    <ul id="main-form-list">
        <li class="size-col-2 size-content-1">
            {!! Form::label('width', 'Largura', array('class' => 'control-label' )) !!}
            {!! Form::text('width', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->width : null, ['class'
            => 'form-control']) !!}
        </li>
        <li class="size-col-2 size-content-1">
            {!! Form::label('height', 'Altura', array('class' => 'control-label' )) !!}
            {!! Form::text('height', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->height : null,
            ['class' => 'form-control']) !!}
        </li>

        <li class="size-col-2 size-content-1">
            {!! Form::label('storange_name', 'Nome da pasta de armazenamento', array('class' => 'control-label' )) !!}
            {!! Form::text('storange_name', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->storange_name :
            null, ['class' => 'form-control']) !!}
        </li>
        <li class="size-col-2 size-content-1">
            {!! Form::label('cut', 'Cortar em', array('class' => 'control-label' )) !!}
            {!! Form::text('cut', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->cut : 0, ['class' =>
            'form-control']) !!}
        </li>

    </ul>
    {!! Form::close() !!} {{-- Fechar formulário --}}

</section>

<script type="text/javascript">
    jQuery(document).ready(function () {
        $("input[name='height']").change(function() { 
            var height = $("input[name='height']").val();
            var width = $("input[name='width']").val();
            $("input[name='storange_name']").val("thumb" + width + "x" + height);
        }); 
        $("input[name='width']").change(function() { 
            var height = $("input[name='height']").val();
            var width = $("input[name='width']").val();
            $("input[name='storange_name']").val("thumb" + width + "x" + height);
        }); 
        jQuery( "input[name='height']" ).rules( "add", { required: true, digits: true });
        jQuery( "input[name='width']" ).rules( "add", { required: true, digits: true });
        jQuery( "input[name='storange_name']" ).rules( "add", { required: true });
        jQuery( "input[name='cut']" ).rules( "add", { required: true });
    });
</script>