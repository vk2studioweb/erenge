<section id="main-form">
  {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' =>
  'mainFormInsert']) !!}
  <ul id="main-form-list">
    <li class="size-col-2 size-content-1">
      {!! Form::label('name', 'Nome/Título', array('class' => 'control-label' )) !!}
      {!! Form::text('name', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->name : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('name_en', 'Nome/Título', array('class' => 'control-label' )) !!}
      {!! Form::text('name_en', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->name_en : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('slug', 'Slug', array('class' => 'control-label' )) !!}
      {!! Form::text('slug', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->slug : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('link', 'Link', array('class' => 'control-label' )) !!}
      {!! Form::text('link', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->link : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
  </ul>
  {!! Form::close() !!}
</section>
<script type="text/javascript">
  jQuery(document).ready(function () {
    jQuery("input[name='name']").rules("add", { required: true });
    jQuery("input[name='name_en']").rules("add", { required: true });
    jQuery("input[name='slug']").rules("add", { required: true });
    jQuery("input[name='link']").rules("add", { required: true });
  });
</script>