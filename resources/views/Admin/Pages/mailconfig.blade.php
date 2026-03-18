<section id="main-form">
  {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' =>
  'mainFormInsert']) !!}
  <ul id="main-form-list">
    <li class="size-col-1 size-content-3">
      {!! Form::label('smtp', 'Host SMTP', array('class' => 'control-label' )) !!}
      {!! Form::text('smtp', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->smtp : null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
    </li>
    <li class="size-col-1 size-content-3">
      {!! Form::label('mail_send', 'Email de Envio', array('class' => 'control-label' )) !!}
      {!! Form::text('mail_send', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->mail_send : null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
    </li>
    <li class="size-col-2 size-content-3">
      {!! Form::label('password_mail_send', 'Senha do Email de Envio', array('class' => 'control-label' )) !!}
      {!! Form::text('password_mail_send', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->password_mail_send : null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
    </li>
    <li class="size-col-1 size-content-3">
      {!! Form::label('smtp_port', 'Porta', array('class' => 'control-label' )) !!}
      {!! Form::text('smtp_port', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->smtp_port : null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
    </li>

    <li class="size-col-4 size-content-2">
      {!! Form::label('ssl', 'SSL?', array('class' => 'control-label' )) !!}
      <div class="main-radio">
          {!! Form::radio('ssl', '1', isset($thisdata->listRegister[0]->ssl) && ((boolean) $thisdata->listRegister[0]->ssl) ? true : false, 
          ['class' => 'form-control-radio', 'id' => 'radio1']) !!}
          {!! Form::label('ssl', 'Sim', ['class' => isset($thisdata->listRegister) && ((boolean) $thisdata->listRegister[0]->ssl) ? 'label-radio ui-admin-rec-circular-button': 'label-radio ui-admin-circle', 
          'data-radio' => '1']) !!}
      </div>
      <div class="main-radio">
          {!! Form::radio('ssl', '0', (isset($thisdata->listRegister) && !((boolean) $thisdata->listRegister[0]->ssl)) || !(isset($thisdata->listRegister)) ? true : false , 
          ['class' => 'form-control-radio', 'id' => 'radio0']) !!}
          {!! Form::label('ssl', 'Não', array('class' => (isset($thisdata->listRegister) && !((boolean) $thisdata->listRegister[0]->ssl)) || !(isset($thisdata->listRegister)) ? 'label-radio ui-admin-rec-circular-button' : 'label-radio ui-admin-circle', 'data-radio' => '0'
          )) !!}
      </div>
    </li>
  </ul>
  {!! Form::close() !!}
</section>
<script type="text/javascript">
  jQuery(document).ready(function () {
    jQuery("input[name='name']").rules("add", { required: true });
    jQuery("input[name='email']").rules("add", { required: true });
    jQuery("input[name='phone']").rules("add", { required: true });
    jQuery("input[name='subject']").rules("add", { required: true });
    jQuery("textarea[name='message']").rules("add", {required: true});
  });
</script>