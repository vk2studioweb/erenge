@extends('Admin.Layouts.app')
@section('content')

    <!-- Inclui identificação da pag. -->
    @include('Admin.Layouts.identification')

    <section class="main-content">
        <section id="main-form">
            {{-- @dump($thisdata->userProfile); --}}
            <section class="userProfileContainer">
                {!! Form::open([
                    'url' => route('usuario.postPicture'),
                    'method' => 'POST',
                    'id' => 'userProfilePictureForm',
                    'files' => true,
                ]) !!}

                <ul id="main-form-list">
                    @if (isset(Auth::user()->image))
                        <li class="size-col-1 size-content-2 size-heigt-auto">
                            {!! Form::label('currentPicture', 'Foto de Perfil atual', ['class' => 'control-label']) !!}
                            <br>
                            <figure class="picturePreviewContainer">
                                <img class="header-user-image" src="{{ Auth::user()->image }}"
                                    alt="Foto de Perfil {{ $thisdata->userProfile->name }}">
                            </figure>
                            {!! Form::file('file', ['id' => 'file', 'style' => 'display:none;']) !!}
                        </li>
                    @endif
                    {!! Form::close() !!}
                    <hr>
                    {!! Form::open([
                        'url' => route('usuario.post'),
                        'method' => 'POST',
                        'id' => 'userProfileForm',
                        'files' => true,
                    ]) !!}

                    @if (!empty($errors->all()))
                        <li class="size-col-1 size-content-2 size-heigt-auto">
                            <div class="errorMessages">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </li>
                    @endif

                    @if (session('message'))
                        <li class="size-col-1 size-content-2 size-heigt-auto">
                            <div class="returnMessage">
                                <p>{{ session('message') }}</p>
                            </div>
                        </li>
                    @endif


                    <li class="size-col-2 size-content-1">
                        {!! Form::label('name', 'Nome', ['class' => 'control-label']) !!}
                        {!! Form::text('name', $thisdata->userProfile->name, [
                            'class' => 'form-control',
                            'autocomplete' => 'off',
                        ]) !!}
                    </li>
                    <li class="size-col-2 size-content-1">
                        {!! Form::label('email', 'E-mail', ['class' => 'control-label']) !!}
                        {!! Form::text('email', $thisdata->userProfile->email, [
                            'class' => 'form-control',
                            'autocomplete' => 'off',
                            'readonly' => 'readonly',
                            'disabled' => 'disabled',
                        ]) !!}
                    </li>
                    <li class="size-col-2 size-content-3">
                        {!! Form::label('theme', 'Cor do tema', ['class' => 'control-label']) !!}
                        {!! Form::select('theme', ['dark' => 'Escuro', 'light' => 'Claro'], $thisdata->userProfile->theme ?? null, [
                            'class' => 'form-control',
                        ]) !!}
                    </li>
                    <hr>
                    <li class="size-col-1 size-content-3">
                        {!! Form::label('old_password', 'Digite sua senha antiga', ['class' => 'control-label']) !!}
                        {!! Form::password('old_password', ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </li>

                    <li class="size-col-1 size-content-3">
                        {!! Form::label('password', 'Alterar sua senha (deixe vazio para manter a senha original)', [
                            'class' => 'control-label',
                        ]) !!}
                        {!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'password']) !!}
                    </li>
                    <li class="size-col-1 size-content-3">
                        {!! Form::label('password_confirm', 'Repita sua nova senha', [
                            'class' => 'control-label',
                        ]) !!}
                        {!! Form::password('password_confirm', [
                            'class' => 'form-control',
                            'autocomplete' => 'off',
                            'id' => 'password_confirm',
                        ]) !!}
                    </li>

                    <li class="size-col-1 size-content-1 size-heigt-auto passwordRestrictions">
                        <p>Restrições de senha</p>
                        <ul>
                            <li id="numbersAndCharacters" class="neutralMark">Somente Números e Caracteres</li>
                            <li id="charMin" class="neutralMark">Minimo de 8 digitos</li>
                            <li id="charSequence" class="neutralMark">
                                Não conter 4 ou mais letras ou números em sequência
                            </li>
                            <li id="domainNameEmail" class="neutralMark">
                                Não conter parte do dominio, nome ou email do
                                usuário
                            </li>
                        </ul>
                    </li>
                    <section id="main-button-list">
                        <button id="button-insert" class="main-button-list" type="submit"
                            form="userProfileForm">SALVAR</button>
                        <a href="{{ route('home') }}" id="button-goBack" class="main-button-list">VOLTAR</a>
                    </section>
                </ul>
                {!! Form::close() !!}
            </section>
            <div class="profilePictureContext">
                <span class="item-menu-image information-image ui-admin-information-circle"><label for="file">Alterar
                        Foto de Perfil</label></span>
            </div>
        </section>
    </section>
    <script>
        $(window).ready(function() {
            if ($('.returnMessage').length) {
                $('.returnMessage').fadeOut(2600, "linear")
            }
            if ($('.errorMessages').length) {
                $('.errorMessages').fadeOut(2600, "linear")
            }
        })

        $('#password').on('keyup', function() {
            let value = $(this).val();
            let pwdTest = testPassword(value)

            if (pwdTest) {
                $('#button-insert').attr('disabled', true);
            } else {
                $('#button-insert').attr('disabled', false);
            }
            if (value.length <= 0) {
                $('.passwordRestrictions ul li').each(function(index, elem) {
                    $(elem).removeClass();
                    $(elem).addClass('neutralMark')
                })
                $('#button-insert').attr('disabled', false);
                return false;
            }
        })

        $('#userProfileForm').validate({
            errorClass: 'error-message',
            errorElement: 'span',
            ignore: [],
            highlight: function(element) {
                $(element).parent().addClass("main-error");
            },
            unhighlight: function(element) {
                $(element).parent().removeClass("main-error");
            },
            rules: {
                password: {
                    minlength: 8,
                },
                password_confirm: {
                    minlength: 8,
                    equalTo: "#password"
                }
            }
        });

        function testPassword(string) {
            let patterns = {
                'charSequence': false,
                'numbersAndCharacters': false,
                'charMin': false,
                'domainNameEmail': false,
            };

            let failedTests = false;

            charSequencePattern = new RegExp(/[a-z]{4,}|[A-Z]{4,}|[0-9]{4,}/m)
            numbersAndCharactersPattern = new RegExp(/\s/g)
            domainNameEmailPattern = new RegExp(/(?:{{ $thisdata->domainPattern }})/gi)

            if (charSequencePattern.test(string)) {
                patterns.charSequence = true;
            }
            if (numbersAndCharactersPattern.test(string)) {
                patterns.numbersAndCharacters = true;
            }
            if (string.length < 8) {
                patterns.charMin = true;
            }
            if (domainNameEmailPattern.test(string)) {
                patterns.domainNameEmail = true;
            }

            for (const key in patterns) {
                $("#" + key).removeClass()
                if (patterns[key]) {
                    $("#" + key).addClass('errorMark')
                    failedTests = true;
                } else {
                    $("#" + key).addClass('correctMark')
                }
            }

            return failedTests;
        }

        $(".picturePreviewContainer").on('contextmenu', function(e) {

            let targetPos = $(e.currentTarget).position()
            var left = targetPos.left,
                top = targetPos.top + 100;

            $('.profilePictureContext').show().css({
                top: top,
                left: left
            });
            return false;
        });

        $('.profilePictureContext').on('mouseleave', function() {
            $('.profilePictureContext').hide();
        })

        $('.picturePreviewContainer').on('click', function() {
            $(this).trigger("contextmenu")
        })

        $('#file').on('change', function() {
            $('#userProfilePictureForm').submit();
        });
    </script>
@endsection
