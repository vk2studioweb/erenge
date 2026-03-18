<section id="main-form">
     
     {{--  Abrir formulário --}}
     {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}
     {!! Form::hidden('id_menu', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->id_menu : $thisdata->idfather, ['class' => 'form-control', 'readonly' => 'true']) !!}
     
     <ul id="main-form-list">
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'Nome', array('class' => 'control-label' )) !!} 
               {!! Form::text('name', isset($thisdata->listRegister) ?  $thisdata->listRegister[0]->name : null, ['class' => 'form-control']) !!}
          </li>
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'Link', array('class' => 'control-label' )) !!} 
               {!! Form::text('link', isset($thisdata->listRegister) ?  $thisdata->listRegister[0]->link : null, ['class' => 'form-control']) !!}
          </li>
          <li class="size-col-5 size-content-2">
               {!! Form::label('name', 'Default', array('class' => 'control-label' )) !!} 
               <div class="main-radio">
               {!!  Form::radio('default', '1', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->opcao1 : false, ['class' => 'form-control-radio', 'id' => 'radio1'])  !!} 
               @if(isset($thisdata->listRegister))
               {!! Form::label('name', 'Sim', array('class' => $thisdata->listRegister[0]->opcao1 == false ? 'label-radio ui-admin-circle' : 'label-radio ui-admin-rec-circular-button', 'data-radio' => '1' )) !!}
               @else
               {!! Form::label('name', 'Sim', array('class' => 'label-radio ui-admin-circle', 'data-radio' => '1' )) !!}
               @endif
               </div>
               <div class="main-radio">
               {!!  Form::radio('default', '0', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->opcao2 : true, ['class' => 'form-control-radio', 'id' => 'radio2'])  !!}
               @if(isset($thisdata->listRegister))
               {!! Form::label('name', 'Não', array('class' => $thisdata->listRegister[0]->opcao2 == false ? 'label-radio ui-admin-circle' : 'label-radio ui-admin-rec-circular-button', 'data-radio' => '2' )) !!}
               @else
               {!! Form::label('name', 'Não', array('class' => 'label-radio ui-admin-rec-circular-button', 'data-radio' => '2' )) !!}
               @endif
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
