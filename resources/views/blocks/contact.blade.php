@php
    $email = setting('email');
    $phoneAe = setting('phone_ae');
    $phoneSg = setting('phone_sg');
    $phoneUs = setting('phone_us');
    $whatsapp = setting('whatsapp_url');
@endphp

<section id="contact" class="contact-band relative overflow-hidden bg-[#0B59AC] py-16 sm:py-[88px]">
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_left,_rgba(255,255,255,0.14),_transparent_55%)]"></div>
    <div class="pointer-events-none absolute -right-24 top-10 h-72 w-72 rounded-full bg-[#F79F12]/20 blur-3xl"></div>

    <div class="container-site relative grid items-start gap-12 lg:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)] lg:gap-16">
        <div>
            <div class="mb-5 h-1 w-10 rounded-sm bg-[#f5a915]"></div>
            @if(!empty($intro))
                <p class="mb-4 whitespace-pre-line text-lg leading-7 text-white/75">{{ $intro }}</p>
            @endif
            <h2 class="text-[1.9rem] font-semibold leading-[1.18] tracking-[-0.025em] text-white sm:text-[2.35rem]">{!! $headline_html !!}</h2>

            <div class="mt-8 space-y-3 text-[15px] text-white/85">
                @if(filled($email))
                    <p>
                        <a href="mailto:{{ $email }}" class="hover:text-white">{{ $email }}</a>
                    </p>
                @endif
                @if(filled($phoneAe))
                    <p>
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', (string) $phoneAe) }}" class="hover:text-white">{{ $phoneAe }}</a>
                    </p>
                @endif
                @if(filled($phoneSg))
                    <p>
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', (string) $phoneSg) }}" class="hover:text-white">{{ $phoneSg }}</a>
                    </p>
                @endif
                @if(filled($phoneUs))
                    <p>
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', (string) $phoneUs) }}" class="hover:text-white">{{ $phoneUs }}</a>
                    </p>
                @endif
                @if(filled($whatsapp))
                    <p>
                        <a href="{{ $whatsapp }}" class="font-medium text-[#F79F12] hover:text-white" target="_blank" rel="noopener">WhatsApp us</a>
                    </p>
                @endif
            </div>
        </div>

        @if(!empty($show_form))
            <div class="rounded-[1.5rem] bg-white p-6 shadow-[0_24px_60px_rgba(10,22,40,0.18)] sm:p-8">
                <livewire:lead-form
                    type="contact"
                    :show-phone="true"
                    :show-company="false"
                    :show-country="false"
                    :show-last-name="true"
                    button-label="Submit"
                />
            </div>
        @endif
    </div>
</section>
