<section id="main-form">
  {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}
  <ul id="main-form-list">
    <li class="size-col-2 size-content-1">
      {!! Form::label('info_location', 'Localização do Texto (Slug/ID)', ['class' => 'control-label']) !!}
      {!! Form::text('info_location', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->info_location : null, ['class' => 'form-control', 'placeholder' => 'ex: home-section-about']) !!}
    </li>

    <li class="size-col-2 size-content-1">
      {!! Form::label('name', 'Título Interno', ['class' => 'control-label']) !!}
      {!! Form::text('name', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->name : null, ['class' => 'form-control']) !!}
    </li>

    <hr>

    <li class="size-col-1 size-content-2 size-heigt2">
      {!! Form::label('description', 'Conteúdo do Texto', ['class' => 'control-label']) !!}
      {!! Form::textarea('description', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->description : null, ['class' => 'textarea-control editor']) !!}
    </li>
  </ul>
  {!! Form::close() !!}
</section>

<script type="text/javascript">
  jQuery(document).ready(function () {
    jQuery("#mainFormInsert").validate({
      rules: {
        info_location: { required: true },
        name: { required: true }
      }
    });
  });
</script>