<section id="main-form">
  {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' =>
  'mainFormInsert']) !!}
  <ul id="main-form-list">
    <li class="size-col-2 size-content-1">
      {!! Form::label('name', 'Nome ', array('class' => 'control-label' )) !!}
      {!! Form::text('name', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->name : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('celphone', 'Celular *', array('class' => 'control-label' )) !!}
      {!! Form::text('celphone', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->celphone : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('mail', 'E-mail *', array('class' => 'control-label' )) !!}
      {!! Form::text('mail', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->mail : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('city', 'Cidade *', array('class' => 'control-label' )) !!}
      {!! Form::text('city', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->city : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('uf', 'Estado *', array('class' => 'control-label' )) !!}
      {!! Form::text('uf', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->uf : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-1 size-content-2 size-heigt2">
      {!! Form::label('description', 'Descrição', array('class' => 'control-label' )) !!}
      {!! Form::textarea('description', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->description : null, ['class' => 'textarea-control', 'autocomplete' => 'off']) !!}
    </li>
    
  </ul>
  {!! Form::close() !!}
</section>
<script type="text/javascript">
  jQuery(document).ready(function () {
   
  city;
</script>