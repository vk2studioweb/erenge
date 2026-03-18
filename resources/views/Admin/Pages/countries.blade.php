<section id="main-form">

     {{--  Abrir formulário --}}
     {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}

     <ul id="main-form-list">
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'Nome do país', array('class' => 'control-label' )) !!} 
               {!! Form::text('name', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->name : null, ['class' => 'form-control'])!!}
          </li>
     </ul>     
     {!! Form::close() !!} {{-- Fechar formulário --}}
     
</section>

<script type="text/javascript">
     jQuery(document).ready(function(){
          jQuery( "input[name='name']" ).rules( "add", { required: true });
     });
</script>
