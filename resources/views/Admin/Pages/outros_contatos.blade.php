<section id="main-form">
  {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}
  <ul id="main-form-list">
    <li class="size-col-2 size-content-1">
      {!! Form::label('nome', 'Nome', ['class' => 'control-label']) !!}
      {!! Form::text('nome', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->nome : null, ['class' => 'form-control']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('orden', 'Ordem', ['class' => 'control-label']) !!}
      {!! Form::number('orden', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->orden : 1, ['class' => 'form-control', 'min' => '1']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('telefone', 'Telefone', ['class' => 'control-label']) !!}
      {!! Form::text('telefone', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->telefone : null, ['class' => 'form-control']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('botao', 'Texto do Botão', ['class' => 'control-label']) !!}
      {!! Form::text('botao', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->botao : null, ['class' => 'form-control', 'placeholder' => 'ex: Falar no WhatsApp']) !!}
    </li>
    <li class="size-col-1 size-content-1">
      {!! Form::label('link', 'Link do Botão', ['class' => 'control-label']) !!}
      {!! Form::text('link', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->link : null, ['class' => 'form-control', 'placeholder' => 'ex: https://wa.me/244...']) !!}
    </li>
  </ul>
  {!! Form::close() !!}
</section>
<script type="text/javascript">
  jQuery(document).ready(function () {
    jQuery("#mainFormInsert").validate({
      rules: {
        nome:  { required: true },
        orden: { required: true, digits: true }
      }
    });
  });
</script>
