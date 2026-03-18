<section id="main-form">
  <ul id="main-permission-list" data-user="{{ $thisdata->userId }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @foreach($thisdata->allPermission as $key=>$permissions)
    <li id="page-permission{{ $permissions->id_permission }}" class="page-permission" data-page="{{ $permissions->id_menu }}" data-quantSelect="{{ $permissions->qtd_select }}">
      <h2 class="name-page-permission">
        <strong>{{ $permissions->group }}</strong>
        \{{ $permissions->menu }}
      </h2>
      
      <div class="permission-select" data-active="{{ $permissions->select_all }}" data-action="0">
        <span>Tudo:</span>
        <span class="marker-permission @if($permissions->select_all == 1) marker-permission-true @endif">@if($permissions->select_all == 1) Sim @else Não @endif</span>
      </div>
      <div class="permission-select" data-active="{{ $permissions->view }}" data-action="1">
        <span>Visualizar:</span>
        <span class="marker-permission @if($permissions->view == 1) marker-permission-true @endif">@if($permissions->view == 1) Sim @else Não @endif</span>
      </div>
      <div class="permission-select" data-active="{{ $permissions->edit }}" data-action="2">
        <span>Alterar:</span>
        <span class="marker-permission @if($permissions->edit == 1) marker-permission-true @endif">@if($permissions->edit == 1) Sim @else Não @endif</span>
      </div>
      <div class="permission-select" data-active="{{ $permissions->add }}" data-action="3">
        <span>Inserir:</span>
        <span class="marker-permission @if($permissions->add == 1) marker-permission-true @endif">@if($permissions->add == 1) Sim @else Não @endif</span>
      </div>
      <div class="permission-select" data-active="{{ $permissions->delete }}" data-action="4">
        <span>Deletar:</span>
        <span class="marker-permission @if($permissions->delete == 1) marker-permission-true @endif">@if($permissions->delete == 1) Sim @else Não @endif</span>
      </div>
      <div class="permission-select" data-active="{{ $permissions->upload }}" data-action="5">
        <span>Uploads:</span>
        <span class="marker-permission @if($permissions->upload == 1) marker-permission-true @endif">@if($permissions->upload == 1) Sim @else Não @endif</span>
      </div>
      <div class="permission-select" data-active="{{ $permissions->status }}" data-action="6">
        <span>Status:</span>
        <span class="marker-permission @if($permissions->status == 1) marker-permission-true @endif">@if($permissions->status == 1) Sim @else Não @endif</span>
      </div>
    </li>
    @endforeach
  </ul>
  
</section>