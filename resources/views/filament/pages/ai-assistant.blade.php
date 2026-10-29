<x-filament-panels::page>
    <div {{ $this->insightsGrid(['lg' => 2]) }}>
        <x-filament::section
            heading="Site suggestions"
            description="Uses the live CMS plus the last 30 days of traffic. New pages are created as drafts only. Image ideas must use files already in the library."
        >
            <x-slot name="afterHeader">
                <x-filament::button
                    wire:click="generateSuggestions"
                    wire:target="generateSuggestions"
                >
                    Generate
                </x-filament::button>
            </x-slot>

            <div {{ $this->insightsGrid(['default' => 1]) }}>
                @forelse ($this->pendingSuggestions() as $suggestion)
                    @php
                        $payload = $suggestion->payload ?? [];
                        $pageId = (int) ($payload['page_id'] ?? 0);
                        $editUrl = $pageId > 0 ? $this->editPageUrl($pageId) : null;
                    @endphp
                    <div wire:key="suggestion-{{ $suggestion->getKey() }}">
                    <x-filament::section :compact="true" :heading="$this->suggestionHeading($suggestion)">
                        <x-slot name="afterHeader">
                            <x-filament::badge color="primary">{{ $suggestion->type }}</x-filament::badge>
                        </x-slot>

                        @if ($suggestion->type === 'page')
                            <p class="fi-section-header-description">{{ $payload['reason'] ?? '' }}</p>
                            <p class="fi-section-header-description">Slug: {{ $payload['slug'] ?? '' }}</p>
                        @elseif ($suggestion->type === 'content')
                            <p>{{ $payload['suggested'] ?? '' }}</p>
                            <p class="fi-section-header-description">{{ $payload['reason'] ?? '' }}</p>
                        @elseif ($suggestion->type === 'image')
                            <p><code>{{ $payload['suggested_path'] ?? '' }}</code></p>
                            <p class="fi-section-header-description">{{ $payload['reason'] ?? '' }}</p>
                        @else
                            <p class="fi-section-header-description">{{ $payload['detail'] ?? '' }}</p>
                        @endif

                        <x-slot name="footer">
                            <div class="fi-ac">
                                @if ($suggestion->type === 'page')
                                    <x-filament::button
                                        size="sm"
                                        wire:click="applyDraftPage({{ $suggestion->getKey() }})"
                                    >
                                        Create draft page
                                    </x-filament::button>
                                @elseif ($editUrl)
                                    <x-filament::button
                                        size="sm"
                                        tag="a"
                                        :href="$editUrl"
                                        color="gray"
                                    >
                                        Open in Pages
                                    </x-filament::button>
                                @endif
                                <x-filament::button
                                    size="sm"
                                    color="gray"
                                    wire:click="dismiss({{ $suggestion->getKey() }})"
                                >
                                    Dismiss
                                </x-filament::button>
                            </div>
                        </x-slot>
                    </x-filament::section>
                    </div>
                @empty
                    <x-filament::empty-state
                        heading="No pending suggestions"
                        description="Generate a set to review content, images, new pages, and improvements."
                        :compact="true"
                        :contained="false"
                    />
                @endforelse
            </div>
        </x-filament::section>

        <x-filament::section
            heading="Ask about analytics"
            description="Questions about traffic, referrers, weak pages, and leads. Answers use the snapshot only."
        >
            <div {{ $this->insightsGrid(['default' => 1]) }}>
                @forelse ($messages as $index => $message)
                    <x-filament::callout
                        wire:key="message-{{ $index }}"
                        :color="$message['role'] === 'user' ? 'gray' : 'primary'"
                        :heading="$message['role'] === 'user' ? 'You' : 'Assistant'"
                    >
                        {{ $message['content'] }}
                    </x-filament::callout>
                @empty
                    <x-filament::empty-state
                        heading="Ask a question"
                        description="Try “Which website sent the most traffic?” or “Which pages look thin?”"
                        :compact="true"
                        :contained="false"
                    />
                @endforelse
            </div>

            <x-slot name="footer">
                <form wire:submit="ask" class="fi-ac fi-width-full">
                    <x-filament::input.wrapper class="fi-width-full">
                        <x-filament::input
                            type="text"
                            wire:model="question"
                            placeholder="Ask about traffic or content"
                        />
                    </x-filament::input.wrapper>
                    <x-filament::button type="submit" color="warning">
                        Ask
                    </x-filament::button>
                </form>
            </x-slot>
        </x-filament::section>
    </div>
</x-filament-panels::page>
