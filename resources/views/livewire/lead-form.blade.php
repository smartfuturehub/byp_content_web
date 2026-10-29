<div>
    @php
        $loadingLabel = $emailOnly ? 'Subscribing...' : 'Sending...';
    @endphp

    @if($submitted)
        <p class="rounded-2xl bg-brand-soft px-4 py-3 text-sm text-brand-dark">Thank you. We will be in touch shortly.</p>
    @elseif($emailOnly)
        <form wire:submit="submit" novalidate class="flex flex-col gap-3 sm:flex-row" autocomplete="on">
            <input
                id="lead-newsletter-email"
                type="email"
                name="lead_newsletter_email"
                wire:key="lead-newsletter-email"
                wire:model.blur="email"
                wire:loading.attr="disabled"
                wire:target="submit"
                @input="$wire.$errors.clear('email')"
                placeholder="{{ $placeholder }}"
                class="w-full rounded-full border border-[#D0D5DD] bg-white px-5 py-3.5 text-[15px] text-[#101828] outline-none focus:border-[#0B59AC] disabled:cursor-wait disabled:bg-[#F9FAFB]"
                required
                autocomplete="email"
            >
            <button type="submit" wire:loading.attr="disabled" wire:target="submit" class="inline-flex shrink-0 items-center justify-center gap-2 overflow-hidden rounded-full bg-[#f5a915] px-[26px] py-3.5 text-[15px] font-semibold text-[#1A1A1A] hover:bg-[#E0960C] disabled:cursor-wait disabled:opacity-80">
                @include('livewire.partials.lead-form-submit-label')
            </button>
        </form>
        @error('email') <p x-show="$wire.$errors.has('email')" class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    @else
        <form wire:submit="submit" novalidate class="relative space-y-4" autocomplete="on">
            <div style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden" aria-hidden="true">
                <label for="lead-website">Do not fill</label>
                <input id="lead-website" type="text" name="company_website" value="" wire:model="website" tabindex="-1" autocomplete="off">
            </div>
            <div wire:key="lead-field-name">
                <label for="lead-name" class="mb-1 block text-sm font-medium text-navy">{{ $showLastName ? 'First Name' : 'Name' }}</label>
                <input
                    id="lead-name"
                    type="text"
                    name="lead_name"
                    wire:model.blur="name"
                    wire:loading.attr="disabled"
                    wire:target="submit"
                    @input="$wire.$errors.clear('name')"
                    class="input-field disabled:cursor-wait disabled:bg-[#F9FAFB]"
                    autocomplete="{{ $showLastName ? 'given-name' : 'name' }}"
                >
                @error('name') <p x-show="$wire.$errors.has('name')" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            @if($showLastName)
                <div wire:key="lead-field-last-name">
                    <label for="lead-last-name" class="mb-1 block text-sm font-medium text-navy">Last Name</label>
                    <input
                        id="lead-last-name"
                        type="text"
                        name="lead_last_name"
                        wire:model.blur="lastName"
                        wire:loading.attr="disabled"
                        wire:target="submit"
                        @input="$wire.$errors.clear('lastName')"
                        class="input-field disabled:cursor-wait disabled:bg-[#F9FAFB]"
                        autocomplete="family-name"
                    >
                    @error('lastName') <p x-show="$wire.$errors.has('lastName')" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            @endif
            <div wire:key="lead-field-email">
                <label for="lead-email" class="mb-1 block text-sm font-medium text-navy">Email</label>
                <input
                    id="lead-email"
                    type="email"
                    name="lead_email"
                    wire:model.blur="email"
                    wire:loading.attr="disabled"
                    wire:target="submit"
                    @input="$wire.$errors.clear('email')"
                    class="input-field disabled:cursor-wait disabled:bg-[#F9FAFB]"
                    autocomplete="email"
                >
                @error('email') <p x-show="$wire.$errors.has('email')" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            @if($showPhone)
                <div wire:key="lead-field-phone">
                    <label for="lead-phone" class="mb-1 block text-sm font-medium text-navy">Phone Number</label>
                    <input
                        id="lead-phone"
                        type="tel"
                        name="lead_phone"
                        wire:model="phone"
                        wire:loading.attr="disabled"
                        wire:target="submit"
                        class="input-field disabled:cursor-wait disabled:bg-[#F9FAFB]"
                        autocomplete="tel"
                    >
                </div>
            @endif
            @if($showCompany)
                <div wire:key="lead-field-company">
                    <label for="lead-company" class="mb-1 block text-sm font-medium text-navy">Organisation</label>
                    <input
                        id="lead-company"
                        type="text"
                        name="lead_organization"
                        wire:model="company"
                        wire:loading.attr="disabled"
                        wire:target="submit"
                        class="input-field disabled:cursor-wait disabled:bg-[#F9FAFB]"
                        autocomplete="organization"
                    >
                </div>
            @endif
            @if($showCountry)
                <div wire:key="lead-field-country">
                    <label for="lead-country" class="mb-1 block text-sm font-medium text-navy">Country of the site of care</label>
                    <input
                        id="lead-country"
                        type="text"
                        name="lead_country"
                        wire:model.blur="country"
                        wire:loading.attr="disabled"
                        wire:target="submit"
                        @input="$wire.$errors.clear('country')"
                        class="input-field disabled:cursor-wait disabled:bg-[#F9FAFB]"
                        placeholder="Any country"
                        autocomplete="country-name"
                    >
                    @error('country') <p x-show="$wire.$errors.has('country')" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            @endif
            @if($showMessage)
                <div wire:key="lead-field-message" x-data="{ count: @js(strlen($message)) }">
                    <label for="lead-message" class="mb-1 block text-sm font-medium text-navy">Write Here</label>
                    <textarea
                        id="lead-message"
                        name="lead_message"
                        wire:model="message"
                        wire:loading.attr="disabled"
                        wire:target="submit"
                        rows="4"
                        maxlength="300"
                        class="input-field disabled:cursor-wait disabled:bg-[#F9FAFB]"
                        autocomplete="off"
                        x-on:input="count = $event.target.value.length"
                    ></textarea>
                    <p class="mt-1 text-xs text-muted" x-text="count + '/300'">{{ strlen($message) }}/300</p>
                </div>
            @endif
            <div wire:key="lead-field-captcha">
                <div class="mb-1 flex items-center justify-between gap-3">
                    <label for="lead-captcha" class="text-sm font-medium text-navy">
                        What is {{ $captchaQuestion }}? <span class="text-red-600">*</span>
                    </label>
                    <button
                        type="button"
                        wire:click="refreshCaptcha"
                        wire:loading.attr="disabled"
                        wire:target="refreshCaptcha"
                        class="inline-flex shrink-0 rounded-full p-1 text-[#0B59AC] hover:bg-[#F4F7FB] disabled:opacity-50"
                        aria-label="New question"
                        title="New question"
                    >
                        <svg wire:loading.remove wire:target="refreshCaptcha" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182" />
                        </svg>
                        <svg wire:loading wire:target="refreshCaptcha" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182" />
                        </svg>
                    </button>
                </div>
                <input
                    id="lead-captcha"
                    type="text"
                    name="lead_captcha"
                    inputmode="numeric"
                    wire:model.blur="captchaAnswer"
                    wire:loading.attr="disabled"
                    wire:target="submit"
                    @input="$wire.$errors.clear('captchaAnswer')"
                    class="input-field max-w-[8rem] disabled:cursor-wait disabled:bg-[#F9FAFB]"
                    required
                    autocomplete="off"
                    aria-required="true"
                >
                @error('captchaAnswer') <p x-show="$wire.$errors.has('captchaAnswer')" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <button type="submit" wire:loading.attr="disabled" wire:target="submit" class="btn-primary w-full gap-2 overflow-hidden disabled:cursor-wait disabled:opacity-80">
                @include('livewire.partials.lead-form-submit-label')
            </button>
        </form>
    @endif
</div>
