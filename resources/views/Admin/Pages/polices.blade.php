<section id="main-form">
  {!! Form::open(['url'=>$thisdata->url,'method'=>'POST','onsubmit'=>'return false','id'=>'mainFormInsert']) !!}
  <ul id="main-form-list">
    <li class="size-col-2 size-content-1">{!! Form::label('slug','Slug',['class'=>'control-label']) !!}
      {!! Form::text('slug',isset($thisdata->listRegister)?$thisdata->listRegister[0]->slug:null,['class'=>'form-control']) !!}
    </li>
    <li class="size-col-2 size-content-1">{!! Form::label('name','Nome',['class'=>'control-label']) !!}
      {!! Form::text('name',isset($thisdata->listRegister)?$thisdata->listRegister[0]->name:null,['class'=>'form-control'])!!}
    </li>
    <li class="size-col-1 size-content-1 size-heigt2">
      {!! Form::label('description','Descrição',['class'=>'control-label']) !!}
      {!! Form::textarea('description',isset($thisdata->listRegister)?$thisdata->listRegister[0]->description:null,['class'=>'textarea-control editor']) !!}
    </li>
  </ul>
  {!! Form::close() !!}
</section>
<script>
  jQuery(document).ready(function(){
  jQuery("input[name='slug']").rules("add",{required:true});
  jQuery("input[name='name']").rules("add",{required:true});
  jQuery("textarea[name='description']").rules("add",{required:true});
});
</script>