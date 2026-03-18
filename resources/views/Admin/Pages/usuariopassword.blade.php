<section id="main-form">

     {{--  Abrir formulário --}}
     {!! Form::open(['url' => $thisdata->url, 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormInsert']) !!}
     {!! Form::hidden('id_login_user', isset($thisdata->listRegister) ? $thisdata->listRegister[0]->id_login_user : $thisdata->idfather, ['class' => 'form-control', 'readonly' => 'true']) !!}
     
     <ul id="main-form-list">
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'Senha', array('class' => 'control-label' )) !!} 
               {!! Form::password('password', ['class' => 'form-control', 'id' => 'password'])!!}
          </li>
          <li class="size-col-2 size-content-1">
               {!! Form::label('name', 'Confirme a Senha', array('class' => 'control-label' )) !!} 
               {!! Form::password('confirmpassword', ['class' => 'form-control'])!!}
          </li>
     </ul>     
     {!! Form::close() !!} {{-- Fechar formulário --}}
     
</section>

<script type="text/javascript">

     jQuery(document).ready(function(){
          jQuery( "input[name='password']" ).rules( "add", { required: true });
          jQuery( "input[name='confirmpassword']" ).rules( "add", { required: true, equalTo: "#password" });
     });

</script>