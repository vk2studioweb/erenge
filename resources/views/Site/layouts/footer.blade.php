@if(isset($thisdata->whatsapp))
<a href="{{ $thisdata->whatsapp->link }}" 
   id="whatsappFloat" 
   target="_blank" 
   rel="noopener noreferrer"
   title="Falar no WhatsApp" 
   aria-label="Falar no WhatsApp">
    <i class="icon-erenge icon-whatsapp icon-whatsappFloat"></i>
</a>
@endif

<footer id="footer">
    <div class="box boxRow">
        <div id="footerContent">
       
            <!-- Coluna 1 — Logo + Info -->
            <div class="footerCol" id="footerColBrand">

                <a href="{{ route('home') }}" title="Erenge" aria-label="Erenge" id="footerLogo">
                    <img src="{{ url('images/erenge-white.svg') }}" alt="Logo Erenge" id="footerLogoImg" loading="lazy" decoding="async">
                </a>

                <div id="footerAddress">
                    @if(isset($thisdata->address[0]))
                    <p class="footerAddressHours">{!! strip_tags($thisdata->texts['footerAddressHours'][0]->description, '<stong><br><\/stong>') !!}</p>
                    <p class="footerAddressStreet">{{ $thisdata->address[0]->address }}</p>
                    @endif
                </div>

                <div id="footerNetworks">
                    @foreach($thisdata->networks as $network)
                    <a href="{{ $network->link }}" 
                    class="footerNetworkLink" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    title="{{ $network->name }}" 
                    aria-label="{{ $network->name }}">
                        <i class="icon-erenge icon-{{ $network->icon }} icon-networkFooter"></i>
                    </a>
                    @endforeach
                </div>

            </div>

            <!-- Coluna 2 — Links Úteis -->
            <div class="footerCol" id="footerColLinksUteis">
                <h3 class="footerColTitle">Links Úteis</h3>
                <ul class="footerColList">
                    <li class="footerColItem"><a href="{{ route('empresa') }}" class="footerColLink">Empresa</a></li>
                    <li class="footerColItem"><a href="{{ route('obras') }}" class="footerColLink">Obras</a></li>
                    <li class="footerColItem"><a href="{{ route('servicos') }}" class="footerColLink">Serviços</a></li>
                    <li class="footerColItem"><a href="{{ route('trabalheConosco') }}" class="footerColLink">Trabalhe Conosco</a></li>
                    <li class="footerColItem"><a href="{{ route('contato') }}" class="footerColLink">Contato</a></li>
                </ul>
            </div>

            <!-- Coluna 3 — Links -->
            <div class="footerCol" id="footerColLinks">
                <h3 class="footerColTitle">Links</h3>
                <ul class="footerColList">
                    <li class="footerColItem"><a href="{{ route('termo', ['slug' => 'politica-de-privacidade']) }}" class="footerColLink">Política de Privacidade</a></li>
                    <li class="footerColItem"><a href="{{ route('termo', ['slug' => 'termos-de-uso']) }}" class="footerColLink">Termos de Uso</a></li>
                    <li class="footerColItem"><a href="{{ route('intranet') }}" class="footerColLink">Intranet</a></li>
                </ul>
            </div>

            <!-- Coluna 4 — Contato -->
            <div class="footerCol" id="footerColContact">
                @if(isset($thisdata->address[0]))
                <a href="tel:{{ preg_replace('/\D/', '', $thisdata->address[0]->celphone) }}" 
                id="footerPhone" 
                title="Ligar para Erenge">
                    {{ $thisdata->address[0]->celphone }}
                </a>
                <a href="mailto:{{ $thisdata->address[0]->mail }}" 
                id="footerMail" 
                title="Enviar e-mail">
                    {{ $thisdata->address[0]->mail }}
                </a>
                @endif

                <a href="https://www.vk2.com.br" 
                id="footerVk2" 
                target="_blank" 
                rel="noopener noreferrer" 
                title="Desenvolvido por VK2" 
                aria-label="Desenvolvido por VK2">
                    <span id="footerVk2Label">Desenvolvido por</span>
                    <img src="{{ url('images/vk2studioweb.webp') }}" alt="VK2" id="footerVk2Logo" loading="lazy" decoding="async">
                </a>
            </div>

        </div>
    </div>
    <!-- Barra Copyright -->
    <div id="footerCopyright">
        <p id="footerCopyrightText">
            Copyright {{ date('Y') }} &copy; Erenge &ndash; Construções e Incorporações. Todos os direitos reservados.
        </p>
    </div>

</footer>
