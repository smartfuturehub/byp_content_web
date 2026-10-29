<section id="contact" class="section-pad bg-[#F8FAFC]">
    <div class="container-site">
        <div class="mb-10 text-center">
            @if(!empty($intro))
                <p class="mb-3 whitespace-pre-line text-lg leading-7 text-[#475467]">{{ $intro }}</p>
            @endif
            <h2 class="display-h2">{!! $headline_html !!}</h2>
        </div>

        <div class="grid items-start gap-12 lg:grid-cols-[220px_minmax(0,1fr)]">
            <div>
                <a href="{{ url('/') }}" class="inline-block">
                    <img src="{{ media_url(setting('logo', '/brand/wp/logo.png')) }}" alt="{{ setting('site_name', 'BYP Health') }}" class="h-16 w-auto">
                </a>
                <ul class="mt-6 space-y-2 text-sm">
                    <li><a href="{{ url('/tnc') }}" class="text-[#0B59AC] hover:underline">Terms and Conditions</a></li>
                    <li><a href="{{ url('/privacy-policy') }}" class="text-[#0B59AC] hover:underline">Privacy Policy</a></li>
                </ul>
            </div>

            @if(!empty($show_form))
                <div class="rounded-2xl border border-line bg-white p-8 shadow-[0_8px_24px_rgba(10,22,40,0.04)]">
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
    </div>
</section>
