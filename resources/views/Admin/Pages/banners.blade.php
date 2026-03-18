<section id="main-form">
  {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}
  <ul id="main-form-list">
    <li class="size-col-2 size-content-1">
      {!! Form::label('name', 'Título do Banner', ['class' => 'control-label']) !!}
      {!! Form::text('name', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->name : null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
    </li>

    <li class="size-col-2 size-content-1">
      {!! Form::label('order', 'Ordem de Exibição', ['class' => 'control-label']) !!}
      {!! Form::number('order', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->order : 0, ['class' => 'form-control', 'min'=> '0', 'step' => '1']) !!}
    </li>

    <li class="size-col-2 size-content-1">
      {!! Form::label('link', 'Link (URL)', ['class' => 'control-label']) !!}
      {!! Form::text('link', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->link : null, ['class' => 'form-control', 'placeholder' => 'https://...']) !!}
    </li>
    <li class="size-col-1 size-content-2 size-heigt2">
      {!! Form::label('description', 'Descrição/Subtítulo', ['class' => 'control-label']) !!}
      {!! Form::textarea('description', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->description : null, ['class' => 'textarea-control editor']) !!}
    </li>
  </ul>
  {!! Form::close() !!}
</section>

<script type="text/javascript">
  jQuery(document).ready(function () {
    // Validações baseadas nos campos da migration vpu_banner
    jQuery("#mainFormInsert").validate({
      rules: {
        name: { required: true },
        link: { required: true },
        button: { required: true }, // Campo obrigatório na migration
        order: { required: true, number: true }
      },
      messages: {
        name: "Insira um título para o banner",
        link: "O link é obrigatório",
        button: "O texto do botão é obrigatório",
        order: "Defina uma ordem"
      }
    });
  });
</script>
