<section id="main-form">
    {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' =>
    'mainFormInsert']) !!}
    <ul id="main-form-list">
      <li class="size-col-2 size-content-1">
        {!! Form::label('name', 'Nome', array('class' => 'control-label' )) !!}
        {!! Form::text('name', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->name : null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
      </li>
      <li class="size-col-1 size-content-2">
        {!! Form::label('link', 'Link', ['class' => 'control-label']) !!}
        {!! Form::text('link', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->link : null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
      </li>
      <li class="size-col-4 size-content-2">
        {!! Form::label('target', 'Abrir em uma nova aba?', array('class' => 'control-label' )) !!}
        <div class="main-radio">
            {!! Form::radio('target', '1', isset($thisdata->listRegister[0]->target) && ((boolean) $thisdata->listRegister[0]->target) ? true : false, 
            ['class' => 'form-control-radio', 'id' => 'radio1']) !!}
            {!! Form::label('target', 'Sim', ['class' => isset($thisdata->listRegister) && ((boolean) $thisdata->listRegister[0]->target) ? 'label-radio ui-admin-rec-circular-button': 'label-radio ui-admin-circle', 
            'data-radio' => '1']) !!}
        </div>
        <div class="main-radio">
            {!! Form::radio('target', '0', (isset($thisdata->listRegister) && !((boolean) $thisdata->listRegister[0]->target)) || !(isset($thisdata->listRegister)) ? true : false , 
            ['class' => 'form-control-radio', 'id' => 'radio0']) !!}
            {!! Form::label('target', 'Não', array('class' => (isset($thisdata->listRegister) && !((boolean) $thisdata->listRegister[0]->target)) || !(isset($thisdata->listRegister)) ? 'label-radio ui-admin-rec-circular-button' : 'label-radio ui-admin-circle', 'data-radio' => '0'
            )) !!}
        </div>
      </li>
      <hr>
      <li class="size-col-1 size-content-1 size-heigt2">
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
      jQuery("textarea[name='description']").rules("add", {required: true});
      jQuery("radio[name='target']").rules("add", {required: true});
    });
  </script>