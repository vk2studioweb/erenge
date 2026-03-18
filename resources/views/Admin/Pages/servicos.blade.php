<section id="main-form">
  {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}
  <ul id="main-form-list">
    <li class="size-col-2 size-content-1">
      {!! Form::label('nome', 'Nome do Serviço', ['class' => 'control-label']) !!}
      {!! Form::text('nome', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->nome : null, ['class' => 'form-control', 'placeholder' => 'ex: Construção Civil']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('order', 'Ordem', ['class' => 'control-label']) !!}
      {!! Form::number('order', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->order : 1, ['class' => 'form-control', 'min' => '1']) !!}
    </li>
    <hr>
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
        nome:  { required: true },
        order: { required: true, digits: true }
      }
    });
  });
</script>
