<section id="main-form">
     
     {{--  Abrir formulário --}}
     {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}
     {!! Form::hidden('id_menu', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->id_menu : $thisdata->idfather, ['class' => 'form-control', 'readonly' => 'true']) !!}
     
     <ul id="main-form-list">
     <li class="size-col-1 size-content-2">
          {!! Form::label('name', 'Estilo de Listagem', array('class' => 'control-label' )) !!} 
          {!! Form::select('id_style', $thisdata->listForeignKey->style, isset($thisdata->listRegister) ? $thisdata->listRegister[0]->id_style : null, ['class' => 'form-control']); !!}
     </li>
     <li class="size-col-5 size-content-2">
          {!! Form::label('name', 'Default', ['class' => 'control-label']) !!}
          <div class="main-radio">
              {!! Form::radio(
                  'default',
                  '1',
                  isset($thisdata->listRegister[0]->opcao1) && $thisdata->listRegister[0]->opcao1 ? true : false,
                  ['class' => 'form-control-radio', 'id' => 'radio1'],
              ) !!}

              {!! Form::label('radio1', 'Sim', [
                  'class' =>
                      isset($thisdata->listRegister) && ((bool) $thisdata->listRegister[0]->opcao1)
                          ? 'label-radio ui-admin-rec-circular-button'
                          : 'label-radio ui-admin-circle',
                  'data-radio' => '1',
              ]) !!}
          </div>
          <div class="main-radio">
              {!! Form::radio(
                  'default',
                  '0',
                  (isset($thisdata->listRegister) && ((bool) $thisdata->listRegister[0]->opcao2)) || empty($thisdata->listRegister)
                      ? true
                      : false,
                  ['class' => 'form-control-radio', 'id' => 'radio2'],
              ) !!}

              {!! Form::label('main', 'Não', [
                  'class' =>
                      (isset($thisdata->listRegister) && ((bool) $thisdata->listRegister[0]->opcao2)) || empty($thisdata->listRegister)
                          ? 'label-radio ui-admin-rec-circular-button'
                          : 'label-radio ui-admin-circle',
                  'data-radio' => '0',
              ]) !!}
          </div>
      </li>
</ul>     
{!! Form::close() !!} {{-- Fechar formulário --}}
     
</section>

<script type="text/javascript">

     jQuery(document).ready(function(){
          jQuery( "input[name='id_style']" ).rules( "add", { required: true });
     });
</script>
