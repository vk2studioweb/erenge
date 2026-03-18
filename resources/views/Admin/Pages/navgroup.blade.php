<section id="main-form">

     {{--  Abrir formulário --}}
     {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}
     
     <ul id="main-form-list">
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'Nome', array('class' => 'control-label' )) !!} 
               {!! Form::text('name', isset($thisdata->listRegister) ?  $thisdata->listRegister[0]->name : null, ['class' => 'form-control'])!!}
          </li>
          <li class="size-col-2 size-content-1">
               {!! Form::label('link', 'Link', array('class' => 'control-label' )) !!} 
               {!! Form::text('link', isset($thisdata->listRegister) ?  $thisdata->listRegister[0]->link : null, ['class' => 'form-control'])!!}
          </li>
        
          <li class="size-col-5 size-content-2">
               {!! Form::label('submenu', 'Submenu', array('class' => 'control-label' )) !!}
               <div class="main-radio">
                    {!! Form::radio('submenu', '1', isset($thisdata->listRegister[0]->submenu) && ((boolean) $thisdata->listRegister[0]->submenu) ? true : false, 
                    ['class' => 'form-control-radio', 'id' => 'radio1']) !!}
                    {!! Form::label('submenu', 'Sim', ['class' => isset($thisdata->listRegister) && ((boolean) $thisdata->listRegister[0]->submenu) ? 'label-radio ui-admin-rec-circular-button': 'label-radio ui-admin-circle', 
                    'data-radio' => '1']) !!}
               </div>
               <div class="main-radio">
                    {!! Form::radio('submenu', '0', (isset($thisdata->listRegister) && !((boolean) $thisdata->listRegister[0]->submenu)) || !(isset($thisdata->listRegister)) ? true : false , 
                    ['class' => 'form-control-radio', 'id' => 'radio0']) !!}
                    {!! Form::label('submenu', 'Não', array('class' => (isset($thisdata->listRegister) && !((boolean) $thisdata->listRegister[0]->submenu)) || !(isset($thisdata->listRegister)) ? 'label-radio ui-admin-rec-circular-button' : 'label-radio ui-admin-circle', 'data-radio' => '0'
                    )) !!}
               </div>
          </li>


          <!-- <li class="size-col-1 size-content-1 size-heigt2">
               {!! Form::label('name', 'Descrição', array('class' => 'control-label' )) !!} 
               {!! Form::textarea('description', null, ['class' => 'textarea-control']) !!}
          </li> -->
     </ul>     
     {!! Form::close() !!} {{-- Fechar formulário --}}
     
</section>

<script type="text/javascript">

     jQuery(document).ready(function(){
          jQuery( "input[name='name']" ).rules( "add", { required: true });
     });
</script>
