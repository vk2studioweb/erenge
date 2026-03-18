<section id="main-form">

     {{--  Abrir formulário --}}
     {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}
     {!! Form::hidden('id_group', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->id_group : $thisdata->idfather, ['class' => 'form-control', 'readonly' => 'true']) !!}
     
     <ul id="main-form-list">
          <!-- <li class="size-col-1 size-content-3"> -->
               <!-- {!! Form::label('name', 'Adicionando Menu para o Grupo', array('class' => 'control-label' )) !!}  -->
               <!-- {!! Form::text('father', isset($thisdata->fatherData) ? $thisdata->fatherData[0]->name : null, ['class' => 'form-control', 'readonly' => 'true']) !!} -->
          <!-- </li> -->
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'Nome', array('class' => 'control-label' )) !!} 
               {!! Form::text('name', isset($thisdata->listRegister) ?  $thisdata->listRegister[0]->name : null, ['class' => 'form-control']) !!}
          </li>
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'Link', array('class' => 'control-label' )) !!} 
               {!! Form::text('link', isset($thisdata->listRegister) ?  $thisdata->listRegister[0]->link : null, ['class' => 'form-control']) !!}
          </li>
          <li class="size-col-5 size-content-2">

               {!! Form::label('visible', 'Menu Visível?', array('class' => 'control-label' )) !!}
               <div class="main-radio">
                   {!! Form::radio('visible', '1', isset($thisdata->listRegister[0]->opcao1) && ((boolean) $thisdata->listRegister[0]->opcao1) ? true : false, 
                   ['class' => 'form-control-radio', 'id' => 'radio1']) !!}
                   {!! Form::label('visible', 'Sim', ['class' => isset($thisdata->listRegister) && ((boolean) $thisdata->listRegister[0]->opcao1) ? 'label-radio ui-admin-rec-circular-button': 'label-radio ui-admin-circle', 
                   'data-radio' => '1']) !!}
               </div>
               <div class="main-radio">
                   {!! Form::radio('visible', '0', (isset($thisdata->listRegister) && !((boolean) $thisdata->listRegister[0]->opcao1)) || !(isset($thisdata->listRegister)) ? true : false , 
                   ['class' => 'form-control-radio', 'id' => 'radio0']) !!}
                   {!! Form::label('visible', 'Não', array('class' => (isset($thisdata->listRegister) && !((boolean) $thisdata->listRegister[0]->opcao1)) || !(isset($thisdata->listRegister)) ? 'label-radio ui-admin-rec-circular-button' : 'label-radio ui-admin-circle', 'data-radio' => '0'
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
          jQuery( "input[name='link']" ).rules( "add", { required: true });
     });

</script>