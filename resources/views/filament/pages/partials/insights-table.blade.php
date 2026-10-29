@props([
    'heading',
    'columns',
    'rows',
    'emptyHeading' => 'No data yet',
    'emptyDescription' => null,
])

@php
    /** @var list<array{label: string, key: string, align?: string, numeric?: bool}> $columns */
    /** @var list<array<string, mixed>> $rows */
@endphp

<div class="fi-ta-ctn fi-ta-ctn-with-header">
    <div class="fi-ta-header">
        <h3 class="fi-ta-header-heading">{{ $heading }}</h3>
    </div>

    @if ($rows === [])
        <div class="fi-ta-empty-state">
            <div class="fi-ta-empty-state-content">
                <h4 class="fi-ta-empty-state-heading">{{ $emptyHeading }}</h4>
                @if (filled($emptyDescription))
                    <p class="fi-ta-empty-state-description">{{ $emptyDescription }}</p>
                @endif
            </div>
        </div>
    @else
        <div class="fi-ta-content-ctn">
            <div class="fi-ta-content">
                <table class="fi-ta-table">
                    <thead>
                        <tr>
                            @foreach ($columns as $column)
                                <th @class([
                                    'fi-ta-header-cell',
                                    'fi-align-end' => ($column['align'] ?? 'start') === 'end',
                                ])>
                                    <span class="fi-ta-header-cell-label">{{ $column['label'] }}</span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $index => $row)
                            <tr class="fi-ta-row" wire:key="{{ $heading }}-{{ $index }}">
                                @foreach ($columns as $column)
                                    @php
                                        $value = $row[$column['key']] ?? '';
                                        $isNumeric = (bool) ($column['numeric'] ?? false);
                                    @endphp
                                    <td @class([
                                        'fi-ta-cell',
                                        'fi-align-end' => ($column['align'] ?? 'start') === 'end',
                                    ])>
                                        <div @class([
                                            'fi-ta-text',
                                            'fi-numeric' => $isNumeric,
                                            'fi-align-end' => ($column['align'] ?? 'start') === 'end',
                                        ])>
                                            {{ $isNumeric ? number_format((int) $value) : $value }}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
