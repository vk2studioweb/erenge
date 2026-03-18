<section id="empresaMapa" aria-label="Localização Erenge">
    <div id="empresaMapaLeaflet" aria-label="Mapa de localização Erenge" data-coords="{{ $thisdata->address[0]->coords ?? ''}}"></div>
    <div id="coordslist">
        @foreach ($thisdata->address as $endereco)
            <span data-coord="{{ $endereco->coords ?? ''}}"></span>
        @endforeach
    </div>    

    <div id="empresaMapaCard">
        <div id="empresaMapaEndereco">
            <h3 class="empresaMapaCardTitle" aria-label="Endereço">
                <i class="icon-erenge icon-dropper icon-dropperMapa" aria-hidden="true"></i>
                Endereço
            </h3>
            @if(isset($thisdata->address[0]))
            <p class="empresaMapaCardTexto">
                {!! strip_tags($thisdata->address[0]->address, '<strong><br>') !!}
            </p>
            @endif
        </div>
        <div id="empresaMapaContato">
            <h3 class="empresaMapaCardTitle" aria-label="Contato">
                <i class="icon-erenge icon-whatsapp icon-whatsappMapa" aria-hidden="true"></i>
                Contato
            </h3>
            @if(isset($thisdata->address[0]))
            <a href="tel:{{ preg_replace('/\D/', '', $thisdata->address[0]->celphone) }}"
               class="empresaMapaCardLink"
               aria-label="Ligar para {{ $thisdata->address[0]->celphone }}">
                {{ $thisdata->address[0]->celphone }}
            </a>
            <a href="mailto:{{ $thisdata->address[0]->mail }}"
               class="empresaMapaCardLink"
               aria-label="Enviar e-mail para {{ $thisdata->address[0]->mail }}">
                {{ $thisdata->address[0]->mail }}
            </a>
            @endif
        </div>
    </div>

</section>