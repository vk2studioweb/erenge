<section id="main-form">
  {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert', 'files' => true]) !!}
  <ul id="main-form-list">
    <li class="size-col-2 size-content-1">
      {!! Form::label('nome', 'Título/Nome', ['class' => 'control-label']) !!}
      {!! Form::text('nome', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->nome : null, ['class' => 'form-control']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('orden', 'Orden de Exibição', ['class' => 'control-label']) !!}
      {!! Form::number('orden', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->orden : null, ['class' => 'form-control']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('telefone', 'Número de Telefone', ['class' => 'control-label']) !!}
      {!! Form::text('telefone', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->telefone : null, ['class' => 'form-control phone_with_ddd', 'placeholder' => '54 9 9999-9999']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('botao', 'Texto do Botão', ['class' => 'control-label']) !!}
     {!! Form::text('botao', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->botao : null, ['class' => 'form-control']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('link', 'Link Botão', ['class' => 'control-label']) !!}
     {!! Form::text('link', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->link : null, ['class' => 'form-control']) !!}
    </li>
  </ul>
  {!! Form::close() !!}
</section>
<script type="text/javascript">
  jQuery(document).ready(function () {
    jQuery("#mainFormInsert").validate({
      rules: {
        nome:     { required: true },
        telefone: { required: true },
        botao:    { required: true }
      }
    });
  });
</script>
