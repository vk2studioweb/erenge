<section id="main-form">
     {{--  Abrir formulário --}}
     {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}

     <ul id="main-form-list">
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'Nome do estado', array('class' => 'control-label' )) !!} 
               {!! Form::text('name', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->name : null, ['class' => 'form-control'])!!}
          </li>
          <li class="size-col-3 size-content-2">
               {!! Form::label('uf', 'UF', array('class' => 'control-label' )) !!} 
               {!! Form::text('uf', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->uf : null, ['class' => 'form-control'])!!}
          </li>
          
          {{-- Devido regra de negocio apenas o estado do Brasil está permitido para cadastros, desta forma o mesmo está hardcoded aqui --}}
          {!! Form::hidden('id_country', 1, ['class' => 'form-control','readonly' => 'true']) !!}
     </ul>     
     {!! Form::close() !!} {{-- Fechar formulário --}}
     
</section>

<script type="text/javascript">
     jQuery(document).ready(function(){
          jQuery( "input[name='name']" ).rules( "add", { required: true });
          jQuery( "input[name='uf']" ).rules( "add", { required: true });
     });
</script>
