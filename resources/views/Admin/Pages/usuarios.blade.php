<section id="main-form">

     {{--  Abrir formulário --}}
     {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}
    
     <ul id="main-form-list">
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'Painel de Acesso do Usuário', array('class' => 'control-label' )) !!} 
               {!! Form::select('id_class', $thisdata->listForeignKey->classes, isset($thisdata->listRegister) ? $thisdata->listRegister[0]->id_class : null, ['class' => 'form-control']); !!}
          </li>
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'Tipo de Usuário', array('class' => 'control-label' )) !!} 
               {!! Form::select('id_permission', $thisdata->listForeignKey->permissoes, isset($thisdata->listRegister) ? $thisdata->listRegister[0]->id_permission : null, ['class' => 'form-control']); !!}
          </li>
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'Nome', array('class' => 'control-label' )) !!} 
               {!! Form::text('name', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->name : null, ['class' => 'form-control'])!!}
          </li>
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'E-mail', array('class' => 'control-label' )) !!} 
               {!! Form::text('email', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->email : null, ['class' => 'form-control'])!!}
          </li>
          @if(!isset($thisdata->listRegister))
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'Senha', array('class' => 'control-label' )) !!} 
               {!! Form::password('password', ['class' => 'form-control'])!!}
          </li>
          @endif
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
          jQuery( "input[name='password']" ).rules( "add", { maxlength: 40 });
     });
</script>
