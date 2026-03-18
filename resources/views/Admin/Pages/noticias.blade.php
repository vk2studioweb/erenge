<section id="main-form">
  {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert', 'files' => true]) !!}
  <ul id="main-form-list">
    <li class="size-col-2 size-content-1">
      {!! Form::label('nome', 'Título da Notícia', ['class' => 'control-label']) !!}
      {!! Form::text('nome', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->nome : null, ['class' => 'form-control']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('autor', 'Autor', ['class' => 'control-label']) !!}
      {!! Form::text('autor', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->autor : null, ['class' => 'form-control']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('direitos', 'Direitos Autorais', ['class' => 'control-label']) !!}
      {!! Form::text('direitos', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->direitos : null, ['class' => 'form-control', 'placeholder' => 'ex: © 2026 Erenge']) !!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('imagem', 'Direitos de Imagem', ['class' => 'control-label']) !!}
     {!! Form::text('imagem', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->imagem : null, ['class' => 'form-control', 'placeholder' => 'ex: © 2026 Erenge']) !!}
    </li>
    <hr>
    <li class="size-col-1 size-content-2 size-heigt2">
      {!! Form::label('abreviacao', 'Resumo', ['class' => 'control-label']) !!}
      {!! Form::textarea('abreviacao', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->abreviacao : null, ['class' => 'textarea-control']) !!}
    </li>
    <li class="size-col-1 size-content-2 size-heigt2">
      {!! Form::label('descricao', 'Conteúdo', ['class' => 'control-label']) !!}
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
        descricao: { required: true }
      }
    });
  });
</script>
