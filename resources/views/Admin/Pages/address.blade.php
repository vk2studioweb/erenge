<section id="main-form">
  {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' =>
  'mainFormInsert']) !!}
  <ul id="main-form-list">
    <li class="size-col-2 size-content-1">
      {!! Form::label('address', 'Endereço Completo *', array('class' => 'control-label' )) !!}
      {!! Form::text('address', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->address : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('celphone', 'Telefone *', array('class' => 'control-label' )) !!}
      {!! Form::text('celphone', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->celphone : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('mail', 'E-mail *', array('class' => 'control-label' )) !!}
      {!! Form::text('mail', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->mail : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('coords', 'Coordenadas *', array('class' => 'control-label' )) !!}
      {!! Form::text('coords', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->coords : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
  </ul>
  {!! Form::close() !!}
</section>
<script type="text/javascript">
  jQuery(document).ready(function () {
    jQuery("input[name='address']").rules("add", { required: true });
    jQuery("input[name='celphone']").rules("add", { required: true });
    jQuery("input[name='mail']").rules("add", { required: true });
    jQuery("input[name='coords']").rules("add", { required: true });
  });
</script>