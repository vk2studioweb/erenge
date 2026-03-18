<section id="main-form">
  {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}
  <ul id="main-form-list">
    <li class="size-col-2 size-content-1">
      {!! Form::label('nome', 'Nome da Filial', ['class' => 'control-label']) !!}
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
      {!! Form::label('email', 'E-mail', ['class' => 'control-label']) !!}
      {!! Form::email('email', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->email : null, ['class' => 'form-control']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('cep', 'CEP', ['class' => 'control-label']) !!}
      {!! Form::text('cep', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->cep : null, ['class' => 'form-control']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('coordenada', 'Coordenada (lat,lng)', ['class' => 'control-label']) !!}
      {!! Form::text('coordenada', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->coordenada : null, ['class' => 'form-control', 'placeholder' => 'ex: -8.8368,13.2343']) !!}
    </li>
    <hr>
    <li class="size-col-1 size-content-2">
      {!! Form::label('endereco', 'Endereço', ['class' => 'control-label']) !!}
      {!! Form::text('endereco', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->endereco : null, ['class' => 'form-control']) !!}
    </li>
    <li class="size-col-1 size-content-2 size-heigt2">
      {!! Form::label('descricao', 'Descrição', ['class' => 'control-label']) !!}
      {!! Form::textarea('descricao', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->descricao : null, ['class' => 'textarea-control editor']) !!}
    </li>
  </ul>
  {!! Form::close() !!}
</section>
<script type="text/javascript">
  jQuery(document).ready(function () {
    jQuery("#mainFormInsert").validate({
      rules: {
        nome:     { required: true },
        endereco: { required: true },
        orden:    { required: true, digits: true }
      }
    });
  });
</script>
