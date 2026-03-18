<section id="main-form">
     @if(!isset($thisdata->listRegister))
     {{--  Abrir formulário --}}
     {!! Form::open(['url' => $thisdata->url . '/insert', 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormCollumnStyle']) !!}
     {!! Form::hidden('id_menu_style', $thisdata->idStyle, ['class' => 'form-control', 'readonly' => 'true']) !!}
     
     <ul id="main-form-list">
          <li class="size-col-5 size-content-1">
               {!! Form::label('name', 'Nome', array('class' => 'control-label' )) !!} 
               {!! Form::text('name', null, ['class' => 'form-control nameinputvalid']) !!}
          </li>
          <li class="size-col-5 size-content-1">
               {!! Form::label('name', 'Coluna', array('class' => 'control-label' )) !!} 
               {!! Form::text('collumn', null, ['class' => 'form-control']) !!}
          </li>
          <li class="size-col-5 size-content-1">
               {!! Form::label('name', 'OrderBy', array('class' => 'control-label' )) !!} 
               {!! Form::select('order', ['asc' => 'ASC', 'desc' => 'DESC'], null, ['class' => 'form-control']) !!}
          </li>
          <li class="size-col-5 size-content-1">
               {!! Form::label('name', 'Lim. Caracteres', array('class' => 'control-label' )) !!} 
               {!! Form::text('legenth', null, ['class' => 'form-control']) !!}
          </li>
          <li class="size-col-5 size-content-1">
               {!! Form::label('name', 'Tam. Coluna', array('class' => 'control-label' )) !!} 
               {!! Form::text('size', null, ['class' => 'form-control']) !!}
          </li>
          <hr>
          <li class="size-col-5 size-content-2">
               {!! Form::label('name', 'Ut. Função', array('class' => 'control-label' )) !!} 
               <div class="main-radio">
               {!!  Form::radio('function', '1', false, ['class' => 'form-control-radio', 'id' => 'radio1'])  !!}
               {!! Form::label('name', 'Sim', array('class' => 'label-radio ui-admin-circle', 'data-radio' => '1' )) !!}
               </div>
               <div class="main-radio">
               {!!  Form::radio('function', '0', true, ['class' => 'form-control-radio', 'id' => 'radio2'])  !!}
               {!! Form::label('name', 'Não', array('class' => 'label-radio ui-admin-rec-circular-button', 'data-radio' => '2' )) !!}
               </div>
          </li>
          <li class="size-col-5 size-content-2">
               {!! Form::label('name', 'Default', array('class' => 'control-label' )) !!} 
               <div class="main-radio">
               {!!  Form::radio('default', '1', false, ['class' => 'form-control-radio', 'id' => 'radio3'])  !!}
               {!! Form::label('name', 'Sim', array('class' => 'label-radio ui-admin-circle', 'data-radio' => '3' )) !!}
               </div>
               <div class="main-radio">
               {!!  Form::radio('default', '0', true, ['class' => 'form-control-radio', 'id' => 'radio4'])  !!}
               {!! Form::label('name', 'Não', array('class' => 'label-radio ui-admin-rec-circular-button', 'data-radio' => '4' )) !!}
               </div>
          </li>
     </ul>     
     {!! Form::close() !!} {{-- Fechar formulário --}}
     @else
     {{--  Abrir formulário --}}
     {!! Form::open(['url' => $thisdata->url . '/toedit', 'method' => 'POST', 'onsubmit' => 'return false', 'id' => 'mainFormCollumnStyle']) !!}
     {!! Form::hidden('id_menu_style_list', $thisdata->idStyleCollumn, ['class' => 'form-control', 'readonly' => 'true']) !!}
     {!! Form::hidden('id_menu_style',  $thisdata->listRegister[0]->id_menu_style, ['class' => 'form-control', 'readonly' => 'true']) !!}
     
     <ul id="main-form-list">
          <li class="size-col-5 size-content-1">
               {!! Form::label('name', 'Nome', array('class' => 'control-label' )) !!} 
               {!! Form::text('name',  $thisdata->listRegister[0]->name, ['class' => 'form-control nameinputvalid']) !!}
          </li>
          <li class="size-col-5 size-content-1">
               {!! Form::label('name', 'Coluna', array('class' => 'control-label' )) !!} 
               {!! Form::text('collumn', $thisdata->listRegister[0]->collumn, ['class' => 'form-control']) !!}
          </li>
          <li class="size-col-5 size-content-1">
               {!! Form::label('name', 'OrderBy', array('class' => 'control-label' )) !!} 
               {!! Form::select('order', ['asc' => 'ASC', 'desc' => 'DESC'], $thisdata->listRegister[0]->order, ['class' => 'form-control']) !!}
          </li>
          <li class="size-col-5 size-content-1">
               {!! Form::label('name', 'Lim. Caracteres', array('class' => 'control-label' )) !!} 
               {!! Form::text('legenth', $thisdata->listRegister[0]->legenth, ['class' => 'form-control']) !!}
          </li>
          <li class="size-col-5 size-content-1">
               {!! Form::label('name', 'Tam. Coluna', array('class' => 'control-label' )) !!} 
               {!! Form::text('size', $thisdata->listRegister[0]->size, ['class' => 'form-control']) !!}
          </li>
          <li class="size-col-5 size-content-2">
               {!! Form::label('name', 'Ut. Função', array('class' => 'control-label' )) !!} 
               <div class="main-radio">
               {!!  Form::radio('function', '1', $thisdata->listRegister[0]->function == true ? true : false, ['class' => 'form-control-radio', 'id' => 'radio1'])  !!} 
               {!! Form::label('name', 'Sim', array('class' => $thisdata->listRegister[0]->function == true ? 'label-radio ui-admin-rec-circular-button' : 'label-radio ui-admin-circle', 'data-radio' => '1' )) !!}
               </div>
               <div class="main-radio">
               {!!  Form::radio('function', '0', $thisdata->listRegister[0]->function == false ? true : false, ['class' => 'form-control-radio', 'id' => 'radio2'])  !!}
               {!! Form::label('name', 'Não', array('class' => $thisdata->listRegister[0]->function == false ? 'label-radio ui-admin-rec-circular-button' : 'label-radio ui-admin-circle', 'data-radio' => '2' )) !!}
               </div>
          </li>
          <li class="size-col-5 size-content-2">
               {!! Form::label('name', 'Default', array('class' => 'control-label' )) !!} 
               <div class="main-radio">
               {!!  Form::radio('default', '1', $thisdata->listRegister[0]->default == true ? true : false, ['class' => 'form-control-radio', 'id' => 'radio3'])  !!} 
               {!! Form::label('name', 'Sim', array('class' => $thisdata->listRegister[0]->default == true ? 'label-radio ui-admin-rec-circular-button' : 'label-radio ui-admin-circle', 'data-radio' => '3' )) !!}
               </div>
               <div class="main-radio">
               {!!  Form::radio('default', '0', $thisdata->listRegister[0]->default == false ? true : false, ['class' => 'form-control-radio', 'id' => 'radio4'])  !!}
               {!! Form::label('name', 'Não', array('class' => $thisdata->listRegister[0]->default == false ? 'label-radio ui-admin-rec-circular-button' : 'label-radio ui-admin-circle', 'data-radio' => '4' )) !!}
               </div>
          </li>
     </ul>     
     {!! Form::close() !!} {{-- Fechar formulário --}}

     @endif
</section>
<section id="main-collumnsstyle-listed">
     <h3 class="title-section-collumnstyle">Colunas Habilitadas</h3>
     <ul id="main-collunsstyle-list">
          @foreach($thisdata->collumns as $key=>$collumn)
          <li id="collumnstyle-item-{{ $collumn->id_menu_style_list }}" class="main-collumnstyle-item">  
               <h2 class="name-page-permission">
                    <strong>{{ $collumn->name }}</strong>
                    \{{ $collumn->collumn }}
               </h2>
               <span class="item-collumnstyle">OrderBy: <strong>{{ $collumn->order }} </strong></span>
               <span class="item-collumnstyle">Lim. Caracteres: <strong>{{ $collumn->legenth }} </strong></span>
               <span class="item-collumnstyle">Tam. Coluna: <strong>{{ $collumn->size }} </strong></span>
               <span class="item-collumnstyle">Ut. Função: <strong>{{ $collumn->function == 1 ? 'Sim' : 'Não' }} </strong></span>
               <span class="item-collumnstyle">Default: <strong>{{ $collumn->default == 1 ? 'Sim' : 'Não' }} </strong></span>
               <a href="{{ $thisdata->url . '/edit/' . $collumn->id_menu_style_list }}" class="link-collumnstyle button-update-register-collumnstyle">Alterar Cadastro</a>
               <button data-idStyle="{{ $collumn->id_menu_style_list }}" class="link-collumnstyle button-delete-register-collumnstyle">Apagar Registro</button>
          </li>
          @endforeach
     </ul>
</section>




<script type="text/javascript">

     jQuery(document).ready(function(){
          jQuery( "input[name='name']" ).rules( "add", { required: true });
     });
</script>