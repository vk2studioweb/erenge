<section id="main-form">
  {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' =>'mainFormInsert']) !!}
  <ul id="main-form-list">
    <li class="size-col-2 size-content-1">
      {!! Form::label('name', 'Nome/Titúlo', array('class' => 'control-label' )) !!}
      {!! Form::text('name', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->name : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('link', 'LInk/Página', array('class' => 'control-label' )) !!}
      {!! Form::text('link', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->link : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('icon', 'Icone Usado', array('class' => 'control-label' )) !!}
      {!! Form::text('icon', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->icon : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-2 size-content-1">
      {!! Form::label('apikey', 'Api Key', array('class' => 'control-label' )) !!}
      {!! Form::text('apikey', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->apikey : null, ['class' => 'form-control', 'autocomplete' => 'off'])!!}
    </li>
    <li class="size-col-5 size-content-2">
        {!! Form::label('print_list', 'Exibir na Listagem', array('class' => 'control-label' )) !!}
        <div class="main-radio">
            {!! Form::radio('print_list', '1', (isset($thisdata->listRegister)) ? (($thisdata->listRegister[0]->print_list == true) ? 'checked' : '') : '', ['class' => 'form-control-radio', 'id' => 'radio1']) !!}
            {!! Form::label('radio1', 'Sim', array('class' => isset($thisdata->listRegister) ? (($thisdata->listRegister[0]->print_list == true) ? 'label-radio ui-admin-rec-circular-button' : 'label-radio ui-admin-circle') : 'label-radio ui-admin-circle', 'data-radio' => '1' )) !!}
        </div>
        <div class="main-radio">
            {!! Form::radio('print_list', '0', (isset($thisdata->listRegister)) ? (($thisdata->listRegister[0]->print_list == 0) ? 'checked' : '') : 'checked', ['class' => 'form-control-radio', 'id' => 'radio2']) !!}
            {!! Form::label('radio2', 'Não', array('class' => isset($thisdata->listRegister) ? (($thisdata->listRegister[0]->print_list == 0) ? 'label-radio ui-admin-rec-circular-button' : 'label-radio ui-admin-circle') : 'label-radio ui-admin-rec-circular-button', 'data-radio' => '2')) !!}
        </div>
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
    jQuery("input[name='name']").rules("add", { required: true });
    jQuery("input[name='link']").rules("add", { required: true });
    jQuery("input[name='icon']").rules("add", { required: true });
  });
</script>
