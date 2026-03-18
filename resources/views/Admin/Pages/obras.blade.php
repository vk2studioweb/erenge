<section id="main-form">
  {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}
  <ul id="main-form-list">
    <li class="size-col-2 size-content-1">
      {!! Form::label('nome', 'Nome da Obra', ['class' => 'control-label']) !!}
      {!! Form::text('nome', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->nome : null, ['class' => 'form-control', 'placeholder' => 'ex: Edifício Central']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('servico_id', 'Serviço', ['class' => 'control-label']) !!}
     {!!Form::select('servico_id',$thisdata->listForeignKey->servicos,isset($thisdata->listRegister)?$thisdata->listRegister[0]->servico_id:null,['class'=>'form-control'])!!}
        </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('local_obra', 'Local da Obra', ['class' => 'control-label']) !!}
      {!! Form::text('local_obra', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->local_obra : null, ['class' => 'form-control', 'placeholder' => 'ex: Luanda, Angola']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('coordenada', 'Coordenada (lat,lng)', ['class' => 'control-label']) !!}
      {!! Form::text('coordenada', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->coordenada : null, ['class' => 'form-control', 'placeholder' => 'ex: -8.8368,13.2343']) !!}
    </li>
    <hr>
    <li class="size-col-1 size-content-2 size-heigt2">
      {!! Form::label('descricao', 'Descrição', ['class' => 'control-label']) !!}
      {!! Form::textarea('descricao', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->descricao : null, ['class' => 'textarea-control editor']) !!}
    </li>
    <li class="size-col-1 size-content-2 size-heigt2">
      {!! Form::label('detalhes', 'Detalhes', ['class' => 'control-label']) !!}
      {!! Form::textarea('detalhes', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->detalhes : null, ['class' => 'textarea-control editor']) !!}
    </li>
  </ul>
  {!! Form::close() !!}
</section>
<script type="text/javascript">
  jQuery(document).ready(function () {
    jQuery("#mainFormInsert").validate({
      rules: {
        nome:       { required: true },
        servico_id: { required: true },
        local_obra: { required: true }
      }
    });
  });
</script>
