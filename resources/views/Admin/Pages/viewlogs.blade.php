@extends('Admin.Layouts.app')

@section('content')
    <!-- Inclui identificação da pag. -->
    @include('Admin.Layouts.identification')

    <section class="main-content">
        <section class="logViewerContainer">
            <ul id="main-form-list" class="logList">
                @foreach ($thisdata->logs as $key => $log)
                    <li class="size-col-1 size-content-1 size-heigt-auto">
                        <table id="{{ $key }}" class="display logTable">
                            <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Página</th>
                                    <th>Data</th>
                                    <th id="user">Usuário</th>
                                    <th>Conteúdo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($log as $logLines)
                                    <tr>
                                        <td>{{ $logLines['level'] }}</td>
                                        @php
                                            $stackVals = explode("\n", trim($logLines['stack']));
                                            $pageStack = json_decode($stackVals[2]);
                                            $userStack = json_decode($stackVals[0]);
                                        @endphp
                                        <td class="text"> {{ $pageStack->página ?? null }} </td>
                                        <td>{{ $logLines['date'] }}</td>
                                        <td class="user"> {{ $userStack->user }} </td>
                                        <td class="stackCol" id="stack-{{ $loop->iteration }}"> {{ $logLines['text'] }} <span
                                                class="ui-admin-search"></span>
                                            @if ($logLines['stack'])
                                                <div class="stack" data-column="stack-{{ $loop->iteration }}"
                                                    style="display: none;">
                                                    <div class="JsonStackVal">
                                                        @foreach ($stackVals as $value)
                                                            @if (!is_null(json_decode($value)))
                                                                @foreach (json_decode($value) as $key => $item)
                                                                    <label for="">{{ $key }}</label>
                                                                    @if (gettype($item) == 'object')
                                                                        @foreach ($item as $itemKey => $itemRow)
                                                                            <p><b>{{ $itemKey }}</b> :
                                                                                {{ strlen($itemRow) > 100 ? substr($itemRow, 0, 100) . '...' : $itemRow }}
                                                                            </p>
                                                                        @endforeach
                                                                    @else
                                                                        <p>{{ $item }}</p>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </li>
                @endforeach
            </ul>
        </section>
    </section>
    <script>
        jQuery(document).ready(function() {
            $('.stackCol').on('click', function() {
                console.log('click')
                let stackDiv = $(this).find('div.stack')
                console.log(stackDiv)
                console.log(stackDiv.is(':hidden'))
                if (stackDiv.is(':hidden')) {
                    stackDiv.show();
                } else {
                    stackDiv.hide();
                }
            })
        });
    </script>
@endsection
