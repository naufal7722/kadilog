@props(['steps' => []])

{{--
Each step should have:
  - status: 'completed' | 'active' | 'pending'
  - title: string
  - description: string (optional)
  - operator: string (optional)
  - time: string (optional)
  - location: string (optional)
--}}

<div class="relative space-y-0">
    @foreach ($steps as $index => $step)
        @php
            $isLast = $index === count($steps) - 1;
            $dotClass = match($step['status'] ?? 'pending') {
                'completed' => 'timeline-dot-completed',
                'active'    => 'timeline-dot-active',
                default     => 'timeline-dot-pending',
            };
            $textClass = match($step['status'] ?? 'pending') {
                'completed' => 'text-secondary-600',
                'active'    => 'text-primary-700 font-medium',
                default     => 'text-secondary-400',
            };
        @endphp
        <div class="relative pl-10 pb-8 {{ $isLast ? 'pb-0' : '' }}">
            {{-- Connecting Line --}}
            @unless ($isLast)
                <div class="absolute left-[1.19rem] top-6 bottom-0 w-0.5 {{ $step['status'] === 'completed' ? 'bg-success-300' : 'bg-secondary-200' }}"></div>
            @endunless

            {{-- Dot --}}
            <div class="absolute left-[0.55rem] top-1 w-5 h-5 rounded-full border-[3px] border-white shadow-sm z-10
                {{ match($step['status'] ?? 'pending') {
                    'completed' => 'bg-success-500 ring-2 ring-success-100',
                    'active'    => 'bg-primary-500 ring-2 ring-primary-100 animate-pulse-soft',
                    default     => 'bg-secondary-300 ring-2 ring-secondary-100',
                } }}">
                @if ($step['status'] === 'completed')
                    <svg class="w-full h-full text-white p-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                @endif
            </div>

            {{-- Content --}}
            <div class="{{ $step['status'] === 'active' ? 'bg-primary-50/50 border border-primary-100 rounded-xl p-3 -ml-1' : '' }}">
                <p class="text-sm font-semibold {{ $textClass }}">{{ $step['title'] }}</p>
                @if (!empty($step['description']))
                    <p class="text-xs text-secondary-500 mt-0.5">{{ $step['description'] }}</p>
                @endif
                <div class="flex flex-wrap items-center gap-3 mt-1.5">
                    @if (!empty($step['operator']))
                        <span class="flex items-center gap-1 text-xs text-secondary-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $step['operator'] }}
                        </span>
                    @endif
                    @if (!empty($step['location']))
                        <span class="flex items-center gap-1 text-xs text-secondary-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $step['location'] }}
                        </span>
                    @endif
                    @if (!empty($step['time']))
                        <span class="flex items-center gap-1 text-xs text-secondary-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $step['time'] }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
