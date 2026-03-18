@extends('Site.layouts.app')
@section('metatags-share')
    <meta name="keywords" content="{{ isset($thisdata->config->keywords) ? $thisdata->config->keywords : '' }}" />
    <meta name="description" content="{{ isset($thisdata->config->description) ? strip_tags($thisdata->config->description) : '' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }} " />
    {{-- <meta property="og:image:alt" content="" />
    <meta property="og:image" content="" /> --}}
    <meta property="og:site_name" content="{{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.nameSite', isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME')) }}</title>
@endsection
@section('content')
    <main id="main-website">
        <!-- Internal Banner -->
        @include('Site.layouts.internalbanner')
        <!-- END Internal Banner -->

        <div class="main main-contact">
            <section id="title-contact" style="background-image:url({{ $thisdata->texts['contact'][0]->images[0]->default ?? '' }})">
                <h1>{{ $thisdata->texts['contact'][0]->name }}</h1>
                <article>{!! $thisdata->texts['contact'][0]->description !!}</article>
            </section>
            <section id="contact">
                <section id="contactform">
                    <h2 class="title-contactform">Vamos Conversar</h2>
                    <article class="phone-contactform data-contactform">
                        <h3 class="titlesection-contactform">{{ $thisdata->texts['contact']['1']->name }}</h3>
                        <spam class="datasection-contactform">{!! strip_tags($thisdata->texts['contact']['1']->description, '') !!}</spam>
                    </article>
                    <article class="mail-contactform data-contactform">
                        <h3 class="titlesection-contactform">{{ $thisdata->texts['contact']['2']->name }}</h3>
                        <spam class="datasection-contactform">{{ strip_tags($thisdata->texts['contact']['2']->description, '') }}</spam>
                    </article>
                    <section class="socialmedia-contactform data-contactform">
                        <h3 class="titlesection-contactform">{{ $thisdata->texts['contact']['3']->name }}</h3>
                        <ul id="redessociais-contato">
                            @foreach ($thisdata->networks as $socialmedia)
                                <li class="item-socialmediaGiovelli"><a href="{{ $socialmedia->link }}" title="{{ $socialmedia->name }}" target="_black" class="icon-redeSocialFooter icon-giovelli {{ 'icon-' . $socialmedia->icon }}" alt="{{ $socialmedia->name }}"><span>{{ $socialmedia->name }}</span></a></li>
                            @endforeach
                        </ul>
                    </section>
                </section>
                <section id="form">
                    {!! Form::open(['url' => route('sendcontato'), 'id' => 'contact-form', 'onsubmit' => 'return false', 'method' => 'POST']) !!}
                    <ul id="contact-formList">
                        <li class="contact-formWrapper" data-aos="fade-right"  data-aos-duration="1000">
                            {!! Form::label('name', 'Nome*', array('class' => 'contact-lable' )) !!}
                            {!! Form::text('name', null, ['id' => 'name', 'class' => 'contact-formInput', 'placeholder' => 'Nome']) !!}
                        </li>
                        <li class="contact-formWrapper" data-aos="fade-right"  data-aos-duration="1100">
                            {!! Form::label('phone', 'Telefone*', array('class' => 'contact-lable' )) !!}
                            {!! Form::text('phone', null, ['id' => 'phone', 'class' => 'contact-formInput mask-phone-ddd', 'placeholder' => 'Telefone']) !!}
                        </li>
                        <li class="contact-formWrapper" data-aos="fade-right"  data-aos-duration="1200">
                            {!! Form::label('mail', 'E-mail', array('class' => 'contact-lable' )) !!}
                            {!! Form::text('mail', null, ['id' => 'mail', 'class' => 'contact-formInput', 'placeholder' => 'Email']) !!}
                        </li>
                        <li class="contact-formWrapper" data-aos="fade-right"  data-aos-duration="1300">
                            {!! Form::label('city', 'Cidade', array('class' => 'contact-lable' )) !!}
                            {!! Form::text('city', null, ['id' => 'city', 'class' => 'contact-formInput', 'placeholder' => 'Cidade']) !!}
                        </li>
                        <li class="contact-formWrapper" data-aos="fade-right"  data-aos-duration="1200">
                            {!! Form::label('company', 'Empresa', array('class' => 'contact-lable' )) !!}
                            {!! Form::text('company', null, ['id' => 'company', 'class' => 'contact-formInput', 'placeholder' => 'Empresa']) !!}
                        </li>
                        <li class="contact-formWrapper" data-aos="fade-right"  data-aos-duration="1300">
                            {!! Form::label('subject', 'Assunto', array('class' => 'contact-lable' )) !!}
                            {!! Form::text('subject', null, ['id' => 'subject', 'class' => 'contact-formInput', 'placeholder' => 'Assunto']) !!}
                        </li>
                        <li class="contact-formWrapperTextarea" data-aos="fade-right"  data-aos-duration="1400">
                            {!! Form::label('description', 'Descrição*', array('class' => 'contact-lable' )) !!}
                            {!! Form::textarea('description', null, ['id' => 'description', 'class' => 'contact-formTextarea']) !!}
                        </li>
                        <li class="contact-formWrapper contact-formMessage" data-aos="fade-up"  data-aos-duration="300">{!! strip_tags($thisdata->texts['contatoterms'][0]->description, '<p><a><strong><i>') !!}</li>
                        <li class="contact-formWrapper contact-formMessage" data-aos="fade-up"  data-aos-duration="400"><span class="form-message"></span></li>
                        <li class="contact-formWrapper contact-formButtons" data-aos="fade-up"  data-aos-duration="500">
                            {!! HCaptcha::display() !!}
                            {!! Form::submit('Enviar', ['class' => 'contact-formButton']) !!}
                        </li>
                    </ul>
                    {!! Form::close() !!}
                </section>

            </section>
        </div>

    </main>
@endsection
